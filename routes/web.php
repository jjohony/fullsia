<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/inicio', 'HomeController@index');

Route::get("/","Auth\LoginController@showLoginForm");
Auth::routes();


Route::get("usuario_inicio","UsuarioController@usuario_inicio");
/*Administrador*/
Route::resource("admin","AdminController");
/*Table*/
Route::get("table/{nombre_tabla}","TableController@index");
Route::get("table/create/{nombre_tabla}","TableController@create");
Route::post("table/{nombre_tabla}","TableController@store");
Route::get("table/{nombre_tabla}/{id_tabla}","TableController@show");
Route::get("table/{nombre_tabla}/{id_tabla}/edit","TableController@edit");
Route::put("table/{nombre_tabla}/{id_tabla}","TableController@update");
Route::get("table/{nombre_tabla}/{id_tabla}/delete","TableController@delete");
Route::delete("table/{nombre_tabla}/{id_tabla}","TableController@destroy");

/*Carrera*/
/*Asignatura_mencion_pensum*/
Route::get("carreras","CarreraController@index");

Route::get("carrera/{id_carrera}/plan_estudio","CarreraController@index_asignatura_mencion_pensum");
Route::get("carrera/{id_carrera}/plan_estudio/{id_asignatura_mencion_pensum}","CarreraController@show_asignatura_mencion_pensum");
Route::get("carrera/{id_carrera}/create/plan_estudio","CarreraController@create_asignatura_mencion_pensum");
Route::post("carrera/{id_carrera}/plan_estudio","CarreraController@store_asignatura_mencion_pensum");
Route::get("carrera/{id_carrera}/plan_estudio/{id_asignatura_mencion_pensum}/edit","CarreraController@edit_asignatura_mencion_pensum");
Route::put("carrera/{id_carrera}/plan_estudio/{id_asignatura_mencion_pensum}","CarreraController@update_asignatura_mencion_pensum");
Route::get("carrera/{id_carrera}/plan_estudio/{id_asignatura_mencion_pensum}/delete","CarreraController@delete_asignatura_mencion_pensum");
Route::delete("carrera/{id_carrera}/plan_estudio/{id_asignatura_mencion_pensum}","CarreraController@destroy_asignatura_mencion_pensum");

/*Pre-requisitos*/
Route::get("pre_requisito/{id_carrera}/{id_asignatura_mencion_pensum}","CarreraController@index_pre_requisito");
Route::get("guardar_pre_requisito/{id_pre_requisito_amp}/{id_amp}","CarreraController@guardar_pre_requisito");

/*Curso*/
Route::get("carrera/{id_carrera}/curso","CursoController@index_curso");
Route::get("carrera/{id_carrera}/curso/{id_curso}","CursoController@show_curso");
Route::get("carrera/{id_carrera}/create/curso","CursoController@create_curso");
Route::post("carrera/{id_carrera}/curso","CursoController@store_curso");
Route::get("carrera/{id_carrera}/curso/{id_curso}/edit","CursoController@edit_curso");
Route::put("carrera/{id_carrera}/curso/{id_curso}","CursoController@update_curso");
Route::get("carrera/{id_carrera}/curso/{id_curso}/delete","CursoController@delete_curso");
Route::delete("carrera/{id_carrera}/curso/{id_curso}","CursoController@destroy_curso");

Route::post("carrera/{id_carrera}/curso_by_parametros","CursoController@curso_by_parametros");
Route::post("carrera/{id_carrera}/buscar_asignaturas_nivel_mencion_pensum","CursoController@buscar_asignaturas_nivel_mencion_pensum");

