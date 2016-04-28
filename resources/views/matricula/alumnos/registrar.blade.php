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
<div class="tabs">
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
	</ul>
	<div class="tab-content">

		<div id="alumno" class="tab-pane active">
			<h2>Alumno</h2>
			@include('alertas.request')
			@include('alertas.success')
			<div class="col-xs-6">                                
				<div class="form-group">
					<label>Codigo</label>
					<input type="text" name="codigo" class="form-control" id="validate" maxlength="10" placeholder="Ingrese el codigo" data-bind="value: acodigo">
				</div>
				<div class="form-group">
					<label>Nombre</label>
					<input type="text" name="nombres" class="form-control" id="validate" placeholder="Ingrese un nombre" data-bind="value: anombre">
				</div>
				<div class="form-group">
					<label>Apellido Paterno</label>
					<input type="text" name="apellido_paterno" class="form-control" id="validate" placeholder="Ingrese un apellido paterno" data-bind="value: apaterno">
				</div>
				<div class="form-group">
					<label>Apellido Materno</label>
					<input type="text" name="apellido_materno" class="form-control" id="validate" placeholder="Ingrese un apellido materno" data-bind="value: amaterno">
				</div>
				<div class="form-group">
					<label>Sexo</label>
					<select class="form-control" id="validate" name="sexo" data-bind="value: sexo">
						<option value="M">Masculino</option>
						<option value="F">Femenino</option>
					</select>
				</div>
				<div class="form-group">
					<label>Fecha de Nacimiento</label>
					<input type="date" name="fecha_nacimiento" pattern="dd/mm/yyyy" class="form-control" id="fechaNac" data-bind="value: afechaNac" placeholder="Seleccione su fecha de nacimiento">
				</div>
				<div class="form-group">
					<label>DNI</label>
					<input class="form-control" id="validate" name="dni" pattern="^[0-9]+$" placeholder="Ingrese un DNI" data-bind="value: adni">
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
					<input class="form-control" name="direccion" type="text" placeholder="Ingrese una dirección" data-bind="value: adireccion">
				</div>
				<div class="form-group">
					<label>Teléfono</label>
					<input class="form-control" name="telefono" type="text" placeholder="Ingrese un telefono" data-bind="value: atelefono">
				</div>
				<div class="form-group">
				<label>Fecha de vencimiento </label>
				<div class="input-group col-sm-5">
  				<input type="text" class="form-control" placeholder="Ingrese día" name="vencimiento" data-bind="value: avencimiento">
  				<span class="input-group-addon" id="basic-addon2">De cada mes</span>
				</div>
			</div>



			</div>
			
			<div style="clear:both"></div>
		</div>
		
		<div id="padre" class="tab-pane">
			<div class="col-xs-4">
				<h4>Datos del Padre</h4>
				<div class="form-group">
					<label>Nombres</label>
					<input type="text" id="validate" class="form-control" placeholder="Nombres" name="p_nombre" data-bind="value: p_nombre">
				</div>
				<div class="form-group">
					<label>Apellidos</label>
					<input type="text" id="validate" class="form-control" placeholder="Apellidos" name="p_apellido" data-bind="value: p_apellido">
				</div>
				<div class="form-group">
					<label>Dni</label>
					<input type="text" class="form-control" placeholder="DNI" name="p_dni" data-bind="value: p_dni">
				</div>
				<div class="form-group">
					<label>Estado Civil</label>
					<select class="form-control" name="p_estadocivil" data-bind="value: p_estadocivil">
						<option value="1">Soltero</option>
						<option value="2">Casado</option>
						<option value="3">Separado</option>
						<option value="4">Viudo</option>
						<option value="5">Otro</option>
					</select>
				</div>
				<div class="form-group">
					<label>Lugar de residencia</label>
					<input type="text" class="form-control" placeholder="Lugar de residencia" name="p_lugarresidencia" data-bind="value: p_lugarresidencia">
				</div>
				<div class="form-group">
					<label>Teléfono fijo</label>
					<input type="text" class="form-control" placeholder="Teléfono fijo" name="p_telefonofijo" data-bind="value: p_telefonofijo">
				</div>
				<div class="form-group">
					<label>Teléfono trabajo</label>
					<input type="text" class="form-control" placeholder="Teléfono trabajo" name="p_telefonotrabajo" data-bind="value: p_telefonotrabajo">
				</div>
				<div class="form-group">
					<label>Celular personal</label>
					<input type="text" class="form-control" placeholder="Celular personal" name="p_celular" data-bind="value: p_celular">
				</div>
				<div class="form-group">
					<label>email</label>
					<input type="email" class="form-control" placeholder="Email" name="p_email" data-bind="value: p_email">
				</div>
			</div>  

			<div class="col-xs-4">  
				<h4>Datos de la Madre</h4>
				<div class="form-group">
					<label>Nombres</label>
					<input type="text" id="validate" class="form-control" placeholder="Nombres" name="m_nombre" data-bind="value: m_nombres">
				</div>
				<div class="form-group">
					<label>Apellidos</label>
					<input type="text" id="validate" class="form-control" placeholder="Apellidos" name="m_apellido" data-bind="value: m_apellido">
				</div>
				<div class="form-group">
					<label>Dni</label>
					<input type="text" class="form-control" placeholder="DNI" name="m_dni" data-bind="value: m_dni">
				</div>
				<div class="form-group">
					<label>Estado Civil</label>
					<select class="form-control" name="m_estadocivil" data-bind="value: m_estadocivil">
						<option value="1">Soltero</option>
						<option value="2">Casado</option>
						<option value="3">Separado</option>
						<option value="4">Viudo</option>
						<option value="5">Otro</option>
					</select>
				</div>
				<div class="form-group">
					<label>Lugar de residencia</label>
					<input type="text" class="form-control" placeholder="Lugar de residencia" name="m_lugarresidencia" data-bind="value: m_lugarresidencia">
				</div>
				<div class="form-group">
					<label>Teléfono fijo</label>
					<input type="text" class="form-control" placeholder="Teléfono fijo" name="m_telefonofijo" data-bind="value: m_telefonofijo">
				</div>
				<div class="form-group">
					<label>Teléfono trabajo</label>
					<input type="text" class="form-control" placeholder="Teléfono trabajo" name="m_telefonotrabajo" data-bind="value: m_telefonotrabajo">
				</div>
				<div class="form-group">
					<label>Celular personal</label>
					<input type="text" class="form-control" placeholder="Celular personal" name="m_celular" data-bind="value: m_celular">
				</div>
				<div class="form-group">
					<label>email</label>
					<input type="email" class="form-control" placeholder="Email" name="m_email" data-bind="value: m_email">
				</div>
			</div>  

			<div class="col-xs-4">
				<h4>Datos del Apoderado</h4>

				<div class="form-group">
					<label>Nombres</label>
					<input type="text" class="form-control" placeholder="Nombres" name="a_nombre" data-bind="value: a_nombres">
				</div>
				<div class="form-group">
					<label>Apellidos</label>
					<input type="text" class="form-control" placeholder="Apellidos" name="a_apellido" data-bind="value: a_apellido">
				</div>
				<div class="form-group">
					<label>Dni</label>
					<input type="text" class="form-control" placeholder="DNI" name="a_dni" data-bind="value: a_dni">
				</div>
				<div class="form-group">
					<label>Estado Civil</label>
					<select class="form-control" name="a_estadocivil" data-bind="value: a_estadocivil">
						<option value="1">Soltero</option>
						<option value="2">Casado</option>
						<option value="3">Separado</option>
						<option value="4">Viudo</option>
						<option value="5">Otro</option>
					</select>					
				</div>
				<div class="form-group">
					<label>Lugar de residencia</label>
					<input type="text" class="form-control" placeholder="Lugar de residencia" name="a_lugarresidencia" data-bind="value: a_lugarresidencia">
				</div>
				<div class="form-group">
					<label>Teléfono fijo</label>
					<input type="text" class="form-control" placeholder="Teléfono fijo" name="a_telefonofijo" data-bind="value: a_telefonofijo">
				</div>
				<div class="form-group">
					<label>Teléfono trabajo</label>
					<input type="text" class="form-control" placeholder="Teléfono trabajo" name="a_telefonotrabajo" data-bind="value: a_telefonotrabajo">
				</div>
				<div class="form-group">
					<label>Celular personal</label>
					<input type="text" class="form-control" placeholder="Celular personal" name="a_celular" data-bind="value: a_celular">
				</div>
				<div class="form-group">
					<label>email</label>
					<input type="email" class="form-control" placeholder="Email" name="a_email" data-bind="value: a_email">
				</div>	                
			</div>	                
			<div style="clear:both"></div>
		</div> 

		<div id="otros" class="tab-pane">
			<h2>Otros datos</h2>
			<div class="col-xs-5">
				<div class="form-group">
					<label>Tipos de sangre</label>
					<input type="text" class="form-control" placeholder="Tipos de sangre" data-bind="value: tipo_sangre" name="tipo_sangre">
				</div>
				<div class="form-group">
					<label>Religión</label>
					<select class="form-control" data-bind="value: religion" name="religion">						
						<option value="10">Ninguna</option>
						<option value="1">Catolica</option>
						<option value="2">Cristiana</option>
						<option value="3">Testigo de Jehova</option>
						<option value="4">Mormon</option>
						<option value="5">Dios Madre</option>
						<option value="6">Adventista</option>
						<option value="7">Insrealita</option>
						<option value="8">Judio</option>
						<option value="9">Otro</option>						
					</select>

				</div>
				<div class="form-group">
					<label>Email</label>
					<input type="email" class="form-control" placeholder="Email" data-bind="value: email" name="email">
				</div>
			</div>

			<div class="col-xs-5">
				<div class="form-group">
					<label>Hermanos en la institución</label>
					<input type="text" class="form-control" placeholder="Hermanos en la institución" data-bind="value: qty_hermanos" name="qty_hermanos">
				</div>
				<div class="form-group">
					<label>Celular personal</label>
					<input type="text" class="form-control" placeholder="Celular personal" data-bind="value: celular" name="celular">
				</div>
				<div class="form-group">
					<label>Seguro afiliado</label>
					<input type="text" class="form-control" placeholder="Seguro afiliado" data-bind="value: seguro" name="seguro">
				</div>
			</div>

			<!--<div class="col-xs-2">
				<img src="http://localhost/hu/public/assets/img/user.png" alt="..." class="img-thumbnail">
				<div class="form-group">
					<input type="file" name="imagen" id="exampleInputFile">
				</div>
			</div>-->
			<div style="clear:both"></div>
		</div>

		<div class="panel panel-info">
			<div class="panel-body">
				<b>Se Matriculó para: </b>
                <p>
                    <span id="sede"></span>:
                    <span id="nivel"></span> |
                    <span id="grado"></span>
                    <span id="seccion"></span>
                </p>
				<div class="col-xs-4">
					<label>Tipo de Pension</label> <br>
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

				<div class="col-xs-4">
					<label>Estado de Matricula</label> <br>
					<div class="btn-group" data-toggle="buttons">
					@foreach($EstadoMatricula as $estado )
						<label class="btn btn-default  btn-sm">
							<input type="radio" id="validate" name="alu_estado" autocomplete="off" value="{!! $estado->idestadomatricula !!}"> 
							{!! $estado->nombre !!}
						</label>
					@endforeach	
					</div>
				</div>

				<div class="col-xs-4">
					<label>Estado del Alumno</label> <br>
					<div class="btn-group" data-toggle="buttons">
					@foreach($EstadoAlumno as $estadoAlumno )
						<label class="btn btn-default  btn-sm">
							<input type="radio" id="validate" name="estadoalumno" autocomplete="off" value="{!! $estadoAlumno->idestadoalumno !!}"> 
							{!! $estadoAlumno->nombre !!}
						</label>
					@endforeach	
					</div>
				</div>

			</div>
		</div>

		<div class="panel-footer">
			<button class="btn btn-primary" data-bind="click: guardar">Guardar Alumno</button>
			<button class="btn btn-danger" data-bind="click: cancelar">Cancelar Matricula</button>
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
	<script type="text/javascript">
	$(document).ready(function(){
		var baseURL = "{!! config('app.urlglobal') !!}";	
	    var sede  = $.cookie("idsede");
	    var nivel = $.cookie("idnivel");		
	    $(".tipopension").click(function(){
	    	var tipopension =  $(this).attr('id');
		    $.ajax({
		    	type: "GET",
		    	url: baseURL + "/api/v1/getPensiones",
		    	data: { tipo : tipopension, sede : sede, nivel : nivel},
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

        $.ajax({
            method: "POST",
            url: "{!! route('viewselectmatricula') !!}",
            dataType: 'json',
            data:
            {
                sede: $.cookie("idsede"), nivel: $.cookie("idnivel"), grado: $.cookie("idgrado"), seccion: $.cookie("idseccion"),
                _token: '{!! csrf_token() !!}'
            },
            success:  function (r)
            {
                $('#sede').html(r.sede);
                $('#nivel').html(r.nivel);
                $('#grado').html(r.grado);
                $('#seccion').html(r.seccion);
            }
        });
    });
	</script>

	<script>
	var baseURL = "{!! config('app.urlglobal') !!}";
	function AlumnoFormViewModel() {
	    fo = this;
	    fo.reID = "{{ $alumnodni->alu_id or ''}}";
	    fo.aid = ko.observable(0);
	    var c_dni = $.cookie("alu_dni");
	    fo.adni = ko.observable(c_dni);
	    fo.anombre = ko.observable(null);
	    fo.acodigo = ko.observable(null);
	    fo.apaterno = ko.observable(null);
	    fo.amaterno = ko.observable(null);
	    fo.sexo = ko.observable("M");
	    fo.afechaNac = ko.observable(null);
	    fo.adepartamento = ko.observable(null);
	    fo.aprovincia = ko.observable(null);
	    fo.adistrito = ko.observable(null);
	    fo.adireccion = ko.observable(null);
	    fo.atelefono = ko.observable(null);
	    fo.avencimiento = ko.observable(null);
	    fo.datavacante = ko.observable(null);
	    fo.pension = ko.observable(null);
	    fo.estadoalumno = ko.observable(null);
	    //JUAN CARLOS
	        fo.apo_id = ko.observable(null);
	        fo.p_nombre = ko.observable(null);
	        fo.p_apellido = ko.observable(null);
	        fo.p_dni = ko.observable(null);
	        fo.p_estadocivil = ko.observable(null);
	        fo.p_lugarresidencia = ko.observable(null);
	        fo.p_telefonofijo = ko.observable(null);
	        fo.p_telefonotrabajo = ko.observable(null);
	        fo.p_celular = ko.observable(null);
	        fo.p_email = ko.observable(null);

	        fo.m_nombres = ko.observable(null);
	        fo.m_apellido = ko.observable(null);
	        fo.m_dni = ko.observable(null);
	        fo.m_estadocivil = ko.observable(null);
	        fo.m_lugarresidencia = ko.observable(null);
	        fo.m_telefonofijo = ko.observable(null);
	        fo.m_telefonotrabajo = ko.observable(null);
	        fo.m_celular = ko.observable(null);
	        fo.m_email = ko.observable(null);

	        fo.a_nombres = ko.observable(null);
	        fo.a_apellido = ko.observable(null);
	        fo.a_dni = ko.observable(null);
	        fo.a_estadocivil = ko.observable(null);
	        fo.a_lugarresidencia = ko.observable(null);
	        fo.a_telefonofijo = ko.observable(null);
	        fo.a_telefonotrabajo = ko.observable(null);
	        fo.a_celular = ko.observable(null);
	        fo.a_email = ko.observable(null);

	        fo.datos_id = ko.observable(null);
	        fo.tipo_sangre = ko.observable(null);
	        fo.religion = ko.observable(null);
	        fo.email = ko.observable(null);
	        fo.qty_hermanos = ko.observable(null);
	        fo.celular = ko.observable(null);
	        fo.seguro = ko.observable(null);

	    //ALUMNO, Trae la data del alumno preguntando por el ID del alumno
	    fo.getAlumnoinfo = function (){
	        if (fo.reID != "") {
	            $.ajax({
	                type: "GET",
	                url: baseURL + "/api/v1/getAlumnoByID",
	                data: { alu_id : fo.reID},
	                dataType: "json",
	                contentType: "application/json; charset=utf-8",
	                success: function (data) {
	                    console.log(data);
	                    var rawAlumno = data.alumno;
	                    fo.loadAlumno(rawAlumno);
	                },
	                error: function (data) {
	                    console.log(data);
	                    console.log("error ;(");
	                }
	            });

	        }else{
	        var c_sed = $.cookie('idsede');
	        var c_niv = $.cookie('idnivel');
	        var c_gra = $.cookie('idgrado');
	        var c_sec = $.cookie('idseccion');
	        var textodata = 'Sede: '+c_sed+' » Nivel: '+c_niv+' » Grado: '+c_gra+' » Seccion: '+c_sec;
	        fo.datavacante(textodata);
	        }
	    };
	    //APODERADO, Trae la data del apoderado, preguntando por el ID del alumno.
	    fo.getApoderadoinfo = function (){
	        if (fo.reID != "") {
	            $.ajax({
	                type: "GET",
	                url: baseURL + "/api/v1/getApoderadosByID",
	                data: { alu_id : fo.reID},
	                dataType: "json",
	                contentType: "application/json; charset=utf-8",
	                success: function (data) {
	                    console.log(data);
	                    var rawApoderado = data.apoderado;
	                    fo.loadApoderado(rawApoderado);
	                },
	                error: function (data) {
	                    console.log(data);
	                    console.log("error");
	                }
	            });

	        }else{
	        }
	    };
	    //DATOS ADICIONALES, Trae la data de mas info del alumno
	    fo.getOtherDatainfo = function (){
	        if (fo.reID != "") {
	            $.ajax({
	                type: "GET",
	                url: baseURL + "/api/v1/getOtherDataByID",
	                data: { alu_id : fo.reID},
	                dataType: "json",
	                contentType: "application/json; charset=utf-8",
	                success: function (data) {
	                    console.log(data);
	                    var rawOtherData = data.otherdata;
	                    fo.loadOtherData(rawOtherData);
	                },
	                error: function (data) {
	                    console.log(data);
	                    console.log("error");
	                }
	            });

	        }else{
	        }
	    };

	    //EJECUTANDO las funciones iniciales
	    fo.getAlumnoinfo();
	    fo.getApoderadoinfo();
	    fo.getOtherDatainfo();

	    fo.loadAlumno = function(rawAlumno){
	        fofi = rawAlumno;
	        fo.aid(fofi.alu_id);
	        fo.adni(fofi.alu_dni);
	        fo.anombre(fofi.alu_nonbres);
	        fo.acodigo(fofi.alu_codigo);
	        fo.apaterno(fofi.alu_apellido_paterno);
	        fo.amaterno(fofi.alu_apellido_materno);
	        fo.sexo(fofi.alu_sexo);
	        fo.pension(fofi.pension)
	        if(fofi.alu_fecha_nac != null){
	            var fecha = new Date(fofi.alu_fecha_nac);
	            if(fecha.getMonth() + 1 < 10){ var mes = "0" + (fecha.getMonth() + 1);}
	            else {var mes = fecha.getMonth() + 1;}
	            if(fecha.getDate() < 10){ var dia = "0" + fecha.getDate();}
	            else {var dia = fecha.getDate();}
	            fo.afechaNac(fecha.getFullYear() + "-" + mes + "-" + dia);
	        }
	        else{
	            fo.afechaNac(fofi.alu_fecha_nac);
	        }
	        fo.adepartamento(fofi.alu_departamento);
	        fo.aprovincia(fofi.alu_provincia);
	        fo.adistrito(fofi.alu_distrito);
	        fo.adireccion(fofi.alu_direccion);
	        fo.atelefono(fofi.alu_telefono);	 
	        fo.avencimiento(fofi.alu_vencimiento);       

	        $("input[name='alu_estado'][value='" + fofi.alu_estado +"']").closest('label').addClass("active");
	        $("input[name='alu_estado'][value='" + fofi.alu_estado +"']").prop('checked', true);

	        $("input[name=alu_tipopension][value='" + fofi.alu_tipopension +"']").closest('label').addClass("active");
	        $("input[name=alu_tipopension][value='" + fofi.alu_tipopension +"']").prop('checked', true);
	        
	        $("input[name=estadoalumno][value='" + fofi.estadoalumno +"']").closest('label').addClass("active");
	        $("input[name=estadoalumno][value='" + fofi.estadoalumno +"']").prop('checked', true);
	    };

	    fo.loadApoderado = function(rawApoderado){
	        apo = rawApoderado;

	        fo.apo_id(apo.apo_id);
	        fo.p_nombre(apo.p_nombres);
	        fo.p_apellido(apo.p_apellidos);
	        fo.p_dni(apo.p_dni);
	        fo.p_estadocivil(apo.p_estadocivil);
	        fo.p_lugarresidencia(apo.p_lugarresidencia);
	        fo.p_telefonofijo(apo.p_telefonofijo);
	        fo.p_telefonotrabajo(apo.p_telefonotrabajo);
	        fo.p_celular(apo.p_celular);
	        fo.p_email(apo.p_email);	        

	        fo.m_nombres(apo.m_nombres);
	        fo.m_apellido(apo.m_apellidos);
	        fo.m_dni(apo.m_dni);
	        fo.m_estadocivil(apo.m_estadocivil);
	        fo.m_lugarresidencia(apo.m_lugarresidencia);
	        fo.m_telefonofijo(apo.p_telefonofijo);
	        fo.m_telefonotrabajo(apo.m_telefonotrabajo);
	        fo.m_celular(apo.m_celular);
	        fo.m_email(apo.m_email);

	        fo.a_nombres(apo.a_nombres);
	        fo.a_apellido(apo.a_apellidos);
	        fo.a_dni(apo.a_dni);
	        fo.a_estadocivil(apo.a_estadocivil);
	        fo.a_lugarresidencia(apo.a_lugarresidencia);
	        fo.a_telefonofijo(apo.p_telefonofijo);
	        fo.a_telefonotrabajo(apo.a_telefonotrabajo);
	        fo.a_celular(apo.a_celular);
	        fo.a_email(apo.a_email);
	    };

	    fo.loadOtherData = function(rawOtherData){
	        data = rawOtherData;

	        fo.datos_id(data.datos_id);
	        fo.tipo_sangre(data.tipo_sangre);
	        fo.religion(data.religion);
	        fo.email(data.email);
	        fo.qty_hermanos(data.qty_hermanos);
	        fo.celular(data.celular);
	        fo.seguro(data.seguro);
	    };

	    fo.revisar = function () {
	        // Primero buscamos input text vacios ! ;)
	            $("input[id=validate]").each(function (){
	                if ($.trim($(this).val()) == '') {
	                    $(this).closest('div.form-group').removeClass('has-success has-feedback');
	                    $(this).closest('div.form-group').addClass('has-error has-feedback');
	                    $(this).closest('div.form-group').children("span.glyphicon-ok").hide();
	                    $(this).closest('div.form-group').append('<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>');                         
	                }else{
	                    $(this).closest('div.form-group').removeClass('has-error has-feedback');
	                    $(this).closest('div.form-group').addClass('has-success has-feedback');
	                    $(this).closest('div.form-group').append('<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>');
	                    $(this).closest('div.form-group').children("span.glyphicon-remove").hide();
	                    $(this).closest('div.form-group').append('<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>');
	                };
	            });
	    }

	    fo.guardar = function () {
	        fo.revisar();
	        //Todas las propiedades a guardar, se almacenan en el objeto: "obj"
	        var obj = {
	            alu_id : fo.aid(),
	            alu_nonbres : fo.anombre(),
	            alu_codigo : fo.acodigo(),
	            alu_apellido_paterno : fo.apaterno(),
	            alu_apellido_materno : fo.amaterno(),
	            alu_sexo : fo.sexo(),
	            alu_fecha_nac : fo.afechaNac(),
	            alu_dni : fo.adni(),
	            alu_departamento : fo.adepartamento(),
	            alu_provincia : fo.aprovincia(),
	            alu_distrito : fo.adistrito(),
	            alu_direccion : fo.adireccion(),
	            alu_telefono : fo.atelefono(),
	            alu_pension : fo.pension(),
	            alu_vencimiento:fo.avencimiento(),
	            alu_estado : $("input[name=alu_estado]:checked").val(),
	            alu_tipopension : $("input[name=alu_tipopension]:checked").val(),
	            alu_estadoalumno : $("input[name=estadoalumno]:checked").val(),	           
	            alu_sede : $.cookie("idsede"),
	            alu_nivel : $.cookie("idnivel"),
	            alu_grado : $.cookie("idgrado"),
	            alu_seccion : $.cookie("idseccion"),
	            alu_aula : $.cookie("idaula")
	        }
	        var objApoderados = {
	            apo_id : fo.apo_id(),
	            p_nombre :fo.p_nombre(),
	            p_apellido :fo.p_apellido(),
	            p_dni :fo.p_dni(),
	            p_estadocivil :fo.p_estadocivil(),
	            p_lugarresidencia :fo.p_lugarresidencia(),
	            p_telefonofijo :fo.p_telefonofijo(),
	            p_telefonotrabajo :fo.p_telefonotrabajo(),
	            p_celular :fo.p_celular(),
	            p_email :fo.p_email(),

	            m_nombres :fo.m_nombres(),
	            m_apellido :fo.m_apellido(),
	            m_dni :fo.m_dni(),
	            m_estadocivil :fo.m_estadocivil(),
	            m_lugarresidencia :fo.m_lugarresidencia(),
	            m_telefonofijo :fo.m_telefonofijo(),
	            m_telefonotrabajo :fo.m_telefonotrabajo(),
	            m_celular :fo.m_celular(),
	            m_email :fo.m_email(),

	            a_nombres :fo.a_nombres(),
	            a_apellido :fo.a_apellido(),
	            a_dni :fo.a_dni(),
	            a_estadocivil :fo.a_estadocivil(),
	            a_lugarresidencia :fo.a_lugarresidencia(),
	            a_telefonofijo :fo.a_telefonofijo(),
	            a_telefonotrabajo :fo.a_telefonotrabajo(),
	            a_celular :fo.a_celular(),
	            a_email :fo.a_email(),

	            alu_id : fo.aid(),
	            anombre : fo.anombre(),
	            apaterno : fo.apaterno(),
	            amaterno : fo.amaterno(),
	            sexo : fo.sexo(),
	            afechaNac : fo.afechaNac(),
	            adni : fo.adni(),
	            adepartamento : fo.adepartamento(),
	            aprovincia : fo.aprovincia(),
	            adistrito : fo.adistrito(),
	            adireccion : fo.adireccion(),
	            atelefono : fo.atelefono(),
	            avencimiento: fo.avencimiento()
	        }
	        var objOtherData = {
	            datos_id : fo.datos_id(),
	            tipo_sangre :fo.tipo_sangre(),
	            religion :fo.religion(),
	            email :fo.email(),
	            qty_hermanos :fo.qty_hermanos(),
	            celular :fo.celular(),
	            seguro :fo.seguro()
	        }

	        //REGISTRA o ACTUALIZA al alumno.
	        if( $("#pension option:selected").val() !=0){
		        $.ajax({
		            type: "GET",
		            url: baseURL + "/api/v1/addAlumno",
		            //MANDO LOS OBJETOS CREADOS QUE TIENEN LAS PROPIEDADES
		            data: {alumno: obj, apoderados: objApoderados, otherdata: objOtherData},  
		            dataType: "json",
		            contentType: "application/json; charset=utf-8",
		            success: function (r) {
		                alert("Registro con éxito");
		                $.removeCookie('idsede', { path: '/' });
				        $.removeCookie('idnivel', { path: '/' });
				        $.removeCookie('idgrado', { path: '/' });
				        $.removeCookie('idseccion', { path: '/' });

				        setTimeout(function () { window.location = baseURL + "/" + r.alumnope; }, 100);
				        console.log('Se registro con exito');
		            },
		            error: function (response) {
		            	alert("Upps, Verifica el formulario del alumno.");
		                console.log('ERROR, no todos los campos no estan llenos');
		                fo.revisar();
		            }
		        });
			}
			else{
				alert("Te olvidaste de seleccionar un monto de pensión.");
			}
	    }

	    fo.cancelar = function cancelar() {
	        $.removeCookie('idsede', { path: '/' });
	        $.removeCookie('idnivel', { path: '/' });
	        $.removeCookie('idgrado', { path: '/' });
	        $.removeCookie('idseccion', { path: '/' });
	        setTimeout(function () { window.location = baseURL + "/searchvacantes"; }, 500);
	    }
	}
	    var viewModel = new AlumnoFormViewModel();

	        $(function () {
	            ko.applyBindings(viewModel , $("#page-wrapper")[0]);
	        });
	</script>
@stop