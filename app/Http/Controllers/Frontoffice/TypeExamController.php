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
    public function actionViewTypeExam(Request $request, $acronymTypeExam, $currentPage)
    {
        $filtersData = (object)[
            'searchParameter' => $request->has('searchParameter') ? $request->input('searchParameter') : '',
            'type' => PlatformHelper::resolvePaginationFilterValue($acronymTypeExam, $request->input('type')),
            'grade' => $request->has('grade') ? $request->input('grade') : 'all',
            'subject' => $request->has('subject') ? $request->input('subject') : 'all',
            'year' => $request->has('year') ? $request->input('year') : 'all',
        ];

        $tTypeExam = $this->resolveTypeExamFilterEntity($filtersData->type);
        $tGradeFilter = $this->resolvePublicFilterEntity(TGrade::class, 'codeGrade', 'idGrade', $filtersData->grade);
        $tSubjectFilter = $this->resolvePublicFilterEntity(TSubject::class, 'codeSubject', 'idSubject', $filtersData->subject);

        $filtersData->type = PlatformHelper::normalizePublicFilterValue($filtersData->type, $tTypeExam, 'acronymTypeExam');
        $filtersData->grade = PlatformHelper::normalizePublicFilterValue($filtersData->grade, $tGradeFilter, 'codeGrade');
        $filtersData->subject = PlatformHelper::normalizePublicFilterValue($filtersData->subject, $tSubjectFilter, 'codeSubject');

        $examsQuery = TExam::with(['tSubject', 'tGrade', 'tTypeExam', 'tDirection'])
            ->whereRaw('compareFind(concat(codeExam, nameExam, descriptionExam), ?, 77) = 1', [$filtersData->searchParameter])
            ->where('stateExam', TExam::STATUS['PUBLIC']);

        if ($filtersData->type != 'all') {
            $examsQuery->where('idTypeExam', PlatformHelper::resolveInternalFilterValue($filtersData->type, $tTypeExam, 'idTypeExam'));
        }

        if ($filtersData->grade != 'all') {
            $examsQuery->where('idGrade', PlatformHelper::resolveInternalFilterValue($filtersData->grade, $tGradeFilter, 'idGrade'));
        }

        if ($filtersData->subject != 'all') {
            $examsQuery->where('idSubject', PlatformHelper::resolveInternalFilterValue($filtersData->subject, $tSubjectFilter, 'idSubject'));
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
            'frontoffice/typeexam/view',
            [
                'tTypeExam' => $tTypeExam,
                'listTExam' => $paginate['listRow'],
                'currentPage' => $paginate['currentPage'],
                'quantityPage' => $paginate['quantityPage'],
                'filtersData' => $filtersData,
                'selectFilters' => $selectFilters,
                'acronymTypeExam' => $acronymTypeExam
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
