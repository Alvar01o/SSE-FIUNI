<?php
    $show = true;
    if (isset($_GET['seccion'])) {
        if ($_GET['seccion'] !== 'usuarios') {
            $show = false;
        }
    } else {
        $show = false;
    }
?>
<div class="table-responsive scrollbar py-4 <?= $show  ? '' : 'd-none' ?>" id="agg_usuasrios-container">
<div class="g-3 pt-3">
    <form method="GET" action="/encuestas/{{ $encuesta->id}}" class="row">
        <input type="hidden" value="usuarios" name="seccion"/>
        <div class="col-sm-5">
            <input class="form-control" type="text" name="name_email" placeholder="Nombre de usuario o email" aria-label="Nombre de usuario o email" />
        </div>
        <div class="col-sm-3">
            <select class="form-select" name="carrera_id" aria-label="Seleccione Carrera">
                <option value="">Seleccione Carrera</option>
                @foreach ($carreras as $carrera)
                    <option value="{{ $carrera->id }}">{{ $carrera->carrera }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm">
            <button class="btn btn-primary me-1 mb-1" type="submit">
                Filtrar
            </button>
        </div>
    </form>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger mt-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
<form class="" action="/encuestas/add_usuarios/{{ $encuesta->id }}" id="agg_egresados_encuesta" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <table class="table table-hover table-striped overflow-hidden">
        <thead>
        <tr>
            <th scope="col"><input name="check_all" type="checkbox"></th>
            <th scope="col">Nombre</th>
            <th scope="col">Apellido</th>
            <th scope="col">Correo</th>
            <th scope="col">C.I.</th>
            <th scope="col">Carrera</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($egresados as $index => $user)
            <tr class="align-middle">
                <td class="text-nowrap">
                    <input name="users[]" <?= $encuesta->existeUsuarioAsignado($user->id) ? 'disabled checked="checked"' : '';?> type="checkbox" value="{{ $user->id }}" >
                </td>
                <td class="text-nowrap">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-xl">
                            <img class="rounded-circle" src="{{ $user->getFirstMediaUrl('avatars', 'small_avatar') }}" alt="">
                        </div>
                        <div class="ms-2">{{ $user->getName() }}</div>
                    </div>
                </td>
                <td class="text-nowrap">{{ $user->apellido }}</td>
                <td class="text-nowrap">{{ $user->getEmail() }}</td>
                <td class="text-nowrap">{{ $user->ci }}</td>
                <td class="text-nowrap">{{ $user->carrera->carrera }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </form>
    <div class=" d-flex justify-content-end">
        {{ $egresados->links('paginacion') }}
    </div>
    <div class="fixed-bottom py-3 px-3 row bg-w justify-content-center">
        <div class="px-3 col-md-10 col-xl-5">
            <button class="btn btn-primary" id="enviar_usuarios"><span class="rounded-circle" id="cantidad_seleccionados" data-encuesta_id="{{ $encuesta->id }}"></span>Agregar Seleccionados</button>
            <button class="btn btn-danger" id="resetear_seleccionados">Reestablecer Seleccion</button>
        </div>
    </div>
</div>
