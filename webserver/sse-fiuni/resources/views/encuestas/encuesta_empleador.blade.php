@extends('layouts.basic')
@section('content')
<div class="container clearfix">
    <h1 class="p-4">{{ $encuesta->nombre }}</h1>
    <div class="alert alert-success border-2 d-flex align-items-center d-none" id="completado_con_exito" role="alert">
        <div class="bg-success me-3 icon-item"><span class="fas fa-check-circle text-white fs-3"></span></div>
        <p class="mb-0 flex-1">Ya completaste las preguntas requeridas, la encuesta esta completa!</p>
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="alert alert-danger border-2 d-flex align-items-center d-none" id="mensaje_de_error" role="alert">
        <div class="bg-danger me-3 icon-item"><span class="fas fa-times-circle text-white fs-3"></span></div>
        <p class="mb-0 flex-1">Todavia existen preguntas requeridas por contestar.</p>
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="list-group">
        <?php $respuestas = $encuesta->respuestas($user);?>
        <form action="{{ route('encuesta_empleador', ['invitacion' => $invitacion]) }}" method="post">
            <input type="hidden" name="_method" value="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" required/>
            <?php $mostrarError = false;?>
            @foreach ($encuesta->preguntas as $pregunta)
            <?php $respuesta = isset($respuestas[$pregunta->id]) ? $respuestas[$pregunta->id] : [];?>
                <div class="list-group-item flex-column {{!empty($respuestas) && !$respuesta && $pregunta->requerido ? 'requerido_pendiente' : '' }} align-items-start p-3 p-sm-4">
                    <?php $mostrarError = !empty($respuestas) && !$respuesta && $pregunta->requerido ? true : $mostrarError;?>
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
                        <?php $opctiones = ($respuesta) ? json_decode($respuesta->opciones) : [];?>
                        <div class="form-check">
                            @if(in_array($pregunta->tipo_pregunta, ['seleccion_multiple', 'seleccion_multiple_justificacion']))
                                <input type="checkbox" name="{{ $pregunta->id }}[]" <?= (in_array($opcion->id, $opctiones)) ? 'checked="checked"' : '';?> class="float-left" value="{{$opcion->id}}"/>
                            @elseif(in_array($pregunta->tipo_pregunta, ['seleccion', 'seleccion_justificacion']))
                                <input type="radio" name="{{ $pregunta->id }}[]" <?= (in_array($opcion->id, $opctiones)) ? 'checked="checked"' : '';?> class="float-left" value="{{$opcion->id}}"/>
                            @endif
                            <label class="form-check-label mb-0" for="flexCheckDefault">{{ $opcion->opcion }}</label>
                        </div>
                        @endforeach
                        @if($pregunta->tipo_pregunta == 'pregunta')
                            <input type="text" name="{{ $pregunta->id }}" value="<?= ($respuesta) ? $respuesta->respuesta : ''; ?>" class="float-left col-12 p-2 mt-4 form-control" placeholder="<?= ($pregunta->justificacion) ? 'Justificacion de Respuesta' : 'Respuesta';?>"/>
                        @endif
                        @if($pregunta->justificacion)
                            <input type="text" name="{{ $pregunta->id }}[justificacion]" value="<?= ($respuesta) ? $respuesta->respuesta : ''; ?>" class="float-left col-12 p-2 mt-4 form-control" placeholder="<?= ($pregunta->justificacion) ? 'Justificacion de Respuesta' : 'Respuesta';?>"/>
                        @endif

                    </div>
                </div>
            @endforeach
            <?php $finalizado = $respuestas && !$mostrarError ? true : false;?>
            <div class="row">
                <button class="btn btn-primary" type="submit">Finalizar</button>
            </div>
        </form>
        @if($finalizado)
            <script>
                jQuery(document).ready(function() {
                    jQuery('#completado_con_exito').toggleClass('d-none')
                })
            </script>
        @endif
        @if($mostrarError)
            <script>
                jQuery(document).ready(function() {
                    jQuery('#mensaje_de_error').toggleClass('d-none')
                })
            </script>
        @endif
    </div>

</div>
@endsection
