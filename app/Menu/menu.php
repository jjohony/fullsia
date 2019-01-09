<?php 
namespace App\Menu;
use App\Models\Admin\users;
use App\Models\estudiante;
class menu
{
	public static function menu_admin()
	{
		$usuario=users::me();
		$tipo=$usuario->nombre_grupo;
		$menu=array();

		switch ($tipo) {
			case 'administrador':
				$menu= [
		        "Inicio" => ['ruta'=>url('')."/inicio","icon"=>"fa fa-home","size-icon"=>"20px"],
		        "Usuario" => ['ruta'=>url('')."/usuario/administrativo","icon"=>"fa fa-users","size-icon"=>"20px"],
		        
		        
             ];		
				break;
			case 'academico':
				$carrera=users::registros_by_tabla("carrera","and estado_carrera='activo'");
				
				//dd($data);
				$menu= [
		        "Inicio" => ['ruta'=>url('')."/inicio","icon"=>"fa fa-home","size-icon"=>"20px"],  
		        
		        /*"Notificación de Docente" => ['ruta'=>url('')."/docente/create/notificacion","icon"=>"fa fa-bell","size-icon"=>"20px"],*/
		        "Tablas" => [
		        	
		        	["titulo"=>"Configuración" ,"ruta"=>url('')."/table/configuracion","icon"=>"fa fa-cog fa-spin","icon_principal"=>"fa fa-table","size-icon"=>"20px"],
		        	["titulo"=>"Asistencia de Docentes" ,"ruta"=>url('')."/table/asistencia_docente","icon"=>"fa fa-user-o","size-icon"=>"20px"],
		        	["titulo"=>"Docente" ,"ruta"=>url('')."/table/docente","icon"=>"fa fa-user-o","size-icon"=>"20px"],
		        	["titulo"=>"Estudiante" ,"ruta"=>url('')."/table/estudiante","icon"=>"fa fa-user-circle-o","size-icon"=>"20px"],
		        	["titulo"=>"Área" ,"ruta"=>url('')."/table/area","icon"=>"fa fa-area-chart","size-icon"=>"20px"],
		            ["titulo"=>"Carrera" ,"ruta"=>url('')."/table/carrera","icon"=>"fa fa-university","size-icon"=>"20px"],
		            ["titulo"=>"Pénsum" ,"ruta"=>url('')."/table/pensum","icon"=>"fa fa-table","size-icon"=>"20px"],
		            ["titulo"=>"Mensión" ,"ruta"=>url('')."/table/mencion","icon"=>"fa fa-table","size-icon"=>"20px"],
		            ["titulo"=>"Asignatura" ,"ruta"=>url('')."/table/asignatura","icon"=>"fa fa-table","size-icon"=>"20px"],
		            ["titulo"=>"Tipo de Evaluación" ,"ruta"=>url('')."/table/evaluacion","icon"=>"fa fa-table","size-icon"=>"20px"],
		            /*["titulo"=>"Notificación a Docentes" ,"ruta"=>url('')."/table/notificacion_docente","icon"=>"fa fa-inbox","size-icon"=>"20px"],*/
		            ["titulo"=>"Gestión" ,"ruta"=>url('')."/table/gestion","icon"=>"fa fa-table","size-icon"=>"20px"],

		            
		        ],
		        "Carreras" => ['ruta'=>url('')."/carreras","icon"=>"fa fa-home","size-icon"=>"20px"],  
		        
		    	];
		        $menu1= [
		        "Reportes" => [

		            ["titulo"=>"Reporte Historial Académico" ,"ruta"=>url('')."/reporte/index_reporte_historial_academico","icon"=>"fa fa-registered","icon_principal"=>"fa fa-registered","size-icon"=>"20px"],
		            ["titulo"=>"Reporte Asignación de Docentes" ,"ruta"=>url('')."/reporte/index_reporte_asignacion_de_docente","icon"=>"fa fa-registered","size-icon"=>"20px"],
		            ["titulo"=>"Reporte Estudiantes por Carrera" ,"ruta"=>url('')."/reporte/index_reporte_estudiantes_por_carrera","icon"=>"fa fa-registered","size-icon"=>"20px"],
		            ["titulo"=>"Reporte Cantidad de Estudiantes por Asignatura" ,"ruta"=>url('')."/reporte/index_reporte_cantidad_de_estudiantes","icon"=>"fa fa-registered","size-icon"=>"20px"],
		            ["titulo"=>"Reporte Estadisticas de Estudiantes" ,"ruta"=>url('')."/reporte/index_reporte_estadisticas_de_estudiantes","icon"=>"fa fa-registered","size-icon"=>"20px"],
		            ["titulo"=>"Reporte Estadísticas de Estudiantes general por carrera" ,"ruta"=>url('')."/reporte/index_reporte_estadisticas_de_estudiantes_por_carreras","icon"=>"fa fa-registered","size-icon"=>"20px"],
		            ["titulo"=>"Reporte Centralizador de calificaciones por carrera" ,"ruta"=>url('')."/reporte/index_reporte_centralizador_de_calificaciones","icon"=>"fa fa-registered","size-icon"=>"20px"],
		            ["titulo"=>"Reporte Boleta de Inscripción" ,"ruta"=>url('')."/reporte/index_reporte_boleta_inscripcion","icon"=>"fa fa-registered","size-icon"=>"20px"],
		            ["titulo"=>"Reporte Boleta de Asignación de Materias" ,"ruta"=>url('')."/reporte/index_reporte_boleta_de_asignacion_de_materias","icon"=>"fa fa-registered","size-icon"=>"20px"],

		            

		            
		        ],        
		        "Usuario Docente" => ['ruta'=>url('')."/usuario/docente","icon"=>"fa fa-users","size-icon"=>"20px"],
		        "Usuario Estudiante" => ['ruta'=>url('')."/usuario/estudiante","icon"=>"fa fa-users","size-icon"=>"20px"]
             ];	
             if(!empty($carrera))
				{
					foreach ($carrera as $key => $value) {
						$menu[$value->carrera][]=array("titulo"=>"Plan de Estudios" ,"ruta"=>url('')."/carrera/".$value->id."/plan_estudio","icon"=>"fa fa-table","icon_principal"=>"fa fa-university","size-icon"=>"20px");
						$menu[$value->carrera][]=array("titulo"=>"Cursos" ,"ruta"=>url('')."/carrera/".$value->id."/curso","icon"=>"fa fa-table","size-icon"=>"20px");
						$menu[$value->carrera][]=array("titulo"=>"Inscripción" ,"ruta"=>url('')."/carrera/".$value->id."/inscripcion","icon"=>"fa fa-table","size-icon"=>"20px");
				                
					}
				}	
				$menu=array_merge($menu,$menu1);
				break;
			case 'operador':
				$menu= [
		        "Inicio" => ['ruta'=>url('')."/inicio","icon"=>"fa fa-home","size-icon"=>"20px"],  
		        "Parametros" => [
		        	["titulo"=>"Nacionalidad" ,"ruta"=>url('')."/table/nacionalidad","icon"=>"fa fa-table","size-icon"=>"20px"],
		        	["titulo"=>"Estado civil" ,"ruta"=>url('')."/table/estado_civil","icon"=>"fa fa-table","size-icon"=>"20px"],
		        	["titulo"=>"Nivel" ,"ruta"=>url('')."/table/nivel","icon"=>"fa fa-table","size-icon"=>"20px"],		        	
		        	["titulo"=>"Forma de Pago" ,"ruta"=>url('')."/table/forma_pago","icon"=>"fa fa-table","size-icon"=>"20px"],
		        	["titulo"=>"Unidad / Área" ,"ruta"=>url('')."/table/unidad_area","icon"=>"fa fa-table","size-icon"=>"20px"],
		        	["titulo"=>"Cargos" ,"ruta"=>url('')."/table/cargo","icon"=>"fa fa-table","size-icon"=>"20px"],
		        	["titulo"=>"Tipo de Contrato" ,"ruta"=>url('')."/table/tipo_contrato","icon"=>"fa fa-table","size-icon"=>"20px"],
		        	["titulo"=>"Banco" ,"ruta"=>url('')."/table/banco","icon"=>"fa fa-table","size-icon"=>"20px"],
		        	["titulo"=>"Tipo de pago" ,"ruta"=>url('')."/table/tipo_pago","icon"=>"fa fa-table","size-icon"=>"20px"],
		        	["titulo"=>"Tipo de descuento" ,"ruta"=>url('')."/table/tipo_descuento","icon"=>"fa fa-table","size-icon"=>"20px"],
		        	
		        ],
		        "Administrativo" => [
		        	["titulo"=>"Administrativo" ,"ruta"=>url('')."/table/administrativo","icon"=>"fa fa-users","size-icon"=>"20px"],
		        	["titulo"=>"Contrato de Administrativo" ,"ruta"=>url('')."/table/contrato_administrativo","icon"=>"fa fa-table","size-icon"=>"20px"],
		        	["titulo"=>"Pago Extra Administrativo" ,"ruta"=>url('')."/table/pago_extra_administrativo","icon"=>"fa fa-table","size-icon"=>"20px"],
		        	["titulo"=>"Descuento Administrativo" ,"ruta"=>url('')."/table/descuento_administrativo","icon"=>"fa fa-table","size-icon"=>"20px"],
		        	["titulo"=>"Pago Administrativo" ,"ruta"=>url('')."/pago_administrativo","icon"=>"fa fa-table","size-icon"=>"20px"],


		        ],
		        "Docente" => [
		        	["titulo"=>"Docente" ,"ruta"=>url('')."/table/docente","icon"=>"fa fa-user-o","size-icon"=>"20px"],
		        	["titulo"=>"Contrato de Docente" ,"ruta"=>url('')."/table/contrato_docente","icon"=>"fa fa-table","size-icon"=>"20px"],
		        	["titulo"=>"Pago Extra Docente" ,"ruta"=>url('')."/table/pago_extra_docente","icon"=>"fa fa-table","size-icon"=>"20px"],
		        	["titulo"=>"Descuento Docente" ,"ruta"=>url('')."/table/descuento_docente","icon"=>"fa fa-table","size-icon"=>"20px"],
		        	["titulo"=>"Pago docente" ,"ruta"=>url('')."/pago_docente","icon"=>"fa fa-table","size-icon"=>"20px"],

		        ],
            "Estudiante" => [
              ["titulo"=>"Estudiante" ,"ruta"=>url('')."/table/estudiante","icon"=>"fa fa-user-circle-o","size-icon"=>"20px"],
              ["titulo"=>"Concepto pago" ,"ruta"=>url('')."/table/concepto_pago","icon"=>"fa fa-table","size-icon"=>"20px"],
              ["titulo"=>"Factura Estudiante" ,"ruta"=>url('')."/factura_estudiante/create","icon"=>"fa fa-table","size-icon"=>"20px"],
              ["titulo"=>"Lista de Pagos registrados" ,"ruta"=>url('')."/factura_estudiante","icon"=>"fa fa-table","size-icon"=>"20px"],
              ["titulo"=>"Control de Pagos" ,"ruta"=>url('')."/factura_estudiante/control_pagos","icon"=>"fa fa-table","size-icon"=>"20px"],
              
            ],
            
            "Reportes" => [
              ["titulo"=>"Planillas Sueldos y Salarios" ,"ruta"=>url('')."/reporte/index_reporte_planillas_sueldo_y_salarios","icon"=>"fa fa-registered","size-icon"=>"20px"],
              ["titulo"=>"Reporte de Ingresos" ,"ruta"=>url('')."/reporte/index_reporte_factura_estudiante_ingresos","icon"=>"fa fa-registered","size-icon"=>"20px"],
              ["titulo"=>"Detalle de pagos por estudiante" ,"ruta"=>url('')."/reporte/index_reporte_detalle_de_pagos_por_estudiante","icon"=>"fa fa-registered","size-icon"=>"20px"],
              ["titulo"=>"Reporte Historial de Usuario" ,"ruta"=>url('')."/reporte/index_reporte_historial_de_usuario","icon"=>"fa fa-registered","size-icon"=>"20px"],
              
              
            ],
		        	
             ];		
				break;	
			case 'docente':
				$carrera=users::registros_by_tabla("carrera","and estado_carrera='activo'");
				$menu= [
		        "Inicio" => ['ruta'=>url('')."/inicio","icon"=>"fa fa-home","size-icon"=>"20px"],  
	            ];
	            if(!empty($carrera))
				{
					foreach ($carrera as $key => $value) {
						
						
						$menu[$value->carrera][]=array("titulo"=>"Cursos" ,"ruta"=>url('')."/carrera/".$value->id."/curso","icon"=>"fa fa-table","size-icon"=>"20px");
						
				                
					}
				}	
				
		        /*$menu1= ["Notificación" => ['ruta'=>url('')."/docente/notificacion","icon"=>"fa fa-bell","size-icon"=>"20px"],  	        
             	];*/		
             	//$menu=array_merge($menu,$menu1);
				break;
			case 'estudiante':
				$carrera=estudiante::carreras_by_estudiante($usuario->id_persona);
				$menu= [
			        "Inicio" => ['ruta'=>url('')."/inicio","icon"=>"fa fa-home","size-icon"=>"20px"]
			    ];
			        
			        
	             	
	             if(!empty($carrera))
				{
					foreach ($carrera as $key => $value) {
						
						
						$menu[$value->carrera][]=array("titulo"=>"Historial académico" ,"ruta"=>url('')."/carrera/".$value->id."/".$usuario->id_persona."/estudiante_nota","icon"=>"fa fa-registered","icon_principal"=>"fa fa-university","size-icon"=>"20px");
						$menu[$value->carrera][]=array("titulo"=>"Calificaciones Actuales" ,"ruta"=>url('')."/carrera/".$value->id."/".$usuario->id_persona."/estudiante_nota_actuales","icon"=>"fa fa-table","size-icon"=>"20px");
						
				                
					}
				}
				$menu1=[
				"Reporte Historial de Pagos" => ['ruta'=>url('')."/reporte/reporte_historial_factura_estudiante/".$usuario->id_persona,"icon"=>"fa fa-registered","size-icon"=>"20px","target"=>"_blank"],  
				];
				$menu=array_merge($menu,$menu1);

			default:
				# code...
				break;
		}
		
		
        return $menu;
	}
}