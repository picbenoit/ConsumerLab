@extends('layouts.app')

@section('content')
<section class="container">
    <div class="row">
        <div class="col-md-6">
            <strong>Questionnaires</strong>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('admin.questionnaire.create') }}" class="btn btn-default" role="button">
                Nouveau questionnaire
            </a>
        </div>
        <div></div>
    </div>
    @foreach ($questionnaires as $questionnaire)
        <div class="row">
            <div class="col-md-6">{{ $questionnaire->name }}</div>
            <div class="col-md-6 text-right">
                <a href="{{ route('admin.questionnaire.stats', ['id' => $questionnaire->id]) }}" class="btn btn-default" role="button">
                    Statistiques
                </a>
                <a href="{{ route('admin.questionnaire.edit', ['id' => $questionnaire->id]) }}" class="btn btn-default" role="button">
                    Editer
                </a>
                <a href="{{ route('admin.questionnaire.destroy', ['id' => $questionnaire->id]) }}" data-method="DELETE"  class="btn btn-default">
                    Supprimer
                </a>
            </div>
        </div>
    @endforeach
</section>
@endsection