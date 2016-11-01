<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Questionnaire;
use Illuminate\Support\Facades\Redirect;
use App\Question;
use App\Choice;
use Illuminate\Support\Facades\DB;

class AdminQuestionnaireController extends Controller
{
	/**
	 * Show form to create a questionnaire
	 * @param Request $request
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
    public function create(Request $request)
    {
    	return view('admin.questionnaire.edit', [
    		'postUrl' => route('admin.questionnaire.store'),
    		'questionnaire' => false,
    	]);
    }
    
    /**
     * Store action to save a new questionnaire
     * @param Request $request
     * @throws \Exception
     * @return unknown
     */
    public function store(Request $request)
    {
    	DB::beginTransaction();
    	try {
	    	$questionnaire = new Questionnaire();
	    	$questionnaire->name = $request->get('name');
	    	if (empty($questionnaire->name)) {
	    		throw new \Exception('Empty questionnaire name');
	    	}
	    	$questionnaire->save();
	    	if (is_null($request->get('question_name_1'))) {
	    		throw new \Exception('No question');
	    	}
	    	for ($i = 1 ; $request->get('question_name_' . $i, false) ; $i++) {
	    		$question = new Question();
	    		$question->questionnaire_id = $questionnaire->id;
	    		$question->label = $request->get('question_name_' . $i);
	    		if (empty($question->label)) {
	    			throw new \Exception('Empty question name');
	    		}
	    		$question->type = $request->get('question_type_' . $i);
	    		$question->order = $i;
	    		$question->save();
	    		if (is_null($request->get('choice_name_' . $i . '_1'))) {
	    			throw new \Exception('No choice for question ' . $i);
	    		}
	    		for ($j = 1 ; $request->get('choice_name_' . $i . '_' . $j, false) ; $j++) {
	    			$choice = new Choice();
	    			$choice->question_id = $question->id;
	    			$choice->label = $request->get('choice_name_' . $i . '_' . $j);
	    			if (empty($choice->label)) {
	    				throw new \Exception('Empty choice name');
	    			}
	    			$choice->order = $j;
	    			$choice->save();
	    		}
	    	}
	    	DB::commit();
	    	$request->session()->flash('flashMessage', [
    			'status'  => 'success',
	    		'message' => 'Questionnaire ajouté avec succès',
	    	]);
    	} catch (\Exception $e) {
    		DB::rollBack();
    		$request->session()->flash('flashMessage', [
    			'status'  => 'danger',
    			'message' => 'Erreur lors de l\'ajout du questionnaire',
    		]);
    	}
    	return Redirect::route('admin.index');
    }
    
    /**
     * Show form to edit a questionnaire
     * @param Request $request
     * @param unknown $id
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(Request $request, $id)
    {
    	return view('admin.questionnaire.edit', [
    		'postUrl' => route('admin.questionnaire.update', ['id' => $id]),
    		'questionnaire' => Questionnaire::findOrFail($id),
    	]);
    }
    
    /**
     * Update action to save a questionnaire
     * @param Request $request
     * @param unknown $id
     * @throws \Exception
     * @return unknown
     */
    public function update(Request $request, $id)
    {
    	DB::beginTransaction();
    	try {
    		$questionnaire = Questionnaire::findOrFail($id);
    		$questionnaire->name = $request->get('name');
    		if (empty($questionnaire->name)) {
    			throw new \Exception('Empty questionnaire name');
    		}
    		$questionnaire->save();
    		if (is_null($request->get('question_name_1'))) {
    			throw new \Exception('No question');
    		}
    		$question_ids = [];
    		for ($i = 1 ; $request->get('question_name_' . $i, false) ; $i++) {
    			if (!empty($question_id = $request->get('question_id_' . $i, false))) {
    				$question = Question::where('id', '=', $question_id)
    								    ->where('questionnaire_id', '=', $questionnaire->id)
    								    ->firstOrFail();
    			} else {
    				$question = new Question();
    				$question->questionnaire_id = $questionnaire->id;
    			}
    			$question->label = $request->get('question_name_' . $i);
    			if (empty($question->label)) {
    				throw new \Exception('Empty question name');
    			}
    			$question->type = $request->get('question_type_' . $i);
    			$question->order = $i;
    			$question->save();
    			$question_ids[] = $question->id;
    			if (is_null($request->get('choice_name_' . $i . '_1'))) {
    				throw new \Exception('No choice for question ' . $i);
    			}
    			$choice_ids = [];
    			for ($j = 1 ; $request->get('choice_name_' . $i . '_' . $j, false) ; $j++) {
    				if (!empty($choice_id = $request->get('choice_id_' . $i . '_' . $j))) {
    					$choice = Choice::where('id', '=', $choice_id)
    									->where('question_id', '=', $question->id)
    									->firstOrFail();
    				} else {
	    				$choice = new Choice();
	    				$choice->question_id = $question->id;
    				}
    				$choice->label = $request->get('choice_name_' . $i . '_' . $j);
    				if (empty($choice->label)) {
    					throw new \Exception('Empty choice name');
    				}
    				$choice->order = $j;
    				$choice->save();
    				$choice_ids[] = $choice->id;
    			}
    			Choice::where('question_id', '=', $question->id)
    				  ->whereNotIn('id', $choice_ids)
    				  ->delete();
    		}
    		Question::where('questionnaire_id', '=', $questionnaire->id)
    				->whereNotIn('id', $question_ids)
    				->delete();
    		DB::commit();
    		$request->session()->flash('flashMessage', [
    			'status'  => 'success',
    			'message' => 'Questionnaire édité avec succès',
    		]);
    	} catch (\Exception $e) {
    		DB::rollBack();
    		$request->session()->flash('flashMessage', [
    			'status'  => 'danger',
    			'message' => 'Erreur lors de l\'édition du questionnaire',
    		]);
    	}
		return Redirect::route('admin.index');
    }
    
    /**
     * Destroy action to delete a questionnaire
     * @param Request $request
     * @param unknown $id
     * @return unknown
     */
    public function destroy(Request $request, $id)
    {
    	Questionnaire::destroy($id);
    	$request->session()->flash('flashMessage', [
    		'status'  => 'success',
    		'message' => 'Questionnaire supprimé avec succès',
    	]);
    	return Redirect::route('admin.index');
    }
    
    /**
     * Show stats of questionnaire answers
     * @param Request $request
     * @param unknown $id
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function stats(Request $request, $id)
    {
    	return view('admin.stats.index', [
    		'questionnaire' => Questionnaire::findOrFail($id),
    	]);
    }
}
