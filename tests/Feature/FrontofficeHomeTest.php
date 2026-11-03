<?php

namespace Tests\Feature;

use Tests\TestCase;

class FrontofficeHomeTest extends TestCase
{
	public function test_home_hero_uses_a_desktop_only_minimum_viewport_height()
	{
		$view = file_get_contents(resource_path('views/frontoffice/general/welcome.blade.php'));
		$layoutCss = file_get_contents(public_path('css/layout.css'));
		$hero = $this->findOpeningTagByClass($view, 'home-hero');

		$this->assertContains('it-hero-3-area', $this->classTokens($hero));
		$this->assertMatchesRegularExpression(
			'/@media\s*\(min-width:\s*1200px\)\s*\{\s*\.home-hero\s*\{([^}]*)\}\s*\}/s',
			$layoutCss
		);
		preg_match(
			'/@media\s*\(min-width:\s*1200px\)\s*\{\s*\.home-hero\s*\{([^}]*)\}\s*\}/s',
			$layoutCss,
			$desktopRule
		);
		$this->assertMatchesRegularExpression('/\bmin-height:\s*100vh;/', $desktopRule[1]);
		$this->assertDoesNotMatchRegularExpression('/(?<!-)\bheight\s*:/', $desktopRule[1]);
		$this->assertDoesNotMatchRegularExpression('/\.it-hero-3-area\s*\{[^}]*min-height/s', $layoutCss);
	}

	public function test_home_hero_content_and_following_section_spacing_are_preserved()
	{
		$view = file_get_contents(resource_path('views/frontoffice/general/welcome.blade.php'));
		$category = $this->findOpeningTagByClass($view, 'it-category-4-area');

		$this->assertStringContainsString('Bienvenido al repositorio web de <span>Evaluaciones</span>', $view);
		$this->assertStringContainsString('Buscar evaluación', $view);
		$this->assertStringContainsString('hero-estudiantes.png', $view);
		$this->assertContains('pt-120', $this->classTokens($category));
		$this->assertContains('grey-bg', $this->classTokens($category));
	}

	private function findOpeningTagByClass($content, $className)
	{
		preg_match_all('/<div\b[^>]*>/s', $content, $openingTags);
		$matches = array_values(array_filter($openingTags[0], function ($tag) use ($className) {
			return in_array($className, $this->classTokens($tag), true);
		}));

		$this->assertCount(1, $matches);

		return $matches[0];
	}

	private function classTokens($markup)
	{
		$matched = preg_match('/\sclass\s*=\s*(["\'])(.*?)\1/s', $markup, $matches);
		$this->assertSame(1, $matched);

		return preg_split('/\s+/', trim($matches[2]));
	}
}
