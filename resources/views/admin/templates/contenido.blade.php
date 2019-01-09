@extends('layouts.admin')
@section("content")
<!-- begin #content -->
<div id="content" class="content">
	<!-- begin breadcrumb -->
	<ol class="breadcrumb pull-right">
		<li><a href="{{url('inicio')}}">Inicio</a></li>
		@if(isset($accion))
		<li class="active">{{strtoupper($accion)}}</li>
		@endif
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	@if(isset($accion))
	<h1 class="page-header">{{strtoupper($accion)}} <small></small></h1>
	@endif
	<!-- end page-header -->
	
	@yield("content_contenido")
</div>
<!-- end #content -->
@endsection