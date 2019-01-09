<?php

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
                            
            <form action="{{url('')}}/pago_administrativo/create" method="get" accept-charset="utf-8" id="formulario">
                
                <h2 class="col-md-3 col-md-offset-2" id="titulo"></h2>
                
    
                <!-- begin col-2 -->                                
                <div class="form-group col-md-12 ">

                    <label class="col-md-3 text-right">* Administrativo:</label>
                    <div class="col-md-6">
                        <select name="id_contrato_administrativo"id="select-id_contrato_administrativo" class="form-control chosen-select" data-rel="chosen" data-parsley-group="" data-placeholder="Administrativo">
                            <option value=""></option>
                            <?php 
                            if(!empty($contratos)){
                            foreach ($contratos as $key => $value) {?>
                            <option value="{{$value->id}}">{{$value->nombre." ".$value->paterno." ".$value->materno." - ".$value->unidad_area." - ".$value->cargo}}</option>
                            <?php
                            }}
                            ?>
                        </select>
                    </div>
                </div>
                <!-- end col-2 -->                      

                <!-- begin col-2 -->                                
                <div class="form-group col-md-12 ">

                    <label class="col-md-3 text-right">* Mes:</label>
                    <div class="col-md-6">
                        <select name="mes"id="select-mes" class="form-control chosen-select" data-rel="chosen" data-parsley-group="" data-placeholder="mes">
                            <option value=""></option>
                            <option value="ENERO">ENERO</option>
                            <option value="FEBRERO">FEBRERO</option>
                            <option value="MARZO">MARZO</option>
                            <option value="ABRIL">ABRIL</option>
                            <option value="MAYO">MAYO</option>
                            <option value="JUNIO">JUNIO</option>
                            <option value="AGOSTO">AGOSTO</option>
                            <option value="SEPTIEMBRE">SEPTIEMBRE</option>
                            <option value="OCTUBRE">OCTUBRE</option>
                            <option value="NOVIEMBRE">NOVIEMBRE</option>
                            <option value="DICIEMBRE">DICIEMBRE</option>
                        </select>
                    </div>
                </div>
                <!-- end col-2 -->

                <!-- begin col-2 -->                                
                <div class="form-group col-md-12 ">

                    <label class="col-md-3 text-right">* Año:</label>
                    <div class="col-md-6">
                        <select name="anio"id="select-anio" class="form-control chosen-select" data-rel="chosen" data-parsley-group="" data-placeholder="Año">
                            <option value=""></option>
                            @for($i=date("Y");$i>=(date("Y")-5);$i--)
                            <option value="{{$i}}">{{$i}}</option>
                            @endfor
                            
                        </select>
                    </div>
                </div>
                <!-- end col-2 -->
                <div class="row">
                    <div class="col-md-6 col-md-offset-2 form-group" style="">
                        <button type="submit"  class="btn btn-success">Registrar nuevo pago</button>
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