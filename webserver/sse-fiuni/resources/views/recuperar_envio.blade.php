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
        <div class="row flex-center min-vh-100 py-6 text-center">
          <div class="col-sm-10 col-md-8 col-lg-6 col-xxl-5"><a class="d-flex flex-center mb-4" href="/"><img class="me-2" src="../../assets/img/icons/spot-illustrations/falcon.png" alt="" width="58" /><span class="font-sans-serif fw-bolder fs-5 d-inline-block">Sistema de Seguimiento de Egresados</span></a>
            <div class="card">
              <div class="card-body p-4 p-sm-5">
                <p class="lead mt-4 text-800 font-sans-serif fw-semi-bold">Enlace para reestablecer la contraseña sera enviado en breve a su correo.</p>
                <hr />
                <p class="lead mt-4 text-800 font-sans-serif fw-semi-bold">Revise su bandeja de entrada. {{substr_replace($user->email, '*******', -10, 10)}}</p>
                </div>
            </div>
          </div>
        </div>
      </div>
    </main>
@endsection
