<?php

namespace App\Http\Controllers;

use App\Questionnaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Answer;
use Illuminate\Support\Facades\Auth;
use App\AnswerChoice;
use App\Choice;

class QuestionnaireController extends Controller
{
	/**
	 * Show a list of all questionnaires
	 * @param Request $request
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
	public function list(Request $request)
	{
		return view('questionnaire.list', [
			'questionnaires' => Questionnaire::all()
		]);
	}
	
	/**
	 * Show a questionnaire and allow to answer it
	 * @param Request $request
	 * @param unknown $id
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
    public function show(Request $request, $id)
    {
    	return view('questionnaire.show', [
    		'questionnaire' => Questionnaire::findOrFail($id),
    		'postUrl' => route('answers', ['id' => $id]),
    	]);
    }
    
    /**
     * Action to save user answers
     * @param Request $request
     * @param unknown $id
     * @throws \Exception
     * @return unknown
     */
    public function answers(Request $request, $id)
    {
    	DB::beginTransaction();
    	try {
	    	$questionnaire = Questionnaire::findOrFail($id);
	    	$answer = new Answer();
	    	$answer->user_id = (Auth::user() === null ? null : Auth::user()->id);
	    	$answer->questionnaire_id = $questionnaire->id;
	    	$answer->save();
	    	foreach ($questionnaire->questions as $question) {
	    		$choices = $request->get('answer_' . $question->id, false);
	    		if ($choices === false) {
	    			throw new \Exception('Must answer the question');
	    		}
	    		$choices = is_array($choices) ? $choices : [$choices];
	    		foreach ($choices as $id) {
	    			$choice = Choice::where('id', '=', $id)
	    							->where('question_id', '=', $question->id)
	    							->firstOrFail();
	    			$answerChoice = new AnswerChoice();
	    			$answerChoice->answer_id = $answer->id;
	    			$answerChoice->question_id = $question->id;
	    			$answerChoice->choice_id = $choice->id;
	    			$answerChoice->save();
	    		}
	    	}
	    	DB::commit();
	    	$request->session()->flash('flashMessage', [
	    		'status'  => 'success',
	    		'message' => 'Réponses enregistrées avec succès',
	    	]);
    	} catch (\Exception $e) {
    		DB::rollBack();
    		$request->session()->flash('flashMessage', [
    			'status'  => 'danger',
    			'message' => 'Erreur lors de l\'enregistrement des réponses',
    		]);
    	}
    	return Redirect::route('questionnaires');
    }
}
