<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Egresado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <form method="post" action="">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            <div class="mb-3">
                <input class="form-control" type="text" autocomplete="on" placeholder="Nombre" name="nombre" required/>
                <div class="invalid-feedback">
                    Campo Requerido.
                </div>
            </div>
            <div class="mb-3">
                <input class="form-control" type="text" autocomplete="on" placeholder="Apellido" name="apellido" required/>
                <div class="invalid-feedback">
                    Campo Requerido.
                </div>
            </div>
            <div class="mb-3">
                <input class="form-control" type="number" autocomplete="on" placeholder="C.I:" name="ci" required/>
                <div class="invalid-feedback">
                    Campo Requerido.
                </div>
            </div>
            <div class="mb-3">
                <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                    <option selected="">Seleccione Carrera</option>
                    @foreach ($carreras as $carrera)
                        <option value="{{ $carrera->id }}">{{ $carrera->carrera }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                    Campo Requerido.
                </div>
            </div>
            <div class="mb-3">
                <input class="form-control" type="email" autocomplete="on" placeholder="Correo" name="email" required/>
                <div class="invalid-feedback">
                    Campo Requerido.
                </div>
            </div>
            <div class="row gx-2">
                <div class="mb-3 col-sm-6">
                <input class="form-control" type="password" autocomplete="on" placeholder="Contraseña" name="password" required/>
                    <div class="invalid-feedback">
                        Campo Requerido.
                    </div>
                </div>
                <div class="mb-3 col-sm-6">
                <input class="form-control" type="password" autocomplete="on" placeholder="Confirmar Contraseña" name="password_confirmation"/>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
