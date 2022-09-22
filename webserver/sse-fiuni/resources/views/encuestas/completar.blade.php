@extends('layouts.admin')
@section('content')
    <h1 class="p-4">{{ $encuesta->nombre }}</h1>
    <div class="list-group">
    <form action="/encuestas/guardar_respuestas/{{ $encuesta->id }}" method="post">
        <input type="hidden" name="_method" value="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" required/>
        @foreach ($encuesta->preguntas as $pregunta)
            <div class="list-group-item flex-column align-items-start p-3 p-sm-4">
                <div class="card-body pt-2">
                    <div class="row py-2">
                            <div class="col-xxl-7 col-lg-6 d-inline-flex justify-content-start">
                                <h5 class="edit_titulo_pergunta">{{ $pregunta->pregunta }}</h5>
                            </div>
                            @if($pregunta->requerido)
                                <div class="float-end col-xxl-5 col-lg-6">
                                    <span class="badge bg-danger float-end">Obligatorio</span>
                                    <span class="badge rounded-pill badge-soft-info pt-2 float-end" title="Tipo de Pregunta">[{{ ucfirst(str_replace('_', ' ', $pregunta->tipo_pregunta)) }}]</span>
                                </div>
                            @else
                                <div class="float-end col-xxl-5 col-lg-6">
                                    <span class="badge rounded-pill badge-soft-info pt-2 float-end" title="Tipo de Pregunta">[{{ ucfirst(str_replace('_', ' ', $pregunta->tipo_pregunta)) }}]</span>
                                </div>
                            @endif
                    </div>
                    @foreach ($pregunta->opcionesPregunta as $opcion_id => $opcion)
                    <div class="form-check">
                        @if(in_array($pregunta->tipo_pregunta, ['seleccion_multiple', 'seleccion_multiple_justificacion']))
                            <input type="checkbox" name="{{ $pregunta->id }}[]" class="float-left" value="{{$opcion->id }}"/>
                        @elseif(in_array($pregunta->tipo_pregunta, ['seleccion', 'seleccion_justificacion']))
                            <input type="radio" name="{{ $pregunta->id }}[]" class="float-left" value="{{$opcion->id  }}"/>
                        @endif
                        <label class="form-check-label mb-0" for="flexCheckDefault">{{ $opcion->opcion }}</label>
                    </div>
                    @endforeach
                    @if($pregunta->tipo_pregunta == 'pregunta')
                        <input type="text" name="{{ $pregunta->id }}" class="float-left col-12 p-2 mt-4 form-control" placeholder="<?= ($pregunta->justificacion) ? 'Justificacion de Respuesta' : 'Respuesta';?>"/>
                    @endif
                    @if($pregunta->justificacion)
                        <input type="text" name="{{ $pregunta->id }}[justificacion]" class="float-left col-12 p-2 mt-4 form-control" placeholder="<?= ($pregunta->justificacion) ? 'Justificacion de Respuesta' : 'Respuesta';?>"/>
                    @endif

                </div>
            </div>
        @endforeach
        <div class="row">
            <button class="btn btn-primary">Finalizar</button>
        </div>
<form>
    </div>
@endsection
