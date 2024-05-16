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

class GradeController extends Controller
{
    public function actionViewGrade(Request $request, $codeGrade, $currentPage)
    {
        $searchParameter = $request->has('searchParameter') ? $request->input('searchParameter') : '';
        $type = $request->has('type') ? $request->input('type') : 'all';
        $grade = $request->has('grade') ? $request->input('grade') : 'all';
        $subject = $request->has('subject') ? $request->input('subject') : 'all';
        $year = $request->has('year') ? $request->input('year') : 'all';

        $tGrade = $codeGrade != 'all' ? TGrade::whereRaw('codeGrade =?', [$codeGrade])->first() : null;

        if ($codeGrade != 'all' && $type != 'all')
            $tGrade =  TGrade::whereRaw('codeGrade =?', [$type])->first();

        $examsQuery = TExam::with(['tSubject', 'tGrade', 'tTypeExam', 'tDirection'])
            ->whereRaw(
                'compareFind(concat(codeExam, nameExam, descriptionExam), ?, 77) = 1 ' .
                'AND stateExam = "' . TExam::STATUS['PUBLIC'] . '"' .
                ($tGrade != null ? 'AND idGrade="' . $tGrade->idGrade . '"' : '') .
                ($subject != 'all' ? 'AND idSubject="' . $subject . '"' : '') .
                ($type != 'all' ? 'AND idTypeExam="' . $type . '"' : '') .
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
            'year' => $year,
        ];

        return view(
            'frontoffice/grade/view',
            [
                'tGrade' => $tGrade,
                'listTExam' => $paginate['listRow'],
                'currentPage' => $paginate['currentPage'],
                'quantityPage' => $paginate['quantityPage'],
                'filtersData' => $filtersData,
                'selectFilters' => $selectFilters,
                'codeGrade' => $codeGrade
            ]
        );
    }

    private function getSelectFilters()
    {
        return [
            'types' => TTypeExam::tTypeExamFront(),
            'grades' => TGrade::tGradeExamFront(),
            'subjects' => TSubject::tSubjectExamFront(),
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
