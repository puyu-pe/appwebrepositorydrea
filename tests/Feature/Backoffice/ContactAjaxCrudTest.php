<?php

namespace Tests\Feature\Backoffice;

use App\Mail\ReplyContact;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ContactAjaxCrudTest extends TestCase
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
		$response=$this->ajaxGet('/contacto/listar');

		$response->assertOk()
			->assertSee('Ana Torres')
			->assertSee('ajaxCrudDelete', false)
			->assertDontSee('@extends')
			->assertDontSee('assets/backoffice/viewResources/contact/getall.js');
	}

	public function test_ajax_reply_returns_json_contract_and_sends_mail_without_layout_navigation()
	{
		Mail::fake();

		$response=$this->ajaxPost('/contacto/responder', [
			'hdIdContact' => 'contact-pending',
			'txtMessage' => 'Thanks for writing.'
		]);

		$response->assertOk()
			->assertJson([
				'success' => true,
				'type' => 'success',
				'messages' => ['Cambios guardado correctamente.']
			])
			->assertJsonStructure(['redirectUrl'])
			->assertJsonPath('redirectUrl', url('contacto/listar'));

		$this->assertDatabaseHas('tcontact', [
			'idContact' => 'contact-pending',
			'replyContact' => 'Thanks for writing.',
			'statusContact' => 1
		]);

		Mail::assertSent(ReplyContact::class);
	}

	public function test_ajax_delete_returns_json_contract()
	{
		$response=$this->ajaxPost('/contacto/eliminar/contact-replied', []);

		$response->assertOk()
			->assertJson([
				'success' => true,
				'type' => 'success',
				'messages' => ['Operación realizada correctamente.']
			])
			->assertJsonStructure(['redirectUrl'])
			->assertJsonPath('redirectUrl', url('contacto/listar'));

		$this->assertDatabaseMissing('tcontact', [
			'idContact' => 'contact-replied'
		]);
	}

	public function test_legacy_mostrar_route_redirects_to_active_listar_route()
	{
		$this->get('/contacto/mostrar/2?searchParameter=Ana')
			->assertRedirect('/contacto/listar/2?searchParameter=Ana');

		$this->get('/contacto/mostrar/1?searchParameter=Ana')
			->assertRedirect('/contacto/listar?searchParameter=Ana');
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

		Schema::create('tcontact', function (Blueprint $table) {
			$table->string('idContact')->primary();
			$table->string('completeNameContact')->nullable();
			$table->string('emailContact')->nullable();
			$table->string('phoneContact')->nullable();
			$table->string('affairContact')->nullable();
			$table->text('messageContact')->nullable();
			$table->text('replyContact')->nullable();
			$table->integer('statusContact')->default(0);
			$table->date('dateContact')->nullable();
			$table->timestamps();
		});
	}

	private function seedFixtures()
	{
		DB::table('tcontact')->insert([
			[
				'idContact' => 'contact-pending',
				'completeNameContact' => 'Ana Torres',
				'emailContact' => 'ana@example.com',
				'phoneContact' => '999999999',
				'affairContact' => 'Consulta',
				'messageContact' => 'Need help',
				'replyContact' => null,
				'statusContact' => 0,
				'dateContact' => now()->toDateString(),
				'updated_at' => now(),
				'created_at' => now()
			],
			[
				'idContact' => 'contact-replied',
				'completeNameContact' => 'Luis Perez',
				'emailContact' => 'luis@example.com',
				'phoneContact' => '988888888',
				'affairContact' => 'Answered',
				'messageContact' => 'Already answered',
				'replyContact' => 'Done',
				'statusContact' => 1,
				'dateContact' => now()->toDateString(),
				'updated_at' => now(),
				'created_at' => now()->subDay()
			]
		]);
	}
}
