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
              <div class="col-md-12">
                
              </div>
            </div>
            
         <table id="data-table" class="table table-striped table-bordered">
            <thead> 
              <tr>
                <th>Foto</th>
                <th>Estudiante</th>
                <th>Inscripción</th>
                <th>Matricula</th>
                <th>Mensualidad</th>
                <th>Total_pagos</th>
                <th>Periodo</th>
                <th>Fecha</th>
                <th>Opciones</th>
                

                
              </tr>
            </thead>
            <tbody id="tbody-curso">
              {{csrf_field()}}
              <?php if(!empty($control_pago)){$i=1; foreach ($control_pago as $key=>$value) {
                    if($value->foto_imagen=="")
                    {
                        $imagen=url('')."/assets/img/persona.png";    
                    }
                    else{
                        $imagen=url('')."/img/".$value->foto_imagen;    
                    }
                    
                  
               ?>
                <tr id="tr_{{$value->id}}">

                  <td><img src="{{$imagen}}"  alt="" style="max-width:60px;min-width:60px;max-height:60px;min-height:60px;"></td>
                  <td><?php echo $value->paterno." ".$value->materno." ".$value->nombre;?></td>
                  <td style="background-color:green;color:white"><?php echo $value->cantidad_inscripcion;?></td>
                  <td style="background-color:blue;color:white"><?php echo $value->cantidad_matriculacion;?></td>
                  
                  <td style="background-color:orange;color:white"><?php echo $value->cantidad_mensualidad;?></td>
                  <td><?php echo $value->monto;?></td>
                  <td><?php echo $value->gestion;?></td>
                  <td><?php echo date("d-m-Y  ",strtotime($value->fecha));?></td>
                  <td>
                    <a href="{{url('')}}/reporte/reporte_historial_factura_estudiante/{{$value->id_estudiante}}" title="" class="btn btn-success" target="_blank">
                        <span class="fa fa-print"></span> historial de pagos
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
            id_nota:$("#tr_"+i+" .id_nota").val(),
            primer_parcial:$("#tr_"+i+" .primer_parcial").val(),
            segundo_parcial:$("#tr_"+i+" .segundo_parcial").val(),
            examen_final:$("#tr_"+i+" .examen_final").val(),
            nota_final:$("#tr_"+i+" .nota_final").val(),
            segundo_turno:$("#tr_"+i+" .segundo_turno").val(),
            libro:$("#tr_"+i+" .libro").val(),
            folio:$("#tr_"+i+" .folio").val(),
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

