<?php

namespace App\Http\Controllers\Frontoffice;

use App\Http\Controllers\Controller;
use App\Helper\PlatformHelper;
use App\Models\TExam;
use App\Models\TTypeExam;
use App\Helper\ExamHelper;
use App\Models\TGrade;
use App\Models\TSubject;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TypeExamController extends Controller
{
    public function actionViewTypeExam(Request $request, $currentPage)
    {
        $searchParameter = $request->has('searchParameter') ? $request->input('searchParameter') : '';
        $type = $request->has('type') ? $request->input('type') : 'all';
        $grade = $request->has('grade') ? $request->input('grade') : 'all';
        $subject = $request->has('subject') ? $request->input('subject') : 'all';
        $year = $request->has('year') ? $request->input('year') : 'all';

        $tTypeExam = TTypeExam::whereRaw('acronymTypeExam=?', [$type])->first();

        $examsQuery = TExam::with(['tSubject', 'tGrade', 'tTypeExam', 'tDirection'])
            ->whereRaw(
                'compareFind(concat(codeExam, nameExam, descriptionExam), ?, 77) = 1 ' .
                'AND stateExam = "' . TExam::STATUS['PUBLIC'] . '"' .
                ($type != 'all' ? 'AND idTypeExam="' . $tTypeExam->idTypeExam . '"' : '') .
                ($grade != 'all' ? 'AND idGrade="' . $grade . '"' : '') .
                ($subject != 'all' ? 'AND idSubject="' . $subject . '"' : '') .
                ($year != 'all' ? 'AND yearExam="' . $year . '"' : ''),
                [
                    $searchParameter
                ]
            )->orderBy('created_at', 'desc');

        $exams = $this->filterAndDeleteExamsWithoutFiles($examsQuery);

        $paginate = PlatformHelper::preparePaginate($exams, 20, $currentPage);

        ExamHelper::getRatingAndUser($paginate['listRow']);

        $selectFilters = self::getSelectFilters();

        $filtersData = (object)[
            'searchParameter' => $searchParameter,
            'type' => $type,
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
            'types' => TTypeExam::all(),
            'grades' => TGrade::all(),
            'subjects' => TSubject::all(),
            'years' => TExam::select(DB::raw('yearExam'))->groupByRaw('yearExam')->get()
        ];
    }

    private function filterAndDeleteExamsWithoutFiles($examsQuery)
    {
        $exams = $examsQuery->get();

        $filteredExams = $exams->filter(function ($exam) {
            $directoryFiles = storage_path('app/file/exam/' . $exam->idExam . '.' . $exam->extensionExam);
            return file_exists($directoryFiles);
        });

        $examsWithoutFiles = $exams->diff($filteredExams)->pluck('idExam');
        $examsQuery->whereNotIn('idExam', $examsWithoutFiles);

        return $examsQuery;
    }

}
