<!-- Modal -->
<div class="modal fade" id="addCarreraModal" tabindex="-1" aria-labelledby="addCarreraModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCarreraModalLabel">Agregar Carrera</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <form method="post" action="/carreras/store">
        <div class="modal-body">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="mb-3">
                    <input class="form-control" type="text" autocomplete="on" placeholder="Nombre Carrera" name="carrera" required/>
                    <div class="invalid-feedback">
                        Campo Requerido.
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
