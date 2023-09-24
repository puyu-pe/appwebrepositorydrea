<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
?>
