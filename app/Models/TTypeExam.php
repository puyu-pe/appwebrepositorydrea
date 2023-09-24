<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TTypeExam extends Model
{
    protected $table='ttypeexam';
    protected $primaryKey='idTypeExam';
    protected $keyType='string';
    public $incrementing=false;
    public $timestamps=true;

    public function tExam()
    {
        return $this->hasMany('App\Models\TExam', 'idTypeExam');
    }
}
?>
