<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TAnswerDetail extends Model
{
    protected $table='tanswerdetail';
    protected $primaryKey='idAnswerDetail';
    protected $keyType='string';
    public $incrementing=false;
    public $timestamps=true;

    public function tAnswer()
    {
        return $this->belongsTo('App\Models\TAnswer', 'idAnswer');
    }

}
