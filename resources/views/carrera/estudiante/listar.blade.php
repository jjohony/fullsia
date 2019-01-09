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
          
          
          <div class="panel-body" style="display:block">
            <div class="row">
              
              <div class="col-md-12 col-sm-12">
                <div class="col-md-12 text-center">
                    <h3>CARRERA DE {{$carrera->carrera}}</h3>    
                </div>
                

                
                
              </div>
            </div>
            
            
            
            
            
      
                 
          

        
         <table id="data-table" class="table table-striped table-bordered">
            <thead> 
              <tr>
                <th>Nro</th>
                <th>Ap. Paterno</th>
                <th>Ap. Materno</th>
                <th>Nombres</th>
                <th>C.I.</th>
                <th>Acción</th>
              </tr>
            </thead>
            <tbody id="tbody-curso">
              {{csrf_field()}}
              <?php if(!empty($estudiante)){$i=1; foreach ($estudiante as $key=>$value) { ?>
                <tr id="tr_{{$value->id}}">
                  <td class="first-td"><?php echo $i?></td>
                  <td><?php echo $value->paterno;?></td>
                  <td><?php echo $value->materno;?></td>
                  <td><?php echo $value->nombre;?></td>
                  <td><?php echo $value->numero_documento;?></td>
                  <td>
                    <a href="{{url('')}}/carrera/{{$carrera->id}}/{{$value->id}}/estudiante_nota" title="Notas" class="btn btn-success" >
                        Notas
                    </a>
                    <a href="{{url('')}}/carrera/{{$carrera->id}}/estudiante/{{$value->id}}/cuota" title="Cuotas" class="btn btn-success" >
                        Cuotas
                    </a>
                    
                    
                    
                  </td>
                </tr>
              <?php $i++;}} ?>
              
            </tbody>
          </table>
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
            <input id="grado_docente" name="grado_docente" class="form-control" value="">
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
            
            _token:$("input[name='_token']").val(),
          }
      
        $.ajax({
          url: url,//action del formulario, ej:
          //http://localhost/mi_proyecto/mi_controlador/mi_funcion
          type: "POST",//el método post o get del formulario
          data: values,//obtenemos todos los datos del formulario
          error: function(data){
          //si hay un error mostramos un mensaje
           //alert(data);
          },
          success:function(data){
          //alert(data)
                        
          }
      });   
       //alert("dsfadf");
    }
    
  
</script>

<div id="ajax_content">
  
</div>



@endsection

