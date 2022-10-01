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
        <th scope="col">Estado</th>
        <th scope="col">C.I.</th>
        <th scope="col">Carrera</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($asignados as $index => $user)
    <?php
    $porcentaje = 0;
    if (array_key_exists($user->user_id, $estado['usuarios'])) {
        $porcentaje = round(($estado['usuarios'][$user->user_id] / $estado['total_preguntas_requeridas']) * 100);
    }
    ?>
        <tr class="align-middle">
            <td class="text-nowrap">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-xl">
                        <img class="rounded-circle" src="{{ $user->getFirstMediaUrl('avatars', 'small_avatar') }}" alt="">
                    </div>
                    <div class="ms-2"><a href="/egresado/{{$user->user_id}}">{{ $user->getName() }}</a></div>
                </div>
            </td>
            <td class="text-nowrap">{{ $user->apellido }}</td>
            <td class="text-nowrap">{{ $user->getEmail() }}</td>
            <td class="text-nowrap">
                @if($porcentaje == 100)
                <div class="progress mb-3" style="height:2px" title="Completo">
                    <div class="progress-bar bg-success" role="progressbar" style="width: <?= $porcentaje;?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
                @else
                <div class="progress mb-3" style="height:2px" title="Completo en un  <?= $porcentaje;?>%">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?= $porcentaje;?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
                @endif
            </td><td
            class="text-nowrap">{{ $user->ci }}</td>
            <td class="text-nowrap">{{ $user->carrera->carrera }}</td>
        </tr>
    @endforeach
    </tbody>
  </table>
</div>
