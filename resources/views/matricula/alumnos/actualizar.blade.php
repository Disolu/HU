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
<div class="tabs" id="page-wrapper">
	{!! Form::open(['route' => ['updatealumno',$id], 'method' => 'put']) !!}
	{!! csrf_field() !!}
	<ul class="nav nav-tabs">
		<li class="active">
			<a href="#alumno" data-toggle="tab" aria-expanded="false"><i class="fa fa-star"></i> Datos del alumno</a>
		</li>
		<li class="">
			<a href="#padre" data-toggle="tab" aria-expanded="true"> Datos del padre</a>
		</li>
		<li class="">
			<a href="#otros" data-toggle="tab" aria-expanded="true"> Otros datos</a>
		</li>
		<li class="">
			<a href="#academica" data-toggle="tab" aria-expanded="true"> Matricula Académica</a>
		</li>
	</ul>
	<div class="tab-content">
		<div id="alumno" class="tab-pane active">
			<h2>Alumno</h2>
			@include('alertas.request')
			@include('alertas.success')

			<div class="col-xs-6">
				<div class="form-group">
					<label>Nombre</label>
					<input type="text" name="nombres" class="form-control" id="validate" placeholder="Ingrese un nombre" value="{!! $alumno->nombres !!}" data-bind="value: anombre">
				</div>
				<div class="form-group">
					<label>Apellido Paterno</label>
					<input type="text" name="apellido_paterno" class="form-control" id="validate" placeholder="Ingrese un apellido paterno" value="{!! $alumno->apellido_paterno !!}" data-bind="value: apaterno">
				</div>
				<div class="form-group">
					<label>Apellido Materno</label>
					<input type="text" name="apellido_materno" class="form-control" id="validate" placeholder="Ingrese un apellido materno" value="{!! $alumno->apellido_materno !!}" data-bind="value: amaterno">
				</div>
				<div class="form-group">
					<label>Sexo</label>
					<select class="form-control" id="validate" name="sexo" data-bind="value: sexo">
						<option value="M" <?php echo ($alumno->sexo=='M' ? 'selected="selected"' : '' ); ?> >Masculino</option>
						<option value="F" <?php echo ($alumno->sexo=='F' ? 'selected="selected"' : '' ); ?> >Femenino</option>
					</select>
				</div>
				<div class="form-group">
					<label>Fecha de Nacimiento</label>
					<input type="date" name="fecha_nacimiento" pattern="dd/mm/yyyy" class="form-control" id="fechaNac" value="{!! $alumno->fecha_nacimiento !!}"	data-bind="value: afechaNac" placeholder="Seleccione su fecha de nacimiento">
				</div>
				<div class="form-group">
					<label>DNI</label>
					<input class="form-control" id="validate" name="dni" value="{!! $alumno->dni !!}" pattern="^[0-9]+$" placeholder="Ingrese un DNI" data-bind="value: adni">
				</div>
			</div>

			<div class="col-xs-6">
				<div class="form-group">
					<label>Departamento</label>
					<select class="form-control" name="departamento" data-bind="value: adepartamento">
						<option value="1">Lima</option>
					</select>
				</div>
				<div class="form-group">
					<label>Provincia</label>
					<select class="form-control" name="provincia" data-bind="value: aprovincia">
						<option value="1">Lima</option>
					</select>
				</div>
				<div class="form-group">
					<label>Distrito</label>
					<select class="form-control" name="distrito" data-bind="value: adistrito">
						<option value="1">Villa El Salvador</option>
					</select>
				</div>
				<div class="form-group">
					<label>Dirección</label>
					<input class="form-control" name="direccion" type="text" value="{!! $alumno->direccion !!}" placeholder="Ingrese una dirección" data-bind="value: adireccion">
				</div>
				<div class="form-group">
					<label>Teléfono</label>
					<input class="form-control" name="telefono" type="text" value="{!! $alumno->telefono !!}" placeholder="Ingrese un telefono" data-bind="value: atelefono">
				</div>
			</div>

			<div style="clear:both"></div>
		</div>

		<div id="padre" class="tab-pane">
			<div class="col-xs-4">
				<h4>Datos del Padre</h4>
				<div class="form-group">
					<label>Nombres</label>
					<input type="text" id="validate" class="form-control" placeholder="Nombres" name="p_nombre" value="{!! $apoderado->p_nombres !!}">
				</div>
				<div class="form-group">
					<label>Apellidos</label>
					<input type="text" id="validate" class="form-control" placeholder="Apellidos" name="p_apellidos" value="{!! $apoderado->p_apellidos !!}" data-bind="value: p_apellido">
				</div>
				<div class="form-group">
					<label>Dni</label>
					<input type="text" class="form-control" placeholder="DNI" name="p_dni" maxlength="7" value="{!! $apoderado->p_dni !!}" data-bind="value: p_dni">
				</div>
				<div class="form-group">
					<label>Estado Civil</label>
					<select class="form-control" name="p_estadocivil" data-bind="value: p_estadocivil">
						<option value="1" <?php echo($apoderado->p_estadocivil == 1 ? "selected='selected'" : ''); ?> >Soltero</option>
						<option value="2" <?php echo($apoderado->p_estadocivil == 2 ? "selected='selected'" : ''); ?>>Casado</option>
						<option value="3" <?php echo($apoderado->p_estadocivil == 3 ? "selected='selected'" : ''); ?>>Separado</option>
						<option value="4" <?php echo($apoderado->p_estadocivil == 4 ? "selected='selected'" : ''); ?>>Viudo</option>
						<option value="5" <?php echo($apoderado->p_estadocivil == 5 ? "selected='selected'" : ''); ?>>Otro</option>
					</select>
				</div>
				<div class="form-group">
					<label>Lugar de residencia</label>
					<input type="text" class="form-control" placeholder="Lugar de residencia" name="p_lugarresidencia" value="{!! $apoderado->p_lugarresidencia !!}" data-bind="value: p_lugarresidencia">
				</div>
				<div class="form-group">
					<label>Teléfono fijo</label>
					<input type="text" class="form-control" placeholder="Teléfono fijo" name="p_telefonofijo" value="{!! $apoderado->p_telefonofijo !!}" data-bind="value: p_telefonofijo">
				</div>
				<div class="form-group">
					<label>Teléfono trabajo</label>
					<input type="text" class="form-control" placeholder="Teléfono trabajo" name="p_telefonotrabajo" value="{!! $apoderado->p_telefonotrabajo !!}" data-bind="value: p_telefonotrabajo">
				</div>
				<div class="form-group">
					<label>Celular personal</label>
					<input type="text" class="form-control" placeholder="Celular personal" name="p_celular" value="{!! $apoderado->p_celular !!}" data-bind="value: p_celular">
				</div>
				<div class="form-group">
					<label>email</label>
					<input type="email" class="form-control" placeholder="Email" name="p_email" value="{!! $apoderado->p_email !!}" data-bind="value: p_email">
				</div>
			</div>

			<div class="col-xs-4">
				<h4>Datos de la Madre</h4>
				<div class="form-group">
					<label>Nombres</label>
					<input type="text" id="validate" class="form-control" placeholder="Nombres" name="m_nombres" value="{!! $apoderado->m_nombres !!}" data-bind="value: m_nombres">
				</div>
				<div class="form-group">
					<label>Apellidos</label>
					<input type="text" id="validate" class="form-control" placeholder="Apellidos" name="m_apellidos" value="{!! $apoderado->m_apellidos !!}" data-bind="value: m_apellido">
				</div>
				<div class="form-group">
					<label>Dni</label>
					<input type="text" class="form-control" placeholder="DNI"  maxlength="7" name="m_dni" value="{!! $apoderado->m_dni !!}" data-bind="value: m_dni">
				</div>
				<div class="form-group">
					<label>Estado Civil</label>
					<select class="form-control" name="m_estadocivil" data-bind="value: m_estadocivil">
						<option value="1" <?php echo($apoderado->m_estadocivil == 1 ? "selected='selected'" : ''); ?> >Soltero</option>
						<option value="2" <?php echo($apoderado->m_estadocivil == 2 ? "selected='selected'" : ''); ?>>Casado</option>
						<option value="3" <?php echo($apoderado->m_estadocivil == 3 ? "selected='selected'" : ''); ?>>Separado</option>
						<option value="4" <?php echo($apoderado->m_estadocivil == 4 ? "selected='selected'" : ''); ?>>Viudo</option>
						<option value="5" <?php echo($apoderado->m_estadocivil == 5 ? "selected='selected'" : ''); ?>>Otro</option>
					</select>
				</div>
				<div class="form-group">
					<label>Lugar de residencia</label>
					<input type="text" class="form-control" placeholder="Lugar de residencia" name="m_lugarresidencia" value="{!! $apoderado->m_lugarresidencia !!}" data-bind="value: m_lugarresidencia">
				</div>
				<div class="form-group">
					<label>Teléfono fijo</label>
					<input type="text" class="form-control" placeholder="Teléfono fijo" name="m_telefonofijo" value="{!! $apoderado->m_telefonofijo !!}" data-bind="value: m_telefonofijo">
				</div>
				<div class="form-group">
					<label>Teléfono trabajo</label>
					<input type="text" class="form-control" placeholder="Teléfono trabajo" name="m_telefonotrabajo" value="{!! $apoderado->m_telefonotrabajo !!}" data-bind="value: m_telefonotrabajo">
				</div>
				<div class="form-group">
					<label>Celular personal</label>
					<input type="text" class="form-control" placeholder="Celular personal" name="m_celular" value="{!! $apoderado->m_celular !!}" data-bind="value: m_celular">
				</div>
				<div class="form-group">
					<label>email</label>
					<input type="email" class="form-control" placeholder="Email" name="m_email" value="{!! $apoderado->m_email !!}" data-bind="value: m_email">
				</div>
			</div>

			<div class="col-xs-4">
				<h4>Datos del Apoderado</h4>

				<div class="form-group">
					<label>Nombres</label>
					<input type="text" class="form-control" placeholder="Nombres" name="a_nombre" value="{!! $apoderado->a_nombres !!}" data-bind="value: a_nombres">
				</div>
				<div class="form-group">
					<label>Apellidos</label>
					<input type="text" class="form-control" placeholder="Apellidos" name="a_apellido" value="{!! $apoderado->a_apellidos !!}" data-bind="value: a_apellido">
				</div>
				<div class="form-group">
					<label>Dni</label>
					<input type="text" class="form-control" placeholder="DNI" name="a_dni" value="{!! $apoderado->a_dni !!}" data-bind="value: a_dni"  maxlength="7">
				</div>
				<div class="form-group">
					<label>Estado Civil</label>
					<select class="form-control" name="a_estadocivil" data-bind="value: a_estadocivil">
						<option value="1" <?php echo($apoderado->a_estadocivil == 1 ? "selected='selected'" : ''); ?> >Soltero</option>
						<option value="2" <?php echo($apoderado->a_estadocivil == 2 ? "selected='selected'" : ''); ?>>Casado</option>
						<option value="3" <?php echo($apoderado->a_estadocivil == 3 ? "selected='selected'" : ''); ?>>Separado</option>
						<option value="4" <?php echo($apoderado->a_estadocivil == 4 ? "selected='selected'" : ''); ?>>Viudo</option>
						<option value="5" <?php echo($apoderado->a_estadocivil == 5 ? "selected='selected'" : ''); ?>>Otro</option>
					</select>
				</div>
				<div class="form-group">
					<label>Lugar de residencia</label>
					<input type="text" class="form-control" placeholder="Lugar de residencia" name="a_lugarresidencia" value="{!! $apoderado->a_lugarresidencia !!}" data-bind="value: a_lugarresidencia">
				</div>
				<div class="form-group">
					<label>Teléfono fijo</label>
					<input type="text" class="form-control" placeholder="Teléfono fijo" name="a_telefonofijo" value="{!! $apoderado->a_telefonofijo !!}" data-bind="value: a_telefonofijo">
				</div>
				<div class="form-group">
					<label>Teléfono trabajo</label>
					<input type="text" class="form-control" placeholder="Teléfono trabajo" name="a_telefonotrabajo" value="{!! $apoderado->a_telefonotrabajo !!}" data-bind="value: a_telefonotrabajo">
				</div>
				<div class="form-group">
					<label>Celular personal</label>
					<input type="text" class="form-control" placeholder="Celular personal" name="a_celular" value="{!! $apoderado->a_celular !!}" data-bind="value: a_celular">
				</div>
				<div class="form-group">
					<label>email</label>
					<input type="email" class="form-control" placeholder="Email" name="a_email" value="{!! $apoderado->a_email !!}" data-bind="value: a_email">
				</div>
			</div>
			<div style="clear:both"></div>
		</div>

		<div id="otros" class="tab-pane">
			<h2>Otros datos</h2>
			<div class="col-xs-5">
				<div class="form-group">
					<label>Tipos de sangre</label>
					<input type="text" class="form-control" placeholder="Tipos de sangre" data-bind="value: tipo_sangre" value="{!! $otherdata->tiposangre !!}" name="tiposangre">
				</div>
				<div class="form-group">
					<label>Religión</label>
					<select class="form-control" data-bind="value: religion" name="religion">
						<option value="10">Ninguna</option>
						<option value="1" <?php echo($otherdata->idreligion == 1 ? "selected='selected'" : ''); ?>> Catolica</option>
						<option value="2" <?php echo($otherdata->idreligion == 2 ? "selected='selected'" : ''); ?>> Cristiana</option>
						<option value="3" <?php echo($otherdata->idreligion == 3 ? "selected='selected'" : ''); ?>> Testigo de Jehova</option>
						<option value="4" <?php echo($otherdata->idreligion == 4 ? "selected='selected'" : ''); ?>> Mormon</option>
						<option value="5" <?php echo($otherdata->idreligion == 5 ? "selected='selected'" : ''); ?>> Dios Madre</option>
						<option value="6" <?php echo($otherdata->idreligion == 6 ? "selected='selected'" : ''); ?>> Adventista</option>
						<option value="7" <?php echo($otherdata->idreligion == 7 ? "selected='selected'" : ''); ?>> Insrealita</option>
						<option value="8" <?php echo($otherdata->idreligion == 8 ? "selected='selected'" : ''); ?>> Judio</option>
						<option value="9" <?php echo($otherdata->idreligion == 9 ? "selected='selected'" : ''); ?>> Otro</option>
					</select>

				</div>
				<div class="form-group">
					<label>Email</label>
					<input type="email" class="form-control" placeholder="Email" data-bind="value: email" value="{!! $otherdata->email !!}" name="email">
				</div>
			</div>

			<div class="col-xs-5">
				<div class="form-group">
					<label>Hermanos en la institución</label>
					<input type="text" class="form-control" placeholder="Hermanos en la institución" value="{!! $otherdata->qty_hermanos !!}" data-bind="value: qty_hermanos" name="qty_hermanos">
				</div>
				<div class="form-group">
					<label>Celular personal</label>
					<input type="text" class="form-control" placeholder="Celular personal" value="{!! $otherdata->celular !!}" data-bind="value: celular" name="celular">
				</div>
				<div class="form-group">
					<label>Seguro afiliado</label>
					<input type="text" class="form-control" placeholder="Seguro afiliado" value="{!! $otherdata->seguro !!}" data-bind="value: seguro" name="seguro">
				</div>
			</div>

			<div style="clear:both"></div>
		</div>

		<div id="academica" class="tab-pane">
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
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>{!! $dataMatricula[0]->sede !!}</td>
								<td>{!! $dataMatricula[0]->nivel !!}</td>
								<td>{!! $dataMatricula[0]->grado !!}</td>
								<td>{!! $dataMatricula[0]->seccion !!}</td>
								<td><strong>{!! $dataMatricula[0]->tipopension !!}:</strong> S/. {!! $dataMatricula[0]->pension !!}</td>
								<td><a href="{{ route('alumnoAcademico',$id) }}" class="mb-xs mt-xs mr-xs btn btn-danger">Editar</a></td>
							</tr>
						</tbody>
					</table>
				</div>

				<hr>
