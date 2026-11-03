<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class FrontofficeAnswerAjaxTest extends TestCase
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
	}

	public function test_ajax_register_returns_json_and_validation_does_not_store_partial_answers()
	{
		$invalid=$this->ajaxPost([
			'hdIdExam' => 'exam-1',
			'txtFirstName' => '',
			'txtSurName' => 'Quispe',
			'txtNumberDni' => '12345678',
			'txtValueResponseExam' => ['A'],
			'hdIdAnswerDetail' => ['']
		]);

		$invalid->assertStatus(422)
			->assertJsonPath('success', false)
			->assertJsonPath('type', 'error')
			->assertJsonStructure(['messages', 'redirectUrl']);
		$this->assertDatabaseCount('tanswer', 0);
		$this->assertDatabaseCount('tanswerdetail', 0);

		$success=$this->ajaxPost([
			'hdIdExam' => 'exam-1',
			'txtFirstName' => 'Ana',
			'txtSurName' => 'Quispe',
			'txtNumberDni' => '12345678',
			'txtValueResponseExam' => ['A'],
			'hdIdAnswerDetail' => ['']
		]);

		$success->assertOk()
			->assertJson([
				'success' => true,
				'type' => 'success',
				'messages' => ['Inserción realizada correctamente.']
			])
			->assertJsonStructure(['redirectUrl']);
		$this->assertDatabaseCount('tanswer', 1);
		$this->assertDatabaseCount('tanswerdetail', 1);
	}

	public function test_non_ajax_register_preserves_redirect_response()
	{
		$response=$this->withHeader('Referer', url('examen/ver/exam-1'))->post('/respuesta/registrar', [
			'hdIdExam' => 'exam-1',
			'txtFirstName' => 'Ana',
			'txtSurName' => 'Quispe',
			'txtNumberDni' => '12345678',
			'txtValueResponseExam' => ['A'],
			'hdIdAnswerDetail' => ['']
		]);

		$response->assertRedirect(url('examen/ver/exam-1'));
	}

	public function test_answer_form_uses_submit_event_ajax_and_stays_on_current_context()
	{
		$script=file_get_contents(public_path('assets/frontoffice/viewResources/answer/insert.js'));
		$view=file_get_contents(resource_path('views/frontoffice/answer/register.blade.php'));

		$this->assertStringContainsString("on('submit.ajaxCrud'", $script);
		$this->assertStringContainsString('event.preventDefault();', $script);
		$this->assertStringContainsString("ajaxCrudSubmitForm('frmInsertAnswer'", $script);
		$this->assertStringContainsString("form.closest('.modal').modal('hide');", $script);
		$this->assertStringNotContainsString('confirmDialogSend', $script);
		$this->assertStringNotContainsString('window.location', $script);
		$this->assertStringContainsString("filemtime(public_path('assets/frontoffice/viewResources/answer/insert.js'))", $view);
	}

	private function ajaxPost(array $data)
	{
		return $this->withHeaders([
			'Accept' => 'application/json',
			'X-Requested-With' => 'XMLHttpRequest',
			'Referer' => url('examen/ver/exam-1')
		])->post('/respuesta/registrar', $data);
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
		Schema::create('tanswer', function (Blueprint $table) {
			$table->string('idAnswer')->primary();
			$table->string('idExam');
			$table->string('idUser')->nullable();
			$table->string('firstName')->nullable();
			$table->string('surName')->nullable();
			$table->string('dni')->nullable();
			$table->string('type');
			$table->timestamps();
		});
		Schema::create('tanswerdetail', function (Blueprint $table) {
			$table->string('idAnswerDetail')->primary();
			$table->string('idAnswer');
			$table->integer('numberAnswer');
			$table->text('descriptionAnswer')->nullable();
			$table->boolean('is_correct')->nullable();
			$table->timestamps();
		});
		DB::table('texam')->insert(['idExam' => 'exam-1', 'stateExam' => 'Oculto', 'created_at' => now(), 'updated_at' => now()]);
	}
}
