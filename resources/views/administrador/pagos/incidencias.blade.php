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



	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/t/bs/dt-1.10.11,b-1.1.2/datatables.min.css"/>
	
 
	
	<link rel="stylesheet" href="{{ asset('assets/vendor/jquery-impromptu/jquery-impromptu.css') }}" />
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
<!--<div class="col-lg-12">
	<section class="panel">-->
		<header class="panel-heading">
			<h2 class="panel-title">Historial de Incidencias</h2>
		</header>
		<div class="panel-body">
			@include('alertas.request')
			@include('alertas.success')
			@include('alertas.error')

			{!! Form::open(array('url' => 'alumno/incidencias')) !!}
			<div class="form-group">
				<label class="col-md-3 control-label">Nombres o Apellidos</label>
				<div class="col-md-6">
					<div class="input-group input-search">
                        <input type="text" class="form-control" name="alumno" id="alumno" placeholder="Buscar alumno..." onKeyPress="if (event.keyCode < 48 && event.keyCode >13 && event.keycode<12 || event.keyCode > 57)event.returnValue = false;">
                        <span class="input-group-btn">
                            <button class="btn btn-default"  data-bind="click: consultarAlumno" type="submit"><i class="fa fa-search"></i></button>
                        </span>
					</div>
					<span class="help-block">
						Ingresar cantidad de incidencias a buscar
					</span>
				</div>
			</div>
			{!! Form::close() !!}

			@include('administrador.pagos.resultadoincidencias')
			
		</div>
	<!--</section>
</div>-->
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
	<script type="text/javascript" src="https://cdn.datatables.net/t/bs/dt-1.10.11,b-1.1.2/datatables.min.js"></script>
	{!! Html::script('assets/vendor/jquery-impromptu/jquery-impromptu.js') !!}
	<script type="text/javascript">
$(document).ready(function(){


    $('#recepcion').DataTable();
});

	</script>



	<script type="text/javascript">
  $(document).ready(function(){
  	function TranslateDate(theDate)
  	{
  		var date;
  		switch(theDate)
  		{
		    case '01':
		        date = "Enero";
		        break;
		    case '02':
		        date = "Febrero";
		        break;
		    case '03':
		        date = "Marzo";
		        break;
		    case '04':
		        date = "Abril";
		        break;
		    case '05':
		        date = "Mayo";
		        break;
		    case '06':
		        date = "Junio";
		        break;
		    case '07':
		        date = "Julio";
		        break;
		    case '08':
		        date = "Agosto";
		        break;
		    case '09':
		        date = "Septiembre";
		        break;
		    case '10':
		        date = "Octubre";
		        break;
		    case '11':
		        date = "Noviembre";
		        break;
		    case '12':
		        date = "Diciembre";
		        break;

		    default:
		    	  date = "No found";
		    	  break;
  		}
  		return "Pagos: "+date;
  	}




   $('.perdida').click(function(){
   	var idnivel = $("#idnivel").data('id');

      $.ajax({
        method: "POST",
        url: "{!! route('PerdidaBeneficioAjax') !!}",
        dataType: 'json',
        data:
        {
        	idnivel:idnivel,
          idalumno: $(this).data('id'),
          _token: '{!! csrf_token() !!}'
        },
        success:  function (r)
        {
          
        },
        error: function()
        {
           $.prompt("El Alumno perdió el beneficio, para deshacer los cambios, busque al alumno en mención y cambie su pensión");
        }
      });
    });

  });
</script>






</script>

	<!-- Theme Base, Components and Settings -->
	{!! Html::script('assets/javascripts/theme.js') !!}

	<!-- Theme Custom -->
	{!! Html::script('assets/javascripts/theme.custom.js') !!}

	<!-- Theme Initialization Files -->
	{!! Html::script('assets/javascripts/theme.init.js') !!}

	<!-- Examples -->
	{!! Html::script('assets/javascripts/ui-elements/examples.modals.js') !!}
@stop
