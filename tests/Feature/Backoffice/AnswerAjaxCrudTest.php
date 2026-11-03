<?php

namespace Tests\Feature\Backoffice;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AnswerAjaxCrudTest extends TestCase
{
	protected function setUp(): void
	{
		parent::setUp();

		$this->withoutExceptionHandling();
		$this->withoutMiddleware();
		$this->useInMemoryDatabase();
		$this->createSchema();
		$this->seedFixtures();
	}

	public function test_ajax_insert_returns_json_contract_and_creates_answer_details()
	{
		$response=$this->ajaxPost('/respuesta/insertar', [
			'hdIdExam' => 'exam-1',
			'hdIdAnswer' => '',
			'hdIdAnswerDetail' => ['', ''],
			'txtValueResponseExam' => ['A', 'B']
		]);

		$response->assertOk()
			->assertJson([
				'success' => true,
				'type' => 'success',
				'messages' => ['Inserción realizada correctamente.']
			])
			->assertJsonStructure(['redirectUrl'])
			->assertJsonPath('redirectUrl', url('examen/mostrar/1'));

		$this->assertDatabaseHas('tanswer', [
			'idExam' => 'exam-1',
			'idUser' => 'user-1',
			'type' => 'correct'
		]);

		$this->assertDatabaseHas('tanswerdetail', [
			'numberAnswer' => 1,
			'descriptionAnswer' => 'A'
		]);

		$this->assertDatabaseHas('tanswerdetail', [
			'numberAnswer' => 2,
			'descriptionAnswer' => 'B'
		]);
	}

	public function test_answer_ajax_success_closes_modal_and_refreshes_current_exam_list_without_navigation()
	{
		$script=file_get_contents(public_path('assets/backoffice/viewResources/answer/insert.js'));

		$this->assertStringContainsString('onSuccess: function(response, form)', $script);
		$this->assertStringContainsString("form.closest('.modal').modal('hide');", $script);
		$this->assertStringContainsString('window.codideepBackofficeListUrl', $script);
		$this->assertStringContainsString('ajaxCrudLoadList(', $script);
		$this->assertStringNotContainsString('window.location', $script);
	}

	public function test_answer_insert_rejects_get_requests()
	{
		$this->withExceptionHandling();

		$this->get('/respuesta/insertar')->assertStatus(405);
		$this->assertDatabaseCount('tanswer', 0);
		$this->assertDatabaseCount('tanswerdetail', 0);
	}

	private function ajaxPost($uri, array $data)
	{
		$_POST=$data;

		return $this->withSession([
			'idUser' => 'user-1'
		])->withHeaders([
			'Accept' => 'application/json',
			'X-Requested-With' => 'XMLHttpRequest',
			'Referer' => url('examen/mostrar/1')
		])->post($uri, $data);
	}

	private function useInMemoryDatabase()
	{
		Config::set('database.default', 'sqlite');
		Config::set('database.connections.sqlite.database', ':memory:');

		DB::purge('sqlite');
		DB::reconnect('sqlite');
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
			$table->string('number_question')->nullable();
			$table->string('keyTypeAnswer')->nullable();
			$table->timestamps();
		});

		Schema::create('tanswer', function (Blueprint $table) {
			$table->string('idAnswer')->primary();
			$table->string('idExam')->nullable();
			$table->string('idUser')->nullable();
			$table->string('type')->nullable();
			$table->timestamps();
		});

		Schema::create('tanswerdetail', function (Blueprint $table) {
			$table->string('idAnswerDetail')->primary();
			$table->string('idAnswer')->nullable();
			$table->integer('numberAnswer')->nullable();
			$table->text('descriptionAnswer')->nullable();
			$table->boolean('is_correct')->nullable();
			$table->timestamps();
		});
	}

	private function seedFixtures()
	{
		DB::table('texam')->insert([
			'idExam' => 'exam-1',
			'idTypeExam' => null,
			'idSubject' => null,
			'idGrade' => null,
			'stateExam' => 'Oculto',
			'number_question' => '2',
			'keyTypeAnswer' => '',
			'updated_at' => now(),
			'created_at' => now()
		]);
	}
}
