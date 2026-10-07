<?php

namespace Tests\Feature\Backoffice;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class GradeAjaxCrudTest extends TestCase
{
	protected function setUp(): void
	{
		parent::setUp();

		$this->withoutMiddleware();
		$this->useInMemoryDatabase();
		$this->createSchema();
		$this->seedFixtures();
	}

	public function test_ajax_insert_returns_contract_and_creates_grade()
	{
		$response=$this->ajaxPost('/grado/insertar', [
			'txtDescriptionGrade' => 'Primer grado',
			'selectNameGrade' => 'Primaria',
			'txtCodeGrade' => 'PRI-1'
		]);

		$response->assertOk()
			->assertJson([
				'success' => true,
				'type' => 'success',
				'messages' => ['Inserción realizada correctamente.']
			])
			->assertJsonStructure(['redirectUrl'])
			->assertJsonPath('redirectUrl', url('grado/listar/1'));

		$this->assertDatabaseHas('tgrade', [
			'descriptionGrade' => 'Primer grado',
			'nameGrade' => 'Primaria',
			'codeGrade' => 'PRI-1'
		]);
	}

	public function test_ajax_insert_validation_error_keeps_contract_without_creating_grade()
	{
		$response=$this->ajaxPost('/grado/insertar', [
			'txtDescriptionGrade' => '',
			'selectNameGrade' => '',
			'txtCodeGrade' => ''
		]);

		$response->assertStatus(422)
			->assertJson([
				'success' => false,
				'type' => 'error',
				'messages' => [
					'El campo "nameGrade" es requerido.',
					'El campo "descriptionGrade" es requerido.',
					'El campo "codeGrade" es requerido.'
				]
			])
			->assertJsonStructure(['redirectUrl'])
			->assertJsonPath('redirectUrl', url('grado/listar/1'));

		$this->assertDatabaseMissing('tgrade', [
			'codeGrade' => ''
		]);
	}

	public function test_ajax_delete_uses_post_contract_and_removes_grade()
	{
		$response=$this->ajaxPost('/grado/eliminar/grade-delete', []);

		$response->assertOk()
			->assertJson([
				'success' => true,
				'type' => 'success',
				'messages' => ['Operación realizada correctamente.']
			])
			->assertJsonStructure(['redirectUrl'])
			->assertJsonPath('redirectUrl', url('grado/listar/1'));

		$this->assertDatabaseMissing('tgrade', [
			'idGrade' => 'grade-delete'
		]);
	}

	public function test_legacy_mostrar_route_redirects_to_active_listar_route()
	{
		$this->get('/grado/mostrar/2?searchParameter=primaria')
			->assertRedirect('/grado/listar/2?searchParameter=primaria');
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
		DB::table('tgrade')->insert([
			'idGrade' => 'grade-delete',
			'nameGrade' => 'Primaria',
			'descriptionGrade' => 'Delete me',
			'codeGrade' => 'DEL',
			'updated_at' => now(),
			'created_at' => now()
		]);
	}
}
