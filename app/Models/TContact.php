<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TContact extends Model
{
    protected $table='tcontact';
    protected $primaryKey='idContact';
    protected $keyType='string';
    public $incrementing=false;
    public $timestamps=true;
}
?>
