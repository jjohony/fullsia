<?php 
	$estado=false;
	switch ($nombre_tabla) {
		case 'asignatura_mencion_pensum':
			$estado=true;
			
			break;
		case 'tipo_pago':
			$estado=true;
			
			break;
		case 'pago_extra_administrativo':
			$estado=true;
		
			break;
		case 'pago_extra_docente':
			$estado=true;
		
			break;
		case 'descuento_administrativo':
			$estado=true;
		
			break;
		case 'descuento_docente':
			$estado=true;
		
			break;
		case 'configuracion':
			$estado=true;
		
			break;
		case 'mencion':
			$estado=true;
		
			break;

		case 'asistencia_docente':
			$estado=true;
		
			break;
		case 'evaluacion':
			$estado=true;
		
			break;
		
		default:
			
			break;
	}

?>
@if($estado)
	@include("table.script.".$nombre_tabla)
@endif