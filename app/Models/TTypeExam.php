<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TTypeExam extends Model
{
    protected $table='ttypeexam';
    protected $primaryKey='idTypeExam';
    protected $keyType='string';
    public $incrementing=false;
    public $timestamps=true;

    public const OTHER_TYPE_EXAM = 'other';

    public function tExam()
    {
        return $this->hasMany('App\Models\TExam', 'idTypeExam');
    }

    public static function tTypeExamFront(){
        $tTypeExam = TTypeExam::select('ttypeexam.idTypeExam', 'ttypeexam.acronymTypeExam',
            'ttypeexam.nameTypeExam', 'ttypeexam.descriptionTypeExam', 'ttypeexam.extensionImageType', 'ttypeexam.updated_at', DB::raw('COUNT(texam.idExam) as exam_count'))
            ->join('texam', 'ttypeexam.idTypeExam', '=', 'texam.idTypeExam')
            ->where('texam.stateExam', TExam::STATUS['PUBLIC'])
            ->groupBy('ttypeexam.idTypeExam', 'ttypeexam.acronymTypeExam', 'ttypeexam.nameTypeExam', 'ttypeexam.descriptionTypeExam', 'ttypeexam.extensionImageType', 'ttypeexam.updated_at')
            ->get();

        return $tTypeExam;
    }
}
?>
