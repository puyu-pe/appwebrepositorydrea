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
			$this->assertStringContainsString("$('.js-exam-select-all').prop('checked', isAllMode);", $script);
			$this->assertStringContainsString("if (Array.isArray(parsedState))", $script);
		}
	}

	public function test_frontoffice_selection_scripts_use_semantic_checkbox_selectors()
	{
		foreach ($this->frontofficeSelectionScripts() as $scriptPath) {
			$script = file_get_contents($scriptPath);

			$this->assertStringContainsString("$('.js-exam-select-all')", $script);
			$this->assertStringContainsString("$('.js-exam-select')", $script);
			$this->assertStringNotContainsString("$('#selectAll')", $script);
			$this->assertStringNotContainsString('name="result[]"', $script);
			$this->assertStringNotContainsString('name="selectedExamIds[]"', $script);
		}
	}

	public function test_download_preparation_paints_busy_state_and_uses_a_hidden_iframe()
	{
		foreach ($this->frontofficeSelectionScripts() as $scriptPath) {
			$script = file_get_contents($scriptPath);

			$this->assertStringContainsString('var downloadPreparationInFlight = false;', $script);
			$this->assertStringContainsString('if (downloadPreparationInFlight) {', $script);
			$this->assertStringContainsString('downloadPreparationInFlight = true;', $script);
			$this->assertStringContainsString('setDownloadButtonBusyState(true);', $script);
			$this->assertStringContainsString("\$button.prop('disabled', isBusy);", $script);
			$this->assertStringContainsString("\$button.attr('aria-busy', isBusy ? 'true' : 'false');", $script);
			$this->assertStringContainsString("\$button.find('.download-label').text(isBusy ? 'Descargando archivos' : 'Descargar archivos');", $script);
			$this->assertStringContainsString('setDownloadButtonBusyState(downloadPreparationInFlight);', $script);
			$this->assertStringNotContainsString('window.open(', $script);
			$this->assertMatchesRegularExpression(
				'/setDownloadButtonBusyState\(true\);\s*requestAnimationFrame\(function \(\) \{\s*setTimeout\(function \(\) \{\s*prepareDownload\(/',
				$script,
				"The preparation request must yield long enough for the browser to paint the busy label in {$scriptPath}."
			);
			$this->assertStringContainsString("iframe.name = 'frontoffice-download-frame';", $script);
			$this->assertStringContainsString("iframe.style.display = 'none';", $script);
			$this->assertStringContainsString('iframe.src = downloadUrl;', $script);
			$this->assertStringContainsString('document.body.appendChild(iframe);', $script);
			$this->assertStringContainsString('window.setTimeout(function () {', $script);
			$this->assertStringContainsString('iframe.parentNode.removeChild(iframe);', $script);
			$this->assertStringContainsString('originatingSelectionStorageKey = selectionStorageKey;', $script);
			$this->assertMatchesRegularExpression(
				'/success:\s*function \(response\)\s*\{\s*if \(!initiateDownload\(response\.downloadUrl\)\)\s*\{\s*return;\s*\}\s*clearPersistedSelections\(originatingSelectionStorageKey\);/',
				$script,
				"Selection clearing must follow a successful download initiation attempt in {$scriptPath}."
			);
			$this->assertStringContainsString('if (selectionStorageKey === originatingSelectionStorageKey) {', $script);
			$this->assertMatchesRegularExpression(
				'/error:\s*function \(\)\s*\{\s*restoreDownloadButtonState\(originatingSelectionStorageKey\);\s*\},\s*complete:/' ,
				$script,
				"Preparation failures must restore the originating selection without clearing it in {$scriptPath}."
			);
			$this->assertMatchesRegularExpression(
				'/complete:\s*function \(\)\s*\{\s*restoreDownloadButtonState\(originatingSelectionStorageKey\);\s*\}/',
				$script,
				"Completion must restore the reusable button state in {$scriptPath}."
			);
			$this->assertSame(1, substr_count($script, 'clearPersistedSelections(originatingSelectionStorageKey);'));
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
