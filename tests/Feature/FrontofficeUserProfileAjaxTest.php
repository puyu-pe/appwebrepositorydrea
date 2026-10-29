<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class FrontofficeUserProfileAjaxTest extends TestCase
{
	protected function setUp(): void
	{
		parent::setUp();

		$this->withoutMiddleware();
		Config::set('database.default', 'sqlite');
		Config::set('database.connections.sqlite.database', ':memory:');
		DB::purge('sqlite');
		DB::reconnect('sqlite');
		$this->createMenuSchema();
		Schema::create('tuser', function (Blueprint $table) {
			$table->string('idUser')->primary();
			$table->string('firstName');
			$table->string('surName');
			$table->string('numberDni');
			$table->string('avatarExtension')->default('');
			$table->timestamps();
		});
		DB::table('tuser')->insert([
			'idUser' => 'user-1',
			'firstName' => 'Ana',
			'surName' => 'Quispe',
			'numberDni' => '12345678',
			'avatarExtension' => '',
			'created_at' => now(),
			'updated_at' => now()
		]);
	}

	public function test_ajax_profile_edit_returns_json_and_validation_preserves_user()
	{
		$invalid=$this->ajaxPost(['hdIdUser' => 'user-1', 'txtFirstNameUser' => '', 'txtSurNameUser' => 'Paz', 'txtDniUser' => '87654321']);
		$invalid->assertStatus(422)->assertJsonPath('success', false)->assertJsonPath('type', 'error');
		$this->assertDatabaseHas('tuser', ['idUser' => 'user-1', 'firstName' => 'Ana', 'surName' => 'Quispe']);

		$success=$this->ajaxPost(['hdIdUser' => 'user-1', 'txtFirstNameUser' => 'Elena', 'txtSurNameUser' => 'Paz', 'txtDniUser' => '87654321']);
		$success->assertOk()
			->assertJson(['success' => true, 'type' => 'success', 'messages' => ['Operación realizada correctamente.']])
			->assertJsonStructure(['redirectUrl', 'data' => ['avatarUrl', 'avatarVersion']]);
		$this->assertSame(asset('img/userlogo.png'), $success->json('data.avatarUrl'));
		$this->assertNotEmpty($success->json('data.avatarVersion'));
		$this->assertDatabaseHas('tuser', ['idUser' => 'user-1', 'firstName' => 'Elena', 'surName' => 'Paz', 'numberDni' => '87654321']);
	}

	public function test_non_ajax_profile_edit_preserves_redirect_response()
	{
		$this->post('/usuario/editar', [
			'hdIdUser' => 'user-1',
			'txtFirstNameUser' => 'Elena',
			'txtSurNameUser' => 'Paz',
			'txtDniUser' => '87654321'
		])->assertRedirect('usuario/editar');
	}

	public function test_profile_form_uses_form_data_submit_event_and_no_navigation()
	{
		$script=file_get_contents(public_path('assets/frontoffice/viewResources/user/edit.js'));
		$view=file_get_contents(resource_path('views/frontoffice/user/edit.blade.php'));

		$this->assertStringContainsString("on('submit.ajaxCrud'", $script);
		$this->assertStringContainsString('event.preventDefault();', $script);
		$this->assertStringContainsString("ajaxCrudSubmitFormData('frmEditUserProfile'", $script);
		$this->assertStringContainsString("response.data.avatarUrl", $script);
		$this->assertStringContainsString("$('[data-user-avatar]').attr('src', response.data.avatarUrl);", $script);
		$this->assertStringContainsString("form.find('input[type=file]').val('');", $script);
		$this->assertStringContainsString('data-user-avatar', $view);
		$this->assertStringNotContainsString("confirmDialogSend('frmEditUserProfile')", $script);
		$this->assertStringNotContainsString('window.location', $script);
		$this->assertStringContainsString("filemtime(public_path('assets/frontoffice/viewResources/user/edit.js'))", $view);
	}

	private function ajaxPost(array $data)
	{
		return $this->withHeaders(['Accept' => 'application/json', 'X-Requested-With' => 'XMLHttpRequest'])->post('/usuario/editar', $data);
	}

	private function createMenuSchema()
	{
		Schema::create('ttypeexam', function (Blueprint $table) {
			$table->string('idTypeExam')->primary(); $table->string('acronymTypeExam')->nullable(); $table->string('nameTypeExam')->nullable(); $table->string('descriptionTypeExam')->nullable(); $table->string('extensionImageType')->nullable(); $table->timestamps();
		});
		Schema::create('tsubject', function (Blueprint $table) {
			$table->string('idSubject')->primary(); $table->string('nameSubject')->nullable(); $table->string('codeSubject')->nullable(); $table->timestamps();
		});
		Schema::create('tgrade', function (Blueprint $table) {
			$table->string('idGrade')->primary(); $table->string('nameGrade')->nullable(); $table->string('descriptionGrade')->nullable(); $table->string('codeGrade')->nullable(); $table->timestamps();
		});
		Schema::create('texam', function (Blueprint $table) {
			$table->string('idExam')->primary(); $table->string('idTypeExam')->nullable(); $table->string('idSubject')->nullable(); $table->string('idGrade')->nullable(); $table->string('stateExam')->nullable(); $table->timestamps();
		});
	}
}
