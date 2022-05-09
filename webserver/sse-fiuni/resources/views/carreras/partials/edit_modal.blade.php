<!-- Modal -->
<div class="modal fade" id="editCarreraModal" tabindex="-1" aria-labelledby="editCarreraModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editCarreraModalLabel">Editar Carrera</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
    <form method="POST" id="editCarreraForm" action="" class="needs-validation" novalidate>
      <div class="modal-body">
          <input type="hidden" name="_method" value="PUT">
          <input type="hidden" name="id" value=""/>
          <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <div class="mb-3">
                <input class="form-control" type="text" pattern=".{9,100}" minlength="9" maxlength="100" autocomplete="on" placeholder="Nombre Carrera" name="carrera" required/>
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
<script>
    jQuery(document).ready(
        function(){
            jQuery('.editBtn').on('click', function(elem) {
                let element = jQuery(elem.currentTarget);
                let index = element.attr('data-index');
                carrera = carreras[index];
                jQuery('#editCarreraModal').modal('show')
                jQuery('#editCarreraModal').find('input[name="carrera"]').val(carreras[index].carrera)
                jQuery('#editCarreraModal').find('input[name="id"]').val(carreras[index].id)
                jQuery('#editCarreraForm').attr('action','/carreras/'+carreras[index].id);
                jQuery('#myModal').modal('hide')
            })
        }
    )
</script>
</div>
