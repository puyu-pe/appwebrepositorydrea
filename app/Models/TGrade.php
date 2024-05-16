<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TGrade extends Model
{
    protected $table='tgrade';
    protected $primaryKey='idGrade';
    protected $keyType='string';
    public $incrementing=false;
    public $timestamps=true;

    public function tExam()
    {
        return $this->hasMany('App\Models\TExam', 'idGrade');
    }

    public static function tGradeExamFront(){
        $tGrade = TGrade::select('tgrade.idGrade', 'tgrade.nameGrade', 'tgrade.descriptionGrade', 'tgrade.codeGrade', DB::raw('COUNT(texam.idExam) as exam_count'))
            ->join('texam', 'tgrade.idGrade', '=', 'texam.idGrade')
            ->where('texam.stateExam', TExam::STATUS['PUBLIC'])
            ->groupBy('tgrade.idGrade', 'tgrade.nameGrade', 'tgrade.descriptionGrade', 'tgrade.codeGrade')
            ->get();

        return $tGrade;
    }
}
?>
