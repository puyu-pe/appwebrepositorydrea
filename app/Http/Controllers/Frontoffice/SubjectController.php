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

class SubjectController extends Controller
{
    public function actionViewSubject(Request $request, $codeSubject, $currentPage)
    {
        $filtersData = (object)[
            'searchParameter' => $request->has('searchParameter') ? $request->input('searchParameter') : '',
            'type' => $request->has('type') ? $request->input('type') : 'all',
            'grade' => $request->has('grade') ? $request->input('grade') : 'all',
            'subject' => PlatformHelper::resolvePaginationFilterValue($codeSubject, $request->input('subject')),
            'year' => $request->has('year') ? $request->input('year') : 'all',
        ];

        $tSubject = $this->resolvePublicFilterEntity(TSubject::class, 'codeSubject', 'idSubject', $filtersData->subject);
        $tTypeExamFilter = $this->resolveTypeExamFilterEntity($filtersData->type);
        $tGradeFilter = $this->resolvePublicFilterEntity(TGrade::class, 'codeGrade', 'idGrade', $filtersData->grade);

        $filtersData->type = PlatformHelper::normalizePublicFilterValue($filtersData->type, $tTypeExamFilter, 'acronymTypeExam');
        $filtersData->subject = PlatformHelper::normalizePublicFilterValue($filtersData->subject, $tSubject, 'codeSubject');
        $filtersData->grade = PlatformHelper::normalizePublicFilterValue($filtersData->grade, $tGradeFilter, 'codeGrade');

        $examsQuery = TExam::with(['tSubject', 'tGrade', 'tTypeExam', 'tDirection'])
            ->whereRaw('compareFind(concat(codeExam, nameExam, descriptionExam), ?, 77) = 1', [$filtersData->searchParameter])
            ->where('stateExam', TExam::STATUS['PUBLIC']);

        if ($filtersData->subject != 'all') {
            $examsQuery->where('idSubject', PlatformHelper::resolveInternalFilterValue($filtersData->subject, $tSubject, 'idSubject'));
        }

        if ($filtersData->grade != 'all') {
            $examsQuery->where('idGrade', PlatformHelper::resolveInternalFilterValue($filtersData->grade, $tGradeFilter, 'idGrade'));
        }

        if ($filtersData->type != 'all') {
            $examsQuery->where('idTypeExam', PlatformHelper::resolveInternalFilterValue($filtersData->type, $tTypeExamFilter, 'idTypeExam'));
        }

        if ($filtersData->year != 'all') {
            $examsQuery->where('yearExam', $filtersData->year);
        }

        $examsQuery->orderBy('created_at', 'desc');

        $exams = $this->filterAndDeleteExamsWithoutFiles($examsQuery);

        $paginate = PlatformHelper::preparePaginate($exams, 20, $currentPage);

        ExamHelper::getRatingAndUser($paginate['listRow']);

        $selectFilters = self::getSelectFilters();

        return view(
            'frontoffice/subject/view',
            [
                'tSubject' => $tSubject,
                'listTExam' => $paginate['listRow'],
                'currentPage' => $paginate['currentPage'],
                'quantityPage' => $paginate['quantityPage'],
                'filtersData' => $filtersData,
                'selectFilters' => $selectFilters,
                'codeSubject' => $codeSubject
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
