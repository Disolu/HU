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
<div class="box-consulta panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Consula: Alumnos matriculados</h3>
	</div>
	<div class="panel-body">
	{!! Form::open(['route' => ['updatealumnoAcademico',$id], 'method' => 'put']) !!}

			<h2>Registro Académico</h2>
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-hover mb-none">
						<thead>
							<tr>
								<th>Sede</th>
								<th>Nivel</th>
								<th>Grado</th>
								<th>Sección</th>
								<th>Pensión</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>{!! $dataMatricula[0]->sede !!}</td>
								<td>{!! $dataMatricula[0]->nivel !!}</td>
								<td>{!! $dataMatricula[0]->grado !!}</td>
								<td>{!! $dataMatricula[0]->seccion !!}</td>
								<td><strong>{!! $dataMatricula[0]->tipopension !!}:</strong> S/. {!! $dataMatricula[0]->pension !!}</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="form-group">
					<b>Seleccione información para el alumno: </b><code>Es importante seleccionar las siguientes opciones:</code><br />	
					<div class="row">
					  <div class="col-md-3">
					  	<fieldset>
							<div class="form-group">
								<select name="sede"  id="cboSede" class="form-control mb-md" data-bind="options: sedes, optionsText: 'nombre', optionsValue: 'idsede',  optionsCaption: 'Seleccione una Sede', value: sedeSeleccionada"></select>
							</div>
						</fieldset>
					  </div>

					  <div class="col-md-3">
					  	<fieldset>
							<div class="form-group">
								<select name="nivel"  id="cboNivel" class="form-control mb-md" data-bind="options: niveles, optionsText: 'nombre', optionsValue: 'idnivel',  optionsCaption: 'Seleccione un Nivel', value: nivelSeleccionado"></select>
							</div>
						</fieldset>
					  </div>

						<div class="col-md-3">
					  	<fieldset>
							<div class="form-group">
								<select name="grado"  id="cboGrado" class="form-control mb-md" data-bind="options: grados, optionsText: 'nombre', optionsValue: 'idgrado',  optionsCaption: 'Seleccione un Grado', value: gradoSeleccionado"></select>
							</div>
						</fieldset>
						</div>

						<div class="col-md-3">
					  	<fieldset>
							<div class="form-group">
								<select name="seccion"  id="cboSeccion" class="form-control mb-md" data-bind="options: secciones, optionsText: 'nombre', optionsValue: 'idseccion',  optionsCaption: 'Seleccione una Sección', value: seccionSeleccionado"></select>
							</div>
						</fieldset>
						</div>

						<div class="form-group">
				<label>Fecha de vencimiento </label>
				<div class="input-group col-sm-5">
  				<input type="text" class="form-control" placeholder="Ingrese día" name="vencimiento" data-bind="value: avencimiento">
  				<span class="input-group-addon" id="basic-addon2">De cada mes</span>
				</div>
			</div>
					</div>
				</div>

				<div class="col-md-12">
					<label><strong>Tipo de Pension</strong></label> <br>
					<div class="btn-group" data-toggle="buttons">
						@foreach($TipoPension as $pension )
						<label class="btn btn-default  btn-sm tipopension" id="{!! $pension->idtipopension !!}">
							<input type="radio" name="alu_tipopension" autocomplete="off" value="{!! $pension->idtipopension !!} "> 
							{!! $pension->nombre !!} 
						</label>
						@endforeach
						<div class="selectPension" style="display:none">
							<div class="form-group">
								<select name="pension" id="pension" class="form-control mb-md" data-bind="value: pension"></select>
							</div>
						</div>
					</div>
				</div>

				
			</div>
			<div style="clear:both"></div>
		<div class="panel-footer">
			<button class="btn btn-primary" type="submit">Actualizar Alumno</button>
			<a href="{!! route('alumnobuscar') !!}" class="btn btn-default ml-sm">Cancelar</a>
		</div>
	{!!Form::close()!!}		
</div>
@stop

@section('scripts')
@parent
<!--knockout-->
{!! Html::script('assets/javascripts/knockout-3.3.0.js') !!}
<script type="text/javascript">
	$(document).ready(function(){
		var baseURL = "{!! config('app.urlglobal') !!}";	
	    var sede  = $.cookie("idsede");
	    var nivel = $.cookie("idnivel");		
	    $(".tipopension").click(function(){
	    	var tipopension =  $(this).attr('id');
	    	var nivelpe = {!! $dataMatricula[0]->idnivel !!};
		    $.ajax({
		    	type: "GET",
		    	url: baseURL + "/api/v1/getPensionesUpdateAlumno",
		    	data: { tipo : tipopension, nivel: 1 },
		    	dataType: "json",
		    	contentType: "application/json; charset=utf-8",
		    	success: function (data) {		    		
		    		$(".selectPension").show();
		    		var $selectPension = $("#pension");
            		$selectPension.empty();
            		$selectPension.append($("<option>Seleccione pension</option>"));

		    		$.each(data.pensiones, function(i, item) {
		                $selectPension.append($("<option></option>").attr("value", item.idpension).text(item.monto));
		            }); 

		    	},
		    	error: function (data) {
		    		console.log(data);
		    		$(".selectPension").hide();
		    	}
		    });	    
	    });
    });
	</script><script>
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

@stop