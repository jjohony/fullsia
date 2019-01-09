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
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
            <h4 class="panel-title" id="titulo_formulario">Panel </h4>
        </div>
        <div class="panel-body">
                
            
			<form action="{{url('')}}/table/{{$nombre_tabla}}" method="post" accept-charset="utf-8" id="formulario-create" enctype="multipart/form-data">
                {{csrf_field()}}
                <h2 class="col-md-8 col-md-offset-2" id="titulo">{{str_replace("_"," ",strtoupper ($nombre_tabla))}}</h2>
                <div class="row">
                    <div class="col-md-6 col-md-offset-2 form-group" style="">
                        <input type="submit" value="Guardar" name="guardar" class="btn btn-success">
                        <input type="submit" value="Guardar y Listar" name="guardar" class="btn btn-success">    
                    
                        <a href="{{url('')}}/table/{{$nombre_tabla}}" class="btn btn-success">Cancelar</a>
                        <a href="{{url('')}}/table/{{$nombre_tabla}}" class="btn btn-success">Volver a la Lista</a>
                    </div>
                </div>
                <?php 
                if(!empty($columnas))
                {
                    foreach ($columnas as $key => $values) {
                        $value="";
                        $columna=str_replace("_"," ",ucwords($columnas[$key]->COLUMN_NAME));
                        
                        switch ($columnas[$key]->DATA_TYPE) {
                            
                            case 'date':
                              $type="date";
                              $value=date("Y-m-d");
                              break;
                            case 'int':
                              $type="number";
                              break;
                            default:
                              $type="text";
                              break;
                        }
                        switch ($columnas[$key]->IS_NULLABLE) {
                            case 'YES':
                              $required="";
                              $required_label="";
                              break;
                            case 'NO':
                              $required="required";
                              $required_label="*";
                              break;
                            default:
                              $required="";
                              $required_label="";
                              break;
                        }
                        ?>
                        
                        <?php 
                        if($columnas[$key]->DATA_TYPE!="enum"&&strpos($columnas[$key]->COLUMN_NAME,"id_")===false&&strpos($columnas[$key]->COLUMN_NAME,"_imagen")===false&&$columnas[$key]->COLUMN_NAME!="created_at"&&$columnas[$key]->COLUMN_NAME!="updated_at"&&$columnas[$key]->COLUMN_NAME!="id"){?>
                        <!-- begin col-2 -->                                
                        <div class="form-group col-md-12">
                            
                            <label class="col-md-3 text-right {{$columnas[$key]->COLUMN_NAME}}" ><span>{{$required_label}}</span>  {{$columna}}:</label>
                            <div class="col-md-3 div-create-{{$columnas[$key]->COLUMN_NAME}}" >
                                <input name="{{$columnas[$key]->COLUMN_NAME}}" class="form-control " id="input-{{$columnas[$key]->COLUMN_NAME}}"   type="{{$type}}" {{$required}} value="{{$value}}">    
                            </div>
                                                            
                            
                        </div>
                        <?php 
                        }
                        else if($columnas[$key]->DATA_TYPE=="enum")
                        {
                            $enum=$columnas[$key]->COLUMN_TYPE;
                            $enum=str_replace("enum(", "", $enum);
                            $enum=str_replace(")", "", $enum);
                            $enum=str_replace("'", "", $enum);
                            $enum=explode(",",$enum);

                        ?>
                        <!-- begin col-2 -->                                
                        <div class="form-group col-md-12 ">
                            
                            <label class="col-md-3 text-right {{$columnas[$key]->COLUMN_NAME}}" ><span>{{$required_label}}</span>  {{$columna}}:</label>
                            <div class="col-md-3">
                                <select name="{{$columnas[$key]->COLUMN_NAME}}"id="select-{{$columnas[$key]->COLUMN_NAME}}" class="form-control chosen-select" data-rel="chosen" data-parsley-group="" >
                                    <?php 
                                    if(!empty($enum)){
                                        foreach ($enum as $key1 => $value1) {
                                    ?>
                                    <option value="{{$value1}}">{{$value1}}</option>
                                            
                                    
                                    <?php
                                        }
                                    }?>
                                </select>
                            </div>
                        </div>
                        <!-- end col-2 -->                      
                        
                        <?php 
                        }
                        else if(strpos($columnas[$key]->COLUMN_NAME,"id_")!==false)
                        {

                            $nombre_tabla_1=str_replace("id_", "", $columnas[$key]->COLUMN_NAME);
                            $registros_1=TableModel::registros_by_tabla($nombre_tabla_1,"and estado_".$nombre_tabla_1."='activo'");
                            $columnas_1=TableModel::columnas_by_tabla($nombre_tabla_1)[0];
                            $campos_1=array();
                            if($columnas_1->COLUMN_COMMENT!="")
                            {
                                $campos_1=explode(",", $columnas_1->COLUMN_COMMENT);    
                            }


                            
                        ?>
                        <!-- begin col-2 -->                                
                        <div class="form-group col-md-12 ">
                            
                            <label class="col-md-3 text-right">{{$required_label}} {{ucwords($nombre_tabla_1)}}:</label>
                            <div class="col-md-3">
                                <select name="{{$columnas[$key]->COLUMN_NAME}}"id="select-{{$columnas[$key]->COLUMN_NAME}}" class="form-control chosen-select" data-rel="chosen" data-parsley-group="" data-placeholder="{{$nombre_tabla_1}}" {{$required}}>
                                    <option value=""></option>
                                    <?php 
                                    if(!empty($registros_1)){
                                        foreach ($registros_1 as $key1 => $value1)
                                        {
                                    ?>
                                    <option value="{{$value1->id}}">
                                    <?php 
                                    
                                    if(!empty($campos_1)){

                                    foreach ($campos_1 as $key2 => $value2) {?>

                                        {{$value1->$value2." "}}    

                                    <?php }
                                    }
                                    else{?>
                                        {{$value1->$nombre_tabla_1}}    
                                    <?php }?>
                                        
                                    </option>
                                            
                                    
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- end col-2 -->                      
                        
                        <?php 

                        }
                        else if(strpos($columnas[$key]->COLUMN_NAME,"_imagen")!==false)
                        {
                        
                        ?>
                        <!-- begin col-2 -->                                
                        <div class="form-group col-md-12 ">
                            <label class="col-md-3 text-right {{$columnas[$key]->COLUMN_NAME}}" ><span>{{$required_label}}</span>  {{$columna}}:</label>
                            <div class="col-md-3">
                                <input name="{{$columnas[$key]->COLUMN_NAME}}" class="form-control " id="input-{{$columnas[$key]->COLUMN_NAME}}"   type="file" {{$required}} value="{{$value}}">    
                            </div>
                        </div>
                        <!-- end col-2 -->                      
                        
                        <?php 
                        }
                        ?>

                    
                  
                  <?php 
                    }
                  }
                ?>   
                           
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

@include("table.personalizacion");

@endsection

