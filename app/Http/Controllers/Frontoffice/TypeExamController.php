<?php

namespace App\Http\Controllers\Frontoffice;

use App\Http\Controllers\Controller;
use App\Helper\PlatformHelper;
use App\Models\TExam;
use App\Models\TTypeExam;

use Illuminate\Http\Request;
use ZipArchive;

class TypeExamController extends Controller
{
    public function actionViewTypeExam(Request $request, $acronymTypeExam, $currentPage)
    {
        $searchParameter = $request->has('searchParameter') ? $request->input('searchParameter') : '';

        $tTypeExam = TTypeExam::whereRaw('acronymTypeExam=?', [$acronymTypeExam])->first();

        $paginate = PlatformHelper::preparePaginate(TExam::with(['tSubject', 'tGrade', 'tTypeExam'])
            ->whereRaw('compareFind(concat(codeExam, nameExam, descriptionExam, yearExam, keywordExam), ?, 77)=1 AND stateExam = "Publico" AND idTypeExam=?', [$searchParameter, $tTypeExam->idTypeExam])
            ->orderby('created_at', 'desc'), 7, $currentPage);

        return view('frontoffice/typeexam/view',
            [
                'tTypeExam' => $tTypeExam,
                'listTExam' => $paginate['listRow'],
                'currentPage' => $paginate['currentPage'],
                'quantityPage' => $paginate['quantityPage'],
                'searchParameter' => $searchParameter
            ]);
    }

}
