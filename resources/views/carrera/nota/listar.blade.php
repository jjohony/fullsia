<?php 
if(!empty($evaluacion))
{
  for($i=1;$i<=12;$i++){
    $campo="casilla_".$i;
    if($evaluacion->$campo!="")
    {
      $data_evaluacion[$i]=$evaluacion->$campo;
    }    
  }
}
?>
@extends('admin.templates.contenido')

@section('link')
<link href="{{url('')}}/assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="{{url('')}}/assets/plugins/DataTables/extensions/Buttons/css/buttons.bootstrap.min.css" rel="stylesheet" />
<link href="{{url('')}}/assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
@endsection

@section('content_contenido')

<div class="row">
     <div class="col-md-12">
       <div class="panel panel-inverse">
          <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
            <h4 class="panel-title">Panel</h4>
        </div>
          
          
          <div class="panel-body" style="display:block">
            <div class="row">
                
              <div class="col-md-12 col-sm-12">
                <div class="col-md-12 text-center">
                    <h3>CARRERA DE {{$carrera->carrera}}</h3>    
                </div>

                <?php if ($mencion->mencion!="REGULAR") {?>                
                <div class="col-md-12 text-center">
                    <h3> MENSIÓN EN {{$mencion->mencion}}</h3>    
                </div>
                <?php }
                ?>
                <div class="col-md-6">
                    <h4>Codigo: {{$asignatura->sigla_asignatura}}</h4>    
                </div>
                <div class="col-md-6">
                    <h4>Asignatura: {{$asignatura->asignatura}}</h4>    
                </div>
                
                <div class="col-md-6 ">
                    <h4>Nivel: {{$asignatura->nivel_asignatura}}</h4>    
                </div>
                <div class="col-md-6 ">
                    <h4>Modalidad: {{$asignatura->modalidad_asignatura}}</h4>    
                </div>
                <div class="col-md-6 ">
                    <h4>Horas: {{$asignatura->horas}}</h4>    
                </div>
              </div>
            </div>
            <div class="row">
              
              <div class=" col-md-3" style="margin-bottom:10px" >
                <a  class="btn btn-success" href="{{url('')}}/reporte_boletin_calificacion/{{$curso->id}}/nota" target="_blank">Reporte</a>
              </div>           
              @if($usuario_me->nombre_grupo=="academico")
              <div class="col-md-3" style="margin-bottom:10px">
                <a  class="btn btn-success" href="{{url('')}}/estado_inscrito/{{$carrera->id}}/{{$curso->id}}/estado/nota">Cambiar el estado de inscrito a nota</a>
              </div>
              <div class="col-md-3" style="margin-bottom:10px">
                <a  class="btn btn-success" href="{{url('')}}/estado_inscrito/{{$carrera->id}}/{{$curso->id}}/estado/inscrito">Cambiar el estado de nota a inscrito</a>
              </div>        
              
              <!--div class=" col-md-2" style="margin-bottom:10px">
                <a href="{{url('')}}/carrera/{{$carrera->id}}/{{$curso->id}}/create/nota" class="btn btn-success" >Adicionar nota</a>
              </div-->      
              @endif
            </div>
            
        <div class="table-responsive">
         <table class="table table-striped table-bordered">
            <thead> 
              <tr>
                <th>Nro</th>
                <th>Ap. Paterno</th>
                <th>Ap. Materno</th>
                <th>Nombres</th>
                <th>C.I.</th>
                
                @if(!empty($data_evaluacion))
                @foreach($data_evaluacion as $key => $value)
                <th>{{$value}}</th>
                @endforeach
                @endif

                <th>Nota Final</th>
                <th>Nota Hab.</th>
                @if($usuario_me->nombre_grupo=="academico")
                <th>Estado</th>
                @endif
                <!--th>Acción</th-->
              </tr>
            </thead>
            <tbody id="tbody-curso">
              {{csrf_field()}}
              <?php if(!empty($notas)){$i=1; foreach ($notas as $key=>$value) { ?>
                <tr id="tr_{{$value->id}}">
                  <td class="first-td"><?php echo $i?></td>
                  <td><?php echo $value->paterno;?></td>
                  <td><?php echo $value->materno;?></td>
                  <td><?php echo $value->nombre;?></td>
                  <td><?php echo $value->numero_documento;?></td>
                  

                  @if(!empty($data_evaluacion))
                  @foreach($data_evaluacion as $key1 => $value1)
                  <?php $campo="casilla_".$key1;?>
                  <th><input style="max-width:25px" class="{{$campo}}" value="<?php echo $value->$campo;?>"  onkeyup="guardar_nota({{$value->id}})"></th>
                  @endforeach
                  @endif

                  
                  <td><input style="max-width:25px" class="nota_final" value="<?php echo $value->nota_final;?>"  onkeyup="guardar_nota({{$value->id}})"></td>
                  <td><input style="max-width:25px" class="segundo_turno" value="<?php echo $value->segundo_turno;?>"  onkeyup="guardar_nota({{$value->id}})"></td>

                  @if($usuario_me->nombre_grupo=="academico")
                  <td>{{$value->estado_inscrito}}</td>
                  @endif
                  <!--td>
                    <a href="{{url('')}}/carrera/{{$carrera->id}}/{{$curso->id}}/nota/{{$value->id}}" title="Ver" class="btn btn-success" >
                        Ver
                    </a>
                    @if($usuario_me->nombre_grupo=="academico")
                    <a href="{{url('')}}/carrera/{{$carrera->id}}/{{$curso->id}}/nota/{{$value->id}}/edit" title="Editar" class="btn btn-success" >
                        <span class="glyphicon glyphicon-pencil"></span>
                    </a>
                    <a href="{{url('')}}/carrera/{{$carrera->id}}/{{$curso->id}}/nota/{{$value->id}}/delete" title="Eliminar" class="btn btn-danger" >
                        <span class="glyphicon glyphicon-trash"></span>
                    </a>
                    @endif
                    
                  </td-->
                </tr>
              <?php $i++;}} ?>
              
            </tbody>
          </table>
        </div>
            <!--div class="col-md-12">
              <input type="submit" class="btn btn-primary" style="margin-bottom:10px"  value="Guardar Cambios">
            </div>
        </form-->  
              
          </div>
      </div>
      
  
    
      
     </div> 
