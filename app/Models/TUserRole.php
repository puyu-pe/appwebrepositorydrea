<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TUserRole extends Model
{
    protected $table='tuserrole';
    protected $primaryKey='idUserRole';
    protected $keyType='string';
    public $incrementing=false;
    public $timestamps=true;

    public function tUser()
    {
        return $this->belongsTo('App\Models\TUser', 'idUser');
    }

    public function tRole()
    {
        return $this->belongsTo('App\Models\TRole', 'idRole');
    }
}
?>
