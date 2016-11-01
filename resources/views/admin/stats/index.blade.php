@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $questionnaire->name }} - Statistiques</h1>
    @foreach ($questionnaire->questions as $question)
    <div class="row">
        <div class="col-md-6 text-right"><strong>{{ $question->label }}</strong></div>
        <div class="col-md-6">
            <canvas id="chart-{{ $question->id }}"></canvas>
        </div>
    </div>
    @endforeach
</div>
@endsection

@section('javascript')
@include('admin.stats.index.js')
@endsection