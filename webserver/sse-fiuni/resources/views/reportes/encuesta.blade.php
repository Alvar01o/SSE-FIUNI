@extends('layouts.admin')
@section('content')
<h1>Reportes de preguntas en la encuesta: </h1>
<h3>{{$encuesta->nombre}}</h3>


<div class="list-group mt-5">
@foreach($encuesta->preguntas as $pregunta)
<a href="#" class="list-group-item list-group-item-action trigger-chart" data-id="{{$pregunta->id}}" data-bs-toggle="modal" data-bs-target="#report_pregunta" aria-current="true">
    <div class="d-flex w-100 justify-content-between">
         <h5 class="mb-1">{{$pregunta->pregunta}}</h5>
    </div>
    <small>{{ $pregunta->getTipoText()}}</small>
</a>
@endforeach
<div class="modal fade" id="report_pregunta" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width: 650px">
    <div class="modal-content position-relative">
      <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
        <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
          <h4 class="mb-1" id="modalExampleDemoLabel">Reporte de Pregunta</h4>
        </div>
        <div class="py-4 pb-0">
            <div id="grafico_pregunta" style="width: 650px;height:400px;" class="text-center">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>
<script>
    jQuery(document).ready(function(){
        jQuery('#report_pregunta').on('hidden.bs.modal', function() {
            echarts.dispose(document.getElementById('grafico_pregunta'))
        })
        jQuery('.trigger-chart').on('click', function(e) {
            let id = jQuery(e.currentTarget).attr('data-id')
            jQuery('#grafico_pregunta').html(`
            <div class="spinner-grow" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>`)
            jQuery.ajax({
                method: "get",
                url: "/reporte_pregunta/" + id
            }).done(function(response) {
                jQuery('#grafico_pregunta').html();
                var myChart = echarts.init(document.getElementById('grafico_pregunta'));
                if (response.tipo !== 'pregunta') {
                    let keys = Object.keys(response.opciones);
                    let values = Object.values(response.opciones);
                    let data = []
                    keys.forEach(function(element, key) {
                        data.push({name:keys[key], value:values[key]})
                    });
                        var option = {
                            title: {
                                text: response.titulo,
                                subtext: 'Resumen de Datos',
                                left: 'center'
                            },
                            tooltip: {
                                trigger: 'item'
                            },
                            legend: {
                                orient: 'horizontal',
                                top : '50'
                            },
                            series: [
                                {
                                name: 'Reporte de Respuestas',
                                type: 'pie',
                                radius: '50%',
                                data: data,
                                emphasis: {
                                    itemStyle: {
                                    shadowBlur: 10,
                                    shadowOffsetX: 0,
                                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                                    }
                                }
                                }
                            ]
                            };
                } else {
                    option = {
                    dataset: {
                        source: [
                        ['score', 'Cantidad Respuestas', 'pregunta'],
                        [response.respuestas , response.respuestas, response.titulo],
                        ]
                    },
                    grid: { containLabel: true },
                    xAxis: { name: 'Respuestas', nameLocation:'middle', nameTextStyle: {
                        lineHeight : 40
                    } },
                    yAxis: { type: 'category' },

                    series: [
                        {
                        type: 'bar',
                        encode: {
                            x: 'Respuestas',
                            y: 'pregunta'
                        }
                        }
                    ]
                    };
                }
                myChart.setOption(option);
            });
        })
    })
</script>

</div>
@endsection
