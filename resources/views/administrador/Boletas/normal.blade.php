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
@section('cuerpo')
<div class="col-lg-12">
@include('alertas.request')
@include('alertas.success')
@include('alertas.error')
<header class="panel-heading">
				<h2 class="panel-title">BOLETAS - PENSIÓN GENERAL</h2>
			</header>
{!! Form::open(['route' => 'normal', 'method' => 'post']) !!}
{!! csrf_field() !!}
	<div class="panel-body">
		<div class="row">
		  <div class="col-md-2">
		  	<fieldset>
				<div class="form-group">
					<select name="periodo" id="cboPeriodo" class="form-control mb-md" data-bind="options: periodos, optionsText: 'nombre', optionsValue: 'idperiodomatricula', value: pediodoSeleccionado"></select>
				</div>
			</fieldset>
			<input type="hidden" value="1" name="tipo" id="tipo">
		  </div>
		  <div class="col-md-3">
		  	<fieldset>
				<div class="form-group">
					<select name="sede"  id="cboSede" class="form-control mb-md" data-bind="options: sedes, optionsText: 'nombre', optionsValue: 'idsede',  optionsCaption: 'Sede', value: sedeSeleccionada"></select>
				</div>
			</fieldset>
		  </div>
		  <div class="col-md-2">
		  	<fieldset>
				<div class="form-group">
					<select name="nivel"  id="cboNivel" class="form-control mb-md" data-bind="options: niveles, optionsText: 'nombre', optionsValue: 'idnivel',  optionsCaption: 'Nivel', value: nivelSeleccionado"></select>
				</div>
			</fieldset>
		  </div>
		  <div class="col-md-2">
		  	<fieldset>
				<div class="form-group">
					<select name="grado"  id="cboGrado" class="form-control mb-md" data-bind="options: grados, optionsText: 'nombre', optionsValue: 'idgrado',  optionsCaption: 'Grado', value: gradoSeleccionado"></select>
				</div>
			</fieldset>
			</div>

			  <div class="col-md-2">
		  	<fieldset>
				<div class="form-group">
					<select name="mensualidad"  id="cboMensualidad" class="form-control mb-md"   optionsCaption: 'Seleccione Mes'>
						<option selected value="03">Seleccione Mes</option>
							<option value="03">Marzo</option>
							<option value="04">Abril</option>
							<option value="05">Mayo</option>
							<option value="06">Junio</option>
							<option value="07">Julio</option>	
							<option value="08">Agosto</option>
							<option value="09">Setiembre</option>
							<option value="10">Octubre</option>
							<option value="11">Noviembre</option>
							<option value="12">Diciembre</option>
											
						</select>

				</div>

			</fieldset>
			</div>

		</div>

	</div>

	<div class="panel-footer">
	<button type="submit" id="consultar" formtarget="_blank" class="btn btn-info col-md-offset-9 text-right">Descargar PDF   <span class="glyphicon glyphicon-circle-arrow-down" aria-hidden="true"></span></button>
		
		
	</div>
{!! Form::close() !!}

</div>

@endsection

@section('scripts')
@parent
{!! Html::script('assets/javascripts/knockout-3.3.0.js') !!}
<!-- jQuery Cookie -->
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

    $('.btnDetails').click(function(){
      $.ajax({
        method: "POST",
        url: "{!! route('SeguimientoPagosAjax') !!}",
        dataType: 'json',
        data:
        {
          idalumno: $(this).data('id'),
          _token: '{!! csrf_token() !!}'
        },
        success:  function (r)
        {
          if(r.length < 1)
          {
            alert('No tenemos data suficiente.');
          }
          else
          {
          	var options;
          	var estado;
            $.each(r, function(i)
            {

            	var date = r[i].mesdeuda;
            	if(r[i].status == 1 ) { estado = "<span class='label label-primary'>Pagado</span>"; } else { estado = "<span class='label label-danger'>Pendiente</span>" }
	            options += "<tr>";
	              options += "<td>"+TranslateDate(date)+"</td>";
	              options += "<td>"+r[i].montopagar+"</td>";
	              options += "<td>"+estado+"</td>";
	            options += "</tr>";
            });
            $('#tableajax').html(options);
            $.magnificPopup.open({
                items: {
                    src: $('#modalBasic')[0]
                },
                type: 'inline'
            });
          }
        },
        error: function()
        {
          alert('error inesperado.');
        }
      });
    });

  });
</script>

