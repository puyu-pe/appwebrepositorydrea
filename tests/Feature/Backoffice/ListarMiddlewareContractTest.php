<?php

namespace Tests\Feature\Backoffice;

use App\Http\Middleware\GenericMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ListarMiddlewareContractTest extends TestCase
{
	public function test_subject_and_grade_listar_routes_use_listar_permission_keys()
	{
		$this->assertRouteUsesMiddleware('GET', 'curso/listar/1', 'GenericMiddleware:curso/listar');
		$this->assertRouteUsesMiddleware('GET', 'grado/listar/1', 'GenericMiddleware:grado/listar');
	}

	public function test_legacy_mostrar_redirect_routes_keep_legacy_permission_keys()
	{
		$this->assertRouteUsesMiddleware('GET', 'curso/mostrar/1', 'GenericMiddleware:curso/mostrar');
		$this->assertRouteUsesMiddleware('GET', 'grado/mostrar/1', 'GenericMiddleware:grado/mostrar');
	}

	public function test_generic_middleware_authorizes_new_and_legacy_list_permissions()
	{
		foreach (['curso/listar', 'curso/mostrar', 'grado/listar', 'grado/mostrar'] as $permissionKey)
		{
			Session::flush();
			Session::put('mainRole', 'Supervisor');

			$response=(new GenericMiddleware())->handle($this->requestWithoutRouteParameters(), function ()
			{
				return response('ok');
			}, $permissionKey);

			$this->assertSame(200, $response->getStatusCode());
		}
	}

	private function assertRouteUsesMiddleware($method, $uri, $middleware)
	{
		$route=Route::getRoutes()->match(request()->create($uri, $method));

		$this->assertContains($middleware, $route->gatherMiddleware());
	}

	private function requestWithoutRouteParameters()
	{
		$request=Request::create('/');

		$request->setRouteResolver(function ()
		{
			return new class
			{
				public function parameter($name)
				{
					return null;
				}
			};
		});

		return $request;
	}
}
