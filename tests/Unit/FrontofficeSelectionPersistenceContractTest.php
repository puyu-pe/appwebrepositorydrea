<?php

namespace Tests\Unit;

use Tests\TestCase;

class FrontofficeSelectionPersistenceContractTest extends TestCase
{
	public function test_frontoffice_selection_scripts_persist_all_mode_per_filter_context()
	{
		foreach ($this->frontofficeSelectionScripts() as $scriptPath) {
			$script = file_get_contents($scriptPath);

			$this->assertStringContainsString("return 'frontoffice-download-selection:' + normalizedPath + ':' + buildFilterContextKey();", $script);
			$this->assertStringContainsString("mode: 'all'", $script);
			$this->assertStringContainsString("persistVisibleCheckedSelections();", $script);
			$this->assertStringContainsString("$('#selectAll').prop('checked', isAllMode);", $script);
			$this->assertStringContainsString("if (Array.isArray(parsedState))", $script);
		}
	}

	private function frontofficeSelectionScripts()
	{
		return [
			public_path('assets/frontoffice/viewResources/grade/view.js'),
			public_path('assets/frontoffice/viewResources/subject/view.js'),
			public_path('assets/frontoffice/viewResources/typeexam/view.js'),
		];
	}
}
