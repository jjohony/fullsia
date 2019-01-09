<?php 

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
        <!--div class="alert alert-warning fade in">
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
            The Buttons extension for DataTables provides a common set of options, API methods and styling to display buttons on a page that will interact with a DataTable. The core library provides the based framework upon which plug-ins can built.
        </div-->
        <div class="panel-body">
          <br>
          <div class="page-title">                    
            <h2><span class="fa fa-folder-open"></span> 
                CURSOS
            </h2>
          </div>
           <div class="col-md-12">
              <br>
              @if($usuario_me->nombre_grupo=="academico")
              <a class="btn btn-success" href="{{url('')}}/carrera/{{$carrera->id}}/create/curso">NUEVO</a>
              @endif

           </div> 
          
          <div class="col-md-3">                    
            <label for="id_gestion" class="col-md-12">Gestion</label>
            <div class="col-md-12">
              {{csrf_field()}}
              <select name="id_gestion" id="id_gestion" class="form-control chosen-select" data-rel="chosen" data-placeholder="gestion" onchange="ajax_curso()" onclick="ajax_curso()">
                
                  <?php
                    if(!empty($gestion)){ 
                    foreach ($gestion as $value) { ?>
                      <option value="<?php echo $value->id;?>"><?php echo $value->periodo_gestion." - ".$value->gestion." - ".$value->tipo_gestion;?></option>    
                  <?php }} ?>                
              </select>
            </div>
          </div>
          <div class="col-md-4">                    
            <label for="id_pensum" class="col-md-12">Pensum</label>
            <div class="col-md-12">
              <select name="id_pensum" id="id_pensum" class="form-control chosen-select" data-rel="chosen" data-placeholder="pensum" onchange="ajax_curso()" onclick="ajax_curso()">
                
                  <?php 
                  if(!empty($pensum)){
                  foreach ($pensum as $value){ ?>
                      <option value="<?php echo $value->id;?>"><?php echo $value->pensum;?></option>    
                  <?php }} ?>                
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <label for="id_mencion" class="col-md-12">Mensión</label>
            <div class="col-md-12">
              <select name="id_mencion" id="id_mencion" class="form-control chosen-select" data-rel="chosen" data-placeholder="mensión" onchange="ajax_curso()" onclick="ajax_curso()">
                
                  <?php 
                  if(!empty($mencion)){
                  foreach ($mencion as $value){ ?>
                      <option value="<?php echo $value->id;?>"><?php echo $value->mencion;?></option>    
                <?php }} ?>                
              </select>
            </div>
          </div>
          <div class="col-md-2">
                  
            <label for="nivel" class="col-md-12">Nivel</label>
            <div class="col-md-12">
              <select name="nivel" id="nivel" class="form-control chosen-select" data-rel="chosen" data-placeholder="nivel" onchange="ajax_curso()" onclick="ajax_curso()">
                
                  <?php for ($i=1;$i<=10;$i++){ ?>
                      <option value="<?php echo $i;?>"><?php echo $i;?></option>    
                  <?php }?>                
              </select>
            </div>
          </div>
                  
                       
          
           <div class="col-md-12">
               <table id="kJtabla" class="table table-striped display">
                  <thead> 
                    <tr>
                      <th>Nro</th>
                      <th>Periodo</th>
                      <th>Gestion</th>
                      <th>Pensum</th>
                      <th>Mensión</th>
                      <th>Nivel</th>
                      <th>Paralelo</th>
                      <th>Turno</th>
                      <th>Sigla</th>
                      <th>Asignatura</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody id="tbody-curso">
                    <?php if(!empty($curso)){$i=1; foreach ($curso as $key=>$value) { ?>
                      <tr class="mini-text">
                        <td class="first-td"><?php echo $i;?></td>
                        
                        <td><?php echo $value->periodo_gestion;?></td>
                        <td><?php echo $value->gestion;?></td>
                        <td><?php echo $value->pensum;?></td>
                        <td><?php echo $value->mencion;?></td>
                        <td><?php echo $value->nivel_asignatura;?></td>
                        <td><?php echo $value->paralelo_curso;?></td>
                        <td><?php echo $value->turno_curso?></td>
                        <td><?php echo $value->sigla_asignatura;?></td>
                        <td><?php echo $value->asignatura;?></td>
                        <td>
                          <a data-toggle="tooltip" data-placement="top" title="Notas" type="button" class="btn btn-primary" href="{{url('')}}/carrera/{{$carrera->id}}/{{$value->id}}/nota">Notas</a>
                          <a data-toggle="tooltip" data-placement="top" title="Control de Asistencia" type="button" class="btn btn-success" href="{{url('')}}/carrera/{{$carrera->id}}/{{$value->id}}/asistencia">Asistencia</a>
                          <a data-toggle="tooltip" data-placement="top" title="Editar" type="button" class="btn btn-info" href="{{url('')}}/carrera/{{$carrera->id}}/curso/{{$value->id}}/edit"><span class="glyphicon glyphicon-pencil"></span></a>
                          
                          <?php if($value->eliminar==1){?> 
                          <a data-toggle="tooltip" data-placement="top" title="Eliminar" id="eliminar<?php echo $i;?>" class="btn btn-danger" href="{{url('')}}/carrera/{{$carrera->id}}/curso/{{$value->id}}/delete">
                                <span class="glyphicon glyphicon-trash"></span>
                                <input type="hidden" class="input-curso"name="id_curso" value="<?php $value->id?>">
                            </a>
                          <?php }?>
                        </td>
                        



                      </tr>
                    <?php $i++;}} ?>
                  </tbody>
                </table>
           </div> 
        </div>
      </div>
    </div>
