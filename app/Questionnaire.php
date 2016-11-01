<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
	/**
	 * Get the questions for the questionnaire.
	 */
	public function questions()
	{
		return $this->hasMany('App\Question');
	}
	
	/**
	 * Get answers for the questionnaire
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function answers()
	{
		return $this->hasMany('App\Answer');
	}
}
