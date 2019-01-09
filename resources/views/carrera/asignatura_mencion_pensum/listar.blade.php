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
                <a type="button" class="btn btn-success" id="tabla-button-nuevo" href="{{url('')}}/carrera/{{$carrera->id}}/create/plan_estudio">Nuevo</a>
                <table id="data-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>    
                            <th>Id</th>    
                            <th> Pensum</th>    
                            <th> Mensión</th>    
                            <th> Codigo Asig.</th>                          
                            <th> Asignatura</th>  
                            <th>Nivel</th>    
                            <th>Modalidad</th>    
                            <th>Horas</th>    
                            <th>Label prerequisito</th>                              
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php 
                        if(!empty($asignatura_mencion_pensum)){
                            foreach ($asignatura_mencion_pensum as $key => $value) {?>
                       
                        <tr class="" id="tabla-tr-1">
                                                                 
                            <td>{{$value->id}}</td>
                            <td>{{$value->pensum}}</td>
                            <td>{{$value->mencion}}</td>
                            <td>{{$value->sigla_asignatura}}</td>
                            <td>{{$value->asignatura}}</td>
                            <td>{{$value->nivel_asignatura}}</td>
                            <td>{{$value->modalidad_asignatura}}</td>
                            <td>{{$value->horas}}</td>
                            <td>{{$value->label_prerequisito}}</td>
                            
                            
                            <td class="td-acciones">
                                <div class="dropdown">
                                    <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      Acciones
                                      <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dLabel">
                                      <li>
                                        <a class=""href="{{url('')}}/pre_requisito/{{$carrera->id}}/{{$value->id}}" >Pre-requisitos</a>
                                      </li>
                                      <li>
                                        <a class=""href="{{url('')}}/carrera/{{$carrera->id}}/plan_estudio/{{$value->id}}" >Ver</a>
                                      </li>
                                      <li>
                                        <a href="{{url('')}}/carrera/{{$carrera->id}}/plan_estudio/{{$value->id}}/edit" title="" >Editar</a>
                                      </li>
                                      <li>

                                        <a href="{{url('')}}/carrera/{{$carrera->id}}/plan_estudio/{{$value->id}}/delete" title="" >Eliminar</a>
                                      </li>
                                    </ul>
                                </div>
                            </td>
                                
                        </tr>    
                        <?php 
                            }
                        }?>
                    </tbody>
                </table>
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