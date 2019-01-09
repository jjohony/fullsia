<?php 
use App\Models\TableModel;
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
                <h2 class="col-md-8  col-md-offset-2" id="titulo">{{str_replace("_"," ",strtoupper ($nombre_tabla))}}</h2>
                <div class="col-md-12 div-button-nuevo" >
                  <a type="button" class="btn btn-success" id="tabla-button-nuevo" href="{{url('table/create/'.$nombre_tabla)}}">Nuevo</a>  
                </div>
                
                <table id="data-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                          <?php 
                          if(!empty($columnas))
                          {
                            foreach ($columnas as $key => $value) {
                              switch ($columnas[$key]->COLUMN_NAME) {
                                case 'created_at':
                                  $columna="Creado";
                                  break;
                                case 'updated_at':
                                  $columna="Actualizado";
                                  break;

                                default:

                                $columna=str_replace("Id_","",ucwords($columnas[$key]->COLUMN_NAME));
                                  $columna=str_replace("_"," ",ucwords($columna));
                                  break;
                              }
                              ?>
                              
                            <th id="th-{{$columnas[$key]->COLUMN_NAME}}">
                              {{$columna}}
                            </th>    
                          
                          <?php 
                            }
                          }
                          ?>
                          
                          <th id="th-acciones">Acciones</th>
                            
                        </tr>
                    </thead>
                    <tbody id="tbody">
                       
                       <?php 
                        if(!empty($registros))
                        {

                            foreach ($registros as $key => $value) {?>
                            <tr class="" id="tabla-tr-<?php echo $value->id;?>">
                                <?php 
                                foreach ($columnas as $key1 => $value1) {
                                    $nombre_campo=$columnas[$key1]->COLUMN_NAME;
                                    switch ($columnas[$key1]->DATA_TYPE) {
                                      case 'datetime':
                                        $valor=date("d-m-Y H:i:s",strtotime($value->$nombre_campo));
                                        break;
                                      case 'date':
                                        $valor=date("d-m-Y",strtotime($value->$nombre_campo));
                                        break;
                                      
                                      default:
                                          $valor=$value->$nombre_campo;
                                        break;
                                    }
                                    if(strpos($columnas[$key1]->COLUMN_NAME,"id_")!==false)
                                    {

                                      
                                      $nombre_tabla_1=str_replace("id_", "", $columnas[$key1]->COLUMN_NAME);
                                      //var_dump($nombre_tabla_1);die;
                                      $registros_1=TableModel::registros_by_tabla($nombre_tabla_1,"and id='".$valor."'");

                                      $columnas_1=TableModel::columnas_by_tabla($nombre_tabla_1)[0];
                                      $campos_1=array();
                                      if($columnas_1->COLUMN_COMMENT!="")
                                      {
                                          $campos_1=explode(",", $columnas_1->COLUMN_COMMENT);    
                                          if(!empty($campos_1)){
                                            $valor="";
                                            if(!empty($registros_1))
                                            {
                                              foreach ($campos_1 as $key2 => $value2) {

                                                $valor=$valor." ".$registros_1[0]->$value2;
                                              }
                                            }
                                            
                                    
                                          }
                                      }
                                      else
                                      {
                                        if(!empty($registros_1))
                                        {
                                          $valor=$registros_1[0]->$nombre_tabla_1;  
                                        }
                                        
                                      }
                                    }
                                    if(strpos($columnas[$key1]->COLUMN_NAME,"_imagen")!==false)
                                    {
                                      
                                      if($value->$nombre_campo!="")
                                      {
                                        $valor="<img src='".url('img/'.$value->$nombre_campo)."' class='img-responsive'>";  

                                      }
                                      else
                                      {
                                        $valor="<img src='".url('assets/img/persona.png')."' class='img-responsive'>"; 
                                      }
                                      
                                    }
                                ?>
                                 
                                <td ><?php echo $valor?></td>
                                
                                <?php }?>
                                <td class="td-acciones">
                                  <div class="dropdown">
                                    <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      Acciones
                                      <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dLabel">
                                      <li class="ver">
                                        <a class=""href="{{url('')}}/table/{{$nombre_tabla}}/{{$value->id}}" >Ver</a>
                                      </li>
                                      <li class="editar">
                                        <a href="{{url('')}}/table/{{$nombre_tabla}}/{{$value->id}}/edit" title="" >Editar</a>
                                      </li>
                                      <li class="eliminar">

                                        <a href="{{url('')}}/table/{{$nombre_tabla}}/{{$value->id}}/delete" title="" >Eliminar</a>
                                      </li>
                                    </ul>
                                  </div>
                                </td>
                                
                            </tr>    
                        <?php   
                            }
                        } ?>
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
  <div class="modal-dialog" role="document" style="width:100%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Reporte</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
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
@include("table.personalizacion");
<script>
    $(document).ready(function() {
        TableManageButtons.init();
    });
</script>
<script type="text/javascript">
    function imprimir(i,e)
    {
        e.preventDefault();
        url=$("#imprimir-"+i).attr("href");
        crearFrame(url);
        $("#input-modal-reporte").trigger("click");
    }
    function crearFrame(pdf) {
      var testFrame = document.createElement("IFRAME");
      $("#testFrame").remove();   
      testFrame.id = "testFrame";
      testFrame.width="100%";
      testFrame.height="500";
      testFrame.scrolling="no";
      testFrame.frameborder="0px";
      testFrame.src = pdf+"?wmode=transparent"; //Sacar el nombre del fichero pdf desde el parametro
      var control = document.getElementById("testFrame")
      if (control==null) { 
         $('#modal-reporte .modal-body').html(testFrame);
      }   
    }
</script>



@endsection

