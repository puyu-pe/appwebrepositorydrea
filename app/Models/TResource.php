<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TResource extends Model
{
    protected $table='tresource';
    protected $primaryKey='idResource';
    protected $keyType='string';
    public $incrementing=false;
    public $timestamps=true;

    public const TYPE_RESOURCE = [
        'TABLE' => 'table',
        'MATERIAL' => 'material'
    ];

    public function tExam()
    {
        return $this->belongsTo('App\Models\TExam', 'idExam');
    }
}
?>
