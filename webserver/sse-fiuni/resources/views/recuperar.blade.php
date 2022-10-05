@extends('layouts.basic')
@section('content')

    <main class="main" id="top">
      <div class="container col-5 min-vh-100" data-layout="container">
        <script>
          var isFluid = JSON.parse(localStorage.getItem('isFluid'));
          if (isFluid) {
            var container = document.querySelector('[data-layout]');
            container.classList.remove('container');
            container.classList.add('container-fluid');
          }
        </script>
        <div class="row flex-center py-6">
            <h1 class="my-5">Recuperar Cuenta</h1>
            @if ($errors->any())
                    <div class="alert alert-danger mt-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card mb-3 px-0">
                    <div class="card-header">
                    <h5 class="mb-0">¿No puedes iniciar sesión?</h5>
                    </div>
                    <div class="card-body bg-light">
                    <form class="row needs-validation" method="POST" action="/recuperar" novalidate>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="mb-3">
                            <input class="form-control" type="email" autocomplete="on" placeholder="Enviaremos un enlace de recuperación a" name="email" required/>
                            <div class="invalid-feedback">
                                Campo Requerido.
                            </div>
                        </div>
                        <div class="col-10">
                            <button class="btn btn-primary d-block" type="submit">Enviar enlace de recuperación</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </main>
@endsection
