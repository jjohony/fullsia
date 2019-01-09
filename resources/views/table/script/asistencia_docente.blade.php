
<script type="text/javascript">
	

	function mueveReloj(){ 
	   	momentoActual = new Date() 
	   	hora = momentoActual.getHours() 
	   	minuto = momentoActual.getMinutes() 
	   	segundo = momentoActual.getSeconds() 
	   	str_hora = new String (hora) 
	   	str_minuto = new String (minuto) 
	   	str_segundo = new String (segundo) 
	   	if(str_hora.length==1)
	   	{

	   		hora="0"+hora;
	   	}
	   	if(str_minuto.length==1)
	   	{
	   		minuto="0"+minuto;
	   	}
	   	if(str_segundo.length==1)
	   	{
	   		segundo="0"+segundo;
	   	}
	   	

	   	$("#titulo").text("Asistencia de Docentes {{date('d-m-Y')}} "+hora+":"+minuto+":"+segundo);
	   	setTimeout("mueveReloj()",1000); 
	} 

	$("#formulario-create #input-hora").val("{{date('H')}}");
	$("#formulario-create #input-minuto").val("{{date('i')}}");
	$("#formulario-create #input-segundo").val("{{date('s')}}");
	$("#titulo").text("Asistencia de Docentes {{date('d-m-Y H:i:s')}}");
	mueveReloj();

	$(".div-button-nuevo").append("<a href='{{url('')}}/reporte/index_reporte_asistencia_de_docente' class='btn btn-success'>Reportar</a>")
	
</script>