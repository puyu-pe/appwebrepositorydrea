<?php

namespace App\Http\Controllers\Frontoffice;

use App\Http\Controllers\Controller;
use App\Helper\PlatformHelper;
use App\Models\TAnswer;
use App\Models\TAnswerDetail;
use App\Models\TResource;
use App\Models\TRole;
use Illuminate\Support\Facades\DB;
use App\Helper\ExamHelper;

use App\Models\TExam;

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

            $tAnswer = TAnswer::whereRaw('idExam = ? AND idUser = ? AND type != ?',
                [$tExam->idExam, session('idUser'), TAnswer::TYPE['CORRECT']])->first();
            $tAnswerDetail = $tAnswer ? TAnswerDetail::whereRaw('idAnswer = ?', [$tAnswer->idAnswer])
                ->orderBy('numberAnswer')->get() : null;

            $tAnswerCorrect = TAnswer::whereRaw('idExam = ? AND type = ?', [$tExam->idExam, TAnswer::TYPE['CORRECT']])->first();
            $tAnswerDetailCorrect = $tAnswerCorrect ? TAnswerDetail::whereRaw('idAnswer = ?', [$tAnswerCorrect->idAnswer])
                ->orderBy('numberAnswer')->get() : null;

            $tAnswersGroupedByUser = TAnswer::where('idExam', $tExam->idExam)
                ->where('type', TAnswer::TYPE['REVIEWED'])
                ->orderBy('created_at')
                ->with(['tAnswerDetail', 'tUser'])
                ->withSum(['tanswerdetail as correct_answers_sum' => function ($query) {
                    $query->where('is_correct', 1);
                }], 'is_correct')
                ->get();

            return view('frontoffice/exam/seed',
                [
                    'tExam' => $tExam,
                    'tResourceTable' => $tResourceTable,
                    'tResourceMaterial' => $tResourceMaterial,
                    'rating' => $rating,
                    'tAnswersGroupedByUser' => $tAnswersGroupedByUser,
                    'tAnswer' => $tAnswer,
                    'tAnswerDetail' => $tAnswerDetail,
                    'tAnswerDetailCorrect' => $tAnswerDetailCorrect
                ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return PlatformHelper::redirectError([$e->getMessage()], '/');
        }
    }
}
