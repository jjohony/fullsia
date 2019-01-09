<?php
//var_dump($hora_extra);die;
?>
@extends('admin.templates.contenido')

@section('link')
<link href="{{url('')}}/assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="{{url('')}}/assets/plugins/DataTables/extensions/Buttons/css/buttons.bootstrap.min.css" rel="stylesheet" />
<link href="{{url('')}}/assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
@endsection

@section('content_contenido')
<!-- begin row -->
<div class="row">
    <!-- begin col-12 -->
    <div class="col-md-12">
      <!-- begin panel -->
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
            <h4 class="panel-title" id="titulo_formulario">Panel </h4>
        </div>
        <div class="panel-body">
                            
            <form >
                
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 form-group" style="">
                        <a href="{{url('')}}/pago_docente" class="btn btn-success btn-block">Volver</a>
                        <a href="{{url('')}}/pago_docente/reporte/{{$pago_docente->id}}" class="btn btn-success btn-block">Reporte</a>
                    </div>
                </div>
                
                <div class="col-md-4">
                  <img src="{{url('')}}/assets/img/user-1.jpg" class="img-responsive" alt="">
                </div>
                <div class="col-md-4">
                
                  <!-- begin col-2 -->                                
                  <div class="form-group">
                      <label class="col-md-12">Empleado:</label>
                      <div class="col-md-12">
                        <input type="text" value="{{$pago_docente->nombre." ".$pago_docente->paterno." ".$pago_docente->materno}}" class="form-control" disabled>
                      </div>

                  </div>
                  <!-- end col-2 --> 
                  <!-- begin col-2 -->                                
                  <div class="form-group">
                      <label class="col-md-12">Cargo:</label>
                      <div class="col-md-12">
                        <input type="text" value="{{$pago_docente->cargo}}" class="form-control" disabled>
                      </div>

                  </div>
                  <!-- end col-2 --> 
                  <!-- begin col-2 -->                                
                  <div class="form-group">
                      <label class="col-md-12">Unidad / Area:</label>
                      <div class="col-md-12">
                        <input type="text" value="{{$pago_docente->unidad_area}}" class="form-control" disabled>
                      </div>

                  </div>
                  <!-- end col-2 -->                        
                
                </div>

                <div class="col-md-4">
                
                  <!-- begin col-2 -->                                
                  <div class="form-group">
                      <label class="col-md-12">Documento:</label>
                      <div class="col-md-12">
                        <input type="text" value="{{$pago_docente->tipo_documento.": ".$pago_docente->numero_documento." ".$pago_docente->expedido}}" class="form-control" disabled>
                      </div>

                  </div>
                  <!-- end col-2 --> 
                  <!-- begin col-2 -->                                
                  <div class="form-group">
                      <label class="col-md-12">Fecha de Ingreso:</label>
                      <div class="col-md-12">
                        <input type="text" value="{{date('d-m-Y',strtotime($pago_docente->fecha_ingreso))}}" class="form-control" disabled>
                      </div>

                  </div>
                  <!-- end col-2 --> 
                  <!-- begin col-2 -->                                
                  <div class="form-group">
                      <label class="col-md-12">Numero de seguro de Salud:</label>
                      <div class="col-md-12">
                        <input type="text" value="{{$pago_docente->numero_seguro_salud}}" class="form-control" disabled>
                      </div>

                  </div>
                  <!-- end col-2 -->                        
                
                </div>
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th colspan="2">INGRESOS</th>
                          <th colspan="2">DESCUENTOS</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>DIAS TRABAJADOS</td>
                          <td><input type="text" class="form-control" value="{{$pago_docente->dias_trabajado}}" name="dias_trabajado" disabled></td>
                          <td>AFPS 10%</td>
                          <td><input type="text" class="form-control" value="{{$pago_docente->afp}}" name="afp" disabled></td>
                        </tr>
                        <tr>
                          <td>HABER BASICO</td>
                          <td><input type="text" class="form-control" value="{{$pago_docente->haber_basico}}" name="haber_basico" disabled></td>
                          <td>COMISION AFP 0.5%</td>
                          <td><input type="text" class="form-control" value="{{$pago_docente->comision_afp}}" name="comision_afp" disabled></td>
                        </tr>
                        <tr>
                          <td>BONO DE ANTIGUEDAD</td>
                          <td><input type="text" class="form-control" value="{{$pago_docente->bono_antiguedad}}" name="bono_antiguedad" disabled></td>
                          <td>FONDO SOLIDARIO 0.5%</td>
                          <td><input type="text" class="form-control" value="{{$pago_docente->fondo_solidario}}" name="fondo_solidario" disabled></td>
                        </tr>
                        <tr>
                          <td>HORAS EXTRAS</td>
                          <td><input type="text" class="form-control" value="{{$pago_docente->horas_extras}}" name="horas_extras" disabled></td>
                          <td>RIESGO COMUN 1.71%</td>
                          <td><input type="text" class="form-control" value="{{$pago_docente->riesgo_comun}}" name="riesgo_comun" disabled></td>
                        </tr>
                        <tr>
                          <td>OTROS</td>
                          <td><input type="text" class="form-control" value="{{$pago_docente->otros_ingresos}}" name="otros_ingresos" disabled></td>
                          <td>ANTICIPOS</td>
                          <td><input type="text" class="form-control" value="{{$pago_docente->anticipos}}" name="anticipos" disabled></td>
                        </tr>
                        <tr>
                          <td></td>
                          <td></td>
                          <td>OTROS</td>
                          <td><input type="text" class="form-control" value="{{$pago_docente->otros_descuentos}}" name="otros_descuentos" disabled></td>
                        </tr>
                        <tr>
                          <td>TOTAL</td>
                          <td><input type="text" class="form-control" value="{{$pago_docente->total_ingresos}}" name="total_ingresos" disabled></td>
                          <td>TOTAL</td>
                          <td><input type="text" class="form-control" value="{{$pago_docente->total_descuento}}" name="total_descuento" disabled></td>
                        </tr>
                        <tr>
                          <td colspan="2">TOTAL LIQUIDO PAGABLE</td>
                          
                          
                          <td><input type="text" class="form-control" value="{{$pago_docente->total_liquido_pagable}}" name="total_liquido_pagable" disabled></td>
                          <td>Bs</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                
                
            </form>
            
        </div>
    </div>
    <!-- end panel -->


       
    </div>
    <!-- end col-10 -->