<!--knockout-->
<script>
	var baseURL = "{!! config('app.urlglobal') !!}";
	function VacantesFormViewModel () {
		var fo = this;

		fo.periodos = ko.observableArray([]);
		fo.pediodoSeleccionado = ko.observable(null);
		fo.sedes    = ko.observableArray([]);
		fo.sedeSeleccionada    = ko.observable({{$request['sede']}});
		fo.niveles  = ko.observableArray([]);
		fo.nivelSeleccionado   = ko.observable(null);
		fo.grados   = ko.observableArray([]);
		fo.gradoSeleccionado   = ko.observable(null);
		fo.secciones= ko.observableArray([]);
		fo.seccionSeleccionada = ko.observable(null);
		fo.aulas    = ko.observableArray([]);
		fo.aulaSeleccionada    = ko.observable(null);

		fo.cargarperiodos = function () {
			$.ajax({
				type: "GET",
				url: baseURL + "/api/v1/getPeriodos",
				dataType: "json",
				contentType: "application/json; charset=utf-8",
				success: function (e) {
					var periodosRaw =  e.periodos;
                //limpio el arrray
                fo.periodos.removeAll();
                for (var i = 0; i < periodosRaw.length; i++) {
                	fo.periodos.push(periodosRaw[i]);
                };
            },
            error: function (r) {
                // Luego...
            }
        });
		}

		fo.cargarsedes = function () {
			$.ajax({
				type: "GET",
				url: baseURL + "/api/v1/getSedes",
				dataType: "json",
				contentType: "application/json; charset=utf-8",
				success: function (e) {
					var sedesRaw =  e.sedes;
                //limpio el arrray
                fo.sedes.removeAll();
                for (var i = 0; i < sedesRaw.length; i++) {
                	fo.sedes.push(sedesRaw[i]);
                };
            },
            error: function (r) {
                // Luego...
            }
        });
		}

		fo.cargarNiveles = function (sedeSeleccionada) {
			$.ajax({
				type: "GET",
				url: baseURL + "/api/v1/getNivel",
				data: {sede:sedeSeleccionada},
				dataType: "json",
				contentType: "application/json; charset=utf-8",
				success: function (e) {
					var nivelesRaw =  e.nivel;
                //limpio el arrray
                fo.niveles.removeAll();
                for (var i = 0; i < nivelesRaw.length; i++) {
                	fo.niveles.push(nivelesRaw[i]);
                };
            },
            error: function (r) {
                // Luego...
            }
        });
		}

		fo.sedeSeleccionada.subscribe(function(newValue) {
			if (newValue) {
				fo.cargarNiveles(newValue);
			}
		});

		fo.cargarGrados = function (sede , nivel) {
			$.ajax({
				type: "GET",
				url: baseURL + "/api/v1/getGrados",
				data: {sede:sede, nivel:nivel},
				dataType: "json",
				contentType: "application/json; charset=utf-8",
				success: function (e) {
					var gradosRaw =  e.grado;
                //limpio el arrray
                fo.grados.removeAll();
                for (var i = 0; i < gradosRaw.length; i++) {
                	fo.grados.push(gradosRaw[i]);
                };
            },
            error: function (r) {
                // Luego...
            }
        });
		}

		fo.nivelSeleccionado.subscribe(function(newValue) {
			if (newValue) {
				fo.cargarGrados(fo.sedeSeleccionada() ,newValue);
			}
		});

		fo.cargarSecciones = function (sede , nivel, grado) {
			$.ajax({
				type: "GET",
				url: baseURL + "/api/v1/getSecciones",
				data: {sede:sede, nivel:nivel, grado:grado},
				dataType: "json",
				contentType: "application/json; charset=utf-8",
				success: function (e) {
					var seccionRaw =  e.secciones;
                //limpio el arrray
                fo.secciones.removeAll();
                for (var i = 0; i < seccionRaw.length; i++) {
                	fo.secciones.push(seccionRaw[i]);
                };
            },
            error: function (r) {
                // Luego...
            }
        });
		}

		fo.gradoSeleccionado.subscribe(function(newValue) {
			if (newValue) {
				fo.cargarSecciones(fo.sedeSeleccionada(), fo.nivelSeleccionado(), newValue);
			}
		});

		fo.seccionSeleccionada.subscribe(function(newValue) {
			if (newValue) {
				fo.cargarAulas(fo.sedeSeleccionada(), fo.nivelSeleccionado(), fo.gradoSeleccionado(), newValue);
			}
		});

		fo.aulaSeleccionada.subscribe(function(newValue) {
			if (newValue) {
				fo.guardarCookie(fo.sedeSeleccionada(), fo.nivelSeleccionado(), fo.gradoSeleccionado(), fo.seccionSeleccionada(), fo.aulaSeleccionada(),newValue);
			}
		});

		fo.cargarperiodos();
		fo.cargarsedes();
	}
	var viewModel = new VacantesFormViewModel();

	$(function(){
		ko.applyBindings(viewModel, $("#page-wrapper")[0]);
	});
</script>
@endsection
