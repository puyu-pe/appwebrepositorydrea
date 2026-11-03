<?php

namespace Tests\Feature\Backoffice;

use Illuminate\Http\UploadedFile;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ExamFormDataAjaxTest extends TestCase
{
	protected function setUp(): void
	{
		parent::setUp();

		$this->withoutExceptionHandling();
		$this->withoutMiddleware();
		$this->useInMemoryDatabase();
		$this->createMenuSchema();
	}

	protected function tearDown(): void
	{
		$_POST=[];

		parent::tearDown();
	}

	public function test_ajax_form_data_insert_validation_returns_json_contract_for_same_form()
	{
		$_POST=['_token' => 'test-token'];

		$response=$this->withSession([
			'roleUser' => 'Administrador',
			'idUser' => 'user-1'
		])->withHeaders([
			'Accept' => 'application/json',
			'X-Requested-With' => 'XMLHttpRequest'
		])->post('/examen/insertar', [
			'_token' => csrf_token(),
			'fileExamExtension' => UploadedFile::fake()->create('exam.pdf', 1, 'application/pdf')
		]);

		$response->assertStatus(422)
			->assertJsonPath('success', false)
			->assertJsonPath('type', 'error')
			->assertJsonPath('redirectUrl', url('examen/insertar'))
			->assertJsonStructure([
				'success',
				'type',
				'messages',
				'redirectUrl'
			]);
	}

	public function test_exam_insert_ajax_success_handler_resets_form_without_navigation_or_list_reload()
	{
		$script=file_get_contents(public_path('assets/backoffice/viewResources/exam/insert.js'));

		$this->assertStringContainsString("onSuccess: function(response, form)", $script);
		$this->assertStringContainsString('resetInsertExamForm(form);', $script);
		$this->assertStringContainsString("form[0].reset();", $script);
		$this->assertStringContainsString("form.data('formValidation').resetForm(true);", $script);
		$this->assertStringContainsString("$('#tblResponseExam > tbody').empty();", $script);
		$this->assertStringNotContainsString("ajaxContainerId: 'divAjaxCrudList'", $script);
		$this->assertStringNotContainsString('window.location', $script);
	}

	private function useInMemoryDatabase()
	{
		Config::set('database.default', 'sqlite');
		Config::set('database.connections.sqlite.database', ':memory:');

		DB::purge('sqlite');
		DB::reconnect('sqlite');
	}

	private function createMenuSchema()
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
			$table->string('codeExam')->nullable();
			$table->string('nameExam')->nullable();
			$table->text('descriptionExam')->nullable();
			$table->integer('totalPageExam')->nullable();
			$table->string('yearExam')->nullable();
			$table->string('keywordExam')->nullable();
			$table->string('stateExam')->nullable();
			$table->string('number_question')->nullable();
			$table->string('numberEvaluation')->nullable();
			$table->string('register_answer')->nullable();
			$table->timestamps();
		});
	}
}
