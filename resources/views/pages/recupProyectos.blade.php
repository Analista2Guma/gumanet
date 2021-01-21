@extends('layouts.main')
@section('title' , $name)
@section('name_user' , 'Administrador')
@section('metodosjs')
  @include('jsViews.js_recupProyectos');
@endsection
@section('content')
<div class="container-fluid"> 
  <div class="row">
    <div class="col-md-12">
      <h4 class="h4 mb-4">Recuperación por Proyectos</h4>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-8">
              <h5 class="card-title">Comparar</h5>
               <p class="font-italic text-muted pt-0 mt-0">Devuelve los registros comparandolos con un mes y un año anterior</p>
              <div class="row">
                <div class="col-sm-4">
                  <div class="form-group">                    
                    <select class="form-control form-control-sm float-right d-block" id="cmbMes1">
                      <option value="all">Todos</option>
                      <?php
                        $mes = date("m");
                        $meses = array('none','enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');

                        for ($i= 1; $i <= 12 ; $i++) {
                          if ($i==$mes) {
                            echo'<option selected value="'.$i.'">'.$meses[$i].'</option>';
                          }else {
                            echo'<option value="'.$i.'">'.$meses[$i].'</option>';
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
                <div class="col-sm-4">
                  <a href="#!" class="btn btn-primary float-left" id="compararMeses">Aplicar</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12 bg-light mb-5">
      <div class="table-responsive mt-1 mb-2">
        <table id="tblRecupProyectos" class="table bg-light table-bordered table-striped table-hover mt-3" width="100%">
          <thead class="bg-blue text-light">
              <tr class="text-center">
                  <th rowspan="2">groupColumn</th>
                  <th rowspan="2">NOMBRE</th>
                  <th rowspan="2">RUTA</th>
                  <th rowspan="2">ZONA</th>
                  <th colspan="3"><span>MES ACTUAL VS ANTERIOR</span></th>
                  <th colspan="3"><span id="lblMesActual">?</span></th>
                  {{-- <th colspan="3"><span id="lblMesAntero">?</span></th> --}}
              </tr>
              <tr>
                  <th class="text-center"><span id="lblMesActual_">?</span></th>
                  <th class="text-center"><span id="lblMesAnteri_">?</span></th>
                  <th class="text-center">%</th>
                  <th class="text-center"><span class="lblAnioActual">?</span></th>
                  <th class="text-center"><span class="lblAnioAnteri">?</span></th>
                  <th class="text-center">%</th>
                  {{-- <th class="text-center"><span class="lblAnioActual"></span></th>
                  <th class="text-center"><span class="lblAnioAnteri"></span></th>
                  <th class="text-center">%</th> --}}
              </tr>
          </thead>
          <tbody>
          </tbody>
           <tfoot>
                <tr>
                    <th colspan="4" style="text-align:right;">TOTALES: </th>
                    <th style="padding-right: 10px!important"></th>
                    <th style="padding-right: 10px!important"></th>
                    <th style="padding-right: 10px!important"></th>
                    <th style="padding-right: 10px!important"></th>
                    <th style="padding-right: 10px!important"></th>
                    <th style="padding-right: 10px!important"></th>
                    {{-- <th style="padding-right: 10px!important"></th>
                    <th style="padding-right: 10px!important"></th>
                    <th style="padding-right: 10px!important"></th> --}}
                </tr>
            </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection