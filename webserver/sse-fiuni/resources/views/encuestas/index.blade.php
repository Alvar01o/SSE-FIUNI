@extends('layouts.admin')
@section('content')
<h1>Encuestas</h1>
    <button class="btn btn-primary me-1 mb-1 float-right" type="button" data-bs-toggle="modal" data-bs-target="#addencuestaModal">Nueva Encuesta
    </button>
<div class="row mt-5">
@if ($errors->any())
    <div class="alert alert-danger mt-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="col">
        <div class="card h-lg-100 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive scrollbar">
            <table class="table table-dashboard mb-0 table-borderless fs--1 border-200">
                <thead class="bg-light">
                <tr class="text-900">
                    <th>Nombre de Encuesta</th>
                    <th class="text-center">Preguntas asignadas</th>
                    <th class="text-center">Usuarios asignados</th>
                    <th class="">Completo (%)</th>
                    <th class="text-center">Creado</th>
                    <th class="text-center"></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($encuestas as $index => $encuesta)
                <tr class="border-bottom border-200 encuesta_cnt_{{$encuesta->id}}">
                    <td>
                        <div class="d-flex align-items-center position-relative">
                            <div class="flex-1 ms-3">
                            @if (request()->route()->getName() == 'ver_por_rol')
                                @if(request()->tipo)
                                <h6 class="mb-1 fw-semi-bold text-nowrap"><a class="text-900 stretched-link" href="{{ '/encuestas/'.request()->tipo.'/'.$encuesta->id}}">{{ $encuesta->nombre}}</a></h6>
                                @endif
                            @else
                                <h6 class="mb-1 fw-semi-bold text-nowrap"><a class="text-900 stretched-link" href="{{ '/encuestas/'.$encuesta->id}}">{{ $encuesta->nombre; }}</a></h6>
                            @endif
                            <p class="fw-semi-bold mb-0 text-500">{{ ucfirst($encuesta->tipo); }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="align-middle text-center fw-semi-bold">{{$encuesta->preguntas()->count()}}</td>
                    <td class="align-middle text-center fw-semi-bold">{{$encuesta->encuestaUsers()->count()}}</td>
                    <td class="align-middle pe-card">
                        <div class="d-flex align-items-center">
                            <div class="progress me-3 rounded-3 bg-200" style="height: 5px;width:80px">
                            <div class="progress-bar bg-primary rounded-pill" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="fw-semi-bold ms-2">0%</div>
                        </div>
                    </td>
                    <td class="align-middle text-center fw-semi-bold">{{ date('Y-m-d', strtotime($encuesta->created_at));}}</td>
                    <td class="align-middle text-center fw-semi-bold">
                        <i id="encuesta_{{$encuesta->id}}" data-id="{{$encuesta->id}}" class="bi-trash px-2 border  float-end  eliminar_encuesta" title="Eliminar Encuesta"></i>
                        <a href="/encuestas?duplicar={{$encuesta->id}}" onclick="confirm('Seguro que desea duplicar esta encuesta?')"><i class="bi bi-folder-plus px-2 border float-end duplicar_encuesta" data-id="{{$encuesta->id}}" title="Duplicar Encuesta"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
            </div>
        </div>
        </div>
    </div>
    </div>
    <script>
        jQuery(document).ready(function() {
            jQuery('.eliminar_encuesta').each(function(k,e) {
                console.log(e);
                jQuery(e).on('click', function(el) {
                    let encuesta_id = jQuery(el.currentTarget).attr('data-id');
                    if (confirm('Seguro que desea eliminar completamente esta encuesta?')) {
                        jQuery('div.toast-body').html(`<div class="spinner-border spinner-border-sm" role="status">
                                                            <span class="visually-hidden">Loading...</span>
                                                        </div>`);
                        jQuery('div.toast-header > strong.me-auto').html('Eliminando Encuesta')
                        if (!jQuery('div.toast-body').parent().hasClass('show')) {
                            jQuery('div.toast-body').parent().toggleClass('show');
                        }
                        jQuery.ajax({
                            method: "DELETE",
                            url: "/encuestas/"+encuesta_id,
                            data: {
                                _token: "{{ csrf_token() }}"
                            }
                        }).done(function(response) {
                            jQuery('div.toast-body').html(response.msg);
                            jQuery('div.toast-header > strong.me-auto').html('Aviso')
                            if (!jQuery('div.toast-body').parent().hasClass('show')) {
                                jQuery('div.toast-body').parent().toggleClass('show');
                            }
                            jQuery('.encuesta_cnt_'+encuesta_id).remove();
                        });
                    }
                })
            })
        })
    </script>
</div>
@include('encuestas.partials.add_modal')
@endsection



