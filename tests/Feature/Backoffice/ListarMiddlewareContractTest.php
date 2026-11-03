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
		$this->assertRouteUsesMiddleware('GET', 'usuario/listar', 'GenericMiddleware:usuario/listar');
		$this->assertRouteUsesMiddleware('GET', 'contacto/listar', 'GenericMiddleware:contacto/listar');
		$this->assertRouteUsesMiddleware('GET', 'tipoexamen/listar', 'GenericMiddleware:tipoexamen/listar');
		$this->assertRouteUsesMiddleware('GET', 'curso/listar', 'GenericMiddleware:curso/listar');
		$this->assertRouteUsesMiddleware('GET', 'grado/listar', 'GenericMiddleware:grado/listar');
		$this->assertRouteUsesMiddleware('GET', 'direccion/listar', 'GenericMiddleware:direccion/listar');
		$this->assertRouteUsesMiddleware('GET', 'examen/listar', 'GenericMiddleware:examen/listar');
		$this->assertRouteUsesMiddleware('GET', 'testimonio/listar', 'GenericMiddleware:testimonio/listar');
	}

	public function test_legacy_mostrar_redirect_routes_keep_legacy_permission_keys()
	{
		$this->assertRouteUsesMiddleware('GET', 'usuario/mostrar/1', 'GenericMiddleware:usuario/mostrar');
		$this->assertRouteUsesMiddleware('GET', 'contacto/mostrar/1', 'GenericMiddleware:contacto/mostrar');
		$this->assertRouteUsesMiddleware('GET', 'tipoexamen/mostrar/1', 'GenericMiddleware:tipoexamen/mostrar');
		$this->assertRouteUsesMiddleware('GET', 'curso/mostrar/1', 'GenericMiddleware:curso/mostrar');
		$this->assertRouteUsesMiddleware('GET', 'grado/mostrar/1', 'GenericMiddleware:grado/mostrar');
		$this->assertRouteUsesMiddleware('GET', 'direccion/mostrar/1', 'GenericMiddleware:direccion/mostrar');
		$this->assertRouteUsesMiddleware('GET', 'examen/mostrar/1', 'GenericMiddleware:examen/mostrar');
		$this->assertRouteUsesMiddleware('GET', 'testimonio/mostrar/1', 'GenericMiddleware:testimonio/mostrar');
	}

	public function test_generic_middleware_authorizes_new_and_legacy_list_permissions()
	{
		foreach (['usuario/listar', 'usuario/mostrar'] as $permissionKey)
		{
			Session::flush();
			Session::put('mainRole', 'Administrador');

			$response=(new GenericMiddleware())->handle($this->requestWithoutRouteParameters(), function ()
			{
				return response('ok');
			}, $permissionKey);

			$this->assertSame(200, $response->getStatusCode());
		}

		foreach (['contacto/listar', 'contacto/mostrar', 'tipoexamen/listar', 'tipoexamen/mostrar', 'curso/listar', 'curso/mostrar', 'grado/listar', 'grado/mostrar', 'direccion/listar', 'direccion/mostrar', 'examen/listar', 'examen/mostrar', 'testimonio/listar', 'testimonio/mostrar'] as $permissionKey)
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
