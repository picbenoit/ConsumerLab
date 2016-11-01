@extends('layouts.app')

@section('content')
<section class="container">
	<form action="{{ $postUrl }}" method="POST" id="questionnaireForm">
        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	    @foreach ($questionnaire->questions as $question)
	    <h3>Question {{$question->order}} : {{ $question->label }}</h3>
	    <ul class="choices">
	        @foreach ($question->choices as $choice)
	        <li>
                <input name="answer_{{ $question->id . ($question->type == config('question.unique_choice') ? '' : '[]') }}" value="{{ $choice->id }}" type="{{ $question->type == config('question.unique_choice') ? 'radio' : 'checkbox' }}" />
                {{ $choice->label }}
            </li>
	        @endforeach
	    </ul>
        <div class="alert alert-danger hide" id="alert-questionnaire-name-empty">
            Merci de bien vouloir répondre à la question
        </div>
	    @endforeach
        <input type="submit" value="Valider le questionnaire" />    
	</form>
</section>
@endsection

@section('javascript')
@include('questionnaire.show.js')
@endsection
