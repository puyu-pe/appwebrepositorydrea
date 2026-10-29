<?php

namespace Tests\Feature\Backoffice;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ResourceAjaxCrudTest extends TestCase
{
	protected function setUp(): void
	{
		parent::setUp();

		$this->withoutMiddleware();
		$this->useInMemoryDatabase();
		$this->createMenuSchema();
		$this->seedFixtures();
	}

	public function test_ajax_insert_validation_returns_json_contract_for_exam_redirect()
	{
		$response=$this->ajaxPost('/recurso/insertar', [
			'hdIdExam' => 'exam-1'
		]);

		$response->assertStatus(422)
			->assertJson([
				'success' => false,
				'type' => 'error',
				'messages' => ['Debe seleccionar al menos un recurso.']
			])
			->assertJsonStructure(['redirectUrl'])
			->assertJsonPath('redirectUrl', url('examen/listar'));
	}

	public function test_resource_insert_ajax_success_refreshes_exam_list_without_navigation()
	{
		$script=file_get_contents(public_path('assets/backoffice/viewResources/resource/insert.js'));

		$this->assertStringContainsString("onSuccess: function(response, form)", $script);
		$this->assertStringContainsString("$('#divAjaxCrudList').length", $script);
		$this->assertStringContainsString('ajaxCrudLoadList(', $script);
		$this->assertStringNotContainsString('window.location', $script);
	}

	public function test_resource_delete_rejects_get_without_mutating_record_or_file()
	{
		$this->get('/recurso/eliminar/resource-1')->assertStatus(405);

		$this->assertDatabaseHas('tresource', ['idResource' => 'resource-1']);
		Storage::disk('public')->assertExists('resource/resource-1.pdf');
	}

	public function test_ajax_resource_delete_removes_record_and_physical_file()
	{
		$response=$this->ajaxPost('/recurso/eliminar/resource-1', [
			'_token' => csrf_token()
		]);

		$response->assertOk()
			->assertJsonPath('success', true)
			->assertJsonPath('type', 'success')
			->assertJsonPath('messages', ['Recurso eliminado correctamente.'])
			->assertJsonPath('redirectUrl', url('examen/listar'));

		$this->assertDatabaseMissing('tresource', ['idResource' => 'resource-1']);
		Storage::disk('public')->assertMissing('resource/resource-1.pdf');
	}

	public function test_resource_delete_restores_record_and_file_when_commit_fails()
	{
		$resourceBefore=(array)DB::table('tresource')
			->where('idResource', 'resource-1')
			->first();
		$fileBefore=Storage::disk('public')->get('resource/resource-1.pdf');

		$this->app->bind(
			\App\Http\Controllers\Backoffice\ResourceController::class,
			function ($app) {
				return new FailingCommitResourceController();
			}
		);

		$response=$this->ajaxPost('/recurso/eliminar/resource-1', [
			'_token' => csrf_token()
		]);

		$response->assertStatus(422)
			->assertJsonPath('success', false)
			->assertJsonPath('type', 'error')
			->assertJsonPath('messages', ['Commit failure for test.'])
			->assertJsonPath('redirectUrl', url('examen/listar'));

		$this->assertDatabaseHas('tresource', ['idResource' => 'resource-1']);
		Storage::disk('public')->assertExists('resource/resource-1.pdf');
		$this->assertSame(
			$resourceBefore,
			(array)DB::table('tresource')->where('idResource', 'resource-1')->first()
		);
		$this->assertSame(
			$fileBefore,
			Storage::disk('public')->get('resource/resource-1.pdf')
		);
		Storage::disk('public')->assertMissing('resource/resource-1.pdf.deleting');
	}

	public function test_resource_delete_uses_post_csrf_confirmation_and_updates_modal_without_navigation()
	{
		$script=file_get_contents(public_path('assets/backoffice/viewResources/resource/insert.js'));
		$view=file_get_contents(resource_path('views/backoffice/resource/insert.blade.php'));

		$this->assertStringContainsString('ajaxCrudDelete(url, token, {', $script);
		$this->assertStringContainsString('onSuccess: function(response)', $script);
		$this->assertStringContainsString('removeTableRowResource(component);', $script);
		$this->assertStringNotContainsString('type: "GET"', $script);
		$this->assertStringNotContainsString('window.location', $script);
		$this->assertStringContainsString("csrf_token()", $view);
	}

	private function ajaxPost($uri, array $data)
	{
		$_POST=$data;

		return $this->withHeaders([
			'Accept' => 'application/json',
			'X-Requested-With' => 'XMLHttpRequest',
			'Referer' => url('examen/mostrar/1')
		])->post($uri, $data);
	}

	private function useInMemoryDatabase()
	{
		Config::set('database.default', 'sqlite');
		Config::set('database.connections.sqlite.database', ':memory:');

		DB::purge('sqlite');
		DB::reconnect('sqlite');
	}

	private function createMenuSchema()
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

		Schema::create('tresource', function (Blueprint $table) {
			$table->string('idResource')->primary();
			$table->string('idExam')->nullable();
			$table->string('namecompleteResource')->nullable();
			$table->string('type')->nullable();
			$table->string('extension')->nullable();
			$table->timestamps();
		});
	}

	private function seedFixtures()
	{
		Storage::fake('public');
		Storage::disk('public')->put('resource/resource-1.pdf', 'resource-content');

		DB::table('texam')->insert([
			'idExam' => 'exam-1',
			'stateExam' => 'Oculto',
			'created_at' => now(),
			'updated_at' => now()
		]);

		DB::table('tresource')->insert([
			'idResource' => 'resource-1',
			'idExam' => 'exam-1',
			'namecompleteResource' => 'Material de prueba',
			'type' => 'material',
			'extension' => 'pdf',
			'created_at' => now(),
			'updated_at' => now()
		]);
	}
}

class FailingCommitResourceController extends \App\Http\Controllers\Backoffice\ResourceController
{
	protected function commitTransaction()
	{
		throw new \RuntimeException('Commit failure for test.');
	}
}
