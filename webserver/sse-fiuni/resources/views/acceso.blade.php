@extends('layouts.basic')
@section('content')

    <main class="main" id="top">
      <div class="container" data-layout="container">
<div class="col-lg-4 ps-lg-2 m-auto">
    <h1 class="my-5">Bienvenido {{ $user->getNombreCompleto(); }}!</h1>
    <div class="sticky-sidebar">
        @if ($errors->any())
            <div class="alert alert-danger mt-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card mb-3">
            <div class="card-header">
            <h5 class="mb-0">Establecer contraseña</h5>
            </div>
            <div class="card-body bg-light">
            <form class="row needs-validation" method="POST" action="/establecer/{{ $user->id }}" novalidate>
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="mb-3">
                <label class="form-label" for="password" name="password">Nueva Contraseña</label>
                <input class="form-control" id="password" minlength="8" name="password" type="password" required />
                <div class="invalid-feedback">
                    Campo Requerido.
                </div>
                </div>
                <div class="mb-3">
                <label class="form-label" for="password_confirmation" name="password_confirmation">Confirmar Contraseña</label>
                <input class="form-control" id="password_confirmation" minlength="8" name="password_confirmation" type="password" required />
                <div class="invalid-feedback">
                    Campo Requerido.
                </div>
                </div>
                <button class="btn btn-primary d-block w-100" type="submit">Actualizar  Contraseña</button>
            </form>
            </div>
        </div>
    </div>
</div>
</div>
</main>
@endsection

