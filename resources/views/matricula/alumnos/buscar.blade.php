<?php
	if(Auth::user()->idrol==1)
	{
		$variable = "layouts.index";
	}
	elseif(Auth::user()->idrol==2)
	{
		$variable = "layouts.responsable";
	}
	elseif(Auth::user()->idrol==3)
	{
		$variable = "layouts.secretaria";
	}
	elseif(Auth::user()->idrol==4)
	{
		$variable = "layouts.profesor";
	}
	elseif(Auth::user()->idrol==5)
	{
		$variable = "layouts.legal";
	}
?>
@extends("$variable")
@section('css')
	<!-- Vendor CSS -->
	<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/vendor/magnific-popup/magnific-popup.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker/css/datepicker3.css') }}" />
	<!-- Specific Page Vendor CSS -->
	<link rel="stylesheet" href="{{ asset('assets/vendor/pnotify/pnotify.custom.css') }}" />
	<!-- Theme CSS -->
	<link rel="stylesheet" href="{{ asset('assets/stylesheets/theme.css') }}" />
	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="{{ asset('assets/stylesheets/theme-custom.css') }}">
	<!-- Head Libs -->
	<script src="{{ asset('assets/vendor/modernizr/modernizr.js') }}"></script>
@stop

@section('cuerpo')
<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading">
			<h2 class="panel-title">Buscar Alumno</h2>
		</header>
		<div class="panel-body">
			@include('alertas.request')
			@include('alertas.success')
			@include('alertas.error')

			{!! Form::open(array('url' => 'alumno/buscar')) !!}
			<div class="form-group">
				<label class="col-md-3 control-label">Nombre / Dni / Codigo</label>
				<div class="col-md-6">
					<div class="input-group input-search">
                        <input type="text" class="form-control" name="alumno" id="alumno" placeholder="Buscar alumno...">
                        <span class="input-group-btn">
                            <button class="btn btn-default"  type="submit"><i class="fa fa-search"></i></button>
                        </span>
					</div>
					<span class="help-block">
						Busque al alumno utilizando su nombre, apellidos, dni o codigo.
					</span>
				</div>
			</div>
			{!! Form::close() !!}

			@include('matricula.alumnos.resultadobusqueda')
		</div>
	</section>
</div>
@stop

@section('scripts')
	<!-- Vendor -->
	{!! Html::script('assets/vendor/jquery/jquery.js') !!}
	{!! Html::script('assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js') !!}
	{!! Html::script('assets/vendor/bootstrap/js/bootstrap.js') !!}
	{!! Html::script('assets/vendor/nanoscroller/nanoscroller.js') !!}
	{!! Html::script('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js') !!}
	{!! Html::script('assets/vendor/magnific-popup/magnific-popup.js') !!}
	{!! Html::script('assets/vendor/jquery-placeholder/jquery.placeholder.js') !!}

	<!-- Theme Base, Components and Settings -->
	{!! Html::script('assets/javascripts/theme.js') !!}

	<!-- Theme Custom -->
	{!! Html::script('assets/javascripts/theme.custom.js') !!}

	<!-- Theme Initialization Files -->
	{!! Html::script('assets/javascripts/theme.init.js') !!}

	<!-- Examples -->
	{!! Html::script('assets/javascripts/ui-elements/examples.modals.js') !!}
@stop
