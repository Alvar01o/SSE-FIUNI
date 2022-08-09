<!-- al guardar agregar otros para justificacion-->
<div id="seleccion_multiple_justificacion" class="tipo_pregunta col-9 m-auto d-none">
    <form method="POST" action="{{ '/encuestas/add_pregunta' }}" class="needs-validation" novalidate>
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <input type="hidden" name="encuesta_id" value="{{ $encuesta->id }}">
        <input type="hidden" name="tipo_pregunta" value="seleccion_multiple_justificacion">
        <div class="row">
            <div class="float-left col-6"><h2>Seleccion Multiple con justificacion</h2></div>
            <div class="float-right col-6 pt-3 requerido">
                <input class="float-right form-check-input" id="flexCheckDefault" name="requerido" type="checkbox"/>
                <label class="float-right form-check-label" for="flexCheckDefault">Requerido</label>
            </div>
        </div>
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
                    <input class="form-control" id="autoSizingInput" type="text" name="smj_opcion_agg" placeholder="Opcion" />
                </div>
                <div class="col-auto">
                    <button id="smj_add_btn" class="btn btn-primary" type="button">Agregar</button>
                </div>
                <a href="javascript:void(0)" onclick="validadorWizard.smj_agg_otro('smj_options_table')"><small>Añadir respuesta "Otro"</small></a>
            </div>
            <div class="table-responsive scrollbar">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Opcion</th>
                        <th scope="col">Accion</th>
                        <th class="text-end" scope="col">Justificacion</th>
                    </tr>
                </thead>
                <tbody id="smj_options_table">
                </tbody>
            </table>
            </div>
        </div>
    </div>
    </form>
</div>
