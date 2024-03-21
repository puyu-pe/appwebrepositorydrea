<?php

namespace App\Helper;

use Exception;
use App\Models\TExamRating;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ExamHelper
{
    public static function incrementViewCounter(Model $exam): bool
    {
        try {
            DB::beginTransaction();

            $exam->increment('view_counter');

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            throw new Exception("Error al intentar incrementar el contador de vistas de la evaluación.", 1);

            DB::rollBack();
            return false;
        }
    }

    public static function getRatingData(string $idExam)
    {
        try {
            $examRatings = TExamRating::where(['idExamRating' => $idExam])->get();

            $count = count($examRatings);
            $avg = 0;

            if ($count > 0) {
                $avg = $examRatings->avg('rating');
            }

            $data = (object) [
                'count' => $count,
                'avg' => number_format($avg, 1, '.', '')
            ];

            return $data;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
