<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TUser extends Model
{
    protected $table='tuser';
    protected $primaryKey='idUser';
    protected $keyType='string';
    public $incrementing=false;
    public $timestamps=true;

    public function tUserExam()
    {
        return $this->hasMany('App\Models\TUserExam', 'idUser');
    }

    public function tUserRole()
    {
        return $this->hasMany('App\Models\TUserRole', 'idUser');
    }
}
?>