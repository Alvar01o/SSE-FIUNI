@extends('layouts.admin')
@section('content')
    <h1>Pagina Principal de Egresados</h1>
    <div>
        <div class="mt-5 card mb-3 mb-lg-0">
            <div class="card-header bg-light d-flex justify-content-between">
                <h5 class="mb-0">Encuestas Asignadas</h5>
            </div>
            <div class="card-body fs--1">
                <div class="row">
                @if(!count($user->getEncuestasAsignadas()))
                <h3>No se asignaron Encuestas aun.</h3>
                @endif
                @foreach ($user->getEncuestasAsignadas() as $index => $encuesta)
                <div class="col-md-6 h-100">
                    <div class="d-flex btn-reveal-trigger">
                    <div class="calendar"><span class="calendar-month"><?= date('M', strtotime($encuesta->created_at)); ?></span><span class="calendar-day"><?= date('d', strtotime($encuesta->created_at)); ?></span></div>
                    <div class="flex-1 position-relative ps-3">
                        <h6 class="fs-0 mb-0"><a href="/encuestas/completar/{{$encuesta->encuesta_id}}">{{$encuesta->nombre}}</a></h6>
                        <?php $status = $encuesta->encuesta->status($user, $encuesta->encuesta_id);?>
                        @if ($status['porcentaje'] == 100)
                            <span class="badge badge-soft-success rounded-pill">Completo</span>
                        @else
                            @if($status['porcentaje'])
                                <span class="badge badge-soft-warning rounded-pill">En Progreso</span>
                            @endif
                        @endif
                        <p class="text-1000 mb-0"><?= $encuesta->encuesta->preguntas->count()?> Preguntas</p>
                        <p class="text-1000 mb-0">Asignado el :</p><?= date('d/m/Y H:m:s', strtotime($encuesta->updated_at)); ?>
                        <div class="border-dashed-bottom my-3"></div>
                    </div>
                    </div>
                </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
