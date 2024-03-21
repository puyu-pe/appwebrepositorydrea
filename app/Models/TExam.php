<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TExam extends Model
{
    protected $table='texam';
    protected $primaryKey='idExam';
    protected $keyType='string';
    public $incrementing=false;
    public $timestamps=true;

    public const STATUS = [
        'PUBLIC' => 'Publico',
        'HIDDEN' => 'Oculto',
    ];

    public function tTypeExam()
    {
        return $this->belongsTo('App\Models\TTypeExam', 'idTypeExam');
    }

    public function tSubject()
    {
        return $this->belongsTo('App\Models\TSubject', 'idSubject');
    }

    public function tGrade()
    {
        return $this->belongsTo('App\Models\TGrade', 'idGrade');
    }

    public function tAnswer()
    {
        return $this->hasMany('App\Models\TAnswer', 'idExam');
    }

    public function tUserExam()
    {
        return $this->hasMany('App\Models\TUserExam', 'idExam');
    }

    public function tDirection()
    {
        return $this->belongsTo('App\Models\TDirection', 'idDirection');
    }

    public function tExamRating()
    {
        return $this->hasMany('App\Models\TExamRating', 'idExam');
    }
}
?>
