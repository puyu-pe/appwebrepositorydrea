<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TExamRating extends Model
{
	use HasFactory;

	protected $table = 'texamrating';
	protected $primaryKey = 'idExamRating';
	protected $keyType = 'string';
	public $incrementing = false;
	public $timestamps = true;

	public function tUser()
	{
		return $this->belongsTo('App\Models\TUser', 'idUser');
	}

	public function tExam()
	{
		return $this->belongsTo('App\Models\TExam', 'idExam');
	}
}
