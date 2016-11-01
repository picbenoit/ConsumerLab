@extends('layouts.app')

@section('content')
<section class="container">
    <form action="{{ $postUrl }}" method="POST" id="questionnaire-form">
        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
        <div class="form-group">
            <label for="name">Nom du questionnaire :</label>
            <input type="text" name="name" class="form-control" value="{{ $questionnaire ? $questionnaire->name : '' }}" />
            <input type="hidden" name="questionnaire_id" value="{{ $questionnaire ? $questionnaire->id : 0 }}">
            <div class="alert alert-danger hide" id="alert-questionnaire-name-empty">
            	Merci de renseigner le nom du questionnaire
            </div>
        </div>
        <div id="questions-form">
        @if ($questionnaire)
            @foreach ($questionnaire->questions as $question)
            <div class="row question">
                <div class="col-md-2 question-title">Question {{ $question->order }}</div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nom de la question :</label>
                                <input type="text" name="question_name_{{ $question->order }}" class="form-control" value="{{ $question->label }}" />
                                <input type="hidden" name="question_id_{{ $question->order }}" value="{{ $question->id }}" class="form-control" />
                                <div class="alert alert-danger hide alert-question-name-empty">
                                    Merci de renseigner le nom de la question
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Type de la question :</label>
                                <select name="question_type_{{ $question->order }}" class="form-control">
                                    <option value="{{ config('question.unique_choice') }}"
                                    @if(config('question.unique_choice') == $question->type)
                                        selected="selected"
                                    @endif
                                    >
                                        Choix unique
                                    </option>
                                    <option value="{{ config('question.multiple_choice') }}"
                                    @if(config('question.multiple_choice') == $question->type)
                                        selected="selected"
                                    @endif
                                    >
                                        Choix multiple
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="choices">
                    @foreach($question->choices as $choice)
	                    <div class="row choice">
	                        <div class="col-md-9">
	                            <input type="text" name="choice_name_{{ $question->order }}_{{ $choice->order }}" class="form-control input-choice" value="{{ $choice->label }}" />
	                            <input type="hidden" name="choice_id_{{ $question->order }}_{{ $choice->order }}" value="{{ $choice->id }}" class="form-control" />
	                            <div class="alert alert-danger hide alert-choice-name-empty">
	                                Merci de renseigner le choix de réponse
	                            </div>
	                        </div>
	                        <div class="col-md-3">
	                            <a href="#" class="btn btn-default destroy-choice-btn" role="button">
	                                Supprimer le choix de réponse
	                            </a>
	                        </div>
	                    </div>
                    @endforeach
                    </div>
                    <div class="alert alert-danger hide alert-no-choice">
                        La question doit avoir au minimum un choix de réponse
                    </div>
                    <div class="form-group">
                        <a href="#" class="btn btn-default add-new-choice-btn" role="button">
                            Ajouter un nouveau choix de réponse
                        </a>
                        <a href="#" class="btn btn-default destroy-question-btn" role="button">
                            Supprimer la question
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
        </div>
        <div class="alert alert-danger hide" id="alert-no-question">
        	Le questionnaire doit comporter au minimum une question
        </div>
        <div class="form-group">
            <a href="#" class="btn btn-default" id="add-new-question-btn">
                Ajouter une nouvelle question
            </a>
            <input type="submit" class="btn btn-default" value="Valider le questionnaire">
        </div>
    </form>
    <div id="template-question" class="hide">
        <div class="row question">
            <div class="col-md-2 question-title">Question 1</div>
            <div class="col-md-10">
		        <div class="row">
		            <div class="col-md-6">
		                <div class="form-group">
				            <label>Nom de la question :</label>
				            <input type="text" name="question_name_" class="form-control" />
                            <input type="hidden" name="question_id_" value="0" class="form-control" />
                            <div class="alert alert-danger hide alert-question-name-empty">
                                Merci de renseigner le nom de la question
                            </div>
				        </div>
		            </div>
		            <div class="col-md-6">
		                <div class="form-group">
		                    <label>Type de la question :</label>
		                    <select name="question_type_" class="form-control">
		                        <option value="{{ config('question.unique_choice') }}">Choix unique</option>
		                        <option value="{{ config('question.multiple_choice') }}">Choix multiple</option>
		                    </select>
		                </div>
		            </div>
		        </div>
		        <div class="choices"></div>
                <div class="alert alert-danger hide alert-no-choice">
                    La question doit avoir au minimum un choix de réponse
                </div>
		        <div class="form-group">
		            <a href="#" class="btn btn-default add-new-choice-btn" role="button">
		                Ajouter un nouveau choix de réponse
		            </a>
                    <a href="#" class="btn btn-default destroy-question-btn" role="button">
                        Supprimer la question
                    </a>
		        </div>
            </div>
        </div>
    </div>
    <div id="template-choice" class="hide">
        <div class="row choice">
            <div class="col-md-9">
                <input type="text" name="choice_name_" class="form-control input-choice" />
                <input type="hidden" name="choice_id_" value="0" class="form-control" />
                <div class="alert alert-danger hide alert-choice-name-empty">
                    Merci de renseigner le choix de réponse
                </div>
            </div>
            <div class="col-md-3">
                <a href="#" class="btn btn-default destroy-choice-btn" role="button">
                	Supprimer le choix de réponse
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@section('javascript')
@include('admin.questionnaire.edit.js')
@endsection