@extends('layouts.admin')
@section('content')
<h1>Lista de Carreras</h1>
<div class="pt-5">
<button class="btn btn-primary me-1 mb-1 float-right" type="button" data-bs-toggle="modal" data-bs-target="#addCarreraModal">Agregar Carrera
</button>
</div>
<div class="table-responsive scrollbar py-4">
<script>
    var carreras = [];
    @foreach ($carreras as $index => $carrera)
        carreras.push({id:'{{$carrera->id}}', carrera: '{{$carrera->carrera}}' });
    @endforeach
</script>
@if ($errors->any())
    <div class="alert alert-danger mt-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<table class="table table-hover table-striped overflow-hidden">
    <thead>
      <tr>
        <th scope="col">Carrera</th>
        <th class="text-end" scope="col">Accion</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($carreras as $index => $carrera)
        <tr class="align-middle">
            <td class="text-nowrap">
                <div class="d-flex align-items-center">
                    <div class="ms-2">{{ $carrera->carrera }}</div>
                </div>
            </td>
            <td class="text-end">
                <a href="#" data-index="{{$index}}" class="editBtn"><span class="fas fa-pencil-alt"></span></a>
                <form method="POST" action="/carreras/{{$carrera->id}}" class="eliminarCarreraForm d-inline">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <span id="deleteCarreraBtn{{$carrera->id}}" class="fas fa-trash-alt"></span>
                </form>
                <script>
                    jQuery(document).ready(
                        function(){
                            jQuery('#deleteCarreraBtn{{$carrera->id}}').on('click',function() {
                                jQuery('#deleteCarreraBtn{{$carrera->id}}').parent().submit()
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
@include('carreras.partials.add_modal')
@include('carreras.partials.edit_modal')
@endsection
