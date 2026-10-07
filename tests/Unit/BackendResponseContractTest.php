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

		$response=PlatformHelper::redirectError(['El campo "codeGrade" es requerido.'], 'grado/mostrar/1');
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

		$response=PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], 'grado/mostrar/1');
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

	private function bindJsonRequest()
	{
		$request=Request::create('/test', 'POST', [], [], [], [
			'HTTP_ACCEPT' => 'application/json',
			'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'
		]);

		$this->app->instance('request', $request);
	}
}
