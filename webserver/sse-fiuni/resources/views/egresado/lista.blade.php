@extends('layouts.admin')
@section('content')
<h1>Lista de Egresados</h1>
<div class="pt-5">
    <button class="btn btn-primary me-1 mb-1 float-right" type="button">Agregar Egresado
    </button>
</div>
<div class="table-responsive scrollbar py-4">
  <table class="table table-hover table-striped overflow-hidden">
    <thead>
      <tr>
        <th scope="col">Nombre</th>
        <th scope="col">Correo</th>
        <th scope="col">Carrera</th>
        <th scope="col"> - </th>
        <th scope="col"> - </th>
        <th class="text-end" scope="col"> - </th>
      </tr>
    </thead>
    <tbody>
    @foreach ($egresados as $user)
        <tr class="align-middle">
            <td class="text-nowrap">
            <div class="d-flex align-items-center">
                <div class="avatar avatar-xl">
                <div class="avatar-name rounded-circle"><span>RA</span></div>
                </div>
                <div class="ms-2">{{ $user->getName() }}</div>
            </div>
            </td>
            <td class="text-nowrap">{{ $user->getEmail() }}</td>
            <td class="text-nowrap"> - </td>
            <td class="text-nowrap"> - </td>
            <td><span class="badge badge rounded-pill d-block p-2 badge-soft-primary"> - <span class="ms-1 fas fa-redo" data-fa-transform="shrink-2"></span></span>
            </td>
            <td class="text-end"> - </td>
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

@endsection

