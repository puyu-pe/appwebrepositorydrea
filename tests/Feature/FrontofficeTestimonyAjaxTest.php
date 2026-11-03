<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class FrontofficeTestimonyAjaxTest extends TestCase
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
		Schema::create('ttestimony', function (Blueprint $table) {
			$table->string('idTestimony')->primary();
			$table->text('description');
			$table->string('firstName');
			$table->string('surName');
			$table->string('academic_level')->nullable();
			$table->string('place_origin');
			$table->boolean('is_public');
			$table->timestamps();
		});
	}

	public function test_ajax_testimony_returns_json_and_validation_does_not_store_data()
	{
		$invalid=$this->ajaxPost(['txtfirstName' => '', 'txtsurName' => 'Quispe', 'txtAcademicLevel' => '', 'txtPlaceOrigin' => 'Abancay', 'txtDescription' => 'Excelente']);
		$invalid->assertStatus(422)->assertJsonPath('success', false)->assertJsonPath('type', 'error');
		$this->assertDatabaseCount('ttestimony', 0);

		$success=$this->ajaxPost(['txtfirstName' => 'Ana', 'txtsurName' => 'Quispe', 'txtAcademicLevel' => '', 'txtPlaceOrigin' => 'Abancay', 'txtDescription' => 'Excelente']);
		$success->assertOk()
			->assertJson(['success' => true, 'type' => 'success', 'messages' => ['Operación realizada correctamente.']])
			->assertJsonStructure(['redirectUrl']);
		$this->assertDatabaseCount('ttestimony', 1);
	}

	public function test_non_ajax_testimony_preserves_redirect_response()
	{
		$this->withHeader('Referer', url('general/testimonio'))->post('/general/testimonio', [
			'txtfirstName' => 'Ana', 'txtsurName' => 'Quispe', 'txtAcademicLevel' => '', 'txtPlaceOrigin' => 'Abancay', 'txtDescription' => 'Excelente'
		])->assertRedirect(url('general/testimonio'));
	}

	public function test_testimony_form_uses_ajax_submit_without_navigation_and_clears_on_success()
	{
		$script=file_get_contents(public_path('assets/frontoffice/viewResources/testimony/insert.js'));
		$view=file_get_contents(resource_path('views/frontoffice/testimony/insert.blade.php'));

		$this->assertStringContainsString("on('submit.ajaxCrud'", $script);
		$this->assertStringContainsString('event.preventDefault();', $script);
		$this->assertStringContainsString("ajaxCrudSubmitForm('frmTestimony'", $script);
		$this->assertStringContainsString('form[0].reset();', $script);
		$this->assertStringNotContainsString('confirmDialogSend', $script);
		$this->assertStringNotContainsString('window.location', $script);
		$this->assertStringContainsString("filemtime(public_path('assets/frontoffice/viewResources/testimony/insert.js'))", $view);
	}

	private function ajaxPost(array $data)
	{
		return $this->withHeaders(['Accept' => 'application/json', 'X-Requested-With' => 'XMLHttpRequest', 'Referer' => url('general/testimonio')])->post('/general/testimonio', $data);
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
