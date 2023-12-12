<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TDirection extends Model
{
    protected $table='tdirection';
    protected $primaryKey='idDirection';
    protected $keyType='string';
    public $incrementing=false;
    public $timestamps=true;

    public function tExam()
    {
        return $this->hasMany('App\Models\TExam', 'idDirection');
    }
}
?>