</div>


<div data-backdrop="static" class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel" style="color:#ffffff">Colocar Grado Académico del docente</h4>
      </div>
      <div class="modal-body">
        <form  id="form-editar-gestion"  action="/" method="post">
           
          <input type="hidden" name="id_curso" id="id_curso" value="">
          <div class="form-group">
            <label for="grado_docente" class="control-label">Grado Académico:</label>
            <input id="grado_docente" name="grado_docente" class="form-control" value="<?php echo $curso->grado_docente;?>">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit"id="btn-libro" class="btn btn-primary">Guardar cambios</button>
          </div>
          
        </form>
      </div>
      
    </div>
  </div>
</div>
<div data-backdrop="static" class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel" style="color:#ffffff">Esta seguro de actualizar el estado de las notas de calificación de este curso?</h4>
      </div>
      <div class="modal-body">
        <form  id="form-editar-gestion"  action="/" method="post">
           
          <input type="hidden" name="id_curso" id="id_curso" value="">
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            <button type="submit"id="btn-libro" class="btn btn-primary">Si</button>
          </div>
          
        </form>
      </div>
      
    </div>
  </div>
</div>
<div data-backdrop="static" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel" style="color:#ffffff">Colocar Libro-Folio</h4>
      </div>
      <div class="modal-body">
        <form  id="form-editar-gestion"  action="" method="post">
           
          <input type="hidden" name="id_curso" id="id_curso" value="">
          <div class="form-group">
            <label for="periodo" class="control-label">Libro:</label>
            <input id="libro" name="libro" class="form-control">
          </div>
          <div class="form-group">
            <label for="gestion" class="control-label">Folio:</label>
            <input id="folio" name="folio" class="form-control">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit"id="btn-libro" class="btn btn-primary">Guardar cambios</button>
          </div>
          
        </form>
      </div>
      
    </div>
  </div>
</div>

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
  
     
    function guardar_nota(i){
      url="{{url('')}}/guardar_nota";      
      values={
            id_nota:i,
            <?php 
            if(!empty($data_evaluacion)){
              foreach($data_evaluacion as $key => $value){
                $campo="casilla_".$key;
            ?>
            <?php echo $campo;?>:$("#tr_"+i+" .<?php echo $campo;?>").val(),
            <?php
              }  
            }
            ?>
            
            nota_final:$("#tr_"+i+" .nota_final").val(),
            segundo_turno:$("#tr_"+i+" .segundo_turno").val(),
            _token:$("input[name='_token']").val(),
          }
      
        $.ajax({
          url: url,//action del formulario, ej:
          //http://localhost/mi_proyecto/mi_controlador/mi_funcion
          type: "POST",//el método post o get del formulario
          data: values,//obtenemos todos los datos del formulario
          dataType: 'json',
          error: function(data){
          //si hay un error mostramos un mensaje
           //alert(data);
          },
          success:function(data){
            
            $("#tr_"+i+" .nota_final").val(data.nota.nota_final);
                        
          }
      });   
       //alert("dsfadf");
    }
    
  
</script>
<script type="text/javascript">
  $(function(){
    $("#ci").on("keyup",function(){
      ci=$("#ci").val()
        $.ajax({
          url: "",//action del formulario, ej:
          //http://localhost/mi_proyecto/mi_controlador/mi_funcion
          type: "POST",//el método post o get del formulario
          data: {ci:ci},//obtenemos todos los datos del formulario
          dataType: 'json',
          error: function(){
          
          //si hay un error mostramos un mensaje
           //alert("error");
          },
          success:function(data){
            $("#estudiante").text("Nombre de Estudiante: "+data.nombre+" "+data.paterno+" "+data.materno);
            $("#id_persona").val(data.id);                        
          }
      });   
       //alert("dsfadf");
    })
  })
</script>
<div id="ajax_content">
  
</div>
<script type="text/javascript">
    $(function(){
        <?php if($notas){ $i=1; foreach ($notas as $key) { ?>
        $("#eliminar<?php echo $i;?>").on("click",function(){
            var idnota_inscripcion =  $("#eliminar<?php echo $i;?> .input-nota").val();
            var id_curso=<?php echo $curso->id?>;
            var url= '';           
            values = {
                    idnota_inscripcion: idnota_inscripcion,id_curso: id_curso                
            };

            $.post(url,values, function (resp) {
               $('#ajax_content').html(resp);
            });
        });
        <?php $i++;}}  ?>

        $("#btn_cantidad_cupo").on("click",function(){
            var id_curso=<?php echo $curso->id?>;
            var url= '';           
            values = {
              id_curso: id_curso                
            };
            $.post(url,values, function (resp) {
               $('#ajax_content').html(resp);
            });
        });
        $("#btn_cantidad_cupo_carreras").on("click",function(){
            var id_curso=<?php echo $curso->id?>;
            var url= '';           
            values = {
              id_curso: id_curso                
            };
            $.post(url,values, function (resp) {
               $('#ajax_content').html(resp);
            });
        });
    });
</script>


@endsection

