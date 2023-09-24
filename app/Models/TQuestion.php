<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TQuestion extends Model
{
    protected $table='tquestion';
    protected $primaryKey='idQuestion';
    protected $keyType='string';
    public $incrementing=false;
    public $timestamps=true;

    public function tExam()
    {
        return $this->belongsTo('App\Models\TExam', 'idExam');
    }
}
?>
