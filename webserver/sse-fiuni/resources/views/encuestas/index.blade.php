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
                    <th class="text-center">Habilitado</th>
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
                            <div class="flex-1 ms-3 desc_encuesta">
                            @if (request()->route()->getName() == 'ver_por_rol')
                                @if(request()->tipo)
                                <h6 class="mb-1 fw-semi-bold text-nowrap">
                                    <a class="form_edicion_tg_{{$encuesta->id}} text-900 stretched-link" href="{{ '/encuestas/'.request()->tipo.'/'.$encuesta->id}}">{{ $encuesta->nombre}}</a>
                                    <form id="form_edicion_{{$encuesta->id}}" class="submit_prevent_form d-none">
                                        <input type="text" name="nombre_encuesta_{{$encuesta->id}}" data-id="{{$encuesta->id}}" value="<?= $encuesta->nombre; ?>" class="form-control">
                                    </form>
                                </h6>
                                @endif
                            @else
                                <h6 class="mb-1 fw-semi-bold text-nowrap desc_encuesta">
                                    <a class="form_edicion_tg_{{$encuesta->id}} encuesta_edit text-900 stretched-link" href="{{ '/encuestas/'.$encuesta->id}}">{{ $encuesta->nombre; }}</a>
                                    <form id="form_edicion_{{$encuesta->id}}" class="d-none">
                                        <input type="text" name="nombre_encuesta_{{$encuesta->id}}" data-id="{{$encuesta->id}}" value="<?= $encuesta->nombre; ?>" class="form-control">
                                    </form>
                                </h6>
                            @endif
                            <p class="fw-semi-bold mb-0 text-500">{{ ucfirst($encuesta->tipo); }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="align-middle text-center fw-semi-bold">{{$encuesta->preguntas()->count()}}</td>
                    <td class="align-middle text-center fw-semi-bold">{{$encuesta->encuestaUsers()->count()}}</td>
                    <td class="align-middle text-center fw-semi-bold">
                        @if($encuesta->bloqueado())
                            <span class="badge badge-soft-success">Si</span>
                        @else
                            <span class="badge badge-soft-danger bloquear_encuesta" data-id="{{$encuesta->id}}">No</span>
                        @endif
                    </td>
                    <td class="align-middle pe-card">
                    <?php
                        $estado_report = $encuesta->statusEgresados($encuesta->encuesta_id);
                        $estado = $estado_report['estado'];
                        $total_pendientes = $estado['Pendiente'] ? round(($estado['Pendiente'] / $estado_report['total_usuarios_asignados']) * 100) : 0;
                        $total_progreso = $estado['progreso'] ? round(($estado['progreso'] / $estado_report['total_usuarios_asignados']) * 100) : 0 ;
                        $total_completo = $estado['Completo'] ? round(($estado['Completo'] / $estado_report['total_usuarios_asignados']) * 100) : 0;
                    ?>
                    <div class="progress" style="height:4px">
                            <div class="progress-bar bg-pendiente" title="<?= $estado['Pendiente'];?> PENDIETE" role="progressbar" style="width: <?= $total_pendientes?>%" aria-valuenow="<?= $total_pendientes?>" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar bg-warning" title="<?= $estado['progreso'];?> EN PROGRESO" role="progressbar" style="width: <?= $total_progreso?>%" aria-valuenow="<?= $total_progreso?>" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar bg-success" role="progressbar" title="<?= $estado['Completo'];?> COMPLETO" style="width: <?= $total_completo?>%" aria-valuenow="<?= $total_completo?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </td>
                    <td class="align-middle text-center fw-semi-bold">{{ date('Y-m-d', strtotime($encuesta->created_at));}}</td>
                    <td class="align-middle text-center fw-semi-bold">
                        <i id="encuesta_{{$encuesta->id}}" data-id="{{$encuesta->id}}" class="bi-trash px-2 border  float-end  eliminar_encuesta" title="Eliminar Encuesta"></i>
                        <a href="/encuestas?duplicar={{$encuesta->id}}" onclick="confirm('Seguro que desea duplicar esta encuesta?')"><i class="bi bi-folder-plus px-2 border float-end duplicar_encuesta" data-id="{{$encuesta->id}}" title="Duplicar Encuesta"></i></a>
                        @if(!$encuesta->bloqueado())
                            <i id="edit_encuesta_{{$encuesta->id}}" data-id="{{$encuesta->id}}" class="bi bi-pencil px-2 border float-end edit_encuesta" title="Editar"></i>
                        @endif
                        <i id="guardar_encuesta_{{$encuesta->id}}" data-id="{{$encuesta->id}}" class="bi bi-check px-2 border float-end guardar_nombre_encuesta d-none" title="Guardar"></i>
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
            jQuery('.submit_prevent_form').on('submit', function(e) {
                e.preventDefault();
            });
            jQuery('.edit_encuesta').on('click', function(e) {
                let element = jQuery(e.currentTarget);
                let id = '#form_edicion_'+element.attr('data-id');
                let id_others = '.form_edicion_tg_'+element.attr('data-id');
                jQuery(id).toggleClass('d-none');
                jQuery(id_others).toggleClass('d-none');
                jQuery('#guardar_encuesta_' + element.attr('data-id')).toggleClass('d-none')
                jQuery('#edit_encuesta_' + element.attr('data-id')).toggleClass('d-none')
            })
            jQuery('.guardar_nombre_encuesta').on('click', function(e){
                let element = jQuery(e.currentTarget);
                let id = element.attr('data-id');
                let nuevo_nombre = jQuery('input[name="nombre_encuesta_'+id+'"]').val();
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
            jQuery('.eliminar_encuesta').each(function(k,e) {
                jQuery(e).on('click', function(el) {
                    let encuesta_id = jQuery(el.currentTarget).attr('data-id');
                    if (confirm('Seguro que desea eliminar completamente esta encuesta, y todos los datos relacionada a ella?')) {
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



