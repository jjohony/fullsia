@extends('admin.templates.contenido')

@section('link')
<style type="text/css">

    hr{
        border-radius: 0px 0px 3px 3px;
        height: 5px;
        background: #ce0714;
        margin-left: -4px;
        margin-right: -4px;
        margin-bottom: -4px;
        margin-top: 5px;
    } 

    .caption p {
      margin-bottom: 5px;
    }
    .sthumbnail {
      height: 135px;

      overflow: hidden;
    }

    .mithumbnail {
      height: 135px;

      overflow: hidden;
    }

    .homes{
        color: yellow;
        background-color: blue;
        
    }

    

    .homes:focus,
    .homes:hover {
        color: blue;
        background-color: yellow;
    }

    .homes:focus > h1>.giro,
    .homes:hover > h1>.giro{
        color: blue;
        background-color: yellow;
    }

    a:link{
        text-decoration:none
    }

    a:visited{ 
        text-decoration:none
    }
    a:active{ 
        text-decoration:none
    }
    a:hover{ 
        text-decoration:none
    }

    #mod-header {
      padding: 15px;
      border-bottom: 1px solid #e5e5e5;
      color: #fff;
      background-color: #d9534f;
      border-radius: 4px;
    }
    .icono-hover{
        color:blue;
    }
    .icono-color{
        color:yellow;
    }
    

</style>
@endsection

@section('content_contenido')

    
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Inicio</div>

                <div class="panel-body">                   

                    <!-- page content -->
                    <div class="" >

                        <div class="row" style="margin-top:-12px; margin-left:-25px; margin-right:-20px;">
                            <!--TITULO-->
                            <div class=" col-md-12 col-xs-12 col-sm-12 text-center" style="margin-bottom:18px;">
                                </br>
                                <label style="margin-top:10px; font-size:30px;color:#585858"><i class="fa fa-cog fa-spin"></i> Administracion de Carreras</label>
                                </br>
                                </br>
                            </div>
                        </div>

                        <div class="row">
                            @if(!empty($carrera))
                            @foreach($carrera as $key=>$value)
                            <div class="col-md-11 col-md-offset-1 ">
                                <!--QUIENES SOMOS-->
                                <div class="col-xs-12 col-sm-3 col-md-4 col-md-offset-1-left" >
                                    <a>
                                        <div class="thumbnail text-center homes cuadro">
                                            <h1 style=" font-size:70px">
                                                <i  class="fa fa-university giro icono-color"></i>
                                            </h1>
                                            {{$value->carrera}}
                                            <hr>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xs-12 col-sm-3 col-md-2 col-md-offset-1-left" >
                                    <a href="{{url('')}}/carrera/{{$value->id}}/plan_estudio">
                                        <div class="thumbnail text-center homes cuadro">
                                            <h1 style=" font-size:70px">
                                                <i  class="fa fa-table giro icono-color"></i>
                                            </h1>
                                            Plan de Estudios
                                            <hr>
                                        </div>
                                    </a>
                                </div>                                

                                <div class="col-xs-12 col-sm-3 col-md-2 col-md-offset-1-left" >
                                    <a href="{{url('')}}/carrera/{{$value->id}}/curso">
                                        <div class="thumbnail text-center homes cuadro">
                                            <h1 style=" font-size:70px">
                                                <i  class="fa fa-home giro icono-color"></i>
                                            </h1>
                                            Cursos
                                            <hr>
                                        </div>
                                    </a>
                                </div>            
                                <div class="col-xs-12 col-sm-3 col-md-2 col-md-offset-1-left" >
                                    <a href="{{url('')}}/carrera/{{$value->id}}/inscripcion">
                                        <div class="thumbnail text-center homes cuadro">
                                            <h1 style=" font-size:70px">
                                                <i  class="fa fa-users giro icono-color"></i>
                                            </h1>
                                            Inscripcion
                                            <hr>
                                        </div>
                                    </a>
                                </div>                                

                            </div>
                            @endforeach
                            @endif
                        </div>

                    </div>



                </div>
            </div>
        </div>
    </div>

@endsection

@section("script_3")
<script type="text/javascript">
    $(document).ready(function() {
        $(".giro").hover(
            function () {
                $(this).addClass("fa-spin icono-hover");
                $(this).removeClass("icono-color");
            },
            function () {
                $(this).addClass(" icono-color");
                $(this).removeClass("fa-spin icono-hover");
            }
        );
        $(".homes").hover(
            function () {
                $(this).addClass("cuadro-hover");
                $(this).removeClass("cuadro");

                
            },
            function () {
                $(this).addClass("cuadro");
                $(this).removeClass("cuadro-hover");
            }
        );
    
    });
</script>
@endsection
