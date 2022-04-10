@extends('layouts.basic')
@section('content')
<div class="col-12 row justify-content-center">
    <h2 class="text-center py-5">Sistema de Seguimiento de Egresados</h2>
        <form class="login_form p-5 shadow col-5" action="/login" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="justify-content-center login_img">
                <img class="" src="https://i0.wp.com/www.fiuni.edu.py/wp-content/uploads/2021/08/logonuevo.jpeg?w=512&ssl=1" width="200" height="200">
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
            <div class="form-group py-3">
                <label for="exampleInputEmail1">Correo</label>
                <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp">
            </div>
            <div class="form-group  py-3">
                <label for="exampleInputPassword1">Contraseña</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Ingresar</button>
        </form>
</div>
@endsection
