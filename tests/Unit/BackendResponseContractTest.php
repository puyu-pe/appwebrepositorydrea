<?php

namespace Tests\Unit;

use App\Helper\PlatformHelper;
use Illuminate\Http\Request;
use Tests\TestCase;

class BackendResponseContractTest extends TestCase
{
	public function test_ajax_validation_errors_use_consistent_json_contract()
	{
		$this->bindJsonRequest();

		$response=PlatformHelper::redirectError(['El campo "codeGrade" es requerido.'], 'grado/listar');
		$payload=$response->getData(true);

		$this->assertSame(422, $response->getStatusCode());
		$this->assertFalse($payload['success']);
		$this->assertSame('error', $payload['type']);
		$this->assertSame(['El campo "codeGrade" es requerido.'], $payload['messages']);
		$this->assertArrayHasKey('redirectUrl', $payload);
	}

	public function test_ajax_success_uses_consistent_json_contract()
	{
		$this->bindJsonRequest();

		$response=PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], 'grado/listar');
		$payload=$response->getData(true);

		$this->assertSame(200, $response->getStatusCode());
		$this->assertTrue($payload['success']);
		$this->assertSame('success', $payload['type']);
		$this->assertSame(['Operación realizada correctamente.'], $payload['messages']);
		$this->assertArrayHasKey('redirectUrl', $payload);
	}

	public function test_json_helpers_normalize_scalar_messages()
	{
		$response=PlatformHelper::jsonError('Invalid mode specified', 400);
		$payload=$response->getData(true);

		$this->assertSame(400, $response->getStatusCode());
		$this->assertSame(['Invalid mode specified'], $payload['messages']);
	}

	public function test_shared_ajax_helper_supports_opt_in_success_without_forced_reload()
	{
		$script=file_get_contents(public_path('js/codideepHelpers.js'));

		$this->assertStringContainsString("typeof options.onSuccess=='function'", $script);
		$this->assertStringContainsString('options.onSuccess(response, form);', $script);
	}

	public function test_shared_ajax_form_helpers_block_duplicate_submissions()
	{
		$script=file_get_contents(public_path('js/codideepHelpers.js'));

		$this->assertStringContainsString("form.data('ajaxCrudSubmitting')", $script);
		$this->assertStringContainsString("form.data('ajaxCrudSubmitting', true);", $script);
		$this->assertStringContainsString("form.data('ajaxCrudSubmitting', false);", $script);
		$this->assertSame(2, substr_count($script, "typeof options.onBeforeSend=='function'"));
		$this->assertSame(2, substr_count($script, 'options.onBeforeSend(form);'));
		$this->assertSame(2, substr_count($script, "typeof options.onComplete=='function'"));
		$this->assertSame(2, substr_count($script, 'options.onComplete(form);'));
	}

	public function test_shared_helper_and_exam_list_assets_are_cache_versioned()
	{
		foreach([
			resource_path('views/backoffice/layout.blade.php'),
			resource_path('views/frontoffice/layout.blade.php')
		] as $layout)
		{
			$layoutContents=file_get_contents($layout);
			$this->assertStringContainsString("asset('js/codideepHelpers.js')", $layoutContents);
			$this->assertStringContainsString("filemtime(public_path('js/codideepHelpers.js'))", $layoutContents);
		}

		$examList=file_get_contents(resource_path('views/backoffice/exam/getall.blade.php'));
		$this->assertStringContainsString("asset('assets/backoffice/viewResources/exam/getall.js')", $examList);
		$this->assertStringContainsString("filemtime(public_path('assets/backoffice/viewResources/exam/getall.js'))", $examList);
	}

	public function test_frontoffice_exam_previews_use_updated_at_cache_versions()
	{
		$seed=file_get_contents(resource_path('views/frontoffice/exam/seed.blade.php'));
		$welcome=file_get_contents(resource_path('views/frontoffice/general/welcome.blade.php'));

		$this->assertStringContainsString('.jpg?x=\' . $tExam->updated_at', $seed);
		$this->assertStringContainsString('.jpg?x=\' . $topExam->updated_at', $welcome);
	}

	private function bindJsonRequest()
	{
		$request=Request::create('/test', 'POST', [], [], [], [
			'HTTP_ACCEPT' => 'application/json',
			'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'
		]);

		$this->app->instance('request', $request);
	}
}
