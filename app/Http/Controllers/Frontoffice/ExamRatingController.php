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

			$data = $request->all();

			TExam::where(['idExam' => $data['idExam']])->firstOr(function () {
				throw new ModelNotFoundException('Error al intentar registrar la calificación. Examen no encontrado o no disponible.');
			});

			$tExamRating = new TExamRating([
				'idExam' => $data['idExam'],
				'idUser' => session('idUser'),
				'rating' => $data['rating']
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
