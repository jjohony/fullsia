
<script type="text/javascript">

	$(".div-create-anio").html("");
	$(".div-create-anio").html("<select class='form-control' name='anio'><option value='<?php echo date("Y")?>'><?php echo date("Y")?></option><option value='<?php echo date("Y")-1?>'><?php echo date("Y")-1?></option><option value='<?php echo date("Y")-2?>'><?php echo date("Y")-2?></option><option value='<?php echo date("Y")-3?>'><?php echo date("Y")-3?></option><option value='<?php echo date("Y")-4?>'><?php echo date("Y")-4?></option></select>");
	<?php if(!empty($registro)){?>
	$(".div-edit-anio").html("");
	$(".div-edit-anio").html("<select class='form-control' name='anio'><option value='<?php echo date("Y")?>' <?php echo ($registro->anio==date("Y"))?"selected":"";?>><?php echo date("Y")?></option><option value='<?php echo date("Y")-1?>' <?php echo ($registro->anio==date("Y")-1)?"selected":"";?>><?php echo date("Y")-1?></option><option value='<?php echo date("Y")-2?>' <?php echo ($registro->anio==date("Y")-2)?"selected":"";?>><?php echo date("Y")-2?></option><option value='<?php echo date("Y")-3?>' <?php echo ($registro->anio==date("Y")-3)?"selected":"";?>><?php echo date("Y")-3?></option><option value='<?php echo date("Y")-4?>' <?php echo ($registro->anio==date("Y")-4)?"selected":"";?>><?php echo date("Y")-4?></option></select>");

	<?php }?>

</script>