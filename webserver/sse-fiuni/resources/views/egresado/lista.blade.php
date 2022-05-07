@extends('layouts.admin')
@section('content')
<h1>Lista de Egresados</h1>
<div class="pt-5">
    <button class="btn btn-primary me-1 mb-1 float-right" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Agregar Egresado
    </button>
</div>
<div class="table-responsive scrollbar py-4">
  <table class="table table-hover table-striped overflow-hidden">
    <thead>
      <tr>
        <th scope="col">Nombre</th>
        <th scope="col">Apellido</th>
        <th scope="col">Correo</th>
        <th scope="col">Carrera</th>
        <th class="text-end" scope="col">Accion</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($egresados as $user)
        <tr class="align-middle">
            <td class="text-nowrap">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-xl">
                    <div class="avatar-name rounded-circle"><span>{{ $user->getIniciales()}}</span></div>
                    </div>
                    <div class="ms-2">{{ $user->getName() }}</div>
                </div>
            </td>
            <td class="text-nowrap"> {{ $user->apellido }} </td>
            <td class="text-nowrap">{{ $user->getEmail() }}</td>
            <td class="text-nowrap">{{ $user->carrera->carrera }}</td>
            <td class="text-nowrap"> - </td>
        </tr>
    @endforeach

    </tbody>
  </table>
</div>

<nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>
    <li class="page-item active"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>
  </ul>
</nav>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Egresado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <form method="post" action="">
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
                <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                    <option selected="">Seleccione Carrera</option>
                    @foreach ($carreras as $carrera)
                        <option value="{{ $carrera->id }}">{{ $carrera->carrera }}</option>
                    @endforeach
                </select>
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
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
@endsection

