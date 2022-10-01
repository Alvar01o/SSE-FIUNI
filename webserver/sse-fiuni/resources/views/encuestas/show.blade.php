@extends('layouts.admin')
@section('content')
<h1>{{ $encuesta->nombre}}</h1>
<?php
$tabUsuarios = false;
if (isset($_GET['seccion'])) {
    if ($_GET['seccion'] == 'usuarios' || $_GET['seccion'] == 'asignados') {
        $tabUsuarios = true;
    }
}
?>
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item"><a class="nav-link <?= $tabUsuarios ? '' : 'active';?>" id="preguntas-tab" data-bs-toggle="tab" href="#tab-preguntas" role="tab" aria-controls="tab-preguntas" aria-selected="true">Preguntas</a></li>
  <li class="nav-item"><a class="nav-link <?= $tabUsuarios ? 'active' : '';?>" id="usuarios-tab" data-bs-toggle="tab" href="#tab-usuarios" role="tab" aria-controls="tab-usuarios" aria-selected="false">Usuarios</a></li>
</ul>
<div class="tab-content p-3" id="myTabContent">
<div class="tab-pane fade <?= $tabUsuarios ? '' : 'active show';?>" id="tab-preguntas" role="tabpanel" aria-labelledby="preguntas-tab">
    @if ($encuesta->bloqueado())
        <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading fw-semi-bold">Ya no es posible editar esta Encuesta.</h4>
        <p>Las Encuestas que ya han sido contestadas por algun Egresados no pueden ser modificadas.</p>
        <p class="mb-0">Si desea realizar una encuesta similar puede Duplicar esta Encuesta <a href="/encuestas">en la lista de Encuesta</a></p>
        </div>
    @endif
    <div class="card theme-wizard mb-5">
        <div class="card-header bg-light pt-3 pb-2">
            <ul class="nav justify-content-between nav-wizard <?= ($encuesta->bloqueado()) ? 'd-none' : '';?>">
                <li class="nav-item"><a class="nav-link active fw-semi-bold" href="#step-tab1" data-bs-toggle="tab" data-wizard-step="data-wizard-step"><span class="nav-item-circle-parent"><span class="nav-item-circle"><svg class="svg-inline--fa fa-lock fa-w-14" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="lock" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M400 224h-24v-72C376 68.2 307.8 0 224 0S72 68.2 72 152v72H48c-26.5 0-48 21.5-48 48v192c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V272c0-26.5-21.5-48-48-48zm-104 0H152v-72c0-39.7 32.3-72 72-72s72 32.3 72 72v72z"></path></svg><!-- <span class="fas fa-lock"></span> Font Awesome fontawesome.com --></span></span><span class="d-none d-md-block mt-1 fs--1">Seleccione tipo de Pregunta</span></a></li>
                <li class="nav-item"><a class="nav-link fw-semi-bold" href="#step-tab2" data-bs-toggle="tab" data-wizard-step="data-wizard-step"><span class="nav-item-circle-parent"><span class="nav-item-circle"><svg class="svg-inline--fa fa-user fa-w-14" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"></path></svg><!-- <span class="fas fa-user"></span> Font Awesome fontawesome.com --></span></span><span class="d-none d-md-block mt-1 fs--1">Complete pregunta</span></a></li>
            </ul>
        </div>
        <div class="card-body py-4">
            <div class="tab-content">
            <div class="tab-pane active px-sm-3 px-md-5" role="tabpanel" aria-labelledby="step-tab1" id="step-tab1">
                <label for="selector_de_tipo">Seleccione tipo de pregunta</label>
                <select class="form-select js-choice" id="selector_de_tipo" size="1" name="selector_de_tipo" data-options='{"removeItemButton":true,"placeholder":true}'>
                    <option value="pregunta">Pregunta</option>
                    <option value="seleccion_multiple">Seleccion Multiple</option>
                    <option value="seleccion_multiple_justificacion">Seleccion Multiple con justificacion</option>
                    <option value="seleccion">Seleccion simple</option>
                    <option value="seleccion_justificacion">Seleccion simple con justificacion</option>
                </select>
            </div>
            <div class="tab-pane px-sm-3 px-md-5" role="tabpanel" aria-labelledby="step-tab2" id="step-tab2">
                @include('encuestas.partials.pregunta')
                @include('encuestas.partials.seleccion_multiple')
                @include('encuestas.partials.seleccion_multiple_justificacion')
                @include('encuestas.partials.seleccion')
                @include('encuestas.partials.seleccion_justificacion')
                <hr/>
            </div>
            </div>
        </div>
        <div class="card-footer bg-light">
            <div class="px-sm-3 px-md-5">
            <ul class="pager wizard list-inline mb-0">
                <li class="previous">
                    <button id="prev_btn" class="btn btn-link ps-0 d-none" type="button"><svg class="svg-inline--fa fa-chevron-left fa-w-10 me-2" data-fa-transform="shrink-3" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="" style="transform-origin: 0.3125em 0.5em;"><g transform="translate(160 256)"><g transform="translate(0, 0)  scale(0.8125, 0.8125)  rotate(0 0 0)"><path fill="currentColor" d="M34.52 239.03L228.87 44.69c9.37-9.37 24.57-9.37 33.94 0l22.67 22.67c9.36 9.36 9.37 24.52.04 33.9L131.49 256l154.02 154.75c9.34 9.38 9.32 24.54-.04 33.9l-22.67 22.67c-9.37 9.37-24.57 9.37-33.94 0L34.52 272.97c-9.37-9.37-9.37-24.57 0-33.94z" transform="translate(-160 -256)"></path></g></g></svg><!-- <span class="fas fa-chevron-left me-2" data-fa-transform="shrink-3"></span> Font Awesome fontawesome.com -->Prev</button>
                </li>
                <li class="next">
                    <button class="btn btn-primary px-5 px-sm-6" <?= $encuesta->bloqueado() ? 'disabled' : ''; ?> id="nextStep" type="submit">Siguiente<svg class="svg-inline--fa fa-chevron-right fa-w-10 ms-2" data-fa-transform="shrink-3" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="" style="transform-origin: 0.3125em 0.5em;"><g transform="translate(160 256)"><g transform="translate(0, 0)  scale(0.8125, 0.8125)  rotate(0 0 0)"><path fill="currentColor" d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" transform="translate(-160 -256)"></path></g></g></svg><!-- <span class="fas fa-chevron-right ms-2" data-fa-transform="shrink-3"> </span> Font Awesome fontawesome.com --></button>
                </li>
            </ul>
            </div>
        </div>
    </div>
    <script src="{{asset('js/preguntas.js')}}"></script>
    <script src="{{asset('js/draggable.bundle.legacy.js')}}"></script>
    <script>
    jQuery(document).ready(function() {
        validadorWizard.init();
    })
    </script>
    <div class="px-3 row">
        <div class="col-lg-12 px-0">
            <div class="kanban-items-container border bg-white dark__bg-1000 rounded-2 py-3 mb-3" style="max-height: none;">
            <div class="py-3"><h3>Vista Previa</h3></div>
            @foreach ($encuesta->preguntas as $pregunta_id => $pregunta)
                <div class="card mb-3 shadow rounded dark__bg-1100">
                    <div class="card-body pt-2 col-md-12 pregunta_cont_{{ $pregunta->id }}">
                        <div class="row py-2">
                            <div class="col-xxl-7 col-lg-6 d-inline-flex justify-content-start">
                                    @if (!$encuesta->bloqueado())
                                        <h5 class="edit_titulo_pergunta">{{ $pregunta->pregunta }}</h5>
                                    @else
                                        <h5 class="">{{ $pregunta->pregunta }}</h5>
                                    @endif
                                <input name="pregunta_{{$pregunta->id}}" data-id="{{$pregunta->id}}" type="text" class="d-none input_titulo_pregunta" value="{{ $pregunta->pregunta}}"/>
                            </div>
                            @if($pregunta->requerido)
                                <div class="float-end col-xxl-5 col-lg-6">
                                    <span class="badge bg-danger float-end">Obligatorio</span>
                                    @if (!$encuesta->bloqueado())
                                        <i id="pregunta_{{$pregunta->id}}" data-id="{{$pregunta->id}}" class="bi-trash px-2 border  float-end  eliminar_pregunta" title="Eliminar Pregunta"></i>
                                        <a href="/encuestas/duplicar/{{$pregunta->id}}"><i class="bi bi-folder-plus px-2 border float-end duplicar_pregunta" data-id="6" title="Duplicar Pregunta"></i></a>
                                    @endif
                                    <span class="badge rounded-pill badge-soft-info pt-2 float-end" title="Tipo de Pregunta">[{{ ucfirst(str_replace('_', ' ', $pregunta->tipo_pregunta)) }}]</span>
                                </div>
                            @else
                                <div class="float-end col-xxl-5 col-lg-6">
                                    @if (!$encuesta->bloqueado())
                                        <i id="pregunta_{{$pregunta->id}}" data-id="{{$pregunta->id}}" class="bi-trash px-2 border  float-end  eliminar_pregunta" title="Eliminar Pregunta"></i>
                                        <a href="/encuestas/duplicar/{{$pregunta->id}}"><i class="bi bi-folder-plus px-2 border float-end duplicar_pregunta" data-id="6" title="Duplicar Pregunta"></i></a>
                                    @endif
                                    <span class="badge rounded-pill badge-soft-info pt-2 float-end" title="Tipo de Pregunta">[{{ ucfirst(str_replace('_', ' ', $pregunta->tipo_pregunta)) }}]</span>
                                </div>
                            @endif
                        </div>
                        @foreach ($pregunta->opcionesPregunta as $opcion_id => $opcion)
                        <div class="form-check">
                            @if(in_array($pregunta->tipo_pregunta, ['seleccion_multiple', 'seleccion_multiple_justificacion']))
                            <input type="checkbox" class="float-left" disabled />
                            @elseif(in_array($pregunta->tipo_pregunta, ['seleccion', 'seleccion_justificacion']))
                            <input type="radio" class="float-left" disabled />
                            @endif
                            <label class="form-check-label mb-0" for="flexCheckDefault">{{ $opcion->opcion }}</label>
                        </div>
                        @endforeach
                        @if($pregunta->tipo_pregunta == 'pregunta' || $pregunta->justificacion)
                            <input type="text" class="float-left col-12" disabled placeholder="<?= ($pregunta->justificacion) ? 'Justificacion de Respuesta' : 'Respuesta';?>"/>
                        @endif
                    </div>

                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="tab-pane fade <?= $tabUsuarios ? 'active show' : '';?>" id="tab-usuarios" role="tabpanel" aria-labelledby="usuarios-tab">
