<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TResetPassword extends Model
{
    protected $table='tresetpassword';
    protected $primaryKey='idResetPassword';
    protected $keyType='string';
    public $incrementing=false;
    public $timestamps=true;

    public function tUser()
    {
        return $this->belongsTo('App\Models\TUser', 'idUser');
    }
}
?>