</div>
<div id="ajax_content">
  
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
  function ajax_curso(){
      _token=$("input[name='_token']").val()
      $("#tbody-curso").html("");
      $.ajax({
        url: "{{url('')}}/carrera/{{$carrera->id}}/curso_by_parametros",//action del formulario, ej:
          //http://localhost/mi_proyecto/mi_controlador/mi_funcion
        type: "POST",//el método post o get del formulario
        data: {id_gestion:$("#id_gestion").val(),id_mencion:$("#id_mencion").val(),nivel:$("#nivel").val(),id_pensum:$("#id_pensum").val(),_token:_token},
        dataType: 'json',
        //contentType: 'multipart/form-data',
        error: function(e){
            //alert("error"+e);
        },
        success:function(data){
            $("#tbody-curso").html("");
            if(data!=""){
              i=1;
              $.each(data, function(j){
                  fila="<tr><td class='first-td'>"+i+"</td><td>"+data[j].periodo_gestion+"</td><td>"+data[j].gestion+"</td><td>"+data[j].pensum+"</td><td>"+data[j].mencion+"</td><td>"+data[j].nivel_asignatura+"</td><td>"+data[j].paralelo_curso+"</td><td>"+data[j].turno_curso+"</td><td>"+data[j].sigla_asignatura+"</td><td>"+data[j].asignatura+"</td><td><a type='button' class='btn btn-primary' href='"+data[j].notas+"'>Notas</a><a type='button' class='btn btn-primary' href='"+data[j].listado+"' target='_blank'>Lista</a><a type='button' class='btn btn-primary' href='"+data[j].boletin+"' target='_blank'>Boletin</a>";
                  if(data[j].asistencia!=undefined)
                  {
                    fila=fila+"<a target='_blank'type='button' class='btn btn-info' href='"+data[j].asistencia+"' title='Asistencia'>Asistencia</a>";
                  }

                  
                  if(data[j].boletin_anual!=undefined)
                  {
                    fila=fila+"<a target='_blank'type='button' class='btn btn-info' href='"+data[j].boletin_anual+"' title='Boletin Anual'>Boletin Anual</a>";
                  }

                  if(data[j].editar!=undefined)
                  {
                    fila=fila+"<a type='button' class='btn btn-info' href='"+data[j].editar+"' title='Editar'><span class='fa fa-pencil'></span></a>";
                  }
                  if(data[j].eliminar!=undefined)
                  {
                    fila=fila+"<a type='button' class='btn btn-danger' href='"+data[j].eliminar+"'><span class='fa fa-trash'></span></a>";
                  }
                  fila=fila+"</td></tr>";
                  $("#tbody-curso").append(fila);
                  i++;
              });
            }
        }
      });
    }
  
</script>

  
@endsection


