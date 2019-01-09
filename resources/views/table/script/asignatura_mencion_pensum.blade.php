<?php 
	use App\Models\TableModel;
?>
<script type="text/javascript">
	$("#titulo").text("Plan de Estudios");
	$("#select-id_asignatura").html("").trigger("chosen:updated");
	<?php 
		$asignatura=TableModel::registros_by_tabla("asignatura");
		if(!empty($asignatura))
		{
			foreach ($asignatura as $key => $value) 
			{
	?>
				$("#select-id_asignatura").append("<option value='{{$value->id}}'>{{$value->sigla_asignatura.'-'.$value->asignatura}}</option>");
	<?php
			}
		}
	?>
	$("#select-id_asignatura").trigger("chosen:updated");
</script>