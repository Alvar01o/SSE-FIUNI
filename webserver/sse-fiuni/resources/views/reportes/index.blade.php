@extends('layouts.admin')
@section('content')
<h1>Reportes</h1>
<div>
    <h3 class="py-4">Encuestas Egresado</h3>
    @foreach($encuesta_egresados as $ee)
    <div class="card overflow-hidden" style="width: 20rem;">
        <div class="card-body">
            <h5 class="card-title"><a href="/reportes/encuesta/{{$ee->id}}" title="Acceder a Generar Reportes por preguntas">{{$ee->nombre}}</a></h5>
            <small class="card-text">{{ucfirst($ee->tipo)}}</small>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item d-inline-flex border report_item_list"><div class="report_encuesta_number">{{count($ee->preguntas)}}</div> Preguntas</li>
            <li class="list-group-item d-inline-flex report_item_list"><div class="report_encuesta_number">{{count($ee->getUsuariosAsignados())}}</div> Usuarios Asignados</li>
        </ul>
        @if (count($ee->preguntas))
        <div class="card-body descargar_reporte_cont border"><a class="card-link" href="/reporte_encuesta/{{$ee->id}}"><i class="bi bi-file-earmark-spreadsheet"></i>Descargar Reporte General de Encuesta.</a></div>
        <div class="card-body descargar_reporte_cont border"><a class="card-link" href="/reporte_encuestas_completas/{{$ee->id}}"><i class="bi bi-file-earmark-spreadsheet"></i>Descargar Reporte de Encuesta. <small>(Solo Respuestas)<small></a></div>
        @endif
    </div>
    @endforeach
    <h3 class="py-4">Encuestas Empelador</h3>
    @foreach($encuestas_empleador as $em)
    <div class="card overflow-hidden" style="width: 20rem;">
    <div class="card-body">
        <h5 class="card-title">{{$em->nombre}}</h5>
        <p class="card-text">{{ucfirst($em->tipo)}}</p>
    </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item d-inline-flex border report_item_list"><div class="report_encuesta_number">{{count($em->preguntas)}}</div> Preguntas</li>
            <li class="list-group-item d-inline-flex report_item_list"><div class="report_encuesta_number">{{count($em->getUsuariosAsignados())}}</div> Usuarios Asignados</li>
        </ul>
        @if (count($em->preguntas))
        <div class="card-body descargar_reporte_cont border"><a class="card-link" href="/reporte_encuesta/{{$ee->id}}"><i class="bi bi-file-earmark-spreadsheet"></i>Descargar Reporte General de Encuesta.</a></div>
        <div class="card-body descargar_reporte_cont border"><a class="card-link" href="/reporte_encuestas_completas/{{$ee->id}}"><i class="bi bi-file-earmark-spreadsheet"></i>Descargar Reporte de Encuesta. <small>(Solo Respuestas)<small></a></div>
        @endif
    </div>
    @endforeach
</div>
@endsection
