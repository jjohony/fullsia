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
          <div class="col-md-12">
            <h2><span class="fa fa-folder-open orange-icon"></span> 
              CURSOS
          </h2>
          </div>
          <h5>
            <li>Para crear curso(s) es necesario seleccionar  la gestion, el pensum o plan de estudios, la mensión y el turno. </li>  
          </h5>
          <h5><li>Posteriormente hacer click sobre nivel para ver las asignaturas.</li> </h5>
          <h5><li>Seleccionar los paralelos y las asignaturas que se quiere crear.</li> </h5>
          <h5><li>Para finalizar hacer click sobre el boton Guardar o Guardar y Listar.</li> </h5>  
        </div>
          
        <form   id="form_curso"  action="{{url('')}}/carrera/{{$carrera->id}}/curso" method="post" class="">

            {{csrf_field()}}
            <div class="row">
                <div class="col-md-3 form-group">
                  <label for="id_gestion" class="col-md-12">Gestion</label>
                  <div class="col-md-12">
                    <select name="id_gestion" id="id_gestion" class="form-control chosen-select" data-rel="chosen" data-placeholder="gestion">
                        <?php
                          if($gestion){ 
                          foreach ($gestion as $value) { ?>
                            <option value="<?php echo $value->id;?>"><?php echo "".$value->periodo_gestion."-".$value->gestion." ".$value->tipo_gestion;?></option>    
                        <?php }} ?>                
                    </select>
                  </div>
                </div>

                <div class="col-md-3 form-group">
                  <label for="id_pensum" class="col-md-12">Pensum</label>
                  <div class="col-md-12">
                    <select name="id_pensum" id="id_pensum" class="form-control chosen-select" data-rel="chosen" data-placeholder="pensum">
                        <?php 
                        if(!empty($pensum)){
                        foreach ($pensum as $value){ ?>
                            <option value="<?php echo $value->id;?>"><?php echo $value->pensum;?></option>    
                        <?php }} ?>                
                    </select>
                  </div>
                </div>

                <div class="col-md-3 form-group">
                  <label for="id_mencion" class="col-md-12">Mensión</label>
                  <div class="col-md-12">
                    <select name="id_mencion" id="id_mencion" class="form-control chosen-select" data-rel="chosen" data-placeholder="mensión">
                        <?php 
                        if($mencion){
                        foreach ($mencion as $value){ ?>
                            <option value="<?php echo $value->id;?>"><?php echo $value->mencion;?></option>    
                        <?php }} ?>                
                    </select>
                  </div>
                </div>

                <div class="col-md-2 form-group">
                  <label for="turno_curso" class="col-md-12">Turno</label>
                  <div class="col-md-12">
                    <select name="turno_curso" id="turno_curso" class="form-control chosen-select" data-rel="chosen" data-placeholder="turno">
                            <option value="mañana">Mañana</option>    
                            <option value="tarde">Tarde</option>    
                            <option value="noche">Noche</option>    
                    </select>
                  </div>
                </div>

                <div class="col-md-2 form-group">
                  <label for="nivel" class="col-md-12">Nivel</label>
                  <div class="col-md-12">
                    <select name="nivel" id="nivel" onchange="asignaturas()" onclick="asignaturas()" class="form-control chosen-select" data-rel="chosen" data-placeholder="nivel">
                        <?php for ($i=1;$i<=10;$i++){ ?>
                            <option value="<?php echo $i;?>"><?php echo $i;?></option>    
                        <?php }?>                
                    </select>
                  </div>
                </div>
              
                <div class="col-md-2 form-group">
                  <label for="cupo" class="col-md-12">Cupo</label>
                  <div class="col-md-12">
                    <input type="number"name="cupo" id="cupo" class="form-control" placeholder="cupos" required>
                  </div>
                </div>

                <!-- begin col-2 -->                                
                <div class="form-group col-md-2 ">
                    
                    <label class="col-md-12 text-right">Foma de Evaluacion:</label>
                    <div class="col-md-12">
                        <select name="id_evaluacion"id="select-id_evaluacion" class="form-control chosen-select" data-rel="chosen" data-parsley-group="" data-placeholder="Evaluacion" required>
                            <option value=""></option>}
                            
                            @if(!empty($evaluacion))
                            @foreach($evaluacion as $key=>$value)
                            <option value="{{$value->id}}" >{{$value->evaluacion }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <!-- end col-2 --> 

                <div class="col-md-12">
                  <input type="submit" class="btn btn-success" value="Guardar" name="guardar">
                  <input type="submit" class="btn btn-success" value="Guardar y Listar" name="guardar">
                  <a href="{{url('')}}/carrera/{{$carrera->id}}/curso" title="" class="btn btn-success">Cancelar</a>
                  <a href="{{url('')}}/carrera/{{$carrera->id}}/curso" title="" class="btn btn-success">Volver a Lista</a>
                </div>
            </div>
            <div clss="row">
              <div class="col-md-4">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="padding:10px;padding-left:0px">Seleccionar</th>
                      <th style="padding:10px;padding-left:0px">Paralelo</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php for($i=65;$i<=69;$i++){ ?>
                    <tr>
                      <td class='first-td '><input type="checkbox" name="paralelo[]" value="<?php echo chr($i);?>" ></td>
                      <td class='text-center'><?php echo chr($i);?></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <div class="col-md-8">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Seleccionar</th>
                      <th>Sigla-Código</th>
                      <th>Asignatura</th>
                    </tr>
                  </thead>
                  <tbody id="tbody-asignaturas">
                    
                  </tbody>
                </table>
              </div>           
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
  
    function asignaturas()
    {
      
      $("#tbody-asignaturas").html("");
      _token=$("input[name='_token']").val()
      $.ajax({
        url: "{{url('')}}/carrera/{{$carrera->id}}/buscar_asignaturas_nivel_mencion_pensum",//action del formulario, ej:
          //http://localhost/mi_proyecto/mi_controlador/mi_funcion
        type: "POST",//el método post o get del formulario
        data: {id_mencion:$("#id_mencion").val(),nivel:$("#nivel").val(),id_pensum:$("#id_pensum").val(),_token:_token},
        dataType: 'json',
        //contentType: 'multipart/form-data',
        error: function(e){
            alert("error"+e);
        },
        success:function(data){
            $("#tbody-asignaturas").html("");
            if(data!=""){
              $.each(data, function(j){
                  $("#tbody-asignaturas").append("<tr><td class='first-td '><input type='checkbox' name='id_asignatura_mencion_pensum[]'value='"+data[j].id+"'></td><td>"+data[j].sigla_asignatura+"</td><td>"+data[j].asignatura+"</td></tr>");
              });
            }
        }
      });
    }
  
</script>
@endsection