@include('encuestas.partials.tabla_asignados')
@include('encuestas.partials.tabla_seleccion')
<script>
let checker = (function() {
    function init() {
        localStorage.users = localStorage.getItem('users_{{ $encuesta->id }}') ? localStorage.getItem('users_{{ $encuesta->id }}') :  [];
        if (localStorage.getItem('users_{{ $encuesta->id }}')) {
            jQuery('#cantidad_seleccionados').html(localStorage.getItem('users_{{ $encuesta->id }}').split(',').length)
            if (!jQuery('#cantidad_seleccionados').hasClass('indicador_seleccionados')) {
                jQuery('#cantidad_seleccionados').addClass('indicador_seleccionados')
            }
        }
        let ids = localStorage.users.split(',');
        ids.forEach(function(id){
            jQuery('input[value="' + id + '"]').prop('checked', 'checked');
        });
    }

    function resetSeleccionados() {
        let ids = localStorage.getItem('users_{{ $encuesta->id }}');
        if (ids) {
            ids = ids.split(',');
        } else {
            ids = [];
        }

        ids.forEach(function(id){
            jQuery('input[value="' + id + '"]').prop('checked', false);
        });

        localStorage.setItem('users_{{ $encuesta->id }}', '');
        if (localStorage.getItem('users_{{ $encuesta->id }}')) {
            jQuery('#cantidad_seleccionados').html(users.length)
            if (!jQuery('#cantidad_seleccionados').hasClass('indicador_seleccionados')) {
                jQuery('#cantidad_seleccionados').addClass('indicador_seleccionados')
            }
        } else {
            if (jQuery('input[name="check_all"]:checked')) {
                jQuery('input[name="check_all"]:checked').prop('checked', false);
            }
            jQuery('#cantidad_seleccionados').html('');
            if (jQuery('#cantidad_seleccionados').hasClass('indicador_seleccionados')) {
                jQuery('#cantidad_seleccionados').removeClass('indicador_seleccionados')
            }
        }
    }

    function enviarUsuarios() {
        jQuery('#enviar_usuarios').attr('disabled', true);
        let usrs = localStorage.getItem('users_{{ $encuesta->id }}');
        let users = usrs ? usrs.split(',') : [];
        jQuery.ajax({
            method: "POST",
            url: "/encuestas/add_usuarios/{{ $encuesta->id }}",
            data: {
                users: users,
                _token: "{{ csrf_token() }}"
            }
        }).done(function( msg ) {
            resetSeleccionados();
            location.href = '/encuestas/{{ $encuesta->id }}?seccion=asignados';
            jQuery('#enviar_usuarios').attr('disabled', false);
        });
    }

    jQuery('input[name="users[]"]').on('click', function(e) {
        let element = jQuery(e.currentTarget);
        let usrs = localStorage.getItem('users_{{ $encuesta->id }}');
        let users = usrs ? usrs.split(',') : [];
        if (!users.includes(element.val())) {
            users.push(element.val());
        } else {
            users.pop(element.val());
            element.prop('checked', false);
        }
        jQuery('#cantidad_seleccionados').html(users.length)
        localStorage.setItem('users_{{ $encuesta->id }}', users.toString());
        if (localStorage.getItem('users_{{ $encuesta->id }}')) {
            jQuery('#cantidad_seleccionados').html(users.length)
            if (!jQuery('#cantidad_seleccionados').hasClass('indicador_seleccionados')) {
                jQuery('#cantidad_seleccionados').addClass('indicador_seleccionados')
            }
        } else {
            jQuery('#cantidad_seleccionados').html('');
            if (jQuery('#cantidad_seleccionados').hasClass('indicador_seleccionados')) {
                jQuery('#cantidad_seleccionados').removeClass('indicador_seleccionados')
            }
        }
    })

    jQuery('ul.nav-wizard li.nav-item').on('click', function(e) {
        if (jQuery(e.currentTarget).find('a[href="#step-tab2"]').length == 1) {
            if (!jQuery('a[href="#step-tab1"]').hasClass('done')) {
                jQuery('a[href="#step-tab1"]').addClass('done');
                jQuery('#nextStep').click();
                jQuery('#step-tab1').toggleClass('active');
                jQuery('#step-tab2').toggleClass('active');
            }
        }

        if (jQuery(e.currentTarget).find('a[href="#step-tab1"]').length == 1) {
            if (jQuery('a[href="#step-tab2"]').hasClass('active')) {
                jQuery('a[href="#step-tab2"]').removeClass('active');
                jQuery('a[href="#step-tab1"]').removeClass('done');
                jQuery('a[href="#step-tab1"]').addClass('active');
                jQuery('#step-tab1').toggleClass('active');
                jQuery('#step-tab2').toggleClass('active');
            } else if (jQuery('a[href="#step-tab1"]').hasClass('done')) {
                jQuery('#prev_btn').click();
                if (jQuery('#step-tab2:visible').length > 0) {
                    jQuery('#step-tab1').toggleClass('active');
                    jQuery('#step-tab2').toggleClass('active');
                }
            }
        }
    })

    jQuery('#asignar_usuarios_btn').on('click', function(){
        jQuery('#agg_usuasrios-container').toggleClass('d-none');
        jQuery('#assignados-container').toggleClass('d-none');
    });

    jQuery('input[name="check_all"]').on('click', function() {
        jQuery('input[name="users[]"]').each(function(k, e) {
            if (!jQuery(e).prop('disabled')) {
                    let element = jQuery(e);
                    let usrs = localStorage.getItem('users_{{ $encuesta->id }}');
                    let users = usrs ? usrs.split(',') : [];
                    if (!users.includes(element.val())) {
                        users.push(element.val());
                    } else {
                        users = users.filter(function(user_id) {
                           return user_id != element.val();
                        })
                    }
                    jQuery('#cantidad_seleccionados').html(users.length)
                    localStorage.setItem('users_{{ $encuesta->id }}', users.toString());
                    if (localStorage.getItem('users_{{ $encuesta->id }}')) {
                        jQuery('#cantidad_seleccionados').html(users.length)
                        if (!jQuery('#cantidad_seleccionados').hasClass('indicador_seleccionados')) {
                            jQuery('#cantidad_seleccionados').addClass('indicador_seleccionados')
                        }
                        jQuery('input[name="users[]"]:not([disabled])').prop('checked', 'checked')
                    } else {
                        jQuery('#cantidad_seleccionados').html('');
                        if (jQuery('#cantidad_seleccionados').hasClass('indicador_seleccionados')) {
                            jQuery('#cantidad_seleccionados').removeClass('indicador_seleccionados')
                        }
                        jQuery('input[name="users[]"]:not([disabled])').prop('checked', false)
                    }
            }
        })
    })

    return {
        init,
        enviarUsuarios,
        resetSeleccionados
    };
})()
jQuery(document).ready(function() {
    checker.init();
    jQuery('#enviar_usuarios').on('click', function(){
        checker.enviarUsuarios();
    })

    jQuery('#resetear_seleccionados').on('click', function() {
        checker.resetSeleccionados();
    })

    jQuery('.edit_titulo_pergunta').on('click', function(element) {
        let w = jQuery(element.currentTarget).width()
        jQuery(element.currentTarget).toggleClass('d-none');
        jQuery(element.currentTarget).parent().find('input.input_titulo_pregunta').toggleClass('d-none')
        jQuery(element.currentTarget).parent().find('input.input_titulo_pregunta:visible').focus()
        jQuery(element.currentTarget).parent().find('input.input_titulo_pregunta:visible').width(w)
    })

    jQuery('input.input_titulo_pregunta').on('blur',  function(e) {
        let pregunta_id = jQuery(e.currentTarget).attr('data-id');
        jQuery(e.currentTarget).parent().find('h5').html(jQuery(e.currentTarget).val())
        jQuery(e.currentTarget).parent().find('h5').toggleClass('d-none');
        jQuery(e.currentTarget).toggleClass('d-none');
        jQuery('div.toast-body').html(`<div class="spinner-border spinner-border-sm" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>`);
        jQuery('div.toast-header > strong.me-auto').html('Actualizando pregunta')
        if (!jQuery('div.toast-body').parent().hasClass('show')) {
            jQuery('div.toast-body').parent().toggleClass('show');
        }
        jQuery.ajax({
            method: "PUT",
            url: "/encuestas/actualizar_pregunta/"+ jQuery(e.currentTarget).attr('data-id'),
            data: {
                pregunta: jQuery(e.currentTarget).val(),
                _token: "{{ csrf_token() }}"
            }
        }).done(function(response) {
            jQuery('div.toast-header > strong.me-auto').html('Aviso')
            jQuery('div.toast-body').html(response.msg);
            if (!jQuery('div.toast-body').parent().hasClass('show')) {
                jQuery('div.toast-body').parent().toggleClass('show');
            }
        });
    })

    jQuery('.eliminar_pregunta').on('click', function(el) {
        let pregunta_id = jQuery(el.currentTarget).attr('data-id');
        let encuesta_id = '{{ $encuesta->id}}';
        if (confirm('Seguro que desea eliminar esta pregunta?')) {
            jQuery('div.toast-body').html(`<div class="spinner-border spinner-border-sm" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>`);
            jQuery('div.toast-header > strong.me-auto').html('Eliminando pregunta')
            if (!jQuery('div.toast-body').parent().hasClass('show')) {
                jQuery('div.toast-body').parent().toggleClass('show');
            }
            jQuery.ajax({
                method: "DELETE",
                url: "/encuestas/eliminar_pregunta/"+encuesta_id+"/"+pregunta_id,
                data: {
                    _token: "{{ csrf_token() }}"
                }
            }).done(function( response) {
                jQuery('div.toast-body').html(response.msg);
                jQuery('div.toast-header > strong.me-auto').html('Aviso')
                if (!jQuery('div.toast-body').parent().hasClass('show')) {
                    jQuery('div.toast-body').parent().toggleClass('show');
                }
                if (response.status == 'success') {
                    jQuery('.pregunta_cont_'+pregunta_id).remove();
                }
            });
        }
    })
})
</script>

</div>

</div>
@endsection


