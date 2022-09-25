@extends('layouts.admin')
@section('content')
<h1>Reportes</h1>
<div>
    <h3 class="py-4">Encuestas Egresado</h3>
    @foreach($encuesta_egresados as $ee)
    <div class="card overflow-hidden" style="width: 20rem;">
    <div class="card-body">
        <h5 class="card-title"><a href="/reportes/encuesta/{{$ee->id}}" title="Acceder a Generar Reportes por preguntas">{{$ee->nombre}}</a></h5>
        <p class="card-text">{{ucfirst($ee->tipo)}}</p>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item d-inline-flex report_item_list"><div class="report_encuesta_number">{{count($ee->preguntas)}}</div> Usuarios Asignados</li>
    </ul>
    @if (count($ee->preguntas))
    <div class="card-body descargar_reporte_cont border mt-3"><a class="card-link" href="/reporte_encuesta/{{$ee->id}}"><i class="bi bi-file-earmark-spreadsheet"></i>Descargar Reporte General de Encuesta.</a></div>
    </div>
    @endif
    @endforeach
    <h3 class="py-4">Encuestas Empelador</h3>
    @foreach($encuestas_empleador as $em)
    <div class="card overflow-hidden" style="width: 20rem;">
    <div class="card-body">
        <h5 class="card-title">{{$ee->nombre}}</h5>
        <p class="card-text">{{ucfirst($ee->tipo)}}</p>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item d-inline-flex report_item_list"><div class="report_encuesta_number">{{count($em->preguntas)}}</div> Usuarios Asignados</li>
    </ul>
    @if (count($em->preguntas))
    <div class="card-body descargar_reporte_cont border mt-3"><a class="card-link" href="/reporte_encuesta/{{$em->id}}"><i class="bi bi-file-earmark-spreadsheet"></i>Descargar Reporte General de Encuesta.</a></div>
    </div>
    @endif
    @endforeach
</div>
@endsection
