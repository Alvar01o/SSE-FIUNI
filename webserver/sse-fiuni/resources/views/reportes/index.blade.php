@extends('layouts.admin')
@section('content')
<h1>Reportes Encuestas Egresados</h1>
<div>
<form method="GET" action="{{ Route::getCurrentRoute()->getName() == 'reportes.index' ? 'reportes' : 'reportes_empleador'}}" class="row filtro">
        <div class="col-sm-5">
            <input class="form-control" type="text" value="" name="nombre" placeholder="Buscar por nombre de Encuesta" aria-label="Nombre de Encuesta">
        </div>
        <div class="col-sm">
            <button class="btn btn-primary me-1 mb-1 float-end" type="submit">
                Filtrar
            </button>
        </div>
    </form>
    <div class="table-responsive scrollbar">
    <table class="table table-hover table-striped overflow-hidden">
        <thead>
        <tr>
            <th scope="col">Nombre</th>
            <th scope="col"># Preguntas</th>
            <th scope="col"># Usuarios</th>
            <th scope="col">Reportes</th>
        </tr>
        </thead>
        <tbody>
        @foreach($encuestas as $ee)
        <tr class="align-middle">
            <td class="text-nowrap">
            <div class="d-flex align-items-center">
                <a href="/reportes/encuesta/{{$ee->id}}">
                    <div class="ms-2">{{$ee->nombre}}</div>
                </a>
            </div>
            </td>
            <td class="text-nowrap">{{count($ee->preguntas)}} </td>
            <td class="text-nowrap">{{count($ee->getUsuariosAsignados())}} </td>
            <td class="text-nowrap">
                @if (count($ee->preguntas))
                    <div class="card-body descargar_reporte_cont border"><a class="card-link" href="/reporte_encuesta/{{$ee->id}}"><i class="bi bi-file-earmark-spreadsheet"></i>Descargar Reporte General de Encuesta.</a></div>
                    <div class="card-body descargar_reporte_cont border"><a class="card-link" href="/reporte_encuestas_completas/{{$ee->id}}"><i class="bi bi-file-earmark-spreadsheet"></i>Descargar Reporte de Encuesta. <small>(Solo Respuestas)<small></a></div>
                @endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    </div>
</div>
@endsection
