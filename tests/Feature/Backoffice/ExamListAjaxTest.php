<?php

namespace Tests\Feature\Backoffice;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ExamListAjaxTest extends TestCase
{
	protected function setUp(): void
	{
		parent::setUp();

		$this->withoutExceptionHandling();
		$this->withoutMiddleware();
		$this->useInMemoryDatabase();
		$this->registerSqliteFunctions();
		$this->createSchema();
		$this->seedFixtures();
	}

	public function test_ajax_listar_returns_partial_exam_list_without_layout()
	{
		$response=$this->ajaxGet('/examen/listar?searchParameter=matematica');

		$response->assertOk()
			->assertSee('Evaluación Matemática 2024')
			->assertSee('examen/listar', false)
			->assertDontSee('Evaluación Comunicación 2024')
			->assertDontSee('ajaxCrudBindPagination')
			->assertDontSee('@extends')
			->assertDontSee('assets/backoffice/viewResources/exam/getall.js');
	}

	public function test_exam_list_preview_uses_updated_at_cache_version()
	{
		$this->ajaxGet('/examen/listar')
			->assertOk()
			->assertSee('storage/exam-img/exam-math.jpg?x=', false);
	}

	public function test_legacy_mostrar_route_redirects_to_active_listar_route()
	{
		$this->get('/examen/mostrar/2?searchParameter=matematica')
			->assertRedirect('/examen/listar/2?searchParameter=matematica');

		$this->get('/examen/mostrar/1?searchParameter=matematica')
			->assertRedirect('/examen/listar?searchParameter=matematica');
	}

	public function test_ajax_change_state_returns_json_contract_for_exam_list_reload()
	{
		$response=$this->ajaxPost('/examen/estado/exam-communication');

		$response->assertOk()
			->assertJsonPath('success', true)
			->assertJsonPath('type', 'success')
			->assertJsonPath('messages', ['Operación realizada correctamente.'])
			->assertJsonPath('redirectUrl', url('examen/listar'));

		$this->assertSame('Publico', DB::table('texam')->where('idExam', 'exam-communication')->value('stateExam'));
	}

	public function test_exam_mutations_reject_get_requests()
	{
		$this->withExceptionHandling();

		$this->get('/examen/estado/exam-communication')->assertStatus(405);
		$this->get('/examen/eliminar/exam-communication')->assertStatus(405);

		$this->assertSame('Oculto', DB::table('texam')->where('idExam', 'exam-communication')->value('stateExam'));
		$this->assertDatabaseHas('texam', ['idExam' => 'exam-communication']);
	}

	public function test_ajax_delete_removes_hidden_exam_with_json_contract()
	{
		$response=$this->ajaxPost('/examen/eliminar/exam-communication');

		$response->assertOk()
			->assertJsonPath('success', true)
			->assertJsonPath('type', 'success')
			->assertJsonPath('messages', ['Operación realizada correctamente.'])
			->assertJsonPath('redirectUrl', url('examen/listar'));

		$this->assertDatabaseMissing('texam', ['idExam' => 'exam-communication']);
	}

	private function ajaxGet($uri)
	{
		return $this->withSession(['roleUser' => 'Administrador'])->withHeaders([
			'Accept' => 'application/json',
			'X-Requested-With' => 'XMLHttpRequest'
		])->get($uri);
	}

	private function ajaxPost($uri)
	{
		return $this->withSession(['roleUser' => 'Administrador'])->withHeaders([
			'Accept' => 'application/json',
			'X-Requested-With' => 'XMLHttpRequest'
		])->post($uri, ['_token' => csrf_token()]);
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
			$table->string('codeExam')->nullable();
			$table->string('nameExam')->nullable();
			$table->string('descriptionExam')->nullable();
			$table->integer('totalPageExam')->nullable();
			$table->string('yearExam')->nullable();
			$table->string('keywordExam')->nullable();
			$table->string('stateExam')->nullable();
			$table->string('number_question')->nullable();
			$table->string('numberEvaluation')->nullable();
			$table->string('register_answer')->nullable();
			$table->string('extensionExam')->nullable();
			$table->timestamps();
		});

		Schema::create('tresource', function (Blueprint $table) {
			$table->string('idResource')->primary();
			$table->string('idExam')->nullable();
			$table->string('extension')->nullable();
			$table->timestamps();
		});
	}

	private function seedFixtures()
	{
		DB::table('ttypeexam')->insert([
			'idTypeExam' => 'type-eca',
			'acronymTypeExam' => 'ECA',
			'nameTypeExam' => 'Evaluación censal',
			'updated_at' => now(),
			'created_at' => now()
		]);

		DB::table('tsubject')->insert([
			'idSubject' => 'subject-math',
			'nameSubject' => 'Matemática',
			'codeSubject' => 'matematica',
			'updated_at' => now(),
			'created_at' => now()
		]);

		DB::table('tgrade')->insert([
			'idGrade' => 'grade-1',
			'nameGrade' => 'Primero',
			'descriptionGrade' => 'Primer grado',
			'codeGrade' => 'primero',
			'updated_at' => now(),
			'created_at' => now()
		]);

		DB::table('texam')->insert([
			[
				'idExam' => 'exam-math',
				'idTypeExam' => 'type-eca',
				'idSubject' => 'subject-math',
				'idGrade' => 'grade-1',
				'codeExam' => 'E-001',
				'nameExam' => 'Evaluación Matemática 2024',
				'descriptionExam' => 'matematica base',
				'totalPageExam' => 12,
				'yearExam' => '2024',
				'keywordExam' => 'matematica__7SEPARATOR7__primaria',
				'stateExam' => 'Publico',
				'number_question' => '2',
				'numberEvaluation' => '1',
				'register_answer' => '1',
				'extensionExam' => '',
				'updated_at' => now(),
				'created_at' => now()
			],
			[
				'idExam' => 'exam-communication',
				'idTypeExam' => 'type-eca',
				'idSubject' => 'subject-math',
				'idGrade' => 'grade-1',
				'codeExam' => 'E-002',
				'nameExam' => 'Evaluación Comunicación 2024',
				'descriptionExam' => 'comunicacion base',
				'totalPageExam' => 10,
				'yearExam' => '2024',
				'keywordExam' => 'comunicacion',
				'stateExam' => 'Oculto',
				'number_question' => '0',
				'numberEvaluation' => '1',
				'register_answer' => '0',
				'extensionExam' => '',
				'updated_at' => now(),
				'created_at' => now()->subDay()
			]
		]);
	}
}
