<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TAnswer extends Model
{
    protected $table='tanswer';
    protected $primaryKey='idAnswer';
    protected $keyType='string';
    public $incrementing=false;
    public $timestamps=true;

    public const TYPE = [
        'CORRECT' => 'correct',
        'VERIFY' => 'verify',
        'REVIEWED' => 'reviewed'
    ];

    public function tExam()
    {
        return $this->belongsTo('App\Models\TExam', 'idExam');
    }

    public function tUser()
    {
        return $this->belongsTo('App\Models\TUser', 'idUser');
    }

    public function tAnswerDetail()
    {
        return $this->hasMany('App\Models\TAnswerDetail', 'idAnswer');
    }
}
