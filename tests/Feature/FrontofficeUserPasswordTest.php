<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class FrontofficeUserPasswordTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware();
        Config::set('database.default', 'sqlite');
        Config::set('database.connections.sqlite.database', ':memory:');
        DB::purge('sqlite');
        DB::reconnect('sqlite');

        $this->createSchema();

        DB::table('trole')->insert([
            'idRole' => 'role-normal',
            'nameRole' => 'Normal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function test_login_accepts_correct_bcrypt_password(): void
    {
        $this->createUser('user-login', 'login@example.com', Hash::make('correct-password'));
        $this->assignNormalRole('user-login');

        $this->postJson('/usuario/acceder', [
            'txtEmail' => 'login@example.com',
            'passPassword' => 'correct-password',
        ])->assertOk()->assertJsonPath('success', true);

        $this->assertSame('user-login', session('idUser'));
    }

    public function test_login_rejects_incorrect_password(): void
    {
        $this->createUser('user-login', 'login@example.com', Hash::make('correct-password'));

        $this->postJson('/usuario/acceder', [
            'txtEmail' => 'login@example.com',
            'passPassword' => 'wrong-password',
        ])->assertStatus(422)->assertExactJson([
            'success' => false,
            'type' => 'error',
            'messages' => ['Usuario o Contraseña Incorrecto'],
            'redirectUrl' => url('usuario/acceder'),
        ]);

        $this->assertNull(session('idUser'));
    }

    /**
     * @dataProvider invalidStoredPasswordProvider
     */
    public function test_login_rejects_empty_or_corrupt_stored_password_without_server_error(string $storedPassword): void
    {
        $this->createUser('user-invalid', 'invalid@example.com', $storedPassword);

        $this->postJson('/usuario/acceder', [
            'txtEmail' => 'invalid@example.com',
            'passPassword' => 'attempted-password',
        ])->assertStatus(422)->assertExactJson([
            'success' => false,
            'type' => 'error',
            'messages' => ['Usuario o Contraseña Incorrecto'],
            'redirectUrl' => url('usuario/acceder'),
        ]);
    }

    public function invalidStoredPasswordProvider(): array
    {
        return [
            'empty password' => [''],
            'corrupt password' => ['not-a-valid-hash'],
        ];
    }

    public function test_register_stores_a_verifiable_hash_instead_of_plain_text(): void
    {
        $plainPassword = 'registration-password';

        $this->postJson('/usuario/registrar', [
            'txtEmail' => 'new@example.com',
            'passPasswordUser' => $plainPassword,
            'txtNumberDni' => '12345678',
            'txtFirstName' => 'New',
            'txtSurName' => 'User',
        ])->assertOk()->assertJsonPath('success', true);

        $storedPassword = DB::table('tuser')->where('email', 'new@example.com')->value('password');

        $this->assertTrue(Hash::check($plainPassword, $storedPassword));
    }

    public function test_change_hashes_a_new_password(): void
    {
        $this->createUser('user-change', 'change@example.com', Hash::make('old-password'));

        $this->postJson('/usuario/cambiar', [
            'hdIdUserValue' => 'user-change',
            'txtEmailUser' => 'change@example.com',
            'passPasswordUser' => 'new-password',
        ])->assertOk()->assertJsonPath('success', true);

        $storedPassword = DB::table('tuser')->where('idUser', 'user-change')->value('password');
        $this->assertTrue(Hash::check('new-password', $storedPassword));
        $this->assertFalse(Hash::check('old-password', $storedPassword));
    }

    public function test_change_preserves_the_existing_hash_when_password_is_empty(): void
    {
        $originalHash = Hash::make('existing-password');
        $this->createUser('user-preserve', 'preserve@example.com', $originalHash);

        $this->postJson('/usuario/cambiar', [
            'hdIdUserValue' => 'user-preserve',
            'txtEmailUser' => 'preserve@example.com',
            'passPasswordUser' => '',
        ])->assertOk()->assertJsonPath('success', true);

        $storedPassword = DB::table('tuser')->where('idUser', 'user-preserve')->value('password');
        $this->assertTrue(Hash::check('existing-password', $storedPassword));
    }

    public function test_reset_uses_the_token_owner_hashes_password_and_consumes_token(): void
    {
        $userAHash = Hash::make('user-a-old-password');
        $userBHash = Hash::make('user-b-old-password');
        $this->createUser('user-a', 'a@example.com', $userAHash);
        $this->createUser('user-b', 'b@example.com', $userBHash);
        $this->createResetToken('reset-a', 'user-a', 'valid-token');

        $this->postJson('/usuario/resetear/valid-token', [
            'hdIdUser' => 'user-b',
            'passPasswordUser' => 'user-a-new-password',
            'passPasswordRetypeUser' => 'user-a-new-password',
        ])->assertOk()->assertJsonPath('success', true);

        $userAStoredPassword = DB::table('tuser')->where('idUser', 'user-a')->value('password');
        $userBStoredPassword = DB::table('tuser')->where('idUser', 'user-b')->value('password');

        $this->assertTrue(Hash::check('user-a-new-password', $userAStoredPassword));
        $this->assertTrue(Hash::check('user-b-old-password', $userBStoredPassword));
        $this->assertFalse(Hash::check('user-a-new-password', $userBStoredPassword));
        $this->assertDatabaseMissing('tresetpassword', ['idResetPassword' => 'reset-a']);
    }

    public function test_invalid_or_reused_token_does_not_modify_user(): void
    {
        $originalHash = Hash::make('original-password');
        $this->createUser('user-reset', 'reset@example.com', $originalHash);

        $this->postJson('/usuario/resetear/missing-token', [
            'hdIdUser' => 'user-reset',
            'passPasswordUser' => 'attacker-password',
        ])->assertStatus(422);

        $storedAfterInvalidToken = DB::table('tuser')->where('idUser', 'user-reset')->value('password');
        $this->assertTrue(Hash::check('original-password', $storedAfterInvalidToken));
        $this->assertFalse(Hash::check('attacker-password', $storedAfterInvalidToken));

        $this->createResetToken('reset-once', 'user-reset', 'single-use-token');
        $this->postJson('/usuario/resetear/single-use-token', [
            'passPasswordUser' => 'first-reset-password',
        ])->assertOk();

        $firstResetHash = DB::table('tuser')->where('idUser', 'user-reset')->value('password');
        $this->assertTrue(Hash::check('first-reset-password', $firstResetHash));

        $this->postJson('/usuario/resetear/single-use-token', [
            'passPasswordUser' => 'second-reset-password',
        ])->assertStatus(422);

        $storedAfterReuse = DB::table('tuser')->where('idUser', 'user-reset')->value('password');
        $this->assertTrue(Hash::check('first-reset-password', $storedAfterReuse));
        $this->assertFalse(Hash::check('second-reset-password', $storedAfterReuse));
    }

    public function test_reset_with_blank_password_preserves_user_hash_and_token(): void
    {
        $originalHash = Hash::make('original-password');
        $this->createUser('user-blank-reset', 'blank-reset@example.com', $originalHash);
        $this->createResetToken('reset-blank', 'user-blank-reset', 'blank-password-token');

        $this->postJson('/usuario/resetear/blank-password-token', [
            'passPasswordUser' => '   ',
        ])->assertStatus(422)->assertExactJson([
            'success' => false,
            'type' => 'error',
            'messages' => ['El campo "password" es requerido.'],
            'redirectUrl' => url('usuario/resetear/blank-password-token'),
        ]);

        $storedPassword = DB::table('tuser')->where('idUser', 'user-blank-reset')->value('password');
        $this->assertSame($originalHash, $storedPassword);
        $this->assertDatabaseHas('tresetpassword', [
            'idResetPassword' => 'reset-blank',
            'idUser' => 'user-blank-reset',
            'token' => 'blank-password-token',
        ]);
    }

    public function test_reset_form_does_not_expose_a_user_id_field(): void
    {
        $view = file_get_contents(resource_path('views/frontoffice/user/reset.blade.php'));

        $this->assertStringNotContainsString('hdIdUser', $view);
        $this->assertStringContainsString("url('usuario/resetear/'.\$token)", $view);
    }

    private function createUser(string $id, string $email, string $password): void
    {
        DB::table('tuser')->insert([
            'idUser' => $id,
            'email' => $email,
            'password' => $password,
            'numberDni' => '12345678',
            'firstName' => 'Test',
            'surName' => 'User',
            'avatarExtension' => '',
            'state' => 'Habilitado',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function assignNormalRole(string $userId): void
    {
        DB::table('tuserrole')->insert([
            'idUserRole' => 'role-' . $userId,
            'idUser' => $userId,
            'idRole' => 'role-normal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function createResetToken(string $id, string $userId, string $token): void
    {
        DB::table('tresetpassword')->insert([
            'idResetPassword' => $id,
            'idUser' => $userId,
            'token' => $token,
            'isRecuperate' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function createSchema(): void
    {
        Schema::create('ttypeexam', function (Blueprint $table) {
            $table->string('idTypeExam')->primary();
            $table->string('acronymTypeExam')->nullable();
            $table->string('nameTypeExam')->nullable();
            $table->string('descriptionTypeExam')->nullable();
            $table->string('extensionImageType')->nullable();
            $table->timestamps();
        });
        Schema::create('tsubject', function (Blueprint $table) {
            $table->string('idSubject')->primary();
            $table->string('nameSubject')->nullable();
            $table->string('codeSubject')->nullable();
            $table->timestamps();
        });
        Schema::create('tgrade', function (Blueprint $table) {
            $table->string('idGrade')->primary();
            $table->string('nameGrade')->nullable();
            $table->string('descriptionGrade')->nullable();
            $table->string('codeGrade')->nullable();
            $table->timestamps();
        });
        Schema::create('texam', function (Blueprint $table) {
            $table->string('idExam')->primary();
            $table->string('idTypeExam')->nullable();
            $table->string('idSubject')->nullable();
            $table->string('idGrade')->nullable();
            $table->string('stateExam')->nullable();
            $table->timestamps();
        });
        Schema::create('tuser', function (Blueprint $table) {
            $table->string('idUser')->primary();
            $table->string('email');
            $table->string('password', 700);
            $table->string('numberDni');
            $table->string('firstName');
            $table->string('surName');
            $table->string('avatarExtension')->default('');
            $table->string('state');
            $table->timestamps();
        });
        Schema::create('trole', function (Blueprint $table) {
            $table->string('idRole')->primary();
            $table->string('nameRole');
            $table->timestamps();
        });
        Schema::create('tuserrole', function (Blueprint $table) {
            $table->string('idUserRole')->primary();
            $table->string('idUser');
            $table->string('idRole');
            $table->timestamps();
        });
        Schema::create('tresetpassword', function (Blueprint $table) {
            $table->string('idResetPassword')->primary();
            $table->string('idUser');
            $table->string('token');
            $table->boolean('isRecuperate')->default(true);
            $table->timestamps();
        });
    }
}
