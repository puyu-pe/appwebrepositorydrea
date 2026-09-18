<?php

namespace Tests\Unit;

use App\Helper\PlatformHelper;
use App\Helper\ViewHelper;
use Tests\TestCase;

class PaginationContractTest extends TestCase
{
	public function test_resolve_pagination_filter_value_prioritizes_query_filter_without_losing_route_context()
	{
		$this->assertSame('eca', PlatformHelper::resolvePaginationFilterValue('all', 'eca'));
		$this->assertSame('matematica', PlatformHelper::resolvePaginationFilterValue('matematica', 'all'));
		$this->assertSame('all', PlatformHelper::resolvePaginationFilterValue('all', 'all'));
	}

	public function test_front_pagination_preserves_search_and_filter_contract()
	{
		$filtersData=(object)[
			'searchParameter' => 'matematica 2024',
			'type' => 'eca',
			'grade' => 'grade-1',
			'subject' => 'subject-1',
			'year' => '2024'
		];

		$pagination=ViewHelper::renderPaginationFrontExams('tipoexamen/all', 5, 2, $filtersData);

		$this->assertStringContainsString('searchParameter=matematica+2024', $pagination);
		$this->assertStringContainsString('type=eca', $pagination);
		$this->assertStringContainsString('grade=grade-1', $pagination);
		$this->assertStringContainsString('subject=subject-1', $pagination);
		$this->assertStringContainsString('year=2024', $pagination);
	}

	public function test_public_filter_helpers_normalize_codes_and_keep_legacy_ids_compatible()
	{
		$grade=(object)[
			'idGrade' => '6518e4d1ebfd8',
			'codeGrade' => 'grade-1'
		];

		$subject=(object)[
			'idSubject' => '641f76356ced4',
			'codeSubject' => 'subject-1'
		];

		$typeExam=(object)[
			'idTypeExam' => '641f76356ced5',
			'acronymTypeExam' => 'eca'
		];

		$this->assertSame('grade-1', PlatformHelper::normalizePublicFilterValue('6518e4d1ebfd8', $grade, 'codeGrade'));
		$this->assertSame('subject-1', PlatformHelper::normalizePublicFilterValue('641f76356ced4', $subject, 'codeSubject'));
		$this->assertSame('eca', PlatformHelper::normalizePublicFilterValue('641f76356ced5', $typeExam, 'acronymTypeExam'));
		$this->assertSame('6518e4d1ebfd8', PlatformHelper::resolveInternalFilterValue('grade-1', $grade, 'idGrade'));
		$this->assertSame('641f76356ced4', PlatformHelper::resolveInternalFilterValue('subject-1', $subject, 'idSubject'));
		$this->assertSame('641f76356ced5', PlatformHelper::resolveInternalFilterValue('eca', $typeExam, 'idTypeExam'));
		$this->assertSame('legacy-grade-id', PlatformHelper::resolveInternalFilterValue('legacy-grade-id', null, 'idGrade'));
		$this->assertSame('legacy-type-id', PlatformHelper::resolveInternalFilterValue('legacy-type-id', null, 'idTypeExam'));
	}

	public function test_backoffice_pagination_keeps_search_parameter_when_present()
	{
		$pagination=ViewHelper::renderPagination('examen/mostrar', 3, 2, 'codigo 2024');

		$this->assertStringContainsString('searchParameter=codigo+2024', $pagination);
	}
}
