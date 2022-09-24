<?php
    $show_asignados = true;
    if (isset($_GET['seccion'])) {
        if ($_GET['seccion'] == 'asignados') {
            $show_asignados = true;
        } elseif ($_GET['seccion'] == 'usuarios') {
            $show_asignados = false;
        }
    }
?>
<div class="table-responsive scrollbar py-4 <?= $show_asignados ? '' : 'd-none' ?>" id="assignados-container">
    <div class="row">
        <h2 class="col-6">Usuarios Asignados</h2>
        <div class="col-6"><button id="asignar_usuarios_btn" class="btn btn-primary" style="float: right;">Asignar Usuarios a la Encuesta</button></div>
    </div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <table class="table table-hover table-striped overflow-hidden">
    <thead>
      <tr>
        <th scope="col">Nombre</th>
        <th scope="col">Apellido</th>
        <th scope="col">Correo</th>
        <th scope="col">C.I.</th>
        <th scope="col">Carrera</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($asignados as $index => $user)
        <tr class="align-middle">
            <td class="text-nowrap">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-xl">
                        <img class="rounded-circle" src="{{ $user->getFirstMediaUrl('avatars', 'small_avatar') }}" alt="">
                    </div>
                    <div class="ms-2"><a href="/egresado/{{$user->id}}">{{ $user->getName() }}</a></div>
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
</div>
