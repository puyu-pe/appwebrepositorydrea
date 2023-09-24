<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TUserExam extends Model
{
    protected $table='tuserexam';
    protected $primaryKey='idUserExam';
    protected $keyType='string';
    public $incrementing=false;
    public $timestamps=true;

    public function tUser()
    {
        return $this->belongsTo('App\Models\TUser', 'idUser');
    }

    public function tExam()
    {
        return $this->belongsTo('App\Models\TExam', 'idExam');
    }
}
?>
