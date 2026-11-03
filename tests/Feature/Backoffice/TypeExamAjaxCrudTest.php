<?php

namespace Tests\Feature\Backoffice;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class TypeExamAjaxCrudTest extends TestCase
{
	protected function setUp(): void
	{
		parent::setUp();

		$this->withoutMiddleware();
		$this->useInMemoryDatabase();
		$this->createSchema();
		$this->seedFixtures();
	}

	public function test_ajax_delete_validation_error_uses_listar_redirect_contract()
	{
		$response=$this->ajaxGet('/tipoexamen/eliminar/type-in-use');

		$response->assertStatus(422)
			->assertJson([
				'success' => false,
				'type' => 'error',
				'messages' => [
					'No puede eliminar este registro, ya existe evaluaciones que utilizan esta denominación.'
				]
			])
			->assertJsonStructure(['redirectUrl'])
			->assertJsonPath('redirectUrl', url('tipoexamen/listar'));
	}

	public function test_ajax_listar_returns_partial_list()
	{
		$response=$this->ajaxGet('/tipoexamen/listar?searchParameter=In');

		$response->assertOk()
			->assertViewIs('backoffice.typeexam._list')
			->assertSee('In use');
	}

	public function test_ajax_insert_with_form_data_returns_contract_and_creates_type_exam()
	{
		$response=$this->ajaxPost('/tipoexamen/insertar', [
			'txtNameTypeExam' => 'Evaluación censal',
			'txtAcronymTypeExam' => 'ECE',
			'txtDescriptionTypeExam' => 'Evaluación anual',
			'numberExecute' => 1,
			'fileTypeExamLogo' => UploadedFile::fake()->image('logo.png', 10, 10)
		]);

		$response->assertOk()
			->assertJson([
				'success' => true,
				'type' => 'success',
				'messages' => ['Inserción realizada correctamente.']
			])
			->assertJsonStructure(['redirectUrl'])
			->assertJsonPath('redirectUrl', url('tipoexamen/listar'));

		$this->assertDatabaseHas('ttypeexam', [
			'nameTypeExam' => 'Evaluación censal',
			'acronymTypeExam' => 'ECE',
			'descriptionTypeExam' => 'Evaluación anual',
			'extensionImageType' => 'png',
			'numberExecuteYear' => 1
		]);
	}

	public function test_legacy_mostrar_route_redirects_to_active_listar_route()
	{
		$this->get('/tipoexamen/mostrar/2?searchParameter=admision')
			->assertRedirect('/tipoexamen/listar/2?searchParameter=admision');

		$this->get('/tipoexamen/mostrar/1?searchParameter=admision')
			->assertRedirect('/tipoexamen/listar?searchParameter=admision');
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
		DB::connection()->getPdo()->sqliteCreateFunction('compareFind', function ($haystack, $needle) {
			return stripos((string) $haystack, (string) $needle) !== false ? 1 : 0;
		}, 3);
		DB::connection()->getPdo()->sqliteCreateFunction('concat', function (...$values) {
			return implode('', array_map('strval', $values));
		}, -1);
	}

	private function createSchema()
	{
		Schema::create('ttypeexam', function (Blueprint $table) {
			$table->string('idTypeExam')->primary();
			$table->string('acronymTypeExam')->nullable();
			$table->string('nameTypeExam')->nullable();
			$table->string('descriptionTypeExam')->nullable();
			$table->string('extensionImageType')->nullable();
			$table->integer('numberExecuteYear')->nullable();
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
	}

	private function seedFixtures()
	{
		DB::table('ttypeexam')->insert([
			'idTypeExam' => 'type-in-use',
			'nameTypeExam' => 'In use',
			'acronymTypeExam' => 'IU',
			'descriptionTypeExam' => 'Type exam in use',
			'extensionImageType' => 'png',
			'numberExecuteYear' => 1,
			'updated_at' => now(),
			'created_at' => now()
		]);

		DB::table('texam')->insert([
			'idExam' => 'exam-uses-type',
			'idTypeExam' => 'type-in-use',
			'stateExam' => 'Publico',
			'updated_at' => now(),
			'created_at' => now()
		]);
	}
}
