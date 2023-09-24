<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
?>
