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

                
                <div class="col-md-12">
                    <h4>Estudiante: {{$estudiante->paterno}} {{$estudiante->materno}} {{$estudiante->nombre}}</h4>    
                </div>
                <div class="col-md-12">
                    <h4>TIPO DE DOCUMENTO: {{$estudiante->tipo_documento}}</h4>    
                </div>
                <div class="col-md-12">
                    <h4>NRO. DE DOCUMENTO: {{$estudiante->numero_documento}}</h4>    
                </div>
                <div class="col-md-12">
                    <h4>EXPEDIDO: {{$estudiante->expedido}}</h4>    
                </div>
                <div class="col-md-12">
                  <a href="{{url('')}}/reporte/reporte_historial_academico?id_carrera={{$carrera->id}}&id_estudiante={{$estudiante->id}}" class="btn btn-success" target="blank">PDF</a>
                </div>
                
                
              </div>
            </div>
            
         <table class="table table-striped">
            <thead> 
              <tr>
                <th>N°</th>
                <th>Codigo</th>
                <th>Asignatura</th>
                <th>Gestion</th>
                
                <th>Nota Final</th>
                <th>Nota Hab.</th>
                
                <th>Observacion</th>
                
              </tr>
            </thead>
            <tbody id="tbody-curso">
              {{csrf_field()}}
              <?php if(!empty($nota)){$i=1; foreach ($nota as $key=>$value) {
                  $observacion="";
                  
               ?>
                <tr id="tr_{{$value->id}}">
                  <td class="first-td"><?php echo $i?></td>
                  <td><?php echo $value->sigla_asignatura;?></td>
                  <td><?php echo $value->asignatura;?></td>
                  <td><?php echo $value->periodo_gestion."-".$value->gestion;?></td>
                  
                  <td><?php echo $value->nota_final;?></td>
                  <td><?php echo $value->segundo_turno;?></td>
                  
                  <td><?php echo ($value->nota_final>50||$value->segundo_turno>50)?"APROBADO":"REPROBADO"?></td>                
                  
                
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

<div id="ajax_content">
  
</div>



@endsection

