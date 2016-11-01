<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
	/**
	 * Get question of the choice.
	 */
	public function question()
	{
		return $this->belongsTo('App\Question');
	}
	
	/**
	 * Get answer choices of the choice
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function answerChoices()
	{
		return $this->hasMany('App\AnswerChoice');
	}
}