<!--
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
				<hr>
				<br><br><br>

				<div class="row">
					<div class="col-md-5">
						<label>Estado de Matricula</label> <br>
						<div class="btn-group" data-toggle="buttons">
						@foreach($EstadoMatricula as $estado )
							<label class="btn btn-default  btn-sm <?php echo($matricula->idestadomatricula == $estado->idestadomatricula ? 'active' :''); ?>">
								<input type="radio" id="validate" name="alu_estado" autocomplete="off" value="{!! $estado->idestadomatricula !!}" <?php echo($matricula->idestadomatricula == $estado->idestadomatricula ? 'checked="checked"' :''); ?>>
								{!! $estado->nombre !!}
							</label>
						@endforeach
						</div>
					</div>

					<div class="col-xs-5">
						<label>Estado del Alumno</label> <br>
						<div class="btn-group" data-toggle="buttons">
						@foreach($EstadoAlumno as $estadoAlumno )
							<label class="btn btn-default  btn-sm <?php echo($estadoAlumno->idestadoalumno == $alumno->idestadoalumno ? 'active' :''); ?> ">
								<input type="radio" id="validate" name="estadoalumno" autocomplete="off" value="{!! $estadoAlumno->idestadoalumno !!}" <?php echo($estadoAlumno->idestadoalumno == $alumno->idestadoalumno ? 'checked="checked"' :''); ?> >
								{!! $estadoAlumno->nombre !!}
							</label>
						@endforeach
						</div>
					</div>

					<div class="col-xs-2">
						<div class="form-group">
							<p>¿Impedimento?</p>
							<div class="col-sm-12">
								<div class="radio-custom radio-danger">
									<input type="radio" id="radioExample5" name="impedimento" value="1" <?php echo($alumno->impedimento == 1 ? 'checked="checked"' :''); ?> >
									<label for="radioExample5">Si</label>
								</div>
								<div class="radio-custom radio-danger">
									<input type="radio" id="radioExample4" name="impedimento" value="0" <?php echo($alumno->impedimento == 0 ? 'checked="checked"' :''); ?>>
									<label for="radioExample4">No</label>
								</div>
							</div>
						</div>
					</div>
				</div>
-->


			</div>

			<div style="clear:both"></div>

		</div>
		<div class="panel-footer">
			<button class="btn btn-primary" type="submit">Actualizar Alumno</button>
			<a href="{!! route('alumnobuscar') !!}" class="btn btn-default ml-sm">Cancelar</a>
		</div>
	</div>
	{!!Form::close()!!}
</div>
@stop

@section('scripts')
@parent
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
		    	data: { tipo : tipopension, nivel: nivelpe },
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
	</script>
@stop
