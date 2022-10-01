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
          <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4"><a class="d-flex flex-center mb-4" href="../../../index.html"><img class="me-2" src="{{ asset('/img/FIUNI3.png') }}" width="150" height="150"/><span class="d-inline-block align-top"></span></a>
            <div class="card">
              <div class="card-body p-4 p-sm-5">
                <div class="row flex-between-center mb-2">
                  <div class="col-auto">
                    <h5>Ingresar</h5>
                  </div>
                </div>
                <form action="/login" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                @if ($errors->any())
                    <div class="alert alert-danger mt-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="mb-3">
                    <input class="form-control" name="email" type="email" placeholder="Correo" />
                  </div>
                  <div class="mb-3">
                    <input class="form-control"  name="password" type="password" placeholder="Contraseña" />
                  </div>
                  <div class="row flex-between-center">

                    <div class="col-auto"><a class="fs--1" href="#">Recuperar Contraseña?</a></div>
                  </div>
                  <div class="mb-3">
                    <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">Ingresar</button>
                  </div>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
@endsection
