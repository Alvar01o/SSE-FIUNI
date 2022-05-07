<!-- Modal -->
<div class="modal fade" id="editCarreraModal" tabindex="-1" aria-labelledby="editCarreraModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editCarreraModalLabel">Editar Carrera</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
    <form method="PUT" id="editCarreraForm" action="">
      <div class="modal-body">

          <input type="hidden" name="id" value=""/>
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
<script>
    jQuery(document).ready(
        function(){
            jQuery('.editBtn').on('click', function(elem) {
                let element = jQuery(elem.currentTarget);
                let index = element.attr('data-index');
                carrera = carreras[index];
                console.log(carreras[index]);
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
