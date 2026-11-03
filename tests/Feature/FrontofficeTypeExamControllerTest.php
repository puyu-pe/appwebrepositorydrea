<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class FrontofficeTypeExamControllerTest extends TestCase
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

	public function test_invalid_type_filter_returns_empty_results_without_falling_back_to_all()
	{
		$response = $this->get('/tipoexamen/all/listar?type=missing-type');

		$response->assertOk();
		$response->assertViewHas('tTypeExam', null);
		$response->assertViewHas('filtersData', function ($filtersData) {
			return $filtersData->type === 'missing-type';
		});
		$response->assertViewHas('listTExam', function ($listTExam) {
			return $listTExam->count() === 0;
		});
		$response->assertSee('value="missing-type" selected', false);
		$response->assertDontSee('value="all" selected', false);
		$response->assertSeeText('Tipo no válido');
	}

	public function test_legacy_type_exam_id_filter_remains_supported()
	{
		$response = $this->get('/tipoexamen/all/listar?type=type-1');

		$response->assertOk();
		$response->assertViewHas('filtersData', function ($filtersData) {
			return $filtersData->type === 'eca';
		});
		$response->assertViewHas('listTExam', function ($listTExam) {
			return $listTExam->pluck('idExam')->all() === ['exam-public'];
		});
	}

	public function test_ajax_listing_returns_partial_without_full_shell()
	{
		$response = $this->withHeaders([
			'X-Requested-With' => 'XMLHttpRequest'
		])->get('/tipoexamen/all/listar?type=type-1');

		$response->assertOk();
		$response->assertViewIs('frontoffice.typeexam._list');
		$response->assertSeeText('Public Exam');
		$response->assertSeeText('Ver detalles');
		$response->assertSee('button type="button" id="downloadBtn"', false);
		$response->assertSee('aria-busy="false"', false);
		$response->assertSee('aria-hidden="true"', false);
		$response->assertSee('<span class="download-label">Descargar archivos</span>', false);
		$this->assertSelectionCheckboxMarkup($response->getContent());
		$response->assertDontSee('it-breadcrumb-area', false);
		$response->assertDontSee('assets/frontoffice/viewResources/typeexam/view.js', false);
	}

	public function test_public_evaluation_lists_omit_page_count_column()
	{
		$routes = [
			'/tipoexamen/all/listar?type=type-1',
			'/curso/all/listar?subject=subject-1',
			'/grado/all/listar?grade=grade-1',
		];

		foreach ($routes as $route) {
			$response = $this->withHeaders([
				'X-Requested-With' => 'XMLHttpRequest'
			])->get($route);

			$response->assertOk();
			$content = $response->getContent();
			$this->assertStringNotContainsString('<th>Páginas</th>', $content);
			$this->assertStringNotContainsString('1 páginas', $content);
			$this->assertSame(1, preg_match('/<tr>(?<row>(?:(?!<\/tr>).)*<th(?:(?!<\/tr>).)*)<\/tr>/s', $content, $headerRow));
			$this->assertSame(7, substr_count($headerRow['row'], '<th'));
			$this->assertSame(1, preg_match('/<tr>(?<row>(?:(?!<\/tr>).)*Public Exam(?:(?!<\/tr>).)*)<\/tr>/s', $content, $examRow));
			$this->assertSame(7, substr_count($examRow['row'], '<td'));

			$emptyResponse = $this->withHeaders([
				'X-Requested-With' => 'XMLHttpRequest'
			])->get($route . '&searchParameter=MissingExam');

			$emptyResponse->assertOk();
			$emptyResponse->assertSee('colspan="7"', false);
		}
	}

	public function test_public_evaluation_views_share_responsive_layout_contract()
	{
		$variants = [
			['/tipoexamen/all/listar', 'btnSearchType'],
			['/curso/all/listar', 'btnSearchSubject'],
			['/grado/all/listar', 'btnSearchGrade'],
		];

		foreach ($variants as [$route, $searchButtonId]) {
			$response = $this->get($route);

			$response->assertOk();
			$content = $response->getContent();
			$this->assertSingleElementHasClasses($content, 'div', ['row', 'evaluation-search-row']);
			$this->assertElementByAttributeHasClasses($content, 'div', 'id', 'divSearch', ['col-12', 'col-md-10', 'evaluation-search-field']);
			$this->assertSingleElementHasClasses($content, 'div', ['col-12', 'col-md-2', 'evaluation-search-action']);
			$this->assertElementByAttributeHasClasses($content, 'button', 'id', $searchButtonId, []);
			$this->assertSingleElementHasClasses($content, 'div', ['row', 'evaluation-filter-row']);
			$this->assertSame(4, count($this->openingTagsWithClass($content, 'div', 'evaluation-filter')));
			$this->assertElementByAttributeHasClasses($content, 'div', 'id', 'divAjaxExamList', []);
			$this->assertSingleElementHasClasses($content, 'div', ['table-responsive', 'evaluation-table-scroll']);
			$this->assertSingleElementHasClasses($content, 'table', ['table', 'evaluation-results-table']);
			$this->assertSame([], $this->openingTagsWithClasses($content, 'table', ['table', 'table-responsive']));
			$this->assertSingleElementHasClasses($content, 'div', ['row', 'evaluation-results-actions']);
			$this->assertSingleElementHasClasses($content, 'div', ['col-12', 'col-md-4', 'evaluation-download-action']);
			$this->assertElementByAttributeHasClasses($content, 'input', 'id', 'downloadUrl', []);
			$this->assertElementByAttributeHasClasses($content, 'input', 'id', 'csrf_token', []);
			$this->assertElementByAttributeHasClasses($content, 'button', 'id', 'downloadBtn', ['btn', 'btn-primary', 'btn-success', 'evaluation-download-button']);
			$this->assertSingleElementHasClasses($content, 'div', ['col-12', 'col-md-8', 'evaluation-pagination']);
		}

		$layoutCss = File::get(public_path('css/layout.css'));
		$this->assertMatchesRegularExpression(
			'/@media \(max-width: 767\.98px\).*?\.evaluation-download-button\s*\{\s*width: 100%;\s*\}/s',
			$layoutCss
		);
	}

	private function assertElementByAttributeHasClasses($content, $tagName, $attribute, $value, array $expectedClasses)
	{
		$elements = array_values(array_filter($this->openingTags($content, $tagName), function ($element) use ($attribute, $value) {
			return $this->markupAttribute($element, $attribute) === $value;
		}));

		$this->assertCount(1, $elements);
		$this->assertClassesInclude($elements[0], $expectedClasses);
	}

	private function assertSingleElementHasClasses($content, $tagName, array $expectedClasses)
	{
		$elements = $this->openingTagsWithClasses($content, $tagName, $expectedClasses);

		$this->assertCount(1, $elements);
	}

	private function assertClassesInclude($markup, array $expectedClasses)
	{
		$classes = preg_split('/\s+/', trim($this->markupAttribute($markup, 'class') ?: ''));

		foreach ($expectedClasses as $expectedClass) {
			$this->assertContains($expectedClass, $classes);
		}
	}

	private function openingTagsWithClass($content, $tagName, $className)
	{
		return $this->openingTagsWithClasses($content, $tagName, [$className]);
	}

	private function openingTagsWithClasses($content, $tagName, array $expectedClasses)
	{
		return array_values(array_filter($this->openingTags($content, $tagName), function ($element) use ($expectedClasses) {
			$classes = preg_split('/\s+/', trim($this->markupAttribute($element, 'class') ?: ''));

			return count(array_diff($expectedClasses, $classes)) === 0;
		}));
	}

	private function openingTags($content, $tagName)
	{
		preg_match_all('/<' . preg_quote($tagName, '/') . '\b[^>]*>/i', $content, $matches);

		return $matches[0];
	}

	private function markupAttribute($markup, $name)
	{
		if (preg_match('/\s' . preg_quote($name, '/') . '\s*=\s*(["\'])(.*?)\1/s', $markup, $matches) !== 1) {
			return null;
		}

		return html_entity_decode($matches[2], ENT_QUOTES);
	}

	private function assertSelectionCheckboxMarkup($content)
	{
		preg_match_all('/<input type="checkbox" id="([^"]+)"/', $content, $checkboxIds);

		$this->assertSame($checkboxIds[1], array_values(array_unique($checkboxIds[1])));
		$this->assertSame(1, substr_count($content, 'id="type-exam-select-all"'));
		$this->assertSame(1, substr_count($content, 'id="type-exam-select-exam-public"'));
		$this->assertStringContainsString('id="type-exam-select-all" name="selectAllExams" class="ml-10 js-exam-select-all"', $content);
		$this->assertStringContainsString('id="type-exam-select-exam-public" name="selectedExamIds[]"', $content);
		$this->assertStringContainsString('class="mt-10 ml-10 js-exam-select"', $content);
		$this->assertStringContainsString('<label for="type-exam-select-all" class="visually-hidden">Seleccionar todos los exámenes</label>', $content);
		$this->assertStringContainsString('<label for="type-exam-select-exam-public" class="visually-hidden">Seleccionar examen: Public Exam</label>', $content);
		$this->assertStringNotContainsString('id="selectAll"', $content);
		$this->assertStringNotContainsString('id="result[]"', $content);
	}

	public function test_legacy_type_exam_route_redirects_to_listar_preserving_query_string()
	{
		$response = $this->get('/tipoexamen/all/1?type=type-1&searchParameter=Public');

		$response->assertRedirect('/tipoexamen/all/listar?type=type-1&searchParameter=Public');
	}

	public function test_listing_script_restores_popstate_without_pushing_history()
	{
		$script = file_get_contents(public_path('assets/frontoffice/viewResources/typeexam/view.js'));

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
		$this->testStoragePath = '/tmp/opencode/appwebrepositorydrea-typeexam-tests-' . uniqid();
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
