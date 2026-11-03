<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class FrontofficeHeaderTest extends TestCase
{
	public function test_guest_header_exposes_mobile_login_control_without_changing_desktop_access()
	{
		$content = $this->renderHeader();
		$mobileLink = $this->findAnchorByAriaLabel($content, 'Iniciar sesión');

		$this->assertSame(url('usuario/acceder'), $this->attribute($mobileLink, 'href'));
		$this->assertContains('mobile-session-control', $this->classTokens($mobileLink));
		$this->assertContains('d-md-none', $this->classTokens($mobileLink));
		$this->assertIconOnlyControl($mobileLink, ['fa', 'fa-user']);
		$this->assertNull($this->attribute($mobileLink, 'id', false));
		$desktopControl = $this->findSingleElementByClasses($content, 'div', ['it-header-2-button', 'd-none', 'd-md-block']);
		$this->assertSame(url('usuario/acceder'), $this->attribute($this->findSingleElement($desktopControl, 'a'), 'href'));
		$this->assertStringContainsString('Acceder', strip_tags($desktopControl));
		$this->assertCount(0, $this->findElementsByAttribute($content, 'a', 'href', url('usuario/salir')));
		$this->assertSame(0, preg_match_all('/<form\b/i', $content));
		$this->assertHamburgerContract($content);
	}

	public function test_authenticated_header_exposes_mobile_account_control_and_preserves_logout()
	{
		$content = $this->renderHeader([
			'idUser' => 'user-1',
			'firstName' => 'Alejandra',
		]);
		$mobileLink = $this->findAnchorByAriaLabel($content, 'Mi cuenta');

		$this->assertSame(url('usuario/acceder'), $this->attribute($mobileLink, 'href'));
		$this->assertContains('mobile-session-control', $this->classTokens($mobileLink));
		$this->assertContains('d-md-none', $this->classTokens($mobileLink));
		$this->assertIconOnlyControl($mobileLink, ['fa', 'fa-user']);
		$this->assertNull($this->attribute($mobileLink, 'id', false));
		$this->assertStringContainsString('Alejandr', $content);
		$logoutLinks = $this->findElementsByAttribute($content, 'a', 'href', url('usuario/salir'));
		$this->assertCount(1, $logoutLinks);
		$this->assertSingleIcon($logoutLinks[0], ['fa', 'fa-user-clock'], ['title' => 'Cerrar sesión']);
		$this->assertSame(0, preg_match_all('/<form\b/i', $content));
		$this->assertHamburgerContract($content);
	}

	public function test_mobile_session_control_has_minimum_touch_target()
	{
		$layoutCss = file_get_contents(public_path('css/layout.css'));

		$this->assertMatchesRegularExpression(
			'/\.mobile-session-control\s*\{(?=[^}]*min-height:\s*44px;)(?=[^}]*min-width:\s*44px;)[^}]*\}/s',
			$layoutCss
		);
	}

	private function renderHeader(array $session = [])
	{
		Session::flush();
		Session::put($session);

		return view('frontoffice.partial.menu', [
			'menuTypeExamItem' => collect(),
			'menuSubjectItem' => collect(),
			'menuGradeItem' => collect(),
		])->render();
	}

	private function findAnchorByAriaLabel($content, $label)
	{
		$matches = $this->findElementsByAttribute($content, 'a', 'aria-label', $label);

		$this->assertCount(1, $matches);

		return $matches[0];
	}

	private function attribute($markup, $name, $required = true)
	{
		$matched = preg_match('/\s' . preg_quote($name, '/') . '\s*=\s*(["\'])(.*?)\1/s', $markup, $matches);

		if (!$required && $matched !== 1) {
			return null;
		}

		$this->assertSame(1, $matched);

		return html_entity_decode($matches[2], ENT_QUOTES);
	}

	private function classTokens($markup)
	{
		$classAttribute = $this->attribute($markup, 'class', false);

		return $classAttribute === null ? [] : preg_split('/\s+/', trim($classAttribute));
	}

	private function assertHamburgerContract($content)
	{
		$bar = $this->findSingleElementByClasses($content, 'div', ['it-header-2-bar', 'd-xl-none']);
		$button = $this->findSingleElementByClasses($bar, 'button', ['it-menu-bar']);

		$this->assertNull($this->attribute($button, 'id', false));
		$this->assertSingleIcon($button, ['fa-solid', 'fa-bars']);
	}

	private function assertIconOnlyControl($anchor, array $iconClasses)
	{
		$this->assertSingleIcon($anchor, $iconClasses, ['aria-hidden' => 'true']);
		$this->assertSame('', trim(strip_tags($anchor)));
	}

	private function assertSingleIcon($markup, array $iconClasses, array $expectedAttributes = [])
	{
		$icons = $this->findElements($markup, 'i');

		$this->assertCount(1, $icons);
		foreach ($iconClasses as $iconClass) {
			$this->assertContains($iconClass, $this->classTokens($icons[0]));
		}
		foreach ($expectedAttributes as $name => $value) {
			$this->assertSame($value, $this->attribute($icons[0], $name));
		}
	}

	private function findSingleElementByClasses($content, $tagName, array $expectedClasses)
	{
		preg_match_all(
			'/<' . preg_quote($tagName, '/') . '\b[^>]*>/s',
			$content,
			$openingTags,
			PREG_OFFSET_CAPTURE
		);
		$elements = array_values(array_filter($openingTags[0], function ($element) use ($expectedClasses) {
			return count(array_diff($expectedClasses, $this->classTokens($element[0]))) === 0;
		}));

		$this->assertCount(1, $elements);
		[$openingTag, $offset] = $elements[0];
		$closingTag = '</' . $tagName . '>';
		$closingOffset = strpos($content, $closingTag, $offset + strlen($openingTag));
		$this->assertNotFalse($closingOffset);

		return substr($content, $offset, $closingOffset + strlen($closingTag) - $offset);
	}

	private function findSingleElement($content, $tagName)
	{
		$elements = $this->findElements($content, $tagName);

		$this->assertCount(1, $elements);

		return $elements[0];
	}

	private function findElementsByAttribute($content, $tagName, $attribute, $value)
	{
		return array_values(array_filter($this->findElements($content, $tagName), function ($element) use ($attribute, $value) {
			return $this->attribute($element, $attribute, false) === $value;
		}));
	}

	private function findElements($content, $tagName)
	{
		preg_match_all('/<' . preg_quote($tagName, '/') . '\b[^>]*>.*?<\/' . preg_quote($tagName, '/') . '>/s', $content, $matches);

		return $matches[0];
	}
}
