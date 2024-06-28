<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TTestimony extends Model
{
    protected $table='ttestimony';
    protected $primaryKey='idContact';
    protected $keyType='string';
    public $incrementing=false;
    public $timestamps=true;

    public const STATE =[
        'PUBLIC' => 1,
        'HIDDEN' => 0
    ];
}
?>
