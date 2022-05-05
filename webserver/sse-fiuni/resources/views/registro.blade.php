@extends('layouts.basic')
@section('content')
    <main class="main" id="top">
      <div class="container" data-layout="container">
        <script>
          var isFluid = JSON.parse(localStorage.getItem('isFluid'));
          if (isFluid) {
            var container = document.querySelector('[data-layout]');
            container.classList.remove('container');
            container.classList.add('container-fluid');
          }
        </script>
        <div class="row flex-center min-vh-100 py-6">
          <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4"><a class="d-flex flex-center mb-4" href="/"><img class="me-2" src="../../../assets/img/icons/spot-illustrations/falcon.png" alt="" width="58" /><span class="font-sans-serif fw-bolder fs-5 d-inline-block">SSE</span></a>
            <div class="card">
              <div class="card-body p-4 p-sm-5">
                <div class="row flex-between-center mb-2">
                  <div class="col-auto">
                    <h5>Registro</h5>
                  </div>
                  <div class="col-auto fs--1 text-600"><span class="mb-0 undefined">Ya tiene una cuenta?</span> <span><a href="/login">Acceda aqui</a></span></div>
                </div>
                <form action="/registro" method="POST" class="needs-validation" novalidate>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                    <div class="mb-3">
                        <input class="form-control" type="text" autocomplete="on" placeholder="Nombre" name="nombre" required/>
                        <div class="invalid-feedback">
                            Campo Requerido.
                        </div>
                    </div>
                    <div class="mb-3">
                        <input class="form-control" type="text" autocomplete="on" placeholder="Apellido" name="apellido" required/>
                        <div class="invalid-feedback">
                            Campo Requerido.
                        </div>
                    </div>
                    <div class="mb-3">
                        <input class="form-control" type="number" autocomplete="on" placeholder="C.I:" name="ci" required/>
                        <div class="invalid-feedback">
                            Campo Requerido.
                        </div>
                    </div>
                    <div class="mb-3">
                        <input class="form-control" type="email" autocomplete="on" placeholder="Correo" name="email" required/>
                        <div class="invalid-feedback">
                            Campo Requerido.
                        </div>
                    </div>
                    <div class="row gx-2">
                        <div class="mb-3 col-sm-6">
                        <input class="form-control" type="password" autocomplete="on" placeholder="Contraseña" name="password" required/>
                            <div class="invalid-feedback">
                                Campo Requerido.
                            </div>
                        </div>
                        <div class="mb-3 col-sm-6">
                        <input class="form-control" type="password" autocomplete="on" placeholder="Confirmar Contraseña" name="password_confirmation"/>
                        </div>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">Crear Cuenta</button>
                    </div>
                </form>
              </div>
             </div>
          </div>
        </div>
      </div>
    </main>
@endsection
