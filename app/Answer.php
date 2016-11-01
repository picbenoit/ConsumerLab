<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
	/**
	 * Return questionnaire of answer
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function questionnaire()
	{
		return $this->belongsTo('App\Questionnaire');
	}
	
	/**
	 * Return all answer choices
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function answerChoices()
	{
		return $this->hasMany('App\AnswerChoice');
	}
}
