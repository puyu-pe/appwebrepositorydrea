<?php

namespace Tests\Feature\Backoffice;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UserAjaxCrudTest extends TestCase
{
	protected function setUp(): void
	{
		parent::setUp();

		$this->withoutMiddleware();
		$this->useInMemoryDatabase();
		$this->registerSqliteFunctions();
		$this->createSchema();
		$this->seedFixtures();
	}

	public function test_ajax_listar_returns_partial_list_without_layout()
	{
		$response=$this->ajaxGet('/usuario/listar?searchParameter=normal');

		$response->assertOk()
			->assertSee('Normal User')
			->assertSee('ajaxCrudDelete', false)
			->assertDontSee('@extends')
			->assertDontSee('assets/backoffice/viewResources/user/getall.js');
	}

	public function test_ajax_change_status_returns_json_contract_without_losing_role_guard()
	{
		$response=$this->ajaxPost('/usuario/estado/user-normal', []);

		$response->assertOk()
			->assertJson([
				'success' => true,
				'type' => 'success',
				'messages' => ['Operación realizada correctamente.']
			])
			->assertJsonStructure(['redirectUrl'])
			->assertJsonPath('redirectUrl', url('usuario/listar'));

		$this->assertDatabaseHas('tuser', [
			'idUser' => 'user-normal',
			'state' => 'Deshabilitado'
		]);
	}

	public function test_ajax_change_status_requires_role_before_enabling_access()
	{
		$response=$this->ajaxPost('/usuario/estado/user-without-role', []);

		$response->assertStatus(422)
			->assertJson([
				'success' => false,
				'type' => 'error',
				'messages' => ['Asigne al menos un rol al usuario para poder habilitar su acceso.']
			])
			->assertJsonStructure(['redirectUrl'])
			->assertJsonPath('redirectUrl', url('usuario/listar'));

		$this->assertDatabaseHas('tuser', [
			'idUser' => 'user-without-role',
			'state' => 'Deshabilitado'
		]);
	}

	public function test_ajax_change_role_returns_json_contract()
	{
		$response=$this->ajaxPost('/usuario/rol', [
			'HdIdUser' => 'user-without-role',
			'selectRoleUser' => 'role-register'
		]);

		$response->assertOk()
			->assertJson([
				'success' => true,
				'type' => 'success',
				'messages' => ['Operación realizada correctamente.']
			])
			->assertJsonStructure(['redirectUrl'])
			->assertJsonPath('redirectUrl', url('usuario/listar'));

		$this->assertDatabaseHas('tuserrole', [
			'idUser' => 'user-without-role',
			'idRole' => 'role-register'
		]);
	}

	public function test_legacy_mostrar_route_redirects_to_active_listar_route()
	{
		$this->get('/usuario/mostrar/2?searchParameter=normal')
			->assertRedirect('/usuario/listar/2?searchParameter=normal');

		$this->get('/usuario/mostrar/1?searchParameter=normal')
			->assertRedirect('/usuario/listar?searchParameter=normal');
	}

	private function ajaxGet($uri)
	{
		return $this->withHeaders([
			'Accept' => 'application/json',
			'X-Requested-With' => 'XMLHttpRequest'
		])->get($uri);
	}

	private function ajaxPost($uri, array $data)
	{
		$_POST=$data;

		return $this->withHeaders([
			'Accept' => 'application/json',
			'X-Requested-With' => 'XMLHttpRequest'
		])->post($uri, $data);
	}

	private function useInMemoryDatabase()
	{
		Config::set('database.default', 'sqlite');
		Config::set('database.connections.sqlite.database', ':memory:');

		DB::purge('sqlite');
		DB::reconnect('sqlite');
	}

	private function registerSqliteFunctions()
	{
		$pdo=DB::connection()->getPdo();

		if(method_exists($pdo, 'sqliteCreateFunction'))
		{
			$pdo->sqliteCreateFunction('concat', function (...$values) {
				return implode('', array_map(function ($value) {
					return $value ?? '';
				}, $values));
			}, -1);

			$pdo->sqliteCreateFunction('compareFind', function ($haystack, $needle) {
				if($needle===null || $needle==='')
				{
					return 1;
				}

				return stripos((string)$haystack, (string)$needle)!==false ? 1 : 0;
			}, 3);
		}
	}

	private function createSchema()
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
			$table->string('email')->nullable();
			$table->string('numberDni')->nullable();
			$table->string('firstName')->nullable();
			$table->string('surName')->nullable();
			$table->string('state')->nullable();
			$table->string('avatarExtension')->nullable();
			$table->timestamps();
		});

		Schema::create('trole', function (Blueprint $table) {
			$table->string('idRole')->primary();
			$table->string('nameRole')->nullable();
			$table->timestamps();
		});

		Schema::create('tuserrole', function (Blueprint $table) {
			$table->string('idUserRole')->primary();
			$table->string('idUser')->nullable();
			$table->string('idRole')->nullable();
			$table->timestamps();
		});
	}

	private function seedFixtures()
	{
		DB::table('trole')->insert([
			['idRole' => 'role-admin', 'nameRole' => 'Administrador', 'updated_at' => now(), 'created_at' => now()],
			['idRole' => 'role-register', 'nameRole' => 'Registrador', 'updated_at' => now(), 'created_at' => now()]
		]);

		DB::table('tuser')->insert([
			[
				'idUser' => 'current-admin',
				'email' => 'admin@example.com',
				'numberDni' => '11111111',
				'firstName' => 'Current',
				'surName' => 'Admin',
				'state' => 'Habilitado',
				'avatarExtension' => '',
				'updated_at' => now(),
				'created_at' => now()
			],
			[
				'idUser' => 'user-normal',
				'email' => 'normal@example.com',
				'numberDni' => '22222222',
				'firstName' => 'Normal',
				'surName' => 'User',
				'state' => 'Habilitado',
				'avatarExtension' => '',
				'updated_at' => now(),
				'created_at' => now()
			],
			[
				'idUser' => 'user-without-role',
				'email' => 'norole@example.com',
				'numberDni' => '33333333',
				'firstName' => 'No Role',
				'surName' => 'User',
				'state' => 'Deshabilitado',
				'avatarExtension' => '',
				'updated_at' => now(),
				'created_at' => now()
			]
		]);

		DB::table('tuserrole')->insert([
			[
				'idUserRole' => 'user-role-admin',
				'idUser' => 'current-admin',
				'idRole' => 'role-admin',
				'updated_at' => now(),
				'created_at' => now()
			],
			[
				'idUserRole' => 'user-role-normal',
				'idUser' => 'user-normal',
				'idRole' => 'role-register',
				'updated_at' => now(),
				'created_at' => now()
			]
		]);

		session(['idUser' => 'current-admin']);
	}
}
