<?php

namespace Tests\Unit;

use Tests\TestCase;

class StaticAssetCacheVersioningContractTest extends TestCase
{
	public function test_shared_layout_stylesheet_uses_the_configured_cache_version()
	{
		foreach($this->sharedLayouts() as $layout)
		{
			$layoutContents=file_get_contents($layout);

			$this->assertStringContainsString(
				"href=\"{{asset('css/layout.css?x='.env('CACHE_LAST_UPDATE'))}}\"",
				$layoutContents
			);
			$this->assertStringNotContainsString(
				"href=\"{{asset('css/layout.css')}}\"",
				$layoutContents
			);
		}
	}

	private function sharedLayouts()
	{
		return [
			resource_path('views/frontoffice/layout.blade.php'),
			resource_path('views/backoffice/layout.blade.php')
		];
	}
}