/*Nota*/
Route::get("carrera/{id_carrera}/{id_curso}/nota","NotaController@index_nota");
Route::get("carrera/{id_carrera}/{id_curso}/nota/{id_nota}","NotaController@show_nota");
Route::get("carrera/{id_carrera}/{id_curso}/create/nota","NotaController@create_nota");
Route::post("carrera/{id_carrera}/{id_curso}/nota","NotaController@store_nota");
Route::get("carrera/{id_carrera}/{id_curso}/nota/{id_nota}/edit","NotaController@edit_nota");
Route::put("carrera/{id_carrera}/{id_curso}/nota/{id_nota}","NotaController@update_nota");
Route::get("carrera/{id_carrera}/{id_curso}/nota/{id_nota}/delete","NotaController@delete_nota");
Route::delete("carrera/{id_carrera}/{id_curso}/nota/{id_nota}","NotaController@destroy_nota");

Route::post("guardar_nota","NotaController@guardar_nota");
Route::get("estado_inscrito/{id_carrera}/{id_curso}/estado/{estado}","NotaController@estado_inscrito");
Route::get("reporte_boletin_calificacion/{id_curso}/nota","NotaController@reporte_boletin_calificacion");
Route::get("reporte_lista_de_estudiantes/{id_curso}/nota","NotaController@reporte_lista_de_estudiantes");

/*Asistencia*/
Route::get("carrera/{id_carrera}/{id_curso}/asistencia","NotaController@index_asistencia");
Route::post("guardar_asistencia","NotaController@guardar_asistencia");


/*Estudiante*/
Route::get("carrera/{id_carrera}/estudiante","EstudianteController@index_estudiante");
Route::get("carrera/{id_carrera}/estudiante/{id_estudiante}","EstudianteController@show_estudiante");
Route::get("carrera/{id_carrera}/create/estudiante","EstudianteController@create_estudiante");
Route::post("carrera/{id_carrera}/estudiante","EstudianteController@store_estudiante");
Route::get("carrera/{id_carrera}/estudiante/{id_estudiante}/edit","EstudianteController@edit_estudiante");
Route::put("carrera/{id_carrera}/estudiante/{id_estudiante}","EstudianteController@update_estudiante");
Route::get("carrera/{id_carrera}/estudiante/{id_estudiante}/delete","EstudianteController@delete_estudiante");
Route::delete("carrera/{id_carrera}/estudiante/{id_estudiante}","EstudianteController@destroy_estudiante");

Route::get("carrera/{id_carrera}/{id_estudiante}/estudiante_nota","EstudianteController@index_nota");
Route::get("carrera/{id_carrera}/{id_estudiante}/estudiante_nota_actuales","EstudianteController@index_nota_actuales");
/*Cuota*/
Route::get("carrera/{id_carrera}/estudiante/{id_estudiante}/cuota","EstudianteController@index_cuota");
Route::get("carrera/{id_carrera}/estudiante/{id_estudiante}/cuota/{id_cuota}","EstudianteController@show_cuota");
Route::get("carrera/{id_carrera}/estudiante/{id_estudiante}/create/cuota","EstudianteController@create_cuota");
Route::post("carrera/{id_carrera}/estudiante/{id_estudiante}/cuota","EstudianteController@store_cuota");
Route::get("carrera/{id_carrera}/estudiante/{id_estudiante}/cuota/{id_cuota}/edit","EstudianteController@edit_cuota");
Route::put("carrera/{id_carrera}/estudiante/{id_estudiante}/cuota/{id_cuota}","EstudianteController@update_cuota");
Route::get("carrera/{id_carrera}/estudiante/{id_estudiante}/cuota/{id_cuota}/delete","EstudianteController@delete_cuota");
Route::delete("carrera/{id_carrera}/estudiante/{id_estudiante}/cuota/{id_cuota}","EstudianteController@destroy_cuota");

/*Usuario*/
Route::get("usuario/{nombre_tabla}","UsuarioController@index");
Route::get("usuario/create/{nombre_tabla}","UsuarioController@create");
Route::post("usuario/{nombre_tabla}","UsuarioController@store");
Route::get("usuario/{nombre_tabla}/{id}","UsuarioController@show");
Route::get("usuario/{nombre_tabla}/{id}/edit","UsuarioController@edit");
Route::put("usuario/{nombre_tabla}/{id}","UsuarioController@update");
Route::get("usuario/{nombre_tabla}/{id}/delete","UsuarioController@delete");
Route::delete("usuario/{nombre_tabla}/{id}","UsuarioController@destroy");

