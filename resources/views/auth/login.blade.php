
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
<!--<![endif]-->

<!-- Mirrored from seantheme.com/color-admin-v2.2/admin/html/login_v2.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 06 May 2017 02:33:14 GMT -->
<head>
    <meta charset="utf-8" />
    <title>SIA</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    
    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="../../../../fonts.googleapis.com/cssff98.css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="{{url('')}}/assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
    <link href="{{url('')}}/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{url('')}}/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="{{url('')}}/assets/css/animate.min.css" rel="stylesheet" />
    <link href="{{url('')}}/assets/css/style.min.css" rel="stylesheet" />
    <link href="{{url('')}}/assets/css/style-responsive.min.css" rel="stylesheet" />
    <link href="{{url('')}}/assets/css/theme/default.css" rel="stylesheet" id="theme" />
    <!-- ================== END BASE CSS STYLE ================== -->
    
    <!-- ================== BEGIN BASE JS ================== -->
    <script src="{{url('')}}/assets/plugins/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->
</head>
<body class="pace-top">
    <!-- begin #page-loader -->
    <div id="page-loader" class="fade in"><span class="spinner"></span></div>
    <!-- end #page-loader -->
    
    <div class="login-cover">
        <div class="login-cover-image"><img src="{{url('')}}/assets/img/login-bg/principal.png" data-id="login-cover-image" alt="" /></div>
        <div class="login-cover-bg"></div>
    </div>
    <!-- begin #page-container -->
    <div id="page-container" class="fade">
        <!-- begin login -->
        <div class="login login-v2" data-pageload-addclass="animated fadeIn">
            <!-- begin brand -->
            <div class="login-header">
                <div class="brand">
                    <span class="logo"></span> Sistema Académico
                    <small>Software Administrable</small>
                </div>
                <div class="icon">
                    <i class="fa fa-sign-in"></i>
                </div>
            </div>
            <!-- end brand -->
            <div class="login-content">
                <form action="{{ url('/login') }}" method="POST" class="margin-bottom-0">
                    {{ csrf_field() }}
                    @if(session()->has('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message')}}
                        </div>
                        @endif
                    <div class="form-group m-b-20 {{ $errors->has('name') ? ' has-error' : '' }}">
                        <input value="{{old('name')}}" name="name" type="text" class="form-control input-lg" placeholder="Usuario" required autofocus/>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                        
                    </div>
                    <div class="form-group m-b-20 {{ $errors->has('password') ? ' has-error' : '' }}">
                            <input type="password" name="password"class="form-control input-lg" placeholder="Clave" required autofocus/>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    <!--div class="checkbox m-b-20">
                        <label>
                            <input type="checkbox" /> Recordarme
                        </label>
                    </div-->
                    <div class="login-buttons">
                        <button type="submit" class="btn btn-success btn-block btn-lg">Ingresar</button>
                    </div>
                    
                </form>
            </div>
        </div>
        <!-- end login -->
        
        <ul class="login-bg-list clearfix">
            <li class="active"><a href="#" data-click="change-bg"><img src="{{url('')}}/assets/img/login-bg/principal.png" alt="" /></a></li>
            
        </ul>
        
        
    </div>
    <!-- end page container -->
    
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
    <script src="{{url('')}}/assets/js/login-v2.demo.min.js"></script>
    <script src="{{url('')}}/assets/js/apps.min.js"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->

    <script>
        $(document).ready(function() {
            App.init();
            LoginV2.init();
        });
    </script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','../../../../www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-53034621-1', 'auto');
  ga('send', 'pageview');

</script>
</body>

<!-- Mirrored from seantheme.com/color-admin-v2.2/admin/html/login_v2.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 06 May 2017 02:34:24 GMT -->
</html>
