@extends('layouts.admin')
@section('content')
<h1>Lista de Carreras</h1>
<div class="pt-5">
<button class="btn btn-primary me-1 mb-1 float-right" type="button" data-bs-toggle="modal" data-bs-target="#addCarreraModal">Agregar Carrera
</button>
</div>
<div class="table-responsive scrollbar py-4">
<script>
    var carreras = [];
    @foreach ($carreras as $index => $carrera)
        carreras.push({id:'{{$carrera->id}}', carrera: '{{$carrera->carrera}}' });
    @endforeach
</script>
<table class="table table-hover table-striped overflow-hidden">
    <thead>
      <tr>
        <th scope="col">Carrera</th>
        <th class="text-end" scope="col">Accion</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($carreras as $index => $carrera)
        <tr class="align-middle">
            <td class="text-nowrap">
                <div class="d-flex align-items-center">
                    <div class="ms-2">{{ $carrera->carrera }}</div>
                </div>
            </td>
            <td class="text-end">
                <a href="#" data-index="{{$index}}" class="editBtn"><span class="fas fa-pencil-alt"></span></a>
                <form method="POST" action="/carreras/destroy/{{$carrera->id}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <span id="deleteCarreraBtn{{$carrera->id}}" class="fas fa-trash-alt"></span>
                </form>
                <script>
                    jQuery(document).ready(
                        function(){
                            jQuery('#deleteCarreraBtn{{$carrera->id}}').on('click',function() {
                                jQuery('#deleteCarreraBtn{{$carrera->id}}').parent().submit()
                            })
                        }
                    )
                </script>
            </td>
        </tr>
    @endforeach

    </tbody>
  </table>
</div>

<nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>
    <li class="page-item active"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>
  </ul>
</nav>

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
@endsection
