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
                  <h4 class="mb-1">{{ $user->getNombreCompleto() }}<span data-bs-toggle="tooltip" data-bs-placement="right" title="Verified"><small class="fa fa-check-circle text-primary" data-fa-transform="shrink-4 down-2"></small></span>
                  </h4>
                  @if (!$user->hasRole($user::ROLE_ADMINISTRADOR))
                  <h5 class="fs-0 fw-normal">{{ $user->carrera->carrera}}</h5>
                  @endif
                  <p class="text-500">New York, USA</p>
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
                    <h5 class="mb-0">Experience</h5>
                  </div>
                  <div class="card-body fs--1">
                    <div class="d-flex"><a href="#!"> <img class="img-fluid" src="../../assets/img/logos/g.png" alt="" width="56" /></a>
                      <div class="flex-1 position-relative ps-3">
                        <h6 class="fs-0 mb-0">Big Data Engineer<span data-bs-toggle="tooltip" data-bs-placement="top" title="Verified"><small class="fa fa-check-circle text-primary" data-fa-transform="shrink-4 down-2"></small></span>
                        </h6>
                        <p class="mb-1"> <a href="#!">Google</a></p>
                        <p class="text-1000 mb-0">Apr 2012 - Present &bull; 6 yrs 9 mos</p>
                        <p class="text-1000 mb-0">California, USA</p>
                        <div class="border-dashed-bottom my-3"></div>
                      </div>
                    </div>
                    <div class="d-flex"><a href="#!"> <img class="img-fluid" src="../../assets/img/logos/apple.png" alt="" width="56" /></a>
                      <div class="flex-1 position-relative ps-3">
                        <h6 class="fs-0 mb-0">Software Engineer<span data-bs-toggle="tooltip" data-bs-placement="top" title="Verified"><small class="fa fa-check-circle text-primary" data-fa-transform="shrink-4 down-2"></small></span>
                        </h6>
                        <p class="mb-1"> <a href="#!">Apple</a></p>
                        <p class="text-1000 mb-0">Jan 2012 - Apr 2012 &bull; 4 mos</p>
                        <p class="text-1000 mb-0">California, USA</p>
                        <div class="border-dashed-bottom my-3"></div>
                      </div>
                    </div>
                    <div class="d-flex"><a href="#!"> <img class="img-fluid" src="../../assets/img/logos/nike.png" alt="" width="56" /></a>
                      <div class="flex-1 position-relative ps-3">
                        <h6 class="fs-0 mb-0">Mobile App Developer<span data-bs-toggle="tooltip" data-bs-placement="top" title="Verified"><small class="fa fa-check-circle text-primary" data-fa-transform="shrink-4 down-2"></small></span>
                        </h6>
                        <p class="mb-1"> <a href="#!">Nike</a></p>
                        <p class="text-1000 mb-0">Jan 2011 - Apr 2012 &bull; 1 yr 4 mos</p>
                        <p class="text-1000 mb-0">Beaverton, USA</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card mb-3">
                  <div class="card-header bg-light">
                    <h5 class="mb-0">Education</h5>
                  </div>
                  <div class="card-body fs--1">
                    <div class="d-flex"><a href="#!">
                        <div class="avatar avatar-3xl">
                          <div class="avatar-name rounded-circle"><span>SU</span></div>
                        </div>
                      </a>
                      <div class="flex-1 position-relative ps-3">
                        <h6 class="fs-0 mb-0"> <a href="#!">Stanford University<span data-bs-toggle="tooltip" data-bs-placement="top" title="Verified"><small class="fa fa-check-circle text-primary" data-fa-transform="shrink-4 down-2"></small></span></a></h6>
                        <p class="mb-1">Computer Science and Engineering</p>
                        <p class="text-1000 mb-0">2010 - 2014 • 4 yrs</p>
                        <p class="text-1000 mb-0">California, USA</p>
                        <div class="border-dashed-bottom my-3"></div>
                      </div>
                    </div>
                    <div class="d-flex"><a href="#!"> <img class="img-fluid" src="../../assets/img/logos/staten.png" alt="" width="56" /></a>
                      <div class="flex-1 position-relative ps-3">
                        <h6 class="fs-0 mb-0"> <a href="#!">Staten Island Technical High School<span data-bs-toggle="tooltip" data-bs-placement="top" title="Verified"><small class="fa fa-check-circle text-primary" data-fa-transform="shrink-4 down-2"></small></span></a></h6>
                        <p class="mb-1">Higher Secondary School Certificate, Science</p>
                        <p class="text-1000 mb-0">2008 - 2010 &bull; 2 yrs</p>
                        <p class="text-1000 mb-0">New York, USA</p>
                        <div class="border-dashed-bottom my-3"></div>
                      </div>
                    </div>
                    <div class="d-flex"><a href="#!"> <img class="img-fluid" src="../../assets/img/logos/tj-heigh-school.png" alt="" width="56" /></a>
                      <div class="flex-1 position-relative ps-3">
                        <h6 class="fs-0 mb-0"> <a href="#!">Thomas Jefferson High School for Science and Technology<span data-bs-toggle="tooltip" data-bs-placement="top" title="Verified"><small class="fa fa-check-circle text-primary" data-fa-transform="shrink-4 down-2"></small></span></a></h6>
                        <p class="mb-1">Secondary School Certificate, Science</p>
                        <p class="text-1000 mb-0">2003 - 2008 &bull; 5 yrs</p>
                        <p class="text-1000 mb-0">Alexandria, USA</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
@endsection

