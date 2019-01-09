
@extends('admin.templates.contenido')
@section('link')
<link href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="assets/plugins/DataTables/extensions/Buttons/css/buttons.bootstrap.min.css" rel="stylesheet" />
<link href="assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
@endsection

@section("content_contenido")
<!-- begin row -->
<div class="row">
    @include("admin.templates.form_tab")
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
                <button type="button" class="btn btn-success" id="tabla-button-nuevo">Nuevo</button>
                <table id="data-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <?php foreach ($columnas as $key => $value) {?>
                                <th>{{str_replace("_"," ",ucwords($columnas[$key]["COLUMN_NAME"]))}}</th>    
                            <?php }?>
                            <th>Acciones</th>
                            
                        </tr>
                    </thead>
                    <tbody id="tbody-contenido">
                        <?php 
                        if(!empty($db_tabla))
                        {
                            foreach ($db_tabla as $key => $value) {?>
                            <tr class="" id="tabla-tr-<?php echo $value->id;?>">
                                <?php foreach ($columnas as $key1 => $value1) {
                                    $nombre_campo=$columnas[$key1]["COLUMN_NAME"];?>
                                 
                                <td>{{$value->$nombre_campo}}</td>
                                
                                <?php }?>
                                <td class="td-acciones">
                                    <a class="btn btn-info  "href="<?php echo url('').'/'.$accion.'/'.$value->id.'/edit'?>" id="tabla-editar-<?php echo $value->id;?>" onclick="editar_tabla(<?php echo $value->id;?>,event);">Editar</a>
                                    <form method="POST" action="<?php echo url('').'/'.$accion.'/'.$value->id;?>" accept-charset="UTF-8" id="tabla-eliminar-<?php echo $value->id;?>">
                                        <input name="_method" type="hidden" value="DELETE">
                                        {{csrf_field()}}
                                        <input class="btn btn-danger" type="submit"  value="Delete" onclick="eliminar_tabla(<?php echo $value->id;?>,event)">
                                    </form>
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
@endsection