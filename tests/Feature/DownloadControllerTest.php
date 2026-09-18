<?php

namespace Tests\Feature;

use App\Http\Controllers\Backoffice\DownloadController;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Session\ArraySessionHandler;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use ZipArchive;

class DownloadControllerTest extends TestCase
{
	private $testStoragePath;

	protected function setUp(): void
	{
		parent::setUp();

		$this->withoutMiddleware();
		$this->useInMemoryDatabase();
		$this->useIsolatedStoragePath();
		$this->createSchema();
	}

	protected function tearDown(): void
	{
		if ($this->testStoragePath && is_dir($this->testStoragePath)) {
			File::deleteDirectory($this->testStoragePath);
		}

		parent::tearDown();
	}

	public function test_download_zip_file_rejects_invalid_or_arbitrary_filenames()
	{
		File::ensureDirectoryExists(storage_path('app/public/zip'));
		file_put_contents(storage_path('app/public/zip/manual-export.zip'), 'test');

		$controller = $this->app->make(DownloadController::class);
		$request = $this->makeRequestWithSession('GET', '/download/zip/manual-export.zip', [], $this->makeSessionStore());

		$this->assertSame(404, $controller->downloadZipFile($request, '../manual-export.zip')->getStatusCode());
		$this->assertSame(404, $controller->downloadZipFile($request, 'manual-export.zip')->getStatusCode());
	}

	public function test_checked_download_creates_random_zip_and_requires_download_session_metadata()
	{
		$this->seedDownloadFixtures();
		$controller = $this->app->make(DownloadController::class);
		$creatorSession = $this->makeSessionStore();

		$response = $controller->packZipFile($this->makeRequestWithSession('POST', '/download/selected', [
			'mode' => 'checked',
			'ids' => ['exam-public']
		], $creatorSession));

		$this->assertSame(200, $response->getStatusCode());
		$payload = json_decode($response->getContent(), true);
		$downloadPath = parse_url($payload['downloadUrl'], PHP_URL_PATH);
		$filename = basename($downloadPath);

		$this->assertMatchesRegularExpression('/^descarga_[A-Za-z0-9]{40}\.zip$/', $filename);

		$downloadResponse = $controller->downloadZipFile(
			$this->makeRequestWithSession('GET', $downloadPath, [], $this->makeSessionStore()),
			$filename
		);

		$this->assertSame(404, $downloadResponse->getStatusCode());
	}

	public function test_all_download_revalidates_public_scope_before_serving_zip()
	{
		$this->seedDownloadFixtures();
		$controller = $this->app->make(DownloadController::class);
		$creatorSession = $this->makeSessionStore();

		$response = $controller->packZipFile($this->makeRequestWithSession('POST', '/download/selected', [
			'mode' => 'all',
			'ids' => [
				'search' => '',
				'type' => 'eca',
				'grade' => 'grade-1',
				'subject' => 'subject-1',
				'year' => '2024'
			]
		], $creatorSession));

		$this->assertSame(200, $response->getStatusCode());
		$payload = json_decode($response->getContent(), true);
		$downloadPath = parse_url($payload['downloadUrl'], PHP_URL_PATH);
		$filename = basename($downloadPath);

		DB::table('texam')->where('idExam', 'exam-public')->update([
			'stateExam' => 'Oculto'
		]);

		$downloadResponse = $controller->downloadZipFile(
			$this->makeRequestWithSession('GET', $downloadPath, [], $creatorSession),
			$filename
		);

		$this->assertSame(404, $downloadResponse->getStatusCode());
	}

	public function test_checked_download_only_packages_public_exams_for_guest_requests()
	{
		$this->seedDownloadFixtures();
		$controller = $this->app->make(DownloadController::class);
		$creatorSession = $this->makeSessionStore();

		$response = $controller->packZipFile($this->makeRequestWithSession('POST', '/download/selected', [
			'mode' => 'checked',
			'ids' => ['exam-public', 'exam-hidden']
		], $creatorSession));

		$this->assertSame(200, $response->getStatusCode());
		$payload = json_decode($response->getContent(), true);
		$zipPath = $this->resolveZipPathFromUrl($payload['downloadUrl']);

		$this->assertFileExists($zipPath);

		$entries = $this->readZipEntries($zipPath);

		$this->assertCount(1, array_filter($entries, function ($entry) {
			return strpos($entry, 'evaluaciones/') === 0;
		}));
		$this->assertContains('evaluaciones/Public_Exam.pdf', $entries);
		$this->assertNotContains('evaluaciones/Hidden_Exam.pdf', $entries);
	}