</div>

<!-- Button trigger modal -->
<input id="input-modal-reporte" type="hidden" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modal-reporte">

<!-- Modal -->
<div class="modal fade" id="modal-reporte" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Reporte</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- end row -->
@endsection


@section("script_1")
<script src="{{url('')}}/assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
<script src="{{url('')}}/assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>

<script src="{{url('')}}/assets/plugins/DataTables/extensions/Buttons/js/dataTables.buttons.min.js"></script>

<script src="{{url('')}}/assets/plugins/DataTables/extensions/Buttons/js/buttons.bootstrap.min.js"></script>
<script src="{{url('')}}/assets/plugins/DataTables/extensions/Buttons/js/buttons.flash.min.js"></script>
<script src="{{url('')}}/assets/plugins/DataTables/extensions/Buttons/js/jszip.min.js"></script>
<script src="{{url('')}}/assets/plugins/DataTables/extensions/Buttons/js/pdfmake.min.js"></script>
<script src="{{url('')}}/assets/plugins/DataTables/extensions/Buttons/js/vfs_fonts.min.js"></script>
<script src="{{url('')}}/assets/plugins/DataTables/extensions/Buttons/js/buttons.html5.min.js"></script>
<script src="{{url('')}}/assets/plugins/DataTables/extensions/Buttons/js/buttons.print.min.js"></script>
<script src="{{url('')}}/assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
<script src="{{url('')}}/assets/js/table-manage-buttons.demo.min.js"></script>

<!-- ================== END PAGE LEVEL JS ================== -->


@endsection

@section("script_3")
<script>
    $(document).ready(function() {
        TableManageButtons.init();
    });
</script>
<script type="text/javascript">
    

</script>
@endsection