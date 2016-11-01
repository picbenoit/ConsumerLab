<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnswerChoice extends Model
{
	protected $table = 'answer_choices';
	public $timestamps = false;
	
	/**
	 * Return answer of answer choice
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function answer()
	{
		return $this->belongsTo('App\Answer');
	}
	
	/**
	 * Return choice of answer choice
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function choice()
	{
		return $this->belongsTo('App\Choice');
	}
}
