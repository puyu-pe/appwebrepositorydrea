<?php

namespace App\Http\Controllers\Frontoffice;

use App\Http\Controllers\Controller;
use App\Models\TExam;
use App\Models\TExamRating;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ExamRatingController extends Controller
{
	function actionInsert(Request $request)
	{
		try {
			DB::beginTransaction();

			$idExam = $request->input('idExam');
			$rating = $request->input('rating');

			TExam::where(['idExam' => $idExam])->firstOr(function () {
				throw new ModelNotFoundException('Error al intentar registrar la calificación. Examen no encontrado o no disponible.');
			});

			$tExamRating = new TExamRating([
				'idExam' => $idExam,
				'idUser' => session('idUser'),
				'rating' => $rating
			]);

			DB::commit();

			$response = [
				'success' => true,
				'data' => [
					'tExamRating' => $tExamRating
				],
				'message' => null
			];

			return response()->json($response, 200);
		} catch (\Throwable $th) {
			DB::rollBack();

			$response = [
				'success' => true,
				'data' => [
					'tExamRating' => null
				],
				'message' => $th->getMessage()
			];

			return response()->json($data, 500);
		}
	}
}
