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
                  @if (!$user->hasRole($user::ROLE_ADMINISTRADOR))
                  <h5 class="fs-0 fw-normal">{{ $user->carrera->carrera}}</h5>
                  @endif
                  <a href="/perfil/editar" class="btn btn-falcon-default btn-sm px-3 ms-2" type="button">Editar</a>
                  <div class="border-dashed-bottom my-4 d-lg-none"></div>
                </div>

              </div>
            </div>
          </div>
          <div class="row g-0">
            <div class="col-lg-12">
              <div class="sticky-sidebar">
                <div class="card mb-3">
                  <div class="card-header bg-light">
                    <h5 class="mb-0">Experiencia Laboral</h5>
                  </div>
                  <div class="card-body fs--1">
                    @if (count($user->educacion))
                    <div class="d-flex"><a href="#!"> <img class="img-fluid" src="../../assets/img/logos/g.png" alt="" width="56" /></a>
                        @foreach ($user->getEmpleos() as $laboral)
                        <div class="d-flex"><a href="#!"> <img class="img-fluid" src="../../assets/img/logos/g.png" alt="" width="56" /></a>
                            <div class="flex-1 position-relative ps-3">
                                <h6 class="fs-0 mb-0">{{ $laboral->cargo }}
                                </h6>
                                <p class="mb-1"> <a href="#!">{{ $laboral->getEmpresa() }}</a></p>
                                <p class="text-1000 mb-0">Apr 2012 - Present &bull; 6 yrs 9 mos</p>
                                <div class="border-dashed-bottom my-3"></div>
                            </div>
                        </div>
                        @endforeach
                  </div>
                    @else
                    <div class="py-2">
                        <div class="alert alert-primary" role="alert">
                            Ninguna Experiencia Laboral disponible.
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card mb-3">
                  <div class="card-header bg-light">
                    <h5 class="mb-0">Educacion</h5>
                  </div>
                  <div class="card-body fs--1">
                    @if (count($user->educacion))
                        @foreach ($user->educacion as $certificacion)
                            <div class="d-flex"><a href="#!"> <img class="img-fluid" src="../../assets/img/logos/staten.png" alt="" width="56" /></a>
                                <div class="flex-1 position-relative ps-3">
                                    <h6 class="fs-0 mb-0"> <a href="#!" class="text-uppercase">{{ $certificacion->titulo }}</a></h6>
                                    <p class="mb-1">{{ $certificacion->institucion }}</p>
                                    <p class="text-1000 mb-0">{{ date('Y', strtotime($certificacion->inicio)) }} - <?= ($certificacion->fin == null) ? '<b>cursando</b>' : date('Y',strtotime($certificacion->fin));?></p>
                                    <div class="border-dashed-bottom my-3"></div>
                                </div>
                            </div>
                        @endforeach
                    @else
                    <div class="py-2">
                        <div class="alert alert-primary" role="alert">
                            Ninguna certificacion disponible.
                        </div>
                    </div>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
@endsection

