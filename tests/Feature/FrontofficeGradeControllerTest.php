<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class FrontofficeGradeControllerTest extends TestCase
{
	private $testStoragePath;

	protected function setUp(): void
	{
		parent::setUp();

		$this->withoutExceptionHandling();
		$this->withoutMiddleware();
		$this->useInMemoryDatabase();
		$this->registerSqliteFunctions();
		$this->useIsolatedStoragePath();
		$this->createSchema();
		$this->seedFixtures();
	}

	protected function tearDown(): void
	{
		if ($this->testStoragePath && is_dir($this->testStoragePath)) {
			File::deleteDirectory($this->testStoragePath);
		}

		parent::tearDown();
	}

	public function test_ajax_listing_returns_partial_without_full_shell()
	{
		$response = $this->withHeaders([
			'X-Requested-With' => 'XMLHttpRequest'
		])->get('/grado/all/listar?grade=grade-1');

		$response->assertOk();
		$response->assertViewIs('frontoffice.grade._list');
		$response->assertSeeText('Public Exam');
		$response->assertSeeText('Ver detalles');
		$response->assertDontSee('it-breadcrumb-area', false);
		$response->assertDontSee('assets/frontoffice/viewResources/grade/view.js', false);
	}

	public function test_legacy_grade_route_redirects_to_listar_preserving_query_string()
	{
		$response = $this->get('/grado/all/1?grade=grade-1&searchParameter=Public');

		$response->assertRedirect('/grado/all/listar?grade=grade-1&searchParameter=Public');
	}

	public function test_listing_script_restores_popstate_without_pushing_history()
	{
		$script = file_get_contents(public_path('assets/frontoffice/viewResources/grade/view.js'));

		$this->assertMatchesRegularExpression(
			'/\$\(window\)\.on\(\s*[\'\"]popstate[\'\"]\s*,\s*function\s*\(\s*\)\s*\{\s*restoreFiltersFromLocation\(\s*\)\s*;\s*loadExamList\(\s*window\.location\.href\s*,\s*false\s*\)\s*;/s',
			$script
		);
		$this->assertSame(1, preg_match(
			'/function\s+restoreFiltersFromLocation\s*\(\s*\)\s*\{(?<body>.*?)\n\}/s',
			$script,
			$restoreFunction
		));
		foreach (['searchParameter', 'type', 'grade', 'subject', 'year'] as $parameter) {
			$this->assertMatchesRegularExpression(
				'/parameters\.get\(\s*[\'\"]' . preg_quote($parameter, '/') . '[\'\"]\s*\)/',
				$restoreFunction['body']
			);
		}
		$this->assertStringContainsString('function loadExamList(url, updateHistory)', $script);
		$this->assertStringContainsString('if (updateHistory !== false) {', $script);
		$this->assertStringContainsString("window.history.pushState({}, '', url);", $script);
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
		$pdo = DB::connection()->getPdo();

		if (method_exists($pdo, 'sqliteCreateFunction')) {
			$pdo->sqliteCreateFunction('concat', function (...$values) {
				return implode('', array_map(function ($value) {
					return $value ?? '';
				}, $values));
			}, -1);

			$pdo->sqliteCreateFunction('compareFind', function ($haystack, $needle) {
				if ($needle === null || $needle === '') {
					return 1;
				}

				return stripos((string)$haystack, (string)$needle) !== false ? 1 : 0;
			}, 3);
		}
	}

	private function useIsolatedStoragePath()
	{
		$this->testStoragePath = '/tmp/opencode/appwebrepositorydrea-grade-tests-' . uniqid();
		$this->app->useStoragePath($this->testStoragePath);

		File::ensureDirectoryExists(storage_path('app/file/exam'));
	}

	private function createSchema()
	{
		Schema::create('ttypeexam', function (Blueprint $table) {
			$table->string('idTypeExam')->primary();
			$table->string('acronymTypeExam');
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
			$table->string('idTypeExam');
			$table->string('idGrade');
			$table->string('idSubject');
			$table->string('idDirection')->nullable();
			$table->string('codeExam')->nullable();
			$table->string('nameExam');
			$table->text('descriptionExam')->nullable();
			$table->string('yearExam')->nullable();
			$table->string('extensionExam');
			$table->integer('totalPageExam')->default(1);
			$table->string('stateExam');
			$table->timestamps();
		});

		Schema::create('tdirection', function (Blueprint $table) {
			$table->string('idDirection')->primary();
			$table->timestamps();
		});

		Schema::create('texamrating', function (Blueprint $table) {
			$table->string('idExamRating')->primary();
			$table->string('idExam');
			$table->integer('rating')->nullable();
			$table->timestamps();
		});

		Schema::create('tuserexam', function (Blueprint $table) {
			$table->string('idUserExam')->primary();
			$table->string('idExam');
			$table->string('idUser')->nullable();
			$table->string('typeFunctionExam')->nullable();
			$table->timestamps();
		});
	}

	private function seedFixtures()
	{
		DB::table('ttypeexam')->insert([
			'idTypeExam' => 'type-1',
			'acronymTypeExam' => 'eca',
			'nameTypeExam' => 'Evaluación continua',
			'updated_at' => now(),
			'created_at' => now(),
		]);

		DB::table('tgrade')->insert([
			'idGrade' => 'grade-1',
			'nameGrade' => 'Primero',
			'codeGrade' => 'grade-1',
			'descriptionGrade' => 'Primer grado',
			'updated_at' => now(),
			'created_at' => now(),
		]);

		DB::table('tsubject')->insert([
			'idSubject' => 'subject-1',
			'codeSubject' => 'subject-1',
			'nameSubject' => 'Matemática',
			'updated_at' => now(),
			'created_at' => now(),
		]);

		DB::table('texam')->insert([
			'idExam' => 'exam-public',
			'idTypeExam' => 'type-1',
			'idGrade' => 'grade-1',
			'idSubject' => 'subject-1',
			'codeExam' => 'PUB-001',
			'nameExam' => 'Public Exam',
			'descriptionExam' => 'Exam description',
			'yearExam' => '2024',
			'extensionExam' => 'pdf',
			'stateExam' => 'Publico',
			'totalPageExam' => 1,
			'updated_at' => now(),
			'created_at' => now(),
		]);

		file_put_contents(storage_path('app/file/exam/exam-public.pdf'), 'public exam');
	}
}
