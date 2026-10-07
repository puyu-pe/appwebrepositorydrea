<?php

namespace Tests\Feature\Backoffice;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SubjectAjaxCrudTest extends TestCase
{
	protected function setUp(): void
	{
		parent::setUp();

		$this->withoutMiddleware();
		$this->useInMemoryDatabase();
		$this->createSchema();
		$this->seedFixtures();
	}

	public function test_ajax_insert_returns_contract_and_creates_subject()
	{
		$response=$this->ajaxPost('/curso/insertar', [
			'txtNameSubject' => 'Comunicación',
			'txtCodeSubject' => 'COM'
		]);

		$response->assertOk()
			->assertJson([
				'success' => true,
				'type' => 'success',
				'messages' => ['Inserción realizada correctamente.']
			])
			->assertJsonStructure(['redirectUrl'])
			->assertJsonPath('redirectUrl', url('curso/listar/1'));

		$this->assertDatabaseHas('tsubject', [
			'nameSubject' => 'Comunicación',
			'codeSubject' => 'COM'
		]);
	}

	public function test_ajax_insert_validation_error_keeps_contract_without_creating_subject()
	{
		$response=$this->ajaxPost('/curso/insertar', [
			'txtNameSubject' => '',
			'txtCodeSubject' => ''
		]);

		$response->assertStatus(422)
			->assertJson([
				'success' => false,
				'type' => 'error',
				'messages' => [
					'El campo "nameSubject" es requerido.',
					'El campo "codeSubject" es requerido.'
				]
			])
			->assertJsonStructure(['redirectUrl'])
			->assertJsonPath('redirectUrl', url('curso/listar/1'));

		$this->assertDatabaseMissing('tsubject', [
			'codeSubject' => ''
		]);
	}

	public function test_ajax_delete_uses_post_contract_and_removes_subject()
	{
		$response=$this->ajaxPost('/curso/eliminar/subject-delete', []);

		$response->assertOk()
			->assertJson([
				'success' => true,
				'type' => 'success',
				'messages' => ['Operación realizada correctamente.']
			])
			->assertJsonStructure(['redirectUrl'])
			->assertJsonPath('redirectUrl', url('curso/listar/1'));

		$this->assertDatabaseMissing('tsubject', [
			'idSubject' => 'subject-delete'
		]);
	}

	public function test_legacy_mostrar_route_redirects_to_active_listar_route()
	{
		$this->get('/curso/mostrar/2?searchParameter=matematica')
			->assertRedirect('/curso/listar/2?searchParameter=matematica');
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

		Schema::create('tgrade', function (Blueprint $table) {
			$table->string('idGrade')->primary();
			$table->string('nameGrade')->nullable();
			$table->string('descriptionGrade')->nullable();
			$table->string('codeGrade')->nullable();
			$table->timestamps();
		});

		Schema::create('tsubject', function (Blueprint $table) {
			$table->string('idSubject')->primary();
			$table->string('nameSubject')->nullable();
			$table->string('codeSubject')->nullable();
			$table->timestamps();
		});

		Schema::create('texam', function (Blueprint $table) {
			$table->string('idExam')->primary();
			$table->string('idTypeExam')->nullable();
			$table->string('idGrade')->nullable();
			$table->string('idSubject')->nullable();
			$table->string('stateExam')->nullable();
			$table->timestamps();
		});
	}

	private function seedFixtures()
	{
		DB::table('tsubject')->insert([
			'idSubject' => 'subject-delete',
			'nameSubject' => 'Delete me',
			'codeSubject' => 'DEL',
			'updated_at' => now(),
			'created_at' => now()
		]);
	}
}
