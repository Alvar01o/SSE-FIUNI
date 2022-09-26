@extends('layouts.admin')
@section('content')
<h1>Reportes Por Preguntas</h1>

<div class="list-group mt-5">
@foreach($encuesta->preguntas as $pregunta)
<a href="#" class="list-group-item list-group-item-action" data-bs-toggle="modal" data-bs-target="#report_pregunta" aria-current="true">
    <div class="d-flex w-100 justify-content-between">
         <h5 class="mb-1">{{$pregunta->pregunta}}</h5>
    </div>
    <small>{{ $pregunta->getTipoText()}}</small>
</a>
@endforeach
<div class="modal fade" id="report_pregunta" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
    <div class="modal-content position-relative">
      <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
        <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
          <h4 class="mb-1" id="modalExampleDemoLabel">Reporte de Pregunta</h4>
        </div>
        <div class="p-4 pb-0">
            <div id="grafico_pregunta">

            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>
</div>
@endsection
<script>
    jQuery(document).ready(function(){
        jQuery.ajax({
                method: "put",
                url: "/encuestas/" + id,
                data: {
                    _token: "{{ csrf_token() }}",
                    nombre: nuevo_nombre
                }
            }).done(function(response) {
                let id = '#form_edicion_'+element.attr('data-id');
                let id_others = '.form_edicion_tg_'+element.attr('data-id');
                jQuery(id).toggleClass('d-none');
                jQuery(id_others).toggleClass('d-none');
                jQuery('#guardar_encuesta_' + element.attr('data-id')).toggleClass('d-none')
                jQuery('#edit_encuesta_' + element.attr('data-id')).toggleClass('d-none')
            });
    })
</script>
