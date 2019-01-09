<?php
use App\Menu\menu;
use App\Helpers\Funciones;

use App\Models\Admin\users;

$usuario=users::me();
$id_persona=$usuario->id_persona;

switch ($usuario->nombre_grupo) {
	case 'administrador':
	    $persona_usuario=users::registros_by_tabla("administrativo","and id='$id_persona'")[0];
	    break;
	case 'academico':
	    $persona_usuario=users::registros_by_tabla("administrativo","and id='$id_persona'")[0];

	    //var_dump($persona_usuario);die;

	    //var_dump($persona_usuario->foto_imagen);die;
	    break;
	case 'docente':
		$persona_usuario=users::registros_by_tabla("docente","and id='$id_persona'")[0];
	    $notificacion=users::registros_by_tabla("notificacion_docente","and id_docente='$id_persona' and estado_notificacion_docente='activo' and estado_revisado='no revisado'");
	    
	    break;
	case 'estudiante':
	    $persona_usuario=users::registros_by_tabla("estudiante","and id='$id_persona'")[0];

	    break;
	case 'operador':
	    $persona_usuario=users::registros_by_tabla("administrativo","and id='$id_persona'")[0];

	    break;
	default:
	    # code...
	    break;
	}

$menu=menu::menu_admin();


?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8" />
	<title>SIA</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<link href="{{url('')}}/css/animate.css" rel="stylesheet" />
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="../../../../fonts.googleapis.com/cssff98.css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<link href="{{url('')}}/assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
	<link href="{{url('')}}/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="{{url('')}}/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
	<link href="{{url('')}}/assets/css/animate.min.css" rel="stylesheet" />
	<link href="{{url('')}}/assets/css/style.min.css" rel="stylesheet" />
	<link href="{{url('')}}/assets/css/style-responsive.min.css" rel="stylesheet" />
	<link href="{{url('')}}/assets/css/theme/default.css" rel="stylesheet" id="theme" />
	<!-- ================== END BASE CSS STYLE ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
	<link href="{{url('')}}/assets/plugins/jquery-jvectormap/jquery-jvectormap.css" rel="stylesheet" />
	<link href="{{url('')}}/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
    <link href="{{url('')}}/assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
    <link href="{{url('')}}/assets/plugins/chosen/chosen.min.css" rel="stylesheet">
	<!-- ================== END PAGE LEVEL STYLE ================== -->
	@yield("link")
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="{{url('')}}/assets/plugins/pace/pace.min.js"></script>
	<!-- ================== END BASE JS ================== -->
