<?php

namespace App\Helper;

use Exception;
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
}
