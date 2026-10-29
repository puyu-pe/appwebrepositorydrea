<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class FrontofficeContactAjaxTest extends TestCase
{
	protected function setUp(): void
	{
		parent::setUp();

		$this->withoutMiddleware();
		Mail::fake();
		Config::set('database.default', 'sqlite');
		Config::set('database.connections.sqlite.database', ':memory:');
		DB::purge('sqlite');
		DB::reconnect('sqlite');
		$this->createMenuSchema();
		Schema::create('tcontact', function (Blueprint $table) {
			$table->string('idContact')->primary();
			$table->string('completeNameContact');
			$table->string('emailContact');
			$table->string('phoneContact')->nullable();
			$table->string('affairContact');
			$table->text('messageContact');
			$table->date('dateContact');
			$table->boolean('statusContact');
			$table->timestamps();
		});
	}

	public function test_ajax_contact_returns_json_and_validation_does_not_store_data()
	{
		$invalid=$this->ajaxPost(['txtFullName' => '', 'txtEmail' => 'ana@example.com', 'txtPhone' => '', 'txtSubject' => 'Consulta', 'txtMessage' => 'Hola']);
		$invalid->assertStatus(422)->assertJsonPath('success', false)->assertJsonPath('type', 'error');
		$this->assertDatabaseCount('tcontact', 0);

		$success=$this->ajaxPost(['txtFullName' => 'Ana Quispe', 'txtEmail' => 'ana@example.com', 'txtPhone' => '', 'txtSubject' => 'Consulta', 'txtMessage' => 'Hola']);
		$success->assertOk()
			->assertJson(['success' => true, 'type' => 'success', 'messages' => ['Operación realizada correctamente.']])
			->assertJsonStructure(['redirectUrl']);
		$this->assertDatabaseCount('tcontact', 1);
	}

	public function test_non_ajax_contact_preserves_redirect_response()
	{
		$this->withHeader('Referer', url('/'))->post('/general/contacto', [
			'txtFullName' => 'Ana Quispe', 'txtEmail' => 'ana@example.com', 'txtPhone' => '', 'txtSubject' => 'Consulta', 'txtMessage' => 'Hola'
		])->assertRedirect(url('/'));
	}

	public function test_contact_forms_share_ajax_submit_without_navigation_and_clear_on_success()
	{
		$script=file_get_contents(public_path('assets/frontoffice/viewResources/contact/insert.js'));
		$contactView=file_get_contents(resource_path('views/frontoffice/contact/insert.blade.php'));
		$homeView=file_get_contents(resource_path('views/frontoffice/general/welcome.blade.php'));

		$this->assertStringContainsString("on('submit.ajaxCrud'", $script);
		$this->assertStringContainsString('event.preventDefault();', $script);
		$this->assertStringContainsString('sendFrmContact($(this));', $script);
		$this->assertStringContainsString("ajaxCrudSubmitForm('frmContact'", $script);
		$this->assertStringContainsString('onBeforeSend: function(form)', $script);
		$this->assertStringContainsString('onComplete: function(form)', $script);
		$this->assertStringContainsString("form.attr('aria-busy', pending ? 'true' : 'false');", $script);
		$this->assertStringContainsString("form.find('button[type=submit], input[type=submit]')", $script);
		$this->assertStringContainsString(".not('.fv-hidden-submit')", $script);
		$this->assertStringContainsString(".filter(':visible')", $script);
		$this->assertStringContainsString("input:not([type=hidden]):not([readonly]), textarea, select, button", $script);
		$this->assertStringContainsString("control.prop('disabled', true);", $script);
		$this->assertStringContainsString("control.prop('disabled', control.data('ajaxCrudWasDisabled'));", $script);
		$this->assertStringContainsString("submitButton.data('contactOriginalHtml', submitButton.html());", $script);
		$this->assertStringContainsString("submitButton.data('contactOriginalStyle', submitButton.attr('style'));", $script);
		$this->assertStringContainsString("submitButton.css('min-width', submitButton.outerWidth()+'px');", $script);
		$this->assertStringContainsString("submitButton.prop('disabled', true);", $script);
		$this->assertStringContainsString("submitButton.attr('aria-disabled', 'true');", $script);
		$this->assertStringContainsString("submitButton.html('Enviando...');", $script);
		$this->assertStringContainsString("submitButton.html(submitButton.data('contactOriginalHtml'));", $script);
		$this->assertStringContainsString("submitButton.prop('disabled', false);", $script);
		$this->assertStringContainsString("submitButton.attr('aria-disabled', submitButton.data('contactOriginalAriaDisabled'));", $script);
		$this->assertStringContainsString("submitButton.removeAttr('aria-disabled');", $script);
		$this->assertStringContainsString("submitButton.attr('style', submitButton.data('contactOriginalStyle'));", $script);
		$this->assertStringContainsString("submitButton.removeAttr('style');", $script);
		$this->assertStringContainsString('form[0].reset();', $script);
		$this->assertStringNotContainsString('confirmDialogSend', $script);
		$this->assertStringNotContainsString('window.location', $script);
		foreach([$contactView, $homeView] as $view) {
			$this->assertStringContainsString('<form id="frmContact"', $view);
			$this->assertStringContainsString('<button type="submit"', $view);
			$this->assertStringContainsString("filemtime(public_path('assets/frontoffice/viewResources/contact/insert.js'))", $view);
		}
	}

	private function ajaxPost(array $data)
	{
		return $this->withHeaders(['Accept' => 'application/json', 'X-Requested-With' => 'XMLHttpRequest', 'Referer' => url('/')])->post('/general/contacto', $data);
	}

	private function createMenuSchema()
	{
		Schema::create('ttypeexam', function (Blueprint $table) {
			$table->string('idTypeExam')->primary(); $table->string('acronymTypeExam')->nullable(); $table->string('nameTypeExam')->nullable(); $table->string('descriptionTypeExam')->nullable(); $table->string('extensionImageType')->nullable(); $table->timestamps();
		});
		Schema::create('tsubject', function (Blueprint $table) {
			$table->string('idSubject')->primary(); $table->string('nameSubject')->nullable(); $table->string('codeSubject')->nullable(); $table->timestamps();
		});
		Schema::create('tgrade', function (Blueprint $table) {
			$table->string('idGrade')->primary(); $table->string('nameGrade')->nullable(); $table->string('descriptionGrade')->nullable(); $table->string('codeGrade')->nullable(); $table->timestamps();
		});
		Schema::create('texam', function (Blueprint $table) {
			$table->string('idExam')->primary(); $table->string('idTypeExam')->nullable(); $table->string('idSubject')->nullable(); $table->string('idGrade')->nullable(); $table->string('stateExam')->nullable(); $table->timestamps();
		});
	}
}