/*Inscripcion*/
Route::get("carrera/{id_carrera}/inscripcion","InscripcionController@formulario");
Route::post("carrera/{id_carrera}/inscripcion_formulario","InscripcionController@inscripcion_formulario");
Route::get("carrera/{id_carrera}/estudiante/{id_estudiante}/gestion/{id_gestion}/inscripcion_concluida","InscripcionController@concluido");


Route::get("carrera/{id_carrera}/estudiante/{id_estudiante}/gestion/{id_gestion}/inscripcion","InscripcionController@index");
Route::post("carrera/{id_carrera}/estudiante/{id_estudiante}/gestion/{id_gestion}/inscripcion","InscripcionController@store");
Route::get("carrera/{id_carrera}/estudiante/{id_estudiante}/gestion/{id_gestion}/inscripcion/{id_inscripcion}/delete","InscripcionController@delete");

/*Pago Administrativo*/
Route::get("pago_administrativo","Pago_administrativoController@index");
Route::get("pago_administrativo/create","Pago_administrativoController@create");
Route::post("pago_administrativo","Pago_administrativoController@store");
Route::get("pago_administrativo/reporte_boleta_pago/{id}","Pago_administrativoController@reporte_boleta_pago");
Route::get("pago_administrativo/reporte_detalle_boleta_pago/{id}","Pago_administrativoController@reporte_detalle_boleta_pago");


/*Pago Docente*/
Route::get("pago_docente","Pago_docenteController@index");
Route::get("pago_docente/create","Pago_docenteController@create");
Route::post("pago_docente","Pago_docenteController@store");
Route::get("pago_docente/reporte/{id}","Pago_docenteController@reporte");

Route::get("pago_docente/reporte_boleta_pago/{id}","Pago_docenteController@reporte_boleta_pago");
Route::get("pago_docente/reporte_detalle_boleta_pago/{id}","Pago_docenteController@reporte_detalle_boleta_pago");

Route::get("docente/notificacion","Pago_docenteController@index_notificacion");
Route::get("docente/create/notificacion","Pago_docenteController@create_notificacion");
Route::post("docente/notificacion","Pago_docenteController@store_notificacion");
Route::get("docente/notificacion/{id_notificacion}/show","Pago_docenteController@show_notificacion");


/*Factura estudiante*/
Route::get("factura_estudiante","Factura_estudianteController@index");
Route::get("factura_estudiante/create","Factura_estudianteController@create");
Route::post("factura_estudiante","Factura_estudianteController@store");
Route::get("factura_estudiante/{nombre_tabla}/{id}","Factura_estudianteController@show");
Route::get("factura_estudiante/{nombre_tabla}/{id}/edit","Factura_estudianteController@edit");
Route::put("factura_estudiante/{nombre_tabla}/{id}","Factura_estudianteController@update");
Route::get("factura_estudiante/{nombre_tabla}/{id}/delete","Factura_estudianteController@delete");
Route::delete("factura_estudiante/{nombre_tabla}/{id}","Factura_estudianteController@destroy");
Route::get("factura_estudiante/control_pagos","Factura_estudianteController@index_control_pagos");

/*Reporte*/
Route::get("reporte/index_reporte_planillas_sueldo_y_salarios","Pago_administrativoController@index_reporte_planillas_sueldos_y_salarios");
Route::get("reporte/reporte_planillas_sueldo_y_salarios","Pago_administrativoController@reporte_planillas_sueldos_y_salarios");

Route::get("reporte/reporte_personal_de_la_institucion","Pago_administrativoController@reporte_personal_de_la_institucion");
Route::get("reporte/reporte_factura_estudiante/{id_factura_estudiante}","Factura_estudianteController@reporte_factura_estudiante");
Route::get("reporte/reporte_historial_factura_estudiante/{id_estudiante}","Factura_estudianteController@reporte_historial_factura_estudiante");

