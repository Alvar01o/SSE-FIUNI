<!-- Modal -->
<div class="modal fade" id="addencuestaModal" tabindex="-1" aria-labelledby="addencuestaModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addencuestaModalLabel">Agregar Encuesta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <form method="POST" action="/encuestas" id="addencuestaForm" class="needs-validation" novalidate>
        <input type="hidden" name="_method" value="POST">
        <div class="modal-body">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" required/>
                <div class="mb-3">
                    <div class="form-floating">
                        <select class="form-select"  name="tipo" id="selectTipo" aria-label="Floating label select example">
                            <option value="egresado">Egresado</option>
                            <option value="empleador">Empleador</option>
                        </select>
                        <label for="selectTipo">Tipo de Encuesta</label>
                    </div>
                </div>
            <div class="mb-3">
            <div class="form-floating mb-3">
                <input class="form-control" minlength="3" maxlength="100" autocomplete="on"  placeholder="Nombre encuesta" name="nombre" required />
                <label for="floatingInputValid">Nombre de Encuesta</label>
                <div class="invalid-feedback">
                Valor invalido, longitud requerida entre 9-100 caracteres.
                </div>
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
