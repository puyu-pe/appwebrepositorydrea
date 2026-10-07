<?php

namespace App\Http\Controllers\Frontoffice;

use App\Http\Controllers\Controller;
use App\Helper\PlatformHelper;
use App\Models\TExam;
use App\Models\TExamRating;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Helper\ExamHelper;

class ExamRatingController extends Controller
{
    function actionInsert(Request $request)
    {
        try {
            DB::beginTransaction();

            $idExam = $request->input('idExam');
            $rating = $request->input('rating');

            $tExam = TExam::where(['idExam' => $idExam])->firstOr(function () {
                throw new ModelNotFoundException('Error al intentar registrar la calificación. Examen no encontrado o no disponible.');
            });

            $tExamRating = TExamRating::where(['idUser' => session('idUser'), 'idExam' => $idExam])->first();

            if (!$tExamRating) {
                $tExamRating = new TExamRating();
                $tExamRating->idExamRating = uniqid();
                $tExamRating->idExam = $idExam;
                $tExamRating->idUser = session('idUser');
                $tExamRating->rating = $rating;
                $tExamRating->save();

                $message = 'Evaluación calificada de exitosamente.';
            } else {
                $tExamRating->rating = $rating;
                $tExamRating->update();

                $message = 'Calificación actualizada de exitosamente.';
            }

            $rating = ExamHelper::getRatingData($tExam->idExam);

            $tExam->rating_counter = $rating->count;
            $tExam->rating_average = $rating->avg;
            $tExam->save();

            $data = [
                'data' => [
                    'tExamRating' => $tExamRating,
                    'rating' => $rating
                ]
            ];

            DB::commit();

            return PlatformHelper::jsonSuccess([$message], 200, null, $data);
        } catch (ModelNotFoundException $th) {
            DB::rollBack();

            $data = [
                'data' => [
                    'tExamRating' => null
                ]
            ];

            return PlatformHelper::jsonError([$th->getMessage()], 404, null, $data);
        }
    }
}
