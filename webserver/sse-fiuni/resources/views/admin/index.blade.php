@extends('layouts.admin')
@section('content')
    <h1>Pagina Principal de admin</h1>
    <div class="row mt-4">
        <div class="col-xxl-3 col-md-6 col-lg-5">
            <div class="card shopping-cart-bar-min-height dashboard-encuesta_carreras h-100">
            <div class="card-header d-flex flex-between-center">
                <h6 class="mb-0">Usuarios por carreras</h6>
            </div>
            <div class="card-body py-0 d-flex align-items-center h-100">
                <div class="flex-1">
                @foreach($carreras as $carrera)
                <div class="row g-0 align-items-center pb-3">
                    <div class="col pe-4">
                    <h6 class="fs--2 text-600">{{$carrera->carrera}}</h6>
                    <div class="progress" style="height:5px">
                        <div class="progress-bar rounded-3 bg-primary" role="progressbar" style="width: {{round(($carrera->usuariosCount() / $total_users) * 100)}}% " aria-valuenow="{{round(($carrera->usuariosCount() / $total_users) * 100)}}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    </div>
                    <div class="col-auto text-end">
                    <p class="mb-0 fs--2 text-500 fw-semi-bold"> Usuarios: <span class="text-600">{{$carrera->usuariosCount()}}</span> </p>
                    </div>
                </div>
                @endforeach

                </div>
            </div>
            </div>
        </div>
<div class="col-lg-9 pe-lg-2 mb-3">
              <div class="card h-lg-100 overflow-hidden">
                <div class="card-header bg-light">
                  <div class="row align-items-center">
                    <div class="col">
                      <h6 class="mb-0">Ultimas Encuestas de Egresados</h6>
                    </div>
                    <div class="col-auto text-center pe-card">
                      <h6 class="mb-0">Porcentaje completo</h6>
                    </div>
                  </div>
                </div>
                <div class="card-body p-0">
                    @foreach($encuestas as $encuesta)
                    <?php
                        $estado_report = $encuesta->statusEgresados($encuesta->encuesta_id);
                        $estado = $estado_report['estado'];
                        $total_pendientes = $estado['Pendiente'] ? round(($estado['Pendiente'] / $estado_report['total_usuarios_asignados']) * 100) : 0;
                        $total_progreso = $estado['progreso'] ? round(($estado['progreso'] / $estado_report['total_usuarios_asignados']) * 100) : 0 ;
                        $total_completo = $estado['Completo'] ? round(($estado['Completo'] / $estado_report['total_usuarios_asignados']) * 100) : 0;
                    ?>
                    <div class="row g-0 align-items-center py-2 position-relative border-bottom border-200">
                        <div class="col ps-card py-1 position-static">
                        <div class="d-flex align-items-center">
                            <div class="flex-1">
                            <h6 class="mb-0 d-flex align-items-center"><a class="text-800 stretched-link" href="<?= 'encuestas/'.$encuesta->id;?>">{{ $encuesta->nombre }}</a><span class="badge rounded-pill ms-2 bg-200 text-primary"><?= $total_completo?>%</span></h6>
                            </div>
                        </div>
                        </div>
                        <div class="col py-1">
                        <div class="row flex-end-center g-0">
                            <div class="col-5 pe-card ps-2">
                            <div class="progress" style="height:4px">
                                <div class="progress-bar bg-pendiente" title="<?= $estado['Pendiente'];?> PENDIETE" role="progressbar" style="width: <?= $total_pendientes?>%" aria-valuenow="<?= $total_pendientes?>" aria-valuemin="0" aria-valuemax="100"></div>
                                <div class="progress-bar bg-warning" title="<?= $estado['progreso'];?> EN PROGRESO" role="progressbar" style="width: <?= $total_progreso?>%" aria-valuenow="<?= $total_progreso?>" aria-valuemin="0" aria-valuemax="100"></div>
                                <div class="progress-bar bg-success" role="progressbar" title="<?= $estado['Completo'];?> COMPLETO" style="width: <?= $total_completo?>%" aria-valuenow="<?= $total_completo?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="card-footer bg-light p-0"><a class="btn btn-sm btn-link d-block w-100 py-2" href="<?= '/encuestas'?>">Ver todas las encuestas de Egresado<svg class="svg-inline--fa fa-chevron-right fa-w-10 ms-1 fs--2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"></path></svg><!-- <span class="fas fa-chevron-right ms-1 fs--2"></span> Font Awesome fontawesome.com --></a></div>
              </div>
            </div>
    </div>
@endsection
