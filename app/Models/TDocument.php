<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TDocument extends Model
{
    protected $table='tdocument';
    protected $primaryKey='idDocument';
    protected $keyType='string';
    public $incrementing=false;
    public $timestamps=true;
}
?>
