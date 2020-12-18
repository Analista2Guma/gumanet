@extends('layouts.main')
@section('title' , $name)
@section('name_user' , 'Administrador')
@section('metodosjs')
  @include('jsViews.js_ventasProyectos');
@endsection
@section('content')
<div class="container-fluid"> 
  <div class="row">
    <div class="col-md-12">
      <h4 class="h4 mb-4">Ventas por Proyectos</h4>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-8">
              <h5 class="card-title">Comparar</h5>
              <div class="row">
                <div class="col-sm-4">
                  <div class="form-group">                    
                    <select class="form-control form-control-sm float-right d-block" id="cmbMes1">
                      <option value="all">Todos</option>
                      <?php
                        setlocale(LC_ALL, 'es_ES');
                        $mes = date("m");

                        for ($i= 1; $i <= 12 ; $i++) {
                          $dateObj   = DateTime::createFromFormat('!m', $i);
                          $monthName = strftime('%B', $dateObj->getTimestamp());

                          if ($i==$mes) {
                            echo'<option selected value="'.$i.'">'.$monthName.'</option>';
                          }else {
                            echo'<option value="'.$i.'">'.$monthName.'</option>';
                          }
                        }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-1 text-center mt-2 p-0 m-0">
                  <span class="text-muted mt-5">Contra</span>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <select class="form-control form-control-sm float-right d-block" id="cmbMes2">
                      <option value="all">Todos</option>
                      <?php
                        setlocale(LC_ALL, 'es_ES');
                        $mes = date("m");
                        for ($i= 1; $i <= 12 ; $i++) {
                          $dateObj   = DateTime::createFromFormat('!m', $i);
                          $monthName = strftime('%B', $dateObj->getTimestamp());

                          if ($i==$mes) {
                            echo'<option selected value="'.$i.'">'.$monthName.'</option>';
                          }else {
                            echo'<option value="'.$i.'">'.$monthName.'</option>';
                          }
                        }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">                    
                    <select class="form-control form-control-sm" id="cmbAnio">
                    <?php
                      $year = date("Y");
                      for ($i= 2018; $i <= $year ; $i++) {
                        if ($i==$year) {
                          echo'<option selected value="'.$i.'">'.$i.'</option>';
                        }else {
                          echo'<option value="'.$i.'">'.$i.'</option>';
                        }
                      }
                    ?>
                    </select> 
                  </div> 
                </div>
              </div>
            </div>
            <div class="col-sm-4 pt-2">
              <a href="#!" class="btn btn-primary mt-4 float-left" id="compararMeses">Aplicar</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12 bg-light mb-5">
      <div class="table-responsive mt-1 mb-2">
        <table id="tblVtsProyectos" class="table bg-light table-bordered table-striped table-hover mt-3" width="100%">
          <thead class="bg-blue text-light">
              <tr class="text-center">
                  <th rowspan="2">groupColumn</th>
                  <th rowspan="2">Nombre</th>
                  <th rowspan="2">Ruta</th>
                  <th rowspan="2">Zona</th>
                  <th rowspan="2">Crec. Actual</th>
                  <th colspan="3"><span id="lblMesActual">?</span></th>
                  <th colspan="3"><span id="lblMesAntero">?</span></th>
              </tr>
              <tr class="text-center">
                  <th><span class="lblAnioActual">?</span></th>
                  <th><span class="lblAnioAnteri">?</span></th>
                  <th>Crecimiento</th>
                  <th><span class="lblAnioActual"></span></th>
                  <th><span class="lblAnioAnteri"></span></th>
                  <th>Crecimiento</th>
              </tr>
          </thead>
          <tbody>
          </tbody>
           <tfoot>
                <tr>
                    <th colspan="5" style="text-align:right;">TOTALES: </th>
                    <th style="padding-right: 10px!important"></th>
                    <th style="padding-right: 10px!important"></th>
                    <th style="padding-right: 10px!important"></th>
                    <th style="padding-right: 10px!important"></th>
                    <th style="padding-right: 10px!important"></th>
                    <th style="padding-right: 10px!important"></th>

                </tr>
            </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection