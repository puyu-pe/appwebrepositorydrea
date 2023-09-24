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

    public function tExam()
    {
        return $this->belongsTo('App\Models\TExam', 'idExam');
    }
}
?>
