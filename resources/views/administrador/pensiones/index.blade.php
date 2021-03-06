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

	<section class="panel">
		<header class="panel-heading">
			<h2 class="panel-title">Registrar Pensión</h2>
			<div class="text-right">
				<a href="{!! route('tipopensionnew') !!}" class="btn btn-primary text-right" onclick="if (! confirm('¿Estás seguro que deseas agregar un nuevo tipo de pensión?, esto afectará a toda la institución.')) return false;"><i class="glyphicon-plus"></i> Tipo Pensión</a>
			</div>
		</header>
		<div class="panel-body">

			{!! Form::open(['route' => 'pension', 'method' => 'post']) !!}
			{!! csrf_field() !!}
			@include('alertas.success')
			@include('alertas.error')
			@include('alertas.request')
			<div class="form-group">
				<label class="col-md-3 control-label" for="inputSuccess">Tipo de Pensión</label>
				<div class="col-md-6">
					<select class="form-control mb-md" name="tipopension">
						@foreach($tipopensiones as $pension)
						<option value="{!! $pension->idtipopension !!}">{!! $pension->nombre !!}</option>							
						@endforeach
					</select>

					<fieldset>
						<div class="form-group">
							<select name="sede"  id="cboSede" class="form-control mb-md" data-bind="options: sedes, optionsText: 'nombre', optionsValue: 'idsede',  optionsCaption: 'Seleccione una Sede', value: sedeSeleccionada"></select>
						</div>
					</fieldset>
					<fieldset>
						<div class="form-group">
							<select name="nivel"  id="cboNivel" class="form-control mb-md" data-bind="options: niveles, optionsText: 'nombre', optionsValue: 'idnivel',  optionsCaption: 'Seleccione un Nivel', value: nivelSeleccionado"></select>
						</div>
					</fieldset>

					<select class="form-control mb-md" name="periodo">
						<option>Seleccione periodo</option>
						@foreach($periodos as $periodo)
						<option value="{!! $periodo->idperiodomatricula !!}">{!! $periodo->nombre !!}</option>							
						@endforeach
					</select>

					<input name="monto" class="form-control input-sm mb-md" type="text" placeholder="S/. Monto fijo">
				</div>					
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label" for="inputSuccess">Monto personalizado:</label>
				<div class="col-md-2">
					<input class="form-control input-sm mb-md" name="inicial" type="text" placeholder="S/. Inicial">
				</div>
				<div class="col-md-1">
					hasta 
				</div>
				<div class="col-md-2">
					<input class="form-control input-sm mb-md" name="final" type="text" placeholder="S/. Final">
				</div>
			</div>

			<p class="m-none">
				<button type="submit" class="mb-xs mt-xs mr-xs btn btn-success">Registrar</button>
			</p>
			{!!Form::close()!!}
		</div>
	</section>

	<div class="row">
		<div class="col-md-6">
			<section class="panel">
				<header class="panel-heading">
					<h2 class="panel-title">2do Sector</h2>

				</header>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table mb-none">
							<thead>
								<tr>
									<th>Nivel</th>
									<th>Monto</th>
									<th>Tipo Pensión</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody>
							@foreach($pensionesSede01 as $pension)
								<tr>
									<td>{!! $pension->nombre !!}</td>
									<td>{!! $pension->monto !!}</td>
									<td>{!! $pension->nametipopension !!}</td>
									<td class="actions">
										<a href="#"><i class="fa fa-pencil"></i></a>
										<a href="#" class="delete-row"><i class="fa fa-trash-o"></i></a>
									</td>
								</tr>
							@endforeach	
							</tbody>
						</table>
					</div>
				</div>
			</section>
		</div>

		<div class="col-md-6">
			<section class="panel">
				<header class="panel-heading">					
					<h2 class="panel-title">Las Brisas</h2>
				</header>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table mb-none">
							<thead>
								<tr>
									<th>Nivel</th>
									<th>Periodo</th>
									<th>Creado</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody>
							@foreach($pensionesSede02 as $pension)
								<tr>
									<td>{!! $pension->nombre !!}</td>
									<td>{!! $pension->monto !!}</td>
									<td>{!! $pension->nametipopension !!}</td>
									<td class="actions">
										<a href="#"><i class="fa fa-pencil"></i></a>
										<a href="#" class="delete-row"><i class="fa fa-trash-o"></i></a>
									</td>
								</tr>
							@endforeach	
							</tbody>
						</table>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>	
