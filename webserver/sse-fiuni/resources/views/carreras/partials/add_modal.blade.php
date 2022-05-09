<!-- Modal -->
<div class="modal fade" id="addCarreraModal" tabindex="-1" aria-labelledby="addCarreraModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCarreraModalLabel">Agregar Carrera</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <form method="POST" action="/carreras" id="addCarreraForm" class="needs-validation" novalidate>
        <input type="hidden" name="_method" value="POST">
        <div class="modal-body">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" required/>
            <div class="mb-3">
                <input class="form-control" type="text" pattern=".{9,100}" minlength="9" maxlength="100" autocomplete="on" pattern=".{10,100}" placeholder="Nombre Carrera" name="carrera" required/>
                <div class="invalid-feedback">
                    Valor invalido, longitud requerida entre 9-100 caracteres.
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
        </form>
    </div>
  </div>
</div>
