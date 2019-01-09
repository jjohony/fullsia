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
                            
            <form action="{{url('')}}/pago_administrativo" method="post" accept-charset="utf-8" id="formulario">
                {{csrf_field()}}
                
                <input type="hidden" value="{{$contrato->id}}" name="id_contrato_administrativo">
                <input type="hidden" value="{{$mes}}" name="mes">
                <input type="hidden" value="{{$anio}}" name="anio">
                <div class="col-md-4">
                  <?php 
                  if($contrato->foto_imagen=="")
                  {
                      $imagen=url('')."/assets/img/persona.png";    
                  }
                  else{
                      $imagen=url('')."/img/".$contrato->foto_imagen;    
                  }
                  ?>
                  <img src="{{$imagen}}" class="img-responsive" alt="">
                </div>
                <div class="col-md-4">
                
                  <!-- begin col-2 -->                                
                  <div class="form-group">
                      <label class="col-md-12">Empleado:</label>
                      <div class="col-md-12">
                        <input type="text" value="{{$contrato->nombre." ".$contrato->paterno." ".$contrato->materno}}" class="form-control" disabled>
                      </div>

                  </div>
                  <!-- end col-2 --> 
                  <!-- begin col-2 -->                                
                  <div class="form-group">
                      <label class="col-md-12">Cargo:</label>
                      <div class="col-md-12">
                        <input type="text" value="{{$contrato->cargo}}" class="form-control" disabled>
                      </div>

                  </div>
                  <!-- end col-2 --> 
                  <!-- begin col-2 -->                                
                  <div class="form-group">
                      <label class="col-md-12">Unidad / Area:</label>
                      <div class="col-md-12">
                        <input type="text" value="{{$contrato->unidad_area}}" class="form-control" disabled>
                      </div>

                  </div>
                  <!-- end col-2 -->                        
                
                </div>

                <div class="col-md-4">
                
                  <!-- begin col-2 -->                                
                  <div class="form-group">
                      <label class="col-md-12">Documento:</label>
                      <div class="col-md-12">
                        <input type="text" value="{{$contrato->tipo_documento.": ".$contrato->numero_documento." ".$contrato->expedido}}" class="form-control" disabled>
                      </div>

                  </div>
                  <!-- end col-2 --> 
                  <!-- begin col-2 -->                                
                  <div class="form-group">
                      <label class="col-md-12">Fecha de Ingreso:</label>
                      <div class="col-md-12">
                        <input type="text" value="{{date('d-m-Y',strtotime($contrato->fecha_ingreso))}}" class="form-control" disabled>
                      </div>

                  </div>
                  <!-- end col-2 --> 
                  <!-- begin col-2 -->                                
                  <div class="form-group">
                      <label class="col-md-12">Numero de seguro de Salud:</label>
                      <div class="col-md-12">
                        <input type="text" value="{{$contrato->numero_seguro_salud}}" class="form-control" disabled>
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
                          <td><input type="text" class="form-control" value="30" name="dias_trabajado"></td>
                          <td>AFPS 10%</td>
                          <td>{{$contrato->salario*0.1}}<input type="hidden" class="form-control" value="{{$contrato->salario*0.1}}" name="afp"></td>
                        </tr>
                        <tr>
                          <td>HABER BASICO</td>
                          <td>{{$contrato->salario}}<input type="hidden" class="form-control" value="{{$contrato->salario}}" name="haber_basico"></td>
                          <td>COMISION AFP 0.5%</td>
                          <td>{{$contrato->salario*0.005}}<input type="hidden" class="form-control" value="{{$contrato->salario*0.005}}" name="comision_afp"></td>
                        </tr>
                        <tr>
                          <td>BONO DE ANTIGUEDAD</td>
                          <td>0<input type="hidden" class="form-control" value="0" name="bono_antiguedad"></td>
                          <td>FONDO SOLIDARIO 0.5%</td>
                          <td>{{$contrato->salario*0.005}}<input type="hidden" class="form-control" value="{{$contrato->salario*0.005}}" name="fondo_solidario"></td>
                        </tr>
                        <tr>
                          <td>HORAS EXTRAS</td>
                          <td>{{$hora_extra}}<input type="hidden" class="form-control" value="{{$hora_extra}}" name="horas_extras"></td>
                          <td>RIESGO COMUN 1.71%</td>
                          <td>{{$contrato->salario*0.0171}}<input type="hidden" class="form-control" value="{{$contrato->salario*0.0171}}" name="riesgo_comun"></td>
                        </tr>
                        <tr>
                          <td>OTROS</td>
                          <td>{{$pago_otros}}<input type="hidden" class="form-control" value="{{$pago_otros}}" name="otros_ingresos"></td>
                          <td>ANTICIPOS</td>
                          <td>{{$anticipos}}<input type="hidden" class="form-control" value="{{$anticipos}}" name="anticipos"></td>
                        </tr>
                        <tr>
                          <td></td>
                          <td></td>
                          <td>OTROS</td>
                          <td>{{$descuento_otros}}<input type="hidden" class="form-control" value="{{$descuento_otros}}" name="otros_descuentos"></td>
                        </tr>
                        <tr>
                          <td>TOTAL</td>
                          <td>{{$contrato->salario+0+$hora_extra+$pago_otros}}<input type="hidden" class="form-control" value="{{$contrato->salario+0+$hora_extra+$pago_otros}}" name="total_ingresos"></td>
                          <td>TOTAL</td>
                          <td>{{$contrato->salario*0.1+$contrato->salario*0.005+$contrato->salario*0.005+$contrato->salario*0.0171+$anticipos+$descuento_otros}}<input type="hidden" class="form-control" value="{{$contrato->salario*0.1+$contrato->salario*0.005+$contrato->salario*0.005+$contrato->salario*0.0171+$anticipos+$descuento_otros}}" name="total_descuento"></td>
                        </tr>
                        <tr>
                          <td colspan="2">TOTAL LIQUIDO PAGABLE</td>
                          
                          
                          <td>{{$contrato->salario+0+$hora_extra+$pago_otros-($contrato->salario*0.1+$contrato->salario*0.005+$contrato->salario*0.005+$contrato->salario*0.0171+$anticipos+$descuento_otros)}}<input type="hidden" class="form-control" value="{{$contrato->salario+0+$hora_extra+$pago_otros-($contrato->salario*0.1+$contrato->salario*0.005+$contrato->salario*0.005+$contrato->salario*0.0171+$anticipos+$descuento_otros)}}" name="total_liquido_pagable"></td>
                          <td>Bs</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 form-group" style="">
                        <input type="submit" value="Confirmar pago y ver" name="guardar" class="btn btn-success btn-block">
                        <input type="submit" value="Confirmar pago y volver a lista" name="guardar" class="btn btn-success btn-block">
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