	public function test_checked_download_rejects_requests_without_any_allowed_exams()
	{
		$this->seedDownloadFixtures();
		$controller = $this->app->make(DownloadController::class);

		$response = $controller->packZipFile($this->makeRequestWithSession('POST', '/download/selected', [
			'mode' => 'checked',
			'ids' => ['exam-hidden', 'missing-id']
		], $this->makeSessionStore()));

		$this->assertSame(422, $response->getStatusCode());
		$this->assertSame([
			'error' => 'No se encontraron archivos permitidos para descargar'
		], json_decode($response->getContent(), true));
	}

	private function useInMemoryDatabase()
	{
		Config::set('database.default', 'sqlite');
		Config::set('database.connections.sqlite.database', ':memory:');

		DB::purge('sqlite');
		DB::reconnect('sqlite');
	}

	private function useIsolatedStoragePath()
	{
		$this->testStoragePath = '/tmp/opencode/appwebrepositorydrea-tests-' . uniqid();
		$this->app->useStoragePath($this->testStoragePath);

		File::ensureDirectoryExists(storage_path('app/public/zip'));
		File::ensureDirectoryExists(storage_path('app/file/exam'));
		File::ensureDirectoryExists(storage_path('app/public/resource'));
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

		Schema::create('tdirection', function (Blueprint $table) {
			$table->string('idDirection')->primary();
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

		Schema::create('tresource', function (Blueprint $table) {
			$table->string('idResource')->primary();
			$table->string('idExam');
			$table->string('namecompleteResource')->nullable();
			$table->string('extension')->nullable();
			$table->string('type')->nullable();
			$table->timestamps();
		});
	}

	private function seedDownloadFixtures()
	{
		DB::table('ttypeexam')->insert([
			'idTypeExam' => 'type-1',
			'acronymTypeExam' => 'eca',
			'nameTypeExam' => 'ECA',
			'updated_at' => now(),
			'created_at' => now(),
		]);

		DB::table('tgrade')->insert([
			'idGrade' => 'grade-1',
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
			[
				'idExam' => 'exam-public',
				'idTypeExam' => 'type-1',
				'idGrade' => 'grade-1',
				'idSubject' => 'subject-1',
				'codeExam' => 'PUB-001',
				'nameExam' => 'Public Exam',
				'yearExam' => '2024',
				'extensionExam' => 'pdf',
				'stateExam' => 'Publico',
				'updated_at' => now(),
				'created_at' => now(),
			],
			[
				'idExam' => 'exam-hidden',
				'idTypeExam' => 'type-1',
				'idGrade' => 'grade-1',
				'idSubject' => 'subject-1',
				'codeExam' => 'HID-001',
				'nameExam' => 'Hidden Exam',
				'yearExam' => '2024',
				'extensionExam' => 'pdf',
				'stateExam' => 'Oculto',
				'updated_at' => now(),
				'created_at' => now(),
			]
		]);

		file_put_contents(storage_path('app/file/exam/exam-public.pdf'), 'public exam');
		file_put_contents(storage_path('app/file/exam/exam-hidden.pdf'), 'hidden exam');
	}

	private function resolveZipPathFromUrl($downloadUrl)
	{
		$path = parse_url($downloadUrl, PHP_URL_PATH);
		$filename = basename($path);

		return storage_path('app/public/zip/' . $filename);
	}

	private function readZipEntries($zipPath)
	{
		$zip = new ZipArchive();
		$zip->open($zipPath);

		$entries = [];

		for ($index = 0; $index < $zip->numFiles; $index++) {
			$entries[] = $zip->getNameIndex($index);
		}

		$zip->close();

		return $entries;
	}

	private function makeSessionStore(array $sessionData = [])
	{
		$session = new Store('testing', new ArraySessionHandler(120));
		$session->start();

		foreach ($sessionData as $key => $value) {
			$session->put($key, $value);
		}

		return $session;
	}

	private function makeRequestWithSession($method, $uri, array $parameters, Store $session)
	{
		$request = Request::create($uri, $method, $parameters);

		$request->setLaravelSession($session);

		return $request;
	}
}
