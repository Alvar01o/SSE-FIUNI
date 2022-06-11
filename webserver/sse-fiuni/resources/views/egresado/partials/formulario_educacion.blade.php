<form class="row needs-validation" method="POST" action="/egresado/educacion/{{ $user->id }}" novalidate>
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class="col-3 mb-3 text-lg-end">
        <label class="form-label" for="institucion">Institucion</label>
    </div>
    <div class="col-9 col-sm-7 mb-3">
        <input class="form-control form-control-sm" id="institucion" name="institucion" type="text"  minlength="2" maxlength="250" required/>
        <div class="invalid-feedback">
            Campo Requerido.
        </div>
    </div>
    <div class="col-3 mb-3 text-lg-end">
        <label class="form-label" for="certificacion">Certificación</label>
    </div>
    <div class="col-9 col-sm-7 mb-3">
        <input class="form-control form-control-sm" id="titulo" name="titulo" type="text" minlength="2" maxlength="250" required/>
        <div class="invalid-feedback">
            Campo Requerido.
        </div>
    </div>
    <div class="col-3 text-lg-end">
        <label class="form-label" for="experience-form2">Fecha Inicio </label>
    </div>
    <div class="col-9 col-sm-7 mb-3">
    <input class="form-control form-control-sm text-500 datetimepicker" id="educacion_inicio" name="inicio" type="date" placeholder="d/m/y" data-options='{"dateFormat":"d/m/y","disableMobile":true}' required/>
        <div class="invalid-feedback">
            Campo Requerido.
        </div>
    </div>
    <div class="col-3 text-lg-end">
        <label class="form-label" for="experience-to">Hasta</label>
    </div>
    <div class="col-9 col-sm-7 mb-3">
        <input class="form-control form-control-sm text-500 datetimepicker" id="educacion_fin" type="date" name="fin" placeholder="d/m/y" data-options='{"dateFormat":"d/m/y","disableMobile":true}' />
        <div class="invalid-feedback">
            Campo Requerido.
        </div>
    </div>
    <div class="border-dashed-bottom my-4">
    </div>
    <div class="col-9 col-sm-7 offset-3">
        <button class="btn btn-primary" type="submit">Guardar</button>
    </div>
</form>
