<?php
use App\Models\TableModel;
?>
@extends('admin.templates.contenido')

@section('link')
<link href="<?php echo e(url('')); ?>/assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="<?php echo e(url('')); ?>/assets/plugins/DataTables/extensions/Buttons/css/buttons.bootstrap.min.css" rel="stylesheet" />
<link href="<?php echo e(url('')); ?>/assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
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
                
            
            <form action="{{url('')}}/carrera/{{$carrera->id}}/curso/{{$curso->id}}" method="post" accept-charset="utf-8" id="formulario">
                {{csrf_field()}}

                <input name="_method" type="hidden" value="DELETE">
                <h2 class="col-md-3 col-md-offset-2" id="titulo">Curso</h2>
                <div class="row">
                    <div class="col-md-6 col-md-offset-2 form-group" style="">
                        <input type="submit" value="Eliminar" name="guardar" class="btn btn-success">
                        <a href="{{url('')}}/carrera/{{$carrera->id}}/curso" class="btn btn-success">Cancelar</a>
                        <a href="{{url('')}}/carrera/{{$carrera->id}}/curso" class="btn btn-success">Volver a la Lista</a>
                    </div>
                </div>

                <!-- begin col-2 -->                                
                <div class="form-group col-md-12 ">
                    
                    <label class="col-md-3 text-right">* Gestion:</label>
                    <div class="col-md-9">
                        <select name="id_gestion"id="select-id_gestion" class="form-control chosen-select" data-rel="chosen" data-parsley-group="" data-placeholder="gestion" disabled>
                            @if(!empty($gestion))
                            @foreach($gestion as $key=>$value)
                            <option value="{{$value->id}}" <?php echo($value->id==$curso->id_gestion)?'selected':'';?>>{{$value->periodo_gestion." - ".$value->gestion. " ". $value->tipo_gestion}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <!-- end col-2 -->                      
                <!-- begin col-2 -->                                
                <div class="form-group col-md-12 ">
                    
                    <label class="col-md-3 text-right">* Asignatura mensión pensum:</label>
                    <div class="col-md-9">
                        <select name="id_asignatura_mencion_pensum"id="select-id_asignatura_mencion_pensum" class="form-control chosen-select" data-rel="chosen" data-parsley-group="" data-placeholder="asignatura_mencion_pensum" disabled>
                            @if(!empty($asignatura_mencion_pensum))
                            @foreach($asignatura_mencion_pensum as $key=>$value)
                            <option value="{{$value->id}}" <?php echo($value->id==$curso->id_asignatura_mencion_pensum)?'selected':'';?>>{{$value->sigla_asignatura." ".$value->asignatura. " ". $value->mencion." ".$value->pensum}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <!-- end col-2 -->                      
                <!-- begin col-2 -->                                
                <div class="form-group col-md-12 ">
                    
                    <label class="col-md-3 text-right"> Docente:</label>
                    <div class="col-md-9">
                        <select name="id_docente"id="select-id_docente" class="form-control chosen-select" data-rel="chosen" data-parsley-group="" data-placeholder="docente" disabled>
                            <option value="0">Ninguno</option>}
                            
                            @if(!empty($docente))
                            @foreach($docente as $key=>$value)
                            <option value="{{$value->id}}" <?php echo($value->id==$curso->id_docente)?'selected':'';?>>{{$value->numero_documento."-". $value->expedido." ".$value->grado_academico." ".$value->paterno. " ". $value->materno." ".$value->nombre }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <!-- end col-2 -->                      
                <!-- begin col-2 -->                                
                <div class="form-group col-md-12">
                    
                    <label class="col-md-3 text-right">* Paralelo curso:</label>
                    <div class="col-md-3">
                        <input name="paralelo_curso" class="form-control " id="input-paralelo_curso"   type="text" required value="{{$curso->paralelo_curso}}" disabled>    
                    </div>
                                                    
                    
                </div>                    
              <!-- begin col-2 -->                                
                <div class="form-group col-md-12 ">
                    
                    <label class="col-md-3 text-right"> Turno curso:</label>
                    <div class="col-md-3">
                        <select name="turno_curso"id="select-turno_curso" class="form-control chosen-select" data-rel="chosen" data-parsley-group="" disabled>
                            <option value="mañana" <?php echo ($curso->turno_curso=="mañana")?'selected':'';?>>mañana</option>
                            <option value="tarde"  <?php echo ($curso->turno_curso=="tarde")?'selected':'';?>>tarde</option>
                            <option value="noche"  <?php echo ($curso->turno_curso=="noche")?'selected':'';?>>noche</option>
                        </select>
                    </div>
                </div>
                <!-- end col-2 -->                      
                <!-- begin col-2 -->                                
                <div class="form-group col-md-12">
                    
                    <label class="col-md-3 text-right"> Cupo curso:</label>
                    <div class="col-md-3">
                        <input name="cupo_curso" class="form-control " id="input-cupo_curso"   type="number"  value="50" disabled>    
                    </div>
                </div>
                <!-- begin col-2 -->                                
                <div class="form-group col-md-12 ">
                    
                    <label class="col-md-3 text-right">* Estado curso:</label>
                    <div class="col-md-3">
                        <select name="estado_curso"id="select-estado_curso" class="form-control chosen-select" data-rel="chosen" data-parsley-group="" disabled>
                            <option value="activo" selected>activo</option>
                            <option value="eliminado" >eliminado</option>
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
<script src="<?php echo e(url('')); ?>/assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
<script src="<?php echo e(url('')); ?>/assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>

<script src="<?php echo e(url('')); ?>/assets/plugins/DataTables/extensions/Buttons/js/dataTables.buttons.min.js"></script>

<script src="<?php echo e(url('')); ?>/assets/plugins/DataTables/extensions/Buttons/js/buttons.bootstrap.min.js"></script>
<script src="<?php echo e(url('')); ?>/assets/plugins/DataTables/extensions/Buttons/js/buttons.flash.min.js"></script>
<script src="<?php echo e(url('')); ?>/assets/plugins/DataTables/extensions/Buttons/js/jszip.min.js"></script>
<script src="<?php echo e(url('')); ?>/assets/plugins/DataTables/extensions/Buttons/js/pdfmake.min.js"></script>
<script src="<?php echo e(url('')); ?>/assets/plugins/DataTables/extensions/Buttons/js/vfs_fonts.min.js"></script>
<script src="<?php echo e(url('')); ?>/assets/plugins/DataTables/extensions/Buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo e(url('')); ?>/assets/plugins/DataTables/extensions/Buttons/js/buttons.print.min.js"></script>
<script src="<?php echo e(url('')); ?>/assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo e(url('')); ?>/assets/js/table-manage-buttons.demo.min.js"></script>

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