</head>
<body>
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade in"><span class="spinner"></span></div>
	<!-- end #page-loader -->
	
	<!-- begin #page-container -->
	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
		<!-- begin #header -->
		<div id="header" class="header navbar navbar-default navbar-fixed-top">
			<!-- begin container-fluid -->
			<div class="container-fluid">
				<!-- begin mobile sidebar expand / collapse button -->
				<div class="navbar-header">
					<a href="" class="navbar-brand"><span class="navbar-logo"></span> SIA</a>
					<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<!-- end mobile sidebar expand / collapse button -->
				
				<!-- begin header navigation right -->
				<ul class="nav navbar-nav navbar-right">
					
					@if($usuario->nombre_grupo=="docente"&&1==0)
					<li class="dropdown">
						<a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle f-s-14">
							<i class="fa fa-bell-o"></i>
							<span class="label">{{(!empty($notificacion))?count($notificacion):0}}</span>
						</a>

						<ul class="dropdown-menu media-list pull-right animated fadeInDown">
                            <li class="dropdown-header">Notificaciones ({{(!empty($notificacion))?count($notificacion):0}})</li>
                            @if(!empty($notificacion))
                            @foreach($notificacion as $key => $value)
                            <li class="media">
                                <a href="{{url('')}}/docente/notificacion/{{$value->id}}/show">
                                    
                                    <div class="media-body">
                                        <p class="media-heading">{{$value->notificacion_docente}}</p>
                                        
                                    </div>
                                </a>
                            </li>
                            @endforeach
                            @endif
                            <li class="dropdown-footer text-center">
                                <a href="{{url('')}}/docente/notificacion">Ver mas</a>
                            </li>
						</ul>
					</li>
					@endif
					
					
					<li class="dropdown navbar-user">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							@if($persona_usuario->foto_imagen!="")
							<img src="{{url('')}}/img/{{$persona_usuario->foto_imagen}}" alt="" />
							@else
							<img src="{{url('')}}/assets/img/persona.png" alt="" />
							@endif
							<span class="hidden-xs">{{$persona_usuario->nombre." " .$persona_usuario->paterno." ".$persona_usuario->materno}}</span> <b class="caret"></b>
						</a>
						<ul class="dropdown-menu animated fadeInLeft">
							<li class="arrow"></li>
							
							
							
							<li><a href="{{url('ajustes_usuario_edit')}}">Ajustes</a></li>
							<li class="divider"></li>
							<li>
							<a href="{{ url('/logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                Cerrar Session
                            </a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        	</li>
						</ul>
					</li>
				</ul>
				<!-- end header navigation right -->
			</div>
			<!-- end container-fluid -->
		</div>
		<!-- end #header -->
		
		<!-- begin #sidebar -->
		<div id="sidebar" class="sidebar">
			<!-- begin sidebar scrollbar -->
			<div data-scrollbar="true" data-height="100%">
				<!-- begin sidebar user -->
				<ul class="nav">
					<li class="nav-profile">
						<div class="col-md-12 ">
							@if($persona_usuario->foto_imagen!="")

							<a href="javascript:;" style=""><img src="{{url('')}}/img/{{$persona_usuario->foto_imagen}}" alt="" class="img-responsive img-circle"/></a>
							@else

							<a href="javascript:;" style=""><img src="{{url('')}}/assets/img/persona_usuario.png" alt="" class="img-responsive img-circle"/></a>
							@endif
						</div>
						<div class="info text-center">
							{{$persona_usuario->nombre." " .$persona_usuario->paterno." ".$persona_usuario->materno}}
							<small style="font-size:15px;" class="text-center">ROL: {{strtoupper($usuario->nombre_grupo)}}</small>
						
						</div>
					</li>
				</ul>
				<!-- end sidebar user -->
				<!-- begin sidebar nav -->
				<ul class="nav">

					<li class="nav-header">Menu</li>
					
					<?php 
					if($menu)
					{
						foreach ($menu as $key => $value) {
							if(isset($value["ruta"]))
							{

								
					?>
								<li><a href="{{$value['ruta']}}" target='<?php echo (isset($value["target"]))?$value["target"]:"";?>'><i class="{{$value['icon']}}"></i> <span>{{$key}}</span></a></li>

					<?php	
								
							}
							else
							{	
								foreach ($value as $key1 => $value1) {
									
									if($key1==0){
					?>
										<li class="has-sub ">
										<a href="javascript:;">
										    <b class="caret pull-right"></b>
										    <?php $icono=(isset($value1['icon_principal']))?$value1['icon_principal']:$value1['icon'];?>
										    <i class="{{$icono}}"></i>
										    <span>{{$key}}</span>
									    </a>
										<ul class="sub-menu">
											
											<li class=""><a href="{{$value1['ruta']}}"><i class="{{$value1['icon']}}"style="font-size:{{$value1['size-icon']}}"></i> <span>{{$value1["titulo"]}}</sapn></a></li>
											
					<?php 			}
									else{
										
					?>
											
											<li class=""><a href="{{$value1['ruta']}}"><i class="{{$value1['icon']}}" style="font-size:{{$value1['size-icon']}}"></i> <span>{{$value1["titulo"]}}</sapn></a></li>

					<?php				
									}
								}
					?>
									</ul>
								</li>
					<?php	}
							
						}
					}
					?>
					
			        <!-- begin sidebar minify button -->
					<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
			        <!-- end sidebar minify button -->
				</ul>
				<!-- end sidebar nav -->
			</div>
			<!-- end sidebar scrollbar -->
		</div>
		<div class="sidebar-bg"></div>
		<!-- end #sidebar -->
		
		@yield('content')
		
        
		
		<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
	</div>
	<!-- end page container -->
	<audio id="audio-alert" src="{{url('')}}/audio/alert.mp3" preload="auto"></audio>
	<audio id="audio-fail" src="{{url('')}}/audio/fail.mp3" preload="auto"></audio>
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="{{url('')}}/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
	<script src="{{url('')}}/assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
	<script src="{{url('')}}/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
	<script src="{{url('')}}/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<!--[if lt IE 9]>
		<script src="{{url('')}}/assets/crossbrowserjs/html5shiv.js"></script>
		<script src="{{url('')}}/assets/crossbrowserjs/respond.min.js"></script>
		<script src="{{url('')}}/assets/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
	<script src="{{url('')}}/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="{{url('')}}/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
	<!-- ================== END BASE JS ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	@yield("script")
	@yield("script_1")
	<script src="{{url('')}}/assets/plugins/gritter/js/jquery.gritter.js"></script>
	<script src="{{url('')}}/assets/plugins/flot/jquery.flot.min.js"></script>
	<script src="{{url('')}}/assets/plugins/flot/jquery.flot.time.min.js"></script>
	<script src="{{url('')}}/assets/plugins/flot/jquery.flot.resize.min.js"></script>
	<script src="{{url('')}}/assets/plugins/flot/jquery.flot.pie.min.js"></script>
	<script src="{{url('')}}/assets/plugins/sparkline/jquery.sparkline.js"></script>
	<script src="{{url('')}}/assets/plugins/jquery-jvectormap/jquery-jvectormap.min.js"></script>
	<script src="{{url('')}}/assets/plugins/jquery-jvectormap/jquery-jvectormap-world-mill-en.js"></script>
	<script src="{{url('')}}/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="{{url('')}}/assets/js/dashboard.min.js"></script>
	<script src="{{url('')}}/assets/js/apps.min.js"></script>
	<script src="{{url('')}}/assets/plugins/chosen/chosen.jquery.min.js"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->
	
	<script>
		$(document).ready(function() {
			App.init();
			$(".panel").addClass("bounce animated");
			$("input").addClass("fadeInLeft animated");
			$(".panel-title").on("mouseover",function(){
				$(".panel-title").addClass("bounce animated")
			})
			$(".panel-title").on("mouseout",function(){
				$(".panel-title").removeClass("bounce animated")
			})


			//Dashboard.init();
		});
	</script>
	
	@yield("script_2")
	@yield("script_3")
	
	
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','../../../../www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-53034621-1', 'auto');
  ga('send', 'pageview');

</script>
<script type="text/javascript">
    $(".chosen-select").chosen();
    
    function playAudio(file){
	    if(file === 'alert')
	        document.getElementById('audio-alert').play();

	    if(file === 'fail')
	        document.getElementById('audio-fail').play();    
	}
	$(document).ready(function() {
		$(".buttons-print span").text("Imprimir");
		$(".buttons-copy span").text("Copiar");
	});	

	
</script>

</body>

<!-- Mirrored from seantheme.com/color-admin-v2.2/admin/html/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 06 May 2017 02:15:03 GMT -->
</html>
