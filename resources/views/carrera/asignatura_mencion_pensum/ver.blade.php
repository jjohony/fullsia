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
                            
            <form action="{{url('')}}/carrera/{{$carrera->id}}/plan_estudio" method="post" accept-charset="utf-8" id="formulario">
                <input type="hidden" name="_token" value="54WTiPFxiPIbzvmNCBw99jwyrMccQWAzw7RWHm2t">
                <h2 class="col-md-3 col-md-offset-2" id="titulo">Plan de Estudios</h2>
                <div class="row">
                    <div class="col-md-6 col-md-offset-2 form-group" style="">
                        <a href="{{url('')}}/carrera/{{$carrera->id}}/plan_estudio" class="btn btn-success">Cancelar</a>
                        <a href="{{url('')}}/carrera/{{$carrera->id}}/plan_estudio" class="btn btn-success">Volver a la Lista</a>
                    </div>
                </div>

                
        
                                      

    
                <!-- begin col-2 -->                                
                <div class="form-group col-md-12 ">

                    <label class="col-md-3 text-right">* Pensum:</label>
                    <div class="col-md-6">
                        <select name="id_pensum"id="select-id_pensum" class="form-control chosen-select" data-rel="chosen" data-parsley-group="" data-placeholder="pensum" disabled>
                            <option value=""></option>
                            <?php 
                            if(!empty($pensum)){
                            foreach ($pensum as $key => $value) {?>
                            <option value="{{$value->id}}" <?php echo ($asignatura_mencion_pensum->id_pensum==$value->id)?'selected':''?>>{{$value->pensum}}</option>
                            <?php
                            }}
                            ?>
                        </select>
                    </div>
                </div>
                <!-- end col-2 -->                      

                <!-- begin col-2 -->                                
                <div class="form-group col-md-12 ">

                    <label class="col-md-3 text-right">* Mensión:</label>
                    <div class="col-md-6">
                        <select name="id_mencion"id="select-id_mencion" class="form-control chosen-select" data-rel="chosen" data-parsley-group="" data-placeholder="mencion" disabled>
                            <option value=""></option>
                            <?php
                            if(!empty($mencion)){
                            foreach ($mencion as $key => $value) {?>
                            <option value="{{$value->id}}" <?php echo ($asignatura_mencion_pensum->id_mencion==$value->id)?'selected':''?>>{{$value->mencion}}</option>
                            <?php
                            }}
                            ?>
                        </select>
                    </div>
                </div>
                <!-- end col-2 -->
                <!-- begin col-2 -->                                
                <div class="form-group col-md-12 ">
                    
                    <label class="col-md-3 text-right">* Asignatura:</label>
                    <div class="col-md-6">
                        <select name="id_asignatura"id="select-id_asignatura" class="form-control chosen-select" data-rel="chosen" data-parsley-group="" data-placeholder="asignatura" disabled>
                            <option value=""></option>
                            <?php 
                            if(!empty($asignatura)){
                            foreach ($asignatura as $key => $value) {?>
                            <option value="{{$value->id}}" <?php echo ($asignatura_mencion_pensum->id_asignatura==$value->id)?'selected':''?>>{{$value->sigla_asignatura." ".$value->asignatura}}</option>
                            <?php
                            }}
                            ?>
                        </select>
                    </div>
                </div>
                <!-- end col-2 -->
                <!-- begin col-2 -->                                
                <div class="form-group col-md-12">

                    <label class="col-md-3 text-right"> Nivel asignatura:</label>
                    <div class="col-md-3">
                        <input name="nivel_asignatura" class="form-control " id="input-nivel_asignatura"   type="number"  value="{{$asignatura_mencion_pensum->nivel_asignatura}}" disabled>    
                    </div>
                </div>

     
                <!-- begin col-2 -->                                
                <div class="form-group col-md-12 ">

                    <label class="col-md-3 text-right">* Modalidad asignatura:</label>
                    <div class="col-md-3">
                        <select name="modalidad_asignatura"id="select-modalidad_asignatura" class="form-control chosen-select" data-rel="chosen" data-parsley-group="" disabled>
                            <option value="anual" <?php echo ($asignatura_mencion_pensum->modalidad_asignatura=="anual")?'selected':''?>>anual</option>
                            <option value="semestral" <?php echo ($asignatura_mencion_pensum->modalidad_asignatura="semestral")?'selected':''?>>semestral</option>
                            <option value="modular" <?php echo ($asignatura_mencion_pensum->modalidad_asignatura="modular")?'selected':''?>>modular</option>
                        </select>
                    </div>
                </div>
                <!-- end col-2 -->                      
      
                <!-- begin col-2 -->                                
                <div class="form-group col-md-12">
                    <label class="col-md-3 text-right"> Horas:</label>
                    <div class="col-md-3">
                        <input name="horas" class="form-control " id="input-horas"   type="number"  value="{{$asignatura_mencion_pensum->horas}}" disabled>    
                    </div>
                </div>
      
                <!-- begin col-2 -->                                
                <div class="form-group col-md-12">

                    <label class="col-md-3 text-right"> Label prerequisito:</label>
                    <div class="col-md-3">
                        <input name="label_prerequisito" class="form-control " id="input-label_prerequisito"   type="text"  value="{{$asignatura_mencion_pensum->label_prerequisito}}" disabled>    
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