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
                            
            <form action="{{url('')}}/carrera/{{$carrera->id}}/{{$curso->id}}/nota" method="post" accept-charset="utf-8" id="formulario">
                {{csrf_field()}}
                

                <h2 class="col-md-3 col-md-offset-2" id="titulo">Nota Inscripción</h2>
                <div class="row">
                    <div class="col-md-6 col-md-offset-2 form-group" style="">
                        <input type="submit" value="Guardar" name="guardar" class="btn btn-success">
                        <input type="submit" value="Guardar y Listar" name="guardar" class="btn btn-success">    
                    
                        <a href="{{url('')}}/carrera/{{$carrera->id}}/{{$curso->id}}/nota" class="btn btn-success">Cancelar</a>
                        <a href="{{url('')}}/carrera/{{$carrera->id}}/{{$curso->id}}/nota" class="btn btn-success">Volver a la Lista</a>
                    </div>
                </div>
                
                <!-- begin col-2 -->                                
                <div class="form-group col-md-12 ">
                    <label class="col-md-3 text-right">* Estudiante:</label>
                    <div class="col-md-3">
                        <select name="id_estudiante"id="select-id_estudiante" class="form-control chosen-select" data-rel="chosen" data-parsley-group="" data-placeholder="estudiante" required>
                            <option value="">Ninguno</option>}
                            
                            @if(!empty($estudiante))
                            @foreach($estudiante as $key=>$value)
                            <option value="{{$value->id}}"  >{{$value->numero_documento."-". $value->expedido." ".$value->paterno. " ". $value->materno." ".$value->nombre }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <!-- end col-2 -->                                          
                          
                
                
                
                <!-- begin col-2 -->                                
                <div class="form-group col-md-12">
                    <label class="col-md-3 text-right"> Observacion estudiante:</label>
                    <div class="col-md-3">
                        <input name="observacion_estudiante" class="form-control " id="input-observacion_estudiante"   type="text"  value="">    
                    </div>
                </div>
                
                      
                    
                                            
                <!-- begin col-2 -->                                
                <div class="form-group col-md-12 ">
                    <label class="col-md-3 text-right">* Retiro adicion:</label>
                    <div class="col-md-3">
                        <select name="retiro_adicion"id="select-retiro_adicion" class="form-control chosen-select" data-rel="chosen" data-parsley-group="" >
                          <option value="regular">regular</option>
                          <option value="retiro">retiro</option>
                        </select>
                      </div>
                  </div>
                  <!-- end col-2 -->                      
                          
                          
                      
                    
                                            
                <!-- begin col-2 -->                                
                <div class="form-group col-md-12 ">
                  <label class="col-md-3 text-right">* Estado inscrito:</label>
                  <div class="col-md-3">
                      <select name="estado_inscrito"id="select-estado_inscrito" class="form-control chosen-select" data-rel="chosen" data-parsley-group="" >
                        <option value="inscrito">inscrito</option>
                        <option value="nota">nota</option>
                      </select>
                    </div>
                </div>
                <!-- end col-2 -->                      
                          
                <!-- begin col-2 -->                                
                <div class="form-group col-md-12 ">
                  <label class="col-md-3 text-right">* Estado nota:</label>
                  <div class="col-md-3">
                      <select name="estado_nota"id="select-estado_nota" class="form-control chosen-select" data-rel="chosen" data-parsley-group="" >
                        <option value="activo">activo</option>


                        <option value="eliminado">eliminado</option>
                      </select>
                    </div>
                  </div>
                  <!-- end col-2 -->        
                                      

    

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