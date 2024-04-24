<?php

namespace App\Http\Controllers\Frontoffice;

use App\Http\Controllers\Controller;
use App\Helper\PlatformHelper;
use App\Models\TAnswer;
use App\Models\TDirection;
use App\Models\TDocument;
use App\Models\TResource;
use App\Models\TRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helper\ExamHelper;

use App\Models\TExam;
use App\Models\TGrade;
use App\Models\TSubject;
use App\Models\TTypeExam;
use App\Models\TUserExam;
use App\Validation\ExamValidation;

class ExamController extends Controller
{
    public function actionGetExam($codeExam)
    {
        try {
            $tExam = TExam::with(['tSubject', 'tGrade', 'tTypeExam'])->whereRaw('codeExam=?', [$codeExam])->first();

            if (!$tExam) {
                $message = 'No se encontró la página de la evaluación';

                return view('frontoffice/exam/error',
                    [
                        'message' => $message
                    ]);
            }

            if ($tExam && $tExam->stateExam != TExam::STATUS['PUBLIC'] &&
                !stristr(session('roleUser'), TRole::ROLE['ADMIN']) && !stristr(session('roleUser'), TRole::ROLE['SUPERVISOR'])) {
                $message = 'La página de la evaluación aún no se encuentra público.';

                return view('frontoffice/exam/error',
                    [
                        'message' => $message
                    ]);
            }

            $tResourceTable = TResource::whereRaw('idExam = ? AND type = ?', [$tExam->idExam, TResource::TYPE_RESOURCE['TABLE']])->first();
            $tResourceMaterial = TResource::whereRaw('idExam = ? AND type = ?', [$tExam->idExam, TResource::TYPE_RESOURCE['MATERIAL']])->get();
            ExamHelper::incrementViewCounter($tExam);
            $rating = ExamHelper::getRatingData($tExam->idExam);

            $tAnswerUserSession = null;

            $tAnswer = TAnswer::whereRaw('idExam = ? AND idUser = ?', [$tExam->idExam, session('idUser')])
                ->orderBy('numberAnswer')->get();

//            if (session('idUser'))
//                $tAnswerUserSession = TAnswer::where('idExam', $tExam->idExam)
//                    ->orderBy('numberAnswer')
//                    ->with('tuser')
//                    ->where('idUser', session('idUser'))
//                    ->get();

            $tAnswersGroupedByUser = TAnswer::where('idExam', $tExam->idExam)
                ->orderBy('numberAnswer')
                ->with('tuser')
                ->get()
                ->groupBy('idUser');

            return view('frontoffice/exam/seed',
                [
                    'tExam' => $tExam,
                    'tResourceTable' => $tResourceTable,
                    'tResourceMaterial' => $tResourceMaterial,
                    'rating' => $rating,
                    'tAnswersGroupedByUser' => $tAnswersGroupedByUser,
                    'tAnswer' => $tAnswer
                ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return PlatformHelper::redirectError([$e->getMessage()], '/');
        }
    }
}
