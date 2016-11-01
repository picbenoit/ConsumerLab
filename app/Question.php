<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
	/**
	 * Get the choices for the question.
	 */
	public function choices()
	{
		return $this->hasMany('App\Choice');
	}
	
	/**
	 * Get questionnaire of the question.
	 */
	public function questionnaire()
	{
		return $this->belongsTo('App\Questionnaire');
	}
}
