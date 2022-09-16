@extends('layouts.admin')
@section('content')
<h1>Lista de Egresados</h1>
<div class="pt-5">
    <button class="btn btn-primary me-1 mb-1 float-right" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Agregar Egresado
    </button>
</div>
<div class="g-3 pt-3">
    <form method="GET" action="/egresado/lista" class="row">
        <div class="col-sm-5">
            <input class="form-control" type="text" name="name_email" placeholder="Nombre de usuario o email" aria-label="Nombre de usuario o email" />
        </div>
        <div class="col-sm-3">
            <select class="form-select" name="carrera_id" aria-label="Seleccione Carrera">
                <option value="">Seleccione Carrera</option>
                @foreach ($carreras as $carrera)
                    <option value="{{ $carrera->id }}">{{ $carrera->carrera }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm">
            <button class="btn btn-primary me-1 mb-1" type="submit">
                Filtrar
            </button>
        </div>
    </form>
</div>
@if ($errors->any())
    <div class="alert alert-danger mt-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="table-responsive scrollbar py-4">
  <table class="table table-hover table-striped overflow-hidden">
    <thead>
      <tr>
        <th scope="col">Nombre</th>
        <th scope="col">Apellido</th>
        <th scope="col">Correo</th>
        <th scope="col">C.I.</th>
        <th scope="col">Carrera</th>
        <th class="text-end" scope="col">Accion</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($egresados as $index => $user)
        <tr class="align-middle">
            <td class="text-nowrap">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-xl">
                        <img class="rounded-circle" src="{{ $user->getFirstMediaUrl('avatars', 'small_avatar') }}" alt="">
                    </div>
                    <div class="ms-2"><a href="/egresado/{{$user->id}}">{{ $user->getName() }}</a></div>
                </div>
            </td>
            <td class="text-nowrap">{{ $user->apellido }}</td>
            <td class="text-nowrap">{{ $user->getEmail() }}</td>
            <td class="text-nowrap">{{ $user->ci }}</td>
            <td class="text-nowrap">{{ $user->carrera ? $user->carrera->carrera : ''}}</td>
            <td class="text-nowrap">
                <a href="/egresado/{{$user->id}}/edit" data-index="{{$index}}" class="editBtn"><span class="fas fa-pencil-alt"></span></a>
                <form method="POST" action="/egresado/{{$user->id}}" class="eliminarEgresadoForm d-inline" id="deleteEgresadoBtn{{$user->id}}">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <span class="fas fa-trash-alt"></span>
                </form>
                <script>
                    jQuery(document).ready(
                        function(){
                            jQuery('#deleteEgresadoBtn{{$user->id}}').on('click',function() {
                                if (confirm('Seguro que desea elimimar el egresado?')) {
                                    jQuery('#deleteEgresadoBtn{{$user->id}}').submit()
                                }
                            })
                        }
                    )
                </script>
            </td>
        </tr>
    @endforeach
    </tbody>
  </table>
</div>
<div class=" d-flex justify-content-end">
    {{ $egresados->links('paginacion') }}
</div>
@include('egresado.partials.add_modal', ['carreras' => $carreras])
@endsection

