<?php

namespace Tests\Feature\Backoffice;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DirectionAjaxCrudTest extends TestCase
{
	protected function setUp(): void
	{
		parent::setUp();

		$this->withoutMiddleware();
		$this->useInMemoryDatabase();
		$this->createSchema();
		$this->seedFixtures();
	}

	public function test_ajax_listar_returns_partial_list()
	{
		$response=$this->ajaxGet('/direccion/listar?searchParameter=DRE');

		$response->assertOk()
			->assertViewIs('backoffice.direction._list')
			->assertSee('DRE Lima');
	}

	public function test_ajax_insert_with_form_data_returns_contract_and_creates_direction()
	{
		$response=$this->ajaxPost('/direccion/insertar', [
			'txtNameComplete' => 'Dirección Regional de Educación Cusco',
			'txtNameSort' => 'DRE Cusco',
			'txtNameRegion' => 'Cusco',
			'fileLogoExtension' => UploadedFile::fake()->image('logo.png', 10, 10)
		]);

		$response->assertOk()
			->assertJson([
				'success' => true,
				'type' => 'success',
				'messages' => ['Operación realizada correctamente.']
			])
			->assertJsonStructure(['redirectUrl'])
			->assertJsonPath('redirectUrl', url('direccion/listar'));

		$this->assertDatabaseHas('tdirection', [
			'namecompleteDirection' => 'Dirección Regional de Educación Cusco',
			'namesortDirection' => 'DRE Cusco',
			'nameRegion' => 'Cusco',
			'logoExtension' => 'png'
		]);
	}

	public function test_ajax_delete_uses_post_contract_and_removes_direction()
	{
		$response=$this->ajaxPost('/direccion/eliminar/direction-delete', []);

		$response->assertOk()
			->assertJson([
				'success' => true,
				'type' => 'success',
				'messages' => ['Operación realizada correctamente.']
			])
			->assertJsonStructure(['redirectUrl'])
			->assertJsonPath('redirectUrl', url('direccion/listar'));

		$this->assertDatabaseMissing('tdirection', [
			'idDirection' => 'direction-delete'
		]);
	}

	public function test_legacy_mostrar_route_redirects_to_active_listar_route()
	{
		$this->get('/direccion/mostrar/2?searchParameter=lima')
			->assertRedirect('/direccion/listar/2?searchParameter=lima');

		$this->get('/direccion/mostrar/1?searchParameter=lima')
			->assertRedirect('/direccion/listar?searchParameter=lima');
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
		Schema::create('tdirection', function (Blueprint $table) {
			$table->string('idDirection')->primary();
			$table->string('namecompleteDirection')->nullable();
			$table->string('namesortDirection')->nullable();
			$table->string('nameRegion')->nullable();
			$table->string('logoExtension')->nullable();
			$table->timestamps();
		});

		Schema::create('texam', function (Blueprint $table) {
			$table->string('idExam')->primary();
			$table->string('idTypeExam')->nullable();
			$table->string('idSubject')->nullable();
			$table->string('idGrade')->nullable();
			$table->string('idDirection')->nullable();
			$table->string('stateExam')->nullable();
			$table->timestamps();
		});

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
	}

	private function seedFixtures()
	{
		DB::table('tdirection')->insert([
			'idDirection' => 'direction-delete',
			'namecompleteDirection' => 'DRE Lima',
			'namesortDirection' => 'DRE Lima',
			'nameRegion' => 'Lima',
			'logoExtension' => '',
			'updated_at' => now(),
			'created_at' => now()
		]);
	}
}
