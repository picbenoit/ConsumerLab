<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Questionnaire;

class AdminController extends Controller
{
	/**
	 * Show list of all questionnaire
	 * @param Request $request
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
    public function index(Request $request)
    {
    	return view('admin.questionnaire.list', [
			'questionnaires' => Questionnaire::all()
		]);
    }
}
