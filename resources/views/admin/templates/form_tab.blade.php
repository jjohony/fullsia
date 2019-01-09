@section("link")	
	<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
	<link href="{{url('')}}/assets/plugins/bootstrap-wizard/css/bwizard.min.css" rel="stylesheet" />
	<link href="{{url('')}}/assets/plugins/parsley/src/parsley.css" rel="stylesheet" />
	<!-- ================== END PAGE LEVEL STYLE ================== -->
@endsection
<?php 

$titulo=array("Primer paso","Segundo paso","Tercer paso","Cuarto paso","Quinto paso","Sexto paso","Septimo paso");



$tamanio=count((array)$columnas);

if($tamanio<=6)
{
	$tab=1;
	$campos=6;
}
else if($tamanio<=12)
{
	$tab=2;
	$campos=6;
}
else if($tamanio<=18)
{
	$tab=3;
	$campos=6;
}

?>	
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
            <h4 class="panel-title" id="titulo_formulario">Formulario adicionar</h4>
        </div>
        <div class="panel-body">

            <form action="" method="POST" data-parsley-validate="true" name="form-wizard"id="form-wizard" enctype="multipart/form-data">
            	{{csrf_field()}}
            	<div id="div-formulario-wizard">
            		
            	</div>
				<div id="wizard">
					<ol>
						<?php for($i=0;$i<$tab;$i++){ ?>
						<li>
						    <?php echo $titulo[$i]; ?>
						    <small></small>
						</li>
						<?php } ?>
						<li>
						    Completado
						    <small></small>
						</li>
					</ol>
					<?php $j=0;
						for($i=0;$i<$tab;$i++){
						?>
					<!-- begin wizard step-1 -->
					<div class="wizard-step-<?php echo ($i+1);?>">
                        <fieldset>
                            <legend class="pull-left width-full"><?php echo $titulo[$i];?></legend>
                            <!-- begin row -->
                            <div class="row">
                                <?php 
                                for($k=$j;$k<($campos*($i+1));$k++){
                                	if(isset($columnas[$k])){
                                		if(gettype(strpos($columnas[$k]["COLUMN_NAME"],"id_"))=="integer"){
                                ?>
		                                <!-- begin col-4 -->                                
		                                <div class="col-md-4 {{$k.'-'.$i.'-'.($campos*($i+1)) }}">
											<div class="form-group block1 " id="form-group-{{$columnas[$k]['COLUMN_NAME']}}">
												<label id="label-{{$columnas[$k]['COLUMN_NAME']}}">{{str_replace("_"," ",ucwords($columnas[$k]["COLUMN_NAME"]))}}</label>
												<select name="{{$columnas[$k]['COLUMN_NAME']}}" class="form-control select-{{$columnas[$k]['COLUMN_NAME']}}" id="select-{{$columnas[$k]['COLUMN_NAME']}}" data-parsley-group="wizard-step-<?php echo ($i+1);?>" required>
													
												</select>
												
											</div>
		                                </div>
		                                <!-- end col-4 -->
                                <?php
                                		}
                                		else{
                               	?>
											<!-- begin col-4 -->                                
			                                <div class="col-md-4 {{$k.'-'.$i.'-'.($campos*($i+1)) }}">
												<div class="form-group block1" id="form-group-{{$columnas[$k]['COLUMN_NAME']}}">
													<label id="label-{{$columnas[$k]['COLUMN_NAME']}}">{{str_replace("_"," ",ucwords($columnas[$k]["COLUMN_NAME"]))}}</label>
													<input id="input-{{$columnas[$k]['COLUMN_NAME']}}" type="text" name="{{$columnas[$k]['COLUMN_NAME']}}" placeholder="{{str_replace("_"," ",ucwords($columnas[$k]['COLUMN_NAME']))}}" class="form-control" data-parsley-group="wizard-step-<?php echo ($i+1);?>" required />
												</div>
			                                </div>
			                                <!-- end col-4 -->
                                <?php	}
                                	}
                                } 
                                $j=$j+$campos;
                                ?>
                                
                            </div>
                            <!-- end row -->
						</fieldset>
					</div>
					<!-- end wizard step-1 -->
					<?php } ?>
					<!-- begin wizard step-4 -->
					<div>
					    <div class="jumbotron m-b-0 text-center">
                            <h1>Formulario correctamente llenado</h1>
                            <p>Si desea continuar con la acción, presione el boton</p>
                            <p><button class="btn btn-success btn-lg" role="button" id="button-formulario">Enviar</button></p>
                        </div>
					</div>
					<!-- end wizard step-4 -->
				</div>
			</form>
        </div>
    </div>
    <!-- end panel -->
</div>
<!-- end col-12 -->
	
@section("script")	
	
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="{{url('')}}/assets/plugins/parsley/dist/parsley.js"></script>
	<script src="{{url('')}}/assets/plugins/bootstrap-wizard/js/bwizard.js"></script>
	<script src="{{url('')}}/assets/js/form-wizards-validation.demo.min.js"></script>
	
	<!-- ================== END PAGE LEVEL JS ================== -->
@endsection

@section("script_2")	
	<script>
		$(document).ready(function() {
			
			FormWizardValidation.init();
			$(".pager  .previous a").text("Anterior");
			$(".pager .next a").text("Siguiente");
			
		});
	</script>
	@include("admin.script.formulario");
@endsection


