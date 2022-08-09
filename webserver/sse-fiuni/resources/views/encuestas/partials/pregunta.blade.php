<div id="pregunta" class="tipo_pregunta col-9 m-auto d-none">
    <form method="POST" action="{{ '/encuestas/add_pregunta' }}" class="needs-validation" novalidate>
        <div class="row">
            <div class="float-left col-6"><h2>Pregunta Simple</h2></div>
            <div class="float-right col-6 pt-3 requerido">
                <input class="float-right form-check-input" id="flexCheckDefault" name="requerido" type="checkbox"/>
                <label class="float-right form-check-label" for="flexCheckDefault">Requerido</label>
            </div>
        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <input type="hidden" name="encuesta_id" value="{{ $encuesta->id }}">
        <input type="hidden" name="tipo_pregunta" value="pregunta">
        <div class="mb-3 ">
            <label class="form-label" for="pregunta_simple1">Titulo de Pregunta</label>
            <input class="form-control" id="pregunta_simple1" name="pregunta" type="text" placeholder="Ingrese titulo de la pregunta" required/>
            <div class="invalid-feedback">
                Campo Requerido.
            </div>
        </div>
    </form>
</div>