Route::get("reporte/index_reporte_factura_estudiante_ingresos","Factura_estudianteController@index_reporte_factura_estudiante_ingresos");
Route::get("reporte/reporte_factura_estudiante_ingresos","Factura_estudianteController@reporte_factura_estudiante_ingresos");

Route::get("reporte/grafico_factura_estudiante_ingresos","Factura_estudianteController@grafico_factura_estudiante_ingresos");

Route::get("reporte/index_reporte_detalle_de_pagos_por_estudiante","Factura_estudianteController@index_reporte_detalle_de_pagos_por_estudiante");
Route::get("reporte/reporte_detalle_de_pagos_por_estudiante","Factura_estudianteController@reporte_detalle_de_pagos_por_estudiante");

Route::get("reporte/index_reporte_asignacion_de_docente","Pago_docenteController@index_reporte_asignacion_de_docente");
Route::get("reporte/reporte_asignacion_de_docente","Pago_docenteController@reporte_asignacion_de_docente");

Route::get("reporte/index_reporte_estudiantes_por_carrera","CarreraController@index_reporte_estudiantes_por_carrera");
Route::get("reporte/reporte_estudiantes_por_carrera","CarreraController@reporte_estudiantes_por_carrera");

Route::get("reporte/index_reporte_cantidad_de_estudiantes","CarreraController@index_reporte_cantidad_de_estudiantes");
Route::get("reporte/reporte_cantidad_de_estudiantes","CarreraController@reporte_cantidad_de_estudiantes");

Route::get("reporte/index_reporte_estadisticas_de_estudiantes","CarreraController@index_reporte_estadisticas_de_estudiantes");
Route::get("reporte/reporte_estadisticas_de_estudiantes","CarreraController@reporte_estadisticas_de_estudiantes");


Route::get("reporte/index_reporte_estadisticas_de_estudiantes_por_carreras","CarreraController@index_reporte_estadisticas_de_estudiantes_por_carreras");
Route::get("reporte/reporte_estadisticas_de_estudiantes_por_carreras","CarreraController@reporte_estadisticas_de_estudiantes_por_carreras");

Route::get("reporte/index_reporte_historial_academico","CarreraController@index_reporte_historial_academico");
Route::get("reporte/reporte_historial_academico","CarreraController@reporte_historial_academico");


Route::get("reporte/index_reporte_centralizador_de_calificaciones","CarreraController@index_reporte_centralizador_de_calificaciones");
Route::get("reporte/reporte_centralizador_de_calificaciones","CarreraController@reporte_centralizador_de_calificaciones");

Route::get("reporte/index_reporte_boleta_inscripcion","CarreraController@index_reporte_boleta_inscripcion");
Route::get("reporte/reporte_boleta_inscripcion","CarreraController@reporte_boleta_inscripcion");

Route::get("reporte/index_reporte_boleta_de_asignacion_de_materias","CarreraController@index_reporte_boleta_de_asignacion_de_materias");
Route::get("reporte/reporte_boleta_de_asignacion_de_materias","CarreraController@reporte_boleta_de_asignacion_de_materias");

Route::get("reporte/index_reporte_historial_de_usuario","UsuarioController@index_reporte_historial_de_usuario");
Route::get("reporte/reporte_historial_de_usuario","UsuarioController@reporte_historial_de_usuario");

Route::get("reporte/reporte_asistencia_de_estudiantes/{id_curso}","EstudianteController@reporte_asistencia_de_estudiantes");



Route::get("reporte/reporte_boleta_de_calificaciones_dividido_por_semestre/{id_carrera}/{id_curso}","CarreraController@reporte_boleta_de_calificaciones_dividido_por_semestre");

Route::get("reporte/index_reporte_asistencia_de_docente","Pago_docenteController@index_reporte_asistencia_de_docente");
Route::get("reporte/reporte_asistencia_de_docente","Pago_docenteController@reporte_asistencia_de_docente");

Route::get("ajustes_usuario_edit","UsuarioController@ajustes_usuario_edit");
Route::post("ajustes_usuario_save","UsuarioController@ajustes_usuario_save");


