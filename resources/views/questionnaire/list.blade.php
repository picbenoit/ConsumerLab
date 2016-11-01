@extends('layouts.app')

@section('content')
<section class="container">
    <h1>Liste des questionnaires</h1>
    <ul>
    @foreach ($questionnaires as $questionnaire)
        <li><a href="{{ route('questionnaire', ['id' => $questionnaire->id]) }}">{{ $questionnaire->name }}</a></p>
    @endforeach
    </ul>
</section>
@endsection