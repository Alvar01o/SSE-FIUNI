<form class="row needs-validation" method="POST" action="/egresado/laboral/{{ $user->id }}" novalidate>
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class="col-3 mb-3 text-lg-end">
        <label class="form-label" for="empresa">Empresa</label>
    </div>
    <div class="col-9 col-sm-7 mb-3">
        <input class="form-control form-control-sm" id="empresa" minlength="2" maxlength="100" name="empresa" type="typehead" required/>
        <div class="invalid-feedback">
            Campo Requerido.
        </div>
    </div>
    <div class="col-3 mb-3 text-lg-end">
        <label class="form-label" for="cargo">Cargo</label>
    </div>
    <div class="col-9 col-sm-7 mb-3">
        <input class="form-control form-control-sm" id="cargo" minlength="2" maxlength="100" name="cargo" type="text" required/>
        <div class="invalid-feedback">
            Campo Requerido.
        </div>
    </div>
    <div class="col-3 text-lg-end">
        <label class="form-label" for="experience-form2">Fecha Inicio </label>
    </div>
    <div class="col-9 col-sm-7 mb-3">
        <input class="form-control form-control-sm text-500 datetimepicker" id="experience-form2" name="inicio" type="date" placeholder="d/m/y" data-options='{"dateFormat":"d/m/y","disableMobile":true}' required/>
        <div class="invalid-feedback">
            Campo Requerido.
        </div>
    </div>
    <div class="col-3 text-lg-end">
        <label class="form-label" for="experience-to">Hasta</label>
    </div>
    <div class="col-9 col-sm-7 mb-3">
        <input class="form-control form-control-sm text-500 datetimepicker" id="experience-to" type="date" name="fin" placeholder="d/m/y" data-options='{"dateFormat":"d/m/y","disableMobile":true}' />
        <div class="invalid-feedback">
            Campo Requerido.
        </div>
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
        <label class="form-label" for=" ">Correo</label>
    </div>
    <div class="col-9 col-sm-7 mb-3">
        <input class="form-control form-control-sm" id="email" name="email" type="text" />
    </div>
    <div class="border-dashed-bottom my-4">
    </div>
    <div class="col-12 col-sm-12">
        <button class="btn btn-primary float-right" type="submit">Guardar</button>
    </div>
</form>
<script>
var empresas = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  remote: {
    url: '/empleadores/json/'+ $('#empresa').val(),
    wildcard: '%QUERY',

  }
});
$('#empresa').typeahead({
        hint: true,
        highlight: true,
        minLength: 1,
        async:true
    }, {
  name: 'empresas',
  display: 'empresa',
  source: empresas,
  async:true
});
</script>
