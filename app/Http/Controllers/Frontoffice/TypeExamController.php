<?php

namespace App\Http\Controllers\Frontoffice;

use App\Http\Controllers\Controller;
use App\Helper\PlatformHelper;
use App\Models\TExam;
use App\Models\TTypeExam;
use App\Helper\ExamHelper;
use App\Models\TGrade;
use App\Models\TSubject;
use App\Models\TUserExam;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TypeExamController extends Controller
{
	public function actionViewTypeExam(Request $request, $acronymTypeExam, $currentPage)
	{
		$searchParameter = $request->has('searchParameter') ? $request->input('searchParameter') : '';
		$slcGrades = $request->has('slcGrades') ? $request->input('slcGrades') : 'all';
		$slcSubjects = $request->has('slcSubjects') ? $request->input('slcSubjects') : 'all';
		$slcYears = $request->has('slcYears') ? $request->input('slcYears') : 'all';

		$tTypeExam = TTypeExam::whereRaw('acronymTypeExam=?', [$acronymTypeExam])->first();

		$paginate = PlatformHelper::preparePaginate(
			TExam::with(['tSubject', 'tGrade', 'tTypeExam', 'tDirection'])->whereRaw(
				'compareFind(
					concat(
						codeExam,
						nameExam,
						descriptionExam
					),
				?, 77) = 1
				AND idTypeExam=?
				AND stateExam = "Publico"' .
					($slcGrades != 'all' ? 'AND idGrade="' . $slcGrades . '"' : '') .
					($slcSubjects != 'all' ? 'AND idSubject="' . $slcSubjects . '"' : '') .
					($slcYears != 'all' ? 'AND yearExam="' . $slcYears . '"' : ''),
				[
					$searchParameter,
					$tTypeExam->idTypeExam
				]
			)->orderby('created_at', 'desc'),
			4,
			$currentPage
		);

		self::aditionalData($paginate['listRow']);

		$selectFilters = self::getSelectFilters();

		$filtersData = (object) [
			'searchParameter' => $searchParameter,
			'slcGrades' => $slcGrades,
			'slcSubjects' => $slcSubjects,
			'slcYears' => $slcYears
		];

		return view(
			'frontoffice/typeexam/view',
			[
				'tTypeExam' => $tTypeExam,
				'listTExam' => $paginate['listRow'],
				'currentPage' => $paginate['currentPage'],
				'quantityPage' => $paginate['quantityPage'],
				'filtersData' => $filtersData,
				'selectFilters' => $selectFilters
			]
		);
	}

	private function aditionalData($rows)
	{
		foreach ($rows as $key => &$item) {
			$item['rating'] = ExamHelper::getRatingData($item->idExam);
			$item['user'] = (TUserExam::with(['tUser'])->where(['idExam' => $item->idExam, 'typeFunctionExam' => 'Registro'])->first())->tUser;
		}
	}

	private function getSelectFilters()
	{
		return [
			'grades' => TGrade::all(),
			'subjects' => TSubject::all(),
			'years' => TExam::select(DB::raw('yearExam'))->groupByRaw('yearExam')->get()
		];
	}
}
