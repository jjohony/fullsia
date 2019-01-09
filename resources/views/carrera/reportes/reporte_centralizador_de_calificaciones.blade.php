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
                            
            <form action="{{url('')}}/reporte/reporte_centralizador_de_calificaciones" method="get" accept-charset="utf-8" id="formulario" target="_blank">
                
                
                  <!-- begin col-2 -->                                
                  <div class="form-group col-md-6">
                      <label class="col-md-12">Carrera:</label>
                      <div class="col-md-12">                        
                        <select class="form-control chosen-select" data-rel="chosen" data-placeholder="Carrera" name="id_carrera" required>
                          @if(!empty($carrera))
                          @foreach($carrera as $key=>$value)
                          <option value="{{$value->id}}"> {{$value->carrera}}</option>
                          @endforeach
                          @endif
                        
                        </select>
                      </div>

                  </div>
                  <!-- end col-2 --> 

                  
                  <!-- begin col-2 -->                                
                  <div class="form-group col-md-6">
                      <label class="col-md-12">Gestion:</label>
                      <div class="col-md-12">                        
                        <select class="form-control chosen-select" data-rel="chosen" data-placeholder="Todas" name="gestion">
                          <option value="">Todas</option>
                          @for($i=date("Y");$i>=date("Y")-5;$i--)
                          <option value="{{$i}}"> {{$i}}</option>
                          @endfor
                        
                        </select>
                      </div>

                  </div>
                  <!-- end col-2 --> 
                  
                  <!-- begin col-2 -->                                
                  <div class="form-group col-md-6">
                      <label class="col-md-12">Periodo de gestion:</label>
                      <div class="col-md-12">                        
                        <select class="form-control chosen-select" data-rel="chosen" data-placeholder="Todas" name="periodo_gestion">
                          <option value="">Todos</option>
                          <option value="anual">Anual</option>
                          <option value="modular">Modular</option>
                          <option value="I">I</option>
                          <option value="II">II</option>
                          <option value="III">III</option>
                          <option value="IV">IV</option>
                        </select>
                      </div>

                  </div>
                  <!-- end col-2 --> 
                  
                              
                  <div class="col-md-6 col-md-offset-3">                        
                    <button type="submit" class="btn btn-success btn-block">Generar Reporte</button>
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
    <?php if(!empty($id_factura_estudiante)){?>
      window.open("{{url('')}}/reporte/reporte_factura_estudiante/{{$id_factura_estudiante}}");
    <?php }?>

</script>
@endsection