@extends('layouts.admin')
@section('content')
<h1>Lista de Egresados</h1>
<div class="pt-5">
    <button class="btn btn-primary me-1 mb-1 float-right" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Agregar Egresado
    </button>
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
                    <div class="avatar-name rounded-circle"><span>{{ $user->getIniciales()}}</span></div>
                    </div>
                    <div class="ms-2">{{ $user->getName() }}</div>
                </div>
            </td>
            <td class="text-nowrap">{{ $user->apellido }}</td>
            <td class="text-nowrap">{{ $user->getEmail() }}</td>
            <td class="text-nowrap">{{ $user->ci }}</td>
            <td class="text-nowrap">{{ $user->carrera->carrera }}</td>
            <td class="text-nowrap">
                <a href="/egresado/{{$user->id}}/edit" data-index="{{$index}}" class="editBtn"><span class="fas fa-pencil-alt"></span></a>
                <form method="POST" action="/egresado/{{$user->id}}" class="eliminarEgresadoForm d-inline">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <span id="deleteEgresadoBtn{{$user->id}}" class="fas fa-trash-alt"></span>
                </form>
                <script>
                    jQuery(document).ready(
                        function(){
                            jQuery('#deleteEgresadoBtn{{$user->id}}').on('click',function() {
                                jQuery('#deleteEgresadoBtn{{$user->id}}').parent().submit()
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
@include('paginacion')
@include('egresado.partials.add_modal', ['carreras' => $carreras])
@endsection

