@extends('layouts.admin')
@section('content')
        <div class="content">
          <div class="card mb-3">
            <div class="card-header position-relative min-vh-25 mb-7">
              <div class="bg-holder rounded-3 rounded-bottom-0" style="background-image:url(../../assets/img/generic/4.jpg);">
              </div>
              <!--/.bg-holder-->

              <div class="avatar avatar-5xl avatar-profile"><img class="rounded-circle img-thumbnail shadow-sm" src="{{ $user->getFirstMediaUrl('avatars', 'perfil') }}" width="200" alt="" /></div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-8">
                  <h4 class="mb-1">{{ $user->getNombreCompleto() }}
                  </h4>
                  @if ($usuario_logeado->id !== $user->id)
                    @if ($usuario_logeado->hasRole($user::ROLE_ADMINISTRADOR))
                      <a href="/egresado/{{$user->id}}/edit" class="btn btn-falcon-default btn-sm px-3 ms-2" type="button">Editar</a>
                    @endif
                  @else
                    @if (!$usuario_logeado->hasRole($user::ROLE_ADMINISTRADOR))
                      <h5 class="fs-0 fw-normal">{{ $user->carrera->carrera}}</h5>
                    @endif
                      <a href="/perfil/editar" class="btn btn-falcon-default btn-sm px-3 ms-2" type="button">Editar</a>
                  @endif
                  <div class="border-dashed-bottom my-4 d-lg-none"></div>
                </div>

              </div>
            </div>
          </div>



<div class="card">
<div class="card-header bg-light">
                    <h5 class="mb-0">Historial del Egresado</h5>
                  </div>
<div class="card-body px-sm-4 px-md-8 px-lg-6 px-xxl-8">
              <div class="timeline-zigzag">
            <?php $start = true;?>
             @foreach ($historial as $fecha => $mes)
                    @foreach ($mes as $indx => $obj)
                    @if ($obj instanceof App\Models\LaboralUser)
                    <div class="row timeline-item timeline-item-{{$start ? 'start' : 'end' }}">
                        <div class="col-lg-6 timeline-item-content"><span class="bullet"></span>
                            <div class="row g-0 mt-n4">
                            <div class="col timeline-item-text">
                                <h3 class="text-primary mt-4 mt-sm-0">{{$fecha}}</h3>
                                <h6 class="mt-2 mb-1 mt-sm-3">{{$obj->cargo}}</h6>
                                <p class="fs--1">{{$obj->getEmpresa()}}</p>
                            </div>

                            </div>
                        </div>
                    </div>
                    @else
                    <div class="row timeline-item timeline-item-{{$start ? 'start' : 'end' }}">
                        <div class="col-lg-6 timeline-item-content"><span class="bullet"></span>
                            <div class="row g-0 mt-n4">
                            <div class="col timeline-item-text">
                                <h3 class="text-primary mt-4 mt-sm-0">{{$fecha}}</h3>
                                <h6 class="mt-2 mb-1 mt-sm-3">{{$obj->titulo}}</h6>
                                <p class="fs--1">{{$obj->institucion}}</p>
                            </div>

                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                <?php $start = !$start;?>
             @endforeach
              </div>
            </div>
</div>
@endsection

