@extends('layouts.admin')
@section('content')
    <h1>{{ $encuesta->nombre }}</h1>
    <div class="list-group">
        @foreach ($encuesta->preguntas as $pregunta)
            <div class="list-group-item flex-column align-items-start p-3 p-sm-4">
                <div class="card-body pt-2">
                    <div class="row py-2">
                        <div class="float-left <?= $pregunta->requerido ? 'col-8' : 'col-12' ;?>">{{ $pregunta->pregunta}}&nbsp;&nbsp;<small class="pl-4 float-left">[{{ ucfirst(str_replace('_', ' ', $pregunta->tipo_pregunta)) }}]</small></div>
                        @if($pregunta->requerido)
                        <div class="float-right col-4 pregunta_requerida">REQUERIDO</div>
                        @endif
                    </div>
                    @foreach ($pregunta->opcionesPregunta as $opcion_id => $opcion)
                    <div class="form-check">
                        @if(in_array($pregunta->tipo_pregunta, ['seleccion_multiple', 'seleccion_multiple_justificacion']))
                            <input type="checkbox" name="{{ $pregunta->id }}[]" class="float-left" />
                        @elseif(in_array($pregunta->tipo_pregunta, ['seleccion', 'seleccion_justificacion']))
                            <input type="radio" name="{{ $pregunta->id }}" class="float-left" />
                        @endif
                        <label class="form-check-label mb-0" for="flexCheckDefault">{{ $opcion->opcion }}</label>
                    </div>
                    @endforeach
                    @if($pregunta->tipo_pregunta == 'pregunta' || $pregunta->justificacion)
                        <input type="text" name="{{ $pregunta->id }}_justificacion" class="float-left col-12" placeholder="<?= ($pregunta->justificacion) ? 'Justificacion de Respuesta' : 'Respuesta';?>"/>
                    @endif
                </div>
            </div>
        @endforeach
        <div class="row">
            <button class="btn btn-primary">Finalizar</button>
        </div>

    </div>
@endsection
