@extends('layouts.admin')
@section('content')
<h1 class="pb-4">Encuestas Asignadas</h1>
<div class="row">
            <div class="col">
              <div class="card overflow-hidden">
                <div class="card-header d-flex flex-between-center bg-light py-2">
                  <h6 class="mb-0">Encuestas Asignadas</h6>
                </div>
                <div class="card-body py-0">
                  <div class="table-responsive scrollbar">
                    <table class="table table-dashboard mb-0 fs--1">
                      <tbody>
                        @foreach ($encuestas as $encuesta)
                        <tr>
                        <td class="align-middle ps-0 text-nowrap">
                          <div class="d-flex position-relative align-items-center"><img class="d-flex align-self-center me-2" src="../assets/img/logos/atlassian.png" alt="" width="30">
                            <div class="flex-1"><a class="stretched-link" href="/encuestas/completar/{{ $encuesta->encuesta_id }}">
                                <h6 class="mb-0">{{ $encuesta->nombre }}</h6>
                              </a>
                              <p class="mb-0">Asignado el {{ date('d-m-Y', strtotime($encuesta->created_at))}}</p>
                            </div>
                          </div>
                        </td>
                        <td class="align-start">
                        <?php $status = $encuesta->status($user, $encuesta->encuesta_id);?>
                            @if ($status['porcentaje'] == 0)
                            <div class="progress" style="height:30px">
                                <div class="progress-bar bg-info " role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?= $status['status']; ?>
                                </div>
                            </div>
                            @else
                                @if ($status['porcentaje'] == 100)
                                    <div class="progress" style="height:30px">
                                        <div class="progress-bar bg-success " role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?= $status['status']; ?>
                                        </div>
                                    </div>
                                @else
                                    <div class="progress" style="height:30px">
                                        <div class="progress-bar bg-warning " role="progressbar" style="width: <?= round($status['porcentaje']); ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?= round($status['porcentaje']); ?>% <?= $status['status']; ?>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </td>
                        <td class="align-middle ps-4 pe-1" style="width: 130px; min-width: 130px;">
                            <a class="btn btn-link btn-sm px-0 fw-medium" href="/encuestas/completar/{{ $encuesta->encuesta_id }}">Acceder<svg class="svg-inline--fa fa-chevron-right fa-w-10 ms-1 fs--2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"></path></svg><!-- <span class="fas fa-chevron-right ms-1 fs--2"></span> Font Awesome fontawesome.com --></a>
                        </td>
                            </a>
                        @endforeach
                      </tr>

                    </tbody></table>
                  </div>
                </div>

              </div>
            </div>
          </div>
  @endsection
