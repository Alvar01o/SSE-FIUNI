@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-12">
            <div class="card mb-3 btn-reveal-trigger">
                <div class="card-header position-relative min-vh-25 mb-8">
                    <form method="post" enctype="multipart/form-data" action="/upload_avatar" id="avatar_form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="user_id" value="{{ $user->id }}" />
                        <div class="cover-image">
                            <div class="bg-holder rounded-3 rounded-bottom-0" style="background-image:url(../../assets/img/generic/4.jpg);">
                            </div>
                            <!--/.bg-holder-->
                        </div>
                        <div class="avatar avatar-5xl avatar-profile shadow-sm img-thumbnail rounded-circle">
                            <div class="h-100 w-100 rounded-circle overflow-hidden position-relative"> <img src="{{ route('get_avatar2',  ['id' => $user->id]) }}" width="200" alt="" data-dz-thumbnail="data-dz-thumbnail" />
                                <input class="d-none" id="profile-image" name="avatar" type="file" />
                                <script>
                                    jQuery(document).ready(function(){
                                        jQuery('#profile-image').on('change', function () {
                                            console.log(jQuery('#profile-image').val())
                                            jQuery('#avatar_form').submit();
                                        console.log("changed");
                                        })
                                        console.log("ready");
                                    })
                                </script>
                                <label class="mb-0 overlay-icon d-flex flex-center" for="profile-image"><span class="bg-holder overlay overlay-0"></span><span class="z-index-1 text-white dark__text-white text-center fs--1"><span class="fas fa-camera"></span><span class="d-block">Editar</span></span></label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-0">
    @if ($errors->any())
        <div class="alert alert-danger mt-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="col-lg-8 pe-lg-2">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Datos de Perfil</h5>
            </div>
            <div class="card-body bg-light">
                <form class="row g-3 needs-validation" method="post" action="/egresado/{{ $user->id }}">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="col-lg-10">
                        <label class="form-label" for="nombre">Nombre</label>
                        <input class="form-control" minlength="3" maxlength="30" id="nombre" type="text" required value="{{ $user->nombre }}" name="nombre"/>
                    </div>
                    <div class="col-lg-10">
                        <label class="form-label" for="apellido">Apellido</label>
                        <input class="form-control" minlength="3" maxlength="30" id="apellido" type="text" required value="{{ $user->apellido }}" name="apellido"/>
                    </div>
                    <div class="col-lg-10">
                        <label class="form-label" for="ci">C.I.</label>
                        <input class="form-control" pattern=".{6,10}" min="500000" max="3000000000" id="ci" type="text" required value="{{ $user->ci }}" name="ci"/>
                    </div>
                    <div class="col-lg-10">
                        <label class="form-label" for="correo">Correo</label>
                        <input class="form-control" id="correo"  minlength="7" maxlength="100" type="email" required value="{{ $user->email }}" name="email"/>
                    </div>
                    <div class="col-lg-10">
                        <label class="form-label" for="telefono">telefono</label>
                        <input class="form-control" id="telefono" minlength="3" maxlength="30" type="number" value="{{ $user->datosPersonales->count() ? $user->datosPersonales->last()->telefono : '' }}" name="telefono"/>
                    </div>
                    <div class="col-lg-10">
                        <label class="form-label" for="direccion">direccion</label>
                        <input class="form-control" id="direccion" minlength="3" maxlength="300" type="text" value="{{ $user->datosPersonales->count() ? $user->datosPersonales->last()->direccion : '' }}" name="direccion"/>
                    </div>
                    @if (!$user->hasRole($user::ROLE_ADMINISTRADOR))
                        <div class="col-lg-10">
                            <label class="form-label" for="carrera">Carrera</label>
                            <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="carrera_id" required>
                                @foreach ($carreras as $carrera)
                                    <option value="{{ $carrera->id }}" <?= $user->carrera->id == $carrera->id ? 'selected="selected"' : '' ?>>{{ $carrera->carrera }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="col-12 d-flex justify-content-end py-3">
                        <button class="btn btn-primary" type="submit"> Guardar </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0">Experiencia Laboral</h5>
        </div>
        <div class="card-body bg-light"><a class="mb-4 d-block d-flex align-items-center" href="#experience-form1" data-bs-toggle="collapse" aria-expanded="false" aria-controls="experience-form1"><span class="circle-dashed"><span class="fas fa-plus"></span></span><span class="ms-3">Agregar Experiencia Laboral</span></a>
            <div class="collapse" id="experience-form1">
            @include('egresado.partials.formulario_laboral')
            <div class="border-dashed-bottom my-4"></div>
            </div>
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
        <div class="card mb-3 mb-lg-0">
        <div class="card-header">
            <h5 class="mb-0">Educacion</h5>
        </div>
        <div class="card-body bg-light"><a class="mb-4 d-block d-flex align-items-center" href="#education-form" data-bs-toggle="collapse" aria-expanded="false" aria-controls="education-form"><span class="circle-dashed"><span class="fas fa-plus"></span></span><span class="ms-3">Añadir Educacion</span></a>
            <div class="collapse" id="education-form">
            @include('egresado.partials.formulario_educacion')
            <div class="border-dashed-bottom my-3"></div>
            </div>
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
    <div class="col-lg-4 ps-lg-2">
        <div class="sticky-sidebar">
        <div class="card mb-3">
            <div class="card-header">
            <h5 class="mb-0">Cambiar contraseña</h5>
            </div>
            <div class="card-body bg-light">
            <form>
                <div class="mb-3">
                <label class="form-label" for="old-password">Contraseña Actual</label>
                <input class="form-control" id="old-password" name="old_password" type="password" />
                </div>
                <div class="mb-3">
                <label class="form-label" for="password" name="password">Nueva Contraseña</label>
                <input class="form-control" id="password" name="password" type="password" />
                </div>
                <div class="mb-3">
                <label class="form-label" for="password_confirmation" name="password_confirmation">Confirmar Contraseña</label>
                <input class="form-control" id="password_confirmation"  name="password_confirmation" type="password" />
                </div>
                <button class="btn btn-primary d-block w-100" type="submit">Actualizar  Contraseña</button>
            </form>
            </div>
        </div>
        </div>
    </div>
    </div>
</div>
@endsection


