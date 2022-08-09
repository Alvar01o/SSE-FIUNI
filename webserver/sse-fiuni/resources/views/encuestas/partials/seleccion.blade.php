<div id="seleccion" class="tipo_pregunta col-9 m-auto d-none">
    <form method="POST" action="{{ '/encuestas/add_pregunta' }}" class="needs-validation" novalidate>
        <div class="row">
            <div class="float-left col-6"><h2>Seleccion Simple</h2></div>
            <div class="float-right col-6 pt-3 requerido">
                <input class="float-right form-check-input" id="flexCheckDefault" name="requerido" type="checkbox"/>
                <label class="float-right form-check-label" for="flexCheckDefault">Requerido</label>
            </div>
        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <input type="hidden" name="encuesta_id" value="{{ $encuesta->id }}">
        <input type="hidden" name="tipo_pregunta" value="seleccion">
        <div class="mb-4">
            <label class="form-label" for="pregunta_simple1">Titulo de Pregunta</label>
            <input class="form-control" id="pregunta_simple1" name="pregunta" type="text" placeholder="Ingrese titulo de la pregunta" required/>
            <div class="invalid-feedback">
                Campo Requerido.
            </div>
        </div>
    <div class="mb-3">
        <div class="col-6">
            <h5>Agregar Opciones</h5>
            <div class="row gy-2 py-4 gx-3 align-items-center">
            <div class="col-auto">
                <input class="form-control" id="autoSizingInput" type="text" name="ss_opcion_agg" placeholder="Opcion" />
            </div>
            <div class="col-auto">
                <button id="ss_add_btn" class="btn btn-primary" type="button">Agregar</button>
            </div>
            </div>
            <div class="table-responsive scrollbar">
            <table class="table">
                <tbody id="ss_options_table">
                </tbody>
            </table>
            </div>
        </div>
    </div>
    </form>
</div>
