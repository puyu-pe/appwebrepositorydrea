<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TSubject extends Model
{
    protected $table='tsubject';
    protected $primaryKey='idSubject';
    protected $keyType='string';
    public $incrementing=false;
    public $timestamps=true;

    public function tExam()
    {
        return $this->hasMany('App\Models\TExam', 'idSubject');
    }

    public static function tSubjectExamFront(){
        $tSubject = TSubject::select('tsubject.idSubject', 'tsubject.nameSubject', 'tsubject.codeSubject', DB::raw('COUNT(texam.idExam) as exam_count'))
            ->join('texam', 'tsubject.idSubject', '=', 'texam.idSubject')
            ->where('texam.stateExam', TExam::STATUS['PUBLIC'])
            ->groupBy('tsubject.idSubject', 'tsubject.nameSubject', 'tsubject.codeSubject')
            ->get();

        return $tSubject;
    }
}
?>
