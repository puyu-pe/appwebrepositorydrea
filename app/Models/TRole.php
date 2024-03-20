<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TRole extends Model
{
    protected $table='trole';
    protected $primaryKey='idRole';
    protected $keyType='string';
    public $incrementing=false;
    public $timestamps=true;

    public const ROLE = [
        'ADMIN' => 'Administrador',
        'SUPERVISOR' => 'Supervisor',
        'REGISTER' => 'Registrador',
        'NORMAL' => 'Normal'
    ];

    public function tUserRole()
    {
        return $this->hasMany('App\Models\TUserRole', 'idRole');
    }
}
?>
