@extends('layouts.admin')
@section('content')
<h1>Encuestas Asignadas</h1>
<div class="list-group">
@foreach ($encuestas as $encuesta)
    <a class="list-group-item list-group-item-action flex-column align-items-start p-3 p-sm-4" href="#">
        <div class="d-flex flex-column flex-sm-row justify-content-between mb-1 mb-md-0">
        <h5 class="mb-1">{{ $encuesta->nombre }}</h5><small class="text-muted">3 days ago</small>
        </div>
        <p class="mb-1">An ordered list typically is a numbered list of items. HTML 3.0 gives you the ability to control the sequence number - to continue where the previous list left off, or to start at a particular number.</p><small class="text-muted">An ordered list</small>
    </a>
@endforeach
 <!--   <a class="list-group-item list-group-item-action flex-column align-items-start p-3 p-sm-4 light active" href="#">
        <div class="d-flex flex-column flex-sm-row justify-content-between mb-1 mb-md-0">
        <h5 class="mb-1 text-white">List group · Bootstrap</h5><small>3 days ago</small>
        </div>
        <p class="mb-1">The most basic list group is an unordered list with list items and the proper classes. Build upon it with the options that follow, or with your own CSS as needed. </p><small> The most basic list group</small>
    </a>
-->
</div>
  @endsection