@stop

@section('scripts')
@parent
<!--knockout-->
{!! Html::script('assets/javascripts/knockout-3.3.0.js') !!}

<!-- KnockoutJS Mapping http://knockoutjs.com/documentation/plugins-mapping.html -->
{!! Html::script('assets/javascripts/knockout.mapping.min.js') !!}

<!-- jQuery Cookie -->
{!! Html::script('assets/javascripts/jquery.cookie.js') !!}
<script>
	var baseURL = "{!! config('app.urlglobal') !!}";
	function VacantesFormViewModel () {
		var fo = this;

		fo.periodos = ko.observableArray([]);
		fo.pediodoSeleccionado = ko.observable(null);
		fo.sedes    = ko.observableArray([]);
		fo.sedeSeleccionada    = ko.observable(null);
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

		fo.cargarAulas = function (sede , nivel, grado, seccion) {
			$.ajax({
				type: "GET",
				url: baseURL + "/api/v1/getAulas",
				data: {sede:sede, nivel:nivel, grado:grado, seccion:seccion},
				dataType: "json",
				contentType: "application/json; charset=utf-8",
				success: function (e) {
					var aulasRaw =  e.aulas;
                //limpio el arrray
                fo.aulas.removeAll();
                for (var i = 0; i < aulasRaw.length; i++) {
                	fo.aulas.push(aulasRaw[i]);
                };
            },
            error: function (r) {
                // Luego...
            }
        });
		}

		fo.seccionSeleccionada.subscribe(function(newValue) {
			if (newValue) {
				fo.cargarAulas(fo.sedeSeleccionada(), fo.nivelSeleccionado(), fo.gradoSeleccionado(), newValue);
			}
		});

		fo.guardarCookie = function (sede, nivel, grado, seccion, aula) {
			$.cookie('idsede'   , sede,   { expires: 1 , path:'/'});
			$.cookie('idnivel'  , nivel,  { expires: 1 , path:'/'});
			$.cookie('idgrado'  , grado,  { expires: 1 , path:'/'});
			$.cookie('idseccion', seccion,{ expires: 1 , path:'/'});
			$.cookie('idaula'   , aula,   { expires: 1 , path:'/'});
		}

		fo.aulaSeleccionada.subscribe(function(newValue) {
			if (newValue) {
				fo.guardarCookie(fo.sedeSeleccionada(), fo.nivelSeleccionado(), fo.gradoSeleccionado(), fo.seccionSeleccionada(), fo.aulaSeleccionada(),newValue);
			}
		});

		fo.consultaVacantes = function () {
			var sede = fo.sedeSeleccionada();
			var nivel= fo.nivelSeleccionado();
			var grado= fo.gradoSeleccionado();
			var seccion = fo.seccionSeleccionada();
			var aula = fo.aulaSeleccionada();
			$.ajax({
				type: "GET",
				url: baseURL+"/api/v1/getVacantes",
				data: {sede:sede, nivel:nivel, grado:grado, seccion:seccion, aula:aula},
				dataType: "json",
				contentType: "application/json; charset=utf-8",
				success: function (e) {
					var num = e.vacantes;
					if (num > 0) {
						$(".num_vacantes").html(num);
						$(".alert-success").show();
						$(".alert-danger").hide();
					}else{
						$(".alert-danger").show();
						$(".alert-success").hide();
					};
				},
				error: function (){
					$(".alert-danger").hide();
					$(".alert-success").hide();
					$(".msl").show();
				}
			});
		}

		fo.matricularAlumno = function () {
			var c_dni = $.cookie('alu_dni');
			if (c_dni) {
				window.location = baseURL+"matricular/"+c_dni;
			}else{
				window.location = baseURL+"/matricula";
			};
		}

		fo.cargarperiodos();
		fo.cargarsedes();       
	}    
	var viewModel = new VacantesFormViewModel();

	$(function(){
		ko.applyBindings(viewModel, $("#page-wrapper")[0]); 
	});
</script>
@stop