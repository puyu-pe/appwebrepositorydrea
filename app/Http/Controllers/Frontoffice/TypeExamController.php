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
		$grade = $request->has('grade') ? $request->input('grade') : 'all';
		$subject = $request->has('subject') ? $request->input('subject') : 'all';
		$year = $request->has('year') ? $request->input('year') : 'all';

		$tTypeExam = TTypeExam::whereRaw('acronymTypeExam=?', [$acronymTypeExam])->first();

        $examsQuery = TExam::with(['tSubject', 'tGrade', 'tTypeExam', 'tDirection'])
            ->whereRaw(
                'compareFind(concat(codeExam, nameExam, descriptionExam), ?, 77) = 1
        AND idTypeExam=?
        AND stateExam = "'.TExam::STATUS['PUBLIC'].'"'.
                ($grade != 'all' ? 'AND idGrade="' . $grade . '"' : '') .
                ($subject != 'all' ? 'AND idSubject="' . $subject . '"' : '') .
                ($year != 'all' ? 'AND yearExam="' . $year . '"' : ''),
                [
                    $searchParameter,
                    $tTypeExam->idTypeExam
                ]
            )->orderBy('created_at', 'desc');

        $exams = $this->filterAndDeleteExamsWithoutFiles($examsQuery);
        $paginate = PlatformHelper::preparePaginate($exams, 4, $currentPage);

		ExamHelper::getRatingAndUser($paginate['listRow']);

		$selectFilters = self::getSelectFilters();

		$filtersData = (object) [
			'searchParameter' => $searchParameter,
			'grade' => $grade,
			'subject' => $subject,
			'year' => $year
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

	private function getSelectFilters()
	{
		return [
			'grades' => TGrade::all(),
			'subjects' => TSubject::all(),
			'years' => TExam::select(DB::raw('yearExam'))->groupByRaw('yearExam')->get()
		];
	}

    private function filterAndDeleteExamsWithoutFiles($examsQuery) {
        $exams = $examsQuery->get();

        $filteredExams = $exams->filter(function ($exam) {
            $directoryFiles = storage_path('app/file/exam/'.$exam->idExam.'.'.$exam->extensionExam);
            return file_exists($directoryFiles);
        });

        $examsWithoutFiles = $exams->diff($filteredExams)->pluck('idExam');
        $examsQuery->whereNotIn('idExam', $examsWithoutFiles);

        return $examsQuery;
    }

}
