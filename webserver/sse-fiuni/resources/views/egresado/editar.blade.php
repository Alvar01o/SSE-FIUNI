@extends('layouts.admin')
@section('content')
<div class="container">
<div class="py-3">
    <h5 id="exampleModalLabel">Agregar Egresado</h5>
</div>
<form method="POST" action="/egresado" class="eliminarEgresadoForm d-inline needs-validation" novalidate>
    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
    <div class="mb-3">
        <input class="form-control" value="{{ $user->nombre }}" type="text" autocomplete="on" minlength="3" maxlength="30" placeholder="Nombre" name="nombre" required/>
        <div class="invalid-feedback">
            Campo Requerido.
        </div>
    </div>
    <div class="mb-3">
        <input class="form-control" value="{{ $user->apellido }}" type="text" autocomplete="on" minlength="3" maxlength="30" placeholder="Apellido" name="apellido" required/>
        <div class="invalid-feedback">
            Campo Requerido.
        </div>
    </div>
    <div class="mb-3">
        <input class="form-control" type="number" value="{{ $user->ci }}" pattern=".{6,10}" min="500000" max="3000000000" autocomplete="on" placeholder="C.I:" name="ci" required/>
        <div class="invalid-feedback">
            CI invalido, longitud requerida entre 6-10 caracteres.
        </div>
    </div>
    <div class="mb-3">
        <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="carrera_id" required>
            <option value="">Seleccione Carrera</option>
            @foreach ($carreras as $carrera)
                <option value="{{ $carrera->id }}" <?= ($user->carrera_id == $carrera->id) ? "selected='selected'": ''; ?> >{{ $carrera->carrera }}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            Campo Requerido.
        </div>
    </div>
    <div class="mb-3">
        <input class="form-control" type="email" autocomplete="on" minlength="7" value="{{ $user->email }}" maxlength="100" placeholder="Correo" name="email" required/>
        <div class="invalid-feedback">
            Campo Requerido.
        </div>
    </div>
    <div class="row gx-2">
        <div class="mb-3 col-sm-6">
            <input class="form-control" type="password" autocomplete="on" minlength="8" placeholder="Contraseña" name="password"/>
        </div>
        <div class="mb-3 col-sm-6">
            <input class="form-control" type="password" autocomplete="on" minlength="8" placeholder="Confirmar Contraseña" name="password_confirmation"/>
        </div>
    </div>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    <button type="submit" name="submit" class="btn btn-primary">Guardar</button>
</form>
</div>
@endsection
