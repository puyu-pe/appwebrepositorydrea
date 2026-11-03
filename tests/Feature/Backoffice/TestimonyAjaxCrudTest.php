<?php

namespace Tests\Feature\Backoffice;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class TestimonyAjaxCrudTest extends TestCase
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
		$response=$this->ajaxGet('/testimonio/listar?searchParameter=Ana');

		$response->assertOk()
			->assertSee('Ana Torres')
			->assertSee('ajaxCrudDelete', false)
			->assertDontSee('@extends')
			->assertDontSee('assets/backoffice/viewResources/testimony/getall.js');
	}

	public function test_ajax_change_state_returns_json_contract()
	{
		$response=$this->ajaxPost('/testimonio/estado/testimony-hidden', []);

		$response->assertOk()
			->assertJson([
				'success' => true,
				'type' => 'success',
				'messages' => ['Operación realizada correctamente.']
			])
			->assertJsonStructure(['redirectUrl'])
			->assertJsonPath('redirectUrl', url('testimonio/listar'));

		$this->assertDatabaseHas('ttestimony', [
			'idTestimony' => 'testimony-hidden',
			'is_public' => 1
		]);
	}

	public function test_legacy_mostrar_route_redirects_to_active_listar_route()
	{
		$this->get('/testimonio/mostrar/2?searchParameter=Ana')
			->assertRedirect('/testimonio/listar/2?searchParameter=Ana');

		$this->get('/testimonio/mostrar/1?searchParameter=Ana')
			->assertRedirect('/testimonio/listar?searchParameter=Ana');
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

		Schema::create('ttestimony', function (Blueprint $table) {
			$table->string('idTestimony')->primary();
			$table->text('description')->nullable();
			$table->string('firstName')->nullable();
			$table->string('surName')->nullable();
			$table->string('academic_level')->nullable();
			$table->string('place_origin')->nullable();
			$table->integer('is_public')->default(0);
			$table->timestamps();
		});
	}

	private function seedFixtures()
	{
		DB::table('ttestimony')->insert([
			'idTestimony' => 'testimony-hidden',
			'description' => 'Great repository',
			'firstName' => 'Ana',
			'surName' => 'Torres',
			'academic_level' => 'Secundaria',
			'place_origin' => 'Lima',
			'is_public' => 0,
			'updated_at' => now(),
			'created_at' => now()
		]);
	}
}
