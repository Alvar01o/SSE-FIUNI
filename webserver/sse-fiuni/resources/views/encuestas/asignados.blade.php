@extends('layouts.admin')
@section('content')
<h1>Encuestas Asignadas</h1>
<div class="list-group">
@foreach ($encuestas as $encuesta)
    <a class="list-group-item list-group-item-action flex-column align-items-start p-3 p-sm-4" href="/encuestas/completar/{{ $encuesta->encuesta_id }}">
        <div class="d-flex flex-column flex-sm-row justify-content-between mb-1 mb-md-0">
        <h5 class="mb-1">{{ $encuesta->nombre }}</h5><small class="text-muted">Asignado el {{ date('d-m-Y', strtotime($encuesta->created_at))}}</small>
        </div>
    </a>
@endforeach
</div>
  @endsection
