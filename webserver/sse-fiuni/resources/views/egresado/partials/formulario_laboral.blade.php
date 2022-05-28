<form class="row">
    <div class="col-3 mb-3 text-lg-end">
        <label class="form-label" for="empresa">Empresa</label>
    </div>
    <div class="col-9 col-sm-7 mb-3">
        <input class="form-control form-control-sm" id="empresa" name="empresa" type="text" />
    </div>
    <div class="col-3 mb-3 text-lg-end">
        <label class="form-label" for="cargo">Cargo</label>
    </div>
    <div class="col-9 col-sm-7 mb-3">
        <input class="form-control form-control-sm" id="cargo" name="cargo" type="text" />
    </div>
    <div class="col-3 text-lg-end">
        <label class="form-label" for="experience-form2">Fecha Inicio </label>
    </div>
    <div class="col-9 col-sm-7 mb-3">
        <input class="form-control form-control-sm text-500 datetimepicker" id="experience-form2" name="inicio" type="text" placeholder="d/m/y" data-options='{"dateFormat":"d/m/y","disableMobile":true}' />
    </div>
    <div class="col-3 text-lg-end">
        <label class="form-label" for="experience-to">Hasta</label>
    </div>
    <div class="col-9 col-sm-7 mb-3">
        <input class="form-control form-control-sm text-500 datetimepicker" id="experience-to" type="text" name="fin" placeholder="d/m/y" data-options='{"dateFormat":"d/m/y","disableMobile":true}' />
    </div>
    <div class="border-dashed-bottom my-4">
    </div>
    <h5 class="py-4">Datos de Empleador <small>(Opcional)</small></h5>
    <div class="col-3 mb-3 text-lg-end">
        <label class="form-label" for="nombre">Nombre</label>
    </div>
    <div class="col-9 col-sm-7 mb-3">
        <input class="form-control form-control-sm" id="nombre" name="nombre" type="text" />
    </div>
    <div class="col-3 mb-3 text-lg-end">
        <label class="form-label" for="apellido">Apellido</label>
    </div>
    <div class="col-9 col-sm-7 mb-3">
        <input class="form-control form-control-sm" id="apellido" name="apellido" type="text" />
    </div>
    <div class="col-3 mb-3 text-lg-end">
        <label class="form-label" for="correo">Correo</label>
    </div>
    <div class="col-9 col-sm-7 mb-3">
        <input class="form-control form-control-sm" id="correo" name="correo" type="text" />
    </div>
    <div class="border-dashed-bottom my-4">
    </div>
    <div class="col-12 col-sm-12">
        <button class="btn btn-primary float-right" type="button">Guardar</button>
    </div>
</form>
