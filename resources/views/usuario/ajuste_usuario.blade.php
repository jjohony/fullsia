<?php 
use App\Models\Admin\users;



$usuario=users::me();
$id_persona=$usuario->id_persona;
switch ($usuario->nombre_grupo) {
    case 'administrador':
        $persona_usuario=users::registros_by_tabla("administrativo","and id='$id_persona'")[0];
        break;
    case 'academico':
        $persona_usuario=users::registros_by_tabla("administrativo","and id='$id_persona'")[0];

        //var_dump($persona_usuario);die;

        //var_dump($persona_usuario->foto_imagen);die;
        break;
    case 'docente':
        $persona_usuario=users::registros_by_tabla("docente","and id='$id_persona'")[0];
        $notificacion=users::registros_by_tabla("notificacion_docente","and id_docente='$id_persona' and estado_notificacion_docente='activo' and estado_revisado='no revisado'");
        
        break;
    case 'estudiante':
        $persona_usuario=users::registros_by_tabla("estudiante","and id='$id_persona'")[0];

        break;
    case 'operador':
        $persona_usuario=users::registros_by_tabla("administrativo","and id='$id_persona'")[0];

        break;
    default:
        # code...
        break;
}

?>
@extends('admin.templates.contenido')

@section('link')
<link href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="assets/plugins/DataTables/extensions/Buttons/css/buttons.bootstrap.min.css" rel="stylesheet" />
<link href="assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
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
            <h4 class="panel-title" id="titulo_formulario">PANEL DE USUARIO</h4>
        </div>
        <div class="panel-body">
			<form action="<?php echo url('').'/ajustes_usuario_save';?>" method="post" accept-charset="utf-8" id="formulario" enctype="multipart/form-data">
                {{csrf_field()}}
                <div id="div-formulario">
                    
                </div>
				<div clas="row">
                    
                    <?php $foto="/assets/img/persona.png";
                                
                        if($persona_usuario->foto_imagen!=""){$foto='/img/'.$persona_usuario->foto_imagen;}
                    ?>
                    <div class="col-md-4">
                        <img src="{{url('')}}{{$foto}}" class="img-responsive" alt="">
                    </div>    
                    
                    <!-- begin col-2 -->                                
                    <div class="col-md-8">
                        <div class="col-md-12 text-center">
                            <h3>Datos Personales</h3>
                            <hr>
                        </div>
                        <div class="col-md-6 text-right">
                            <h4>Nombres:</h4>
                        </div>
                        <div class="col-md-6 text-left">
                            <h4>{{$persona_usuario->nombre}}</h4>
                        </div>
                        <div class="col-md-12" style="padding:0px;margin:0px;"><hr style="margin:0px;"></div>
                        
                        <div class="col-md-6 text-right">
                            <h4>Apellido Paterno:</h4>
                        </div>
                        <div class="col-md-6 text-left">
                            <h4>{{$persona_usuario->paterno}}</h4>
                        </div>
                        <div class="col-md-12" style="padding:0px;margin:0px;"><hr style="margin:0px;"></div>
                        <div class="col-md-6 text-right">
                            <h4>Apellido Materno:</h4>
                        </div>
                        <div class="col-md-6 text-left">
                            <h4>{{$persona_usuario->materno}}</h4>
                        </div>
                        <div class="col-md-12" style="padding:0px;margin:0px;"><hr style="margin:0px;"></div>
                        <div class="col-md-6 text-right">
                            <h4>Cedula de Identidad:</h4>
                        </div>
                        <div class="col-md-6 text-left">
                            <h4>{{$persona_usuario->numero_documento." ".$persona_usuario->expedido}}</h4>
                        </div>
                        <div class="col-md-12" style="padding:0px;margin:0px;"><hr style="margin:0px;"></div>
                        
                        <div class="col-md-12" style="padding:0px;margin:0px;"><hr style="margin:0px;"></div>
                        
                        <div class="col-md-12" style="padding:0px;margin:0px;"><hr style="margin:0px;"></div>
                        <div class="col-md-6 text-right">
                            <h4>Telefono:</h4>
                        </div>
                        <div class="col-md-6 text-left">
                            <h4>{{$persona_usuario->telefono}}</h4>
                        </div>
                        <div class="col-md-12" style="padding:0px;margin:0px;"><hr style="margin:0px;"></div>
                        <div class="col-md-6 text-right">
                            <h4>Celular:</h4>
                        </div>
                        <div class="col-md-6 text-left">
                            <h4>{{$persona_usuario->celular}}</h4>
                        </div>
                        
                        <div class="col-md-12" style="padding:0px;margin:0px;"><hr style="margin:0px;"></div>
                        
                        <div class="col-md-6 text-right">
                            <h4>Foto:</h4>
                        </div>
                        <div class="col-md-6 text-left">
                            <input type="file" name="foto">
                        </div>
                        <div class="col-md-12" style="padding:0px;margin:0px;"><hr style="margin:0px;"></div>
                        <div class="col-md-6 text-right">
                            <h4>Clave de Acceso:</h4>
                        </div>
                        <div class="col-md-6 text-left">
                            <input type="text" name="password" class="form-control" placeholde="Ingrese su nueva contraseña">

                        </div>
                        <div class="col-md-12 text-center" style="padding:0px;margin:0px;">
                            <input type="submit" value="Guardar Cambios" class="btn btn-success">
                            <hr style="margin:0px;"></div>
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