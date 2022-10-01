@extends('layouts.admin')
@section('content')
    <h1>Pagina Principal de admin</h1>
    <div class="row mt-4">
        <div class="col-xxl-3 col-md-6 col-lg-5">
            <div class="card shopping-cart-bar-min-height h-100">
            <div class="card-header d-flex flex-between-center">
                <h6 class="mb-0">Usuarios por carreras</h6>
            </div>
            <div class="card-body py-0 d-flex align-items-center h-100">
                <div class="flex-1">
                @foreach($carreras as $carrera)
                <div class="row g-0 align-items-center pb-3">
                    <div class="col pe-4">
                    <h6 class="fs--2 text-600">{{$carrera->carrera}}</h6>
                    <div class="progress" style="height:5px">
                        <div class="progress-bar rounded-3 bg-primary" role="progressbar" style="width: 50% " aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    </div>
                    <div class="col-auto text-end">
                    <p class="mb-0 fs--2 text-500 fw-semi-bold"> Usuarios: <span class="text-600">{{$carrera->usuariosCount()}}</span> </p>
                    </div>
                </div>
                @endforeach

                </div>
            </div>
            </div>
        </div>

    </div>
@endsection
