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
<div class="panel-body">
	<div class="invoice">
		<header class="clearfix">
			<div class="row">
				<div class="col-sm-6 mt-md">

					
					<h2 class="h2 mt-none mb-sm text-dark text-bold">


					
					{!! $matricula[0]->alu_nombres !!}
					{!! $matricula[0]->apellido_paterno !!}
					{!! $matricula[0]->apellido_materno !!}
					</h2>
					<h4 class="h4 m-none text-dark text-bold">Codigo: {!! $matricula[0]->codigo !!}</h4>
					<a href="{!! route('observacion',$id) !!}" class="mb-xs mt-xs mr-xs btn btn-xs btn-default">Observaciones</a>
					<a class="mb-xs mt-xs mr-xs btn btn-xs btn-default recepcionpagos" data-id="{!! $matricula[0]->codigo !!}">Ver historial de pagos</a>


				</div>
				<div class="col-sm-6 text-right mt-md mb-md">
					<address class="ib mr-xlg">
						Incidencias de pago: {!! $incidencia[0]->incidencias !!}
						<br>
						Dni: {!! $matricula[0]->dni !!}
						<br>
						{!! $matricula[0]->direccion !!}
						<br>
						Télefono: {!! $matricula[0]->telefono !!} | Celular: {!! $matricula[0]->celular !!}
						<br>
						{!! $matricula[0]->email !!}
					</address>
					<div class="ib">
					@if($matricula[0]->sexo == 'M')
						<img src="{!! asset('assets/img/man.jpg') !!}" style="width: 55px !important;" alt="{!! $matricula[0]->alu_nombres !!}">
					@elseif($matricula[0]->sexo == 'F')
						<img src="{!! asset('assets/img/woman.jpg') !!}" style="width: 55px !important;" alt="{!! $matricula[0]->alu_nombres !!}">
					@endif
					</div>
				</div>
			</div>
		</header>
		<div class="bill-info">
			<div class="row">
				<div class="col-md-6">
					<div class="bill-to">
						<p class="h5 mb-xs text-dark text-semibold"><strong>{!! $matricula[0]->nombreperiodo !!}:</strong></p>
						<address>
							<strong>Sede:</strong> {!! $matricula[0]->sede_nombre !!}
							<br>
							<strong>Escala:</strong> Nivel: {!! $matricula[0]->nivel_nombre !!} | Grado: {!! $matricula[0]->grado_nombre !!} | Sección: {!! $matricula[0]->seccion_nombre !!}
							<br>
							<strong>Estado:</strong> {!! $alumno[0]->nombreestado !!}
							<br>
						</address>
					</div>
				</div>
				<div class="col-md-6">
					<div class="bill-data text-right">
						<p class="mb-none">
							<span class="text-dark"><strong>Pensión mensual:</strong> ({!! $matricula[0]->tipopension_nombre !!})</span>
							<span class="value">S/. {!! $matricula[0]->monto !!}</span>
						</p>
						<p class="mb-none">
							<span class="text-dark">Fecha Matricula:</span>
							<span class="value"><?php echo substr($matricula[0]->fechamatricula, 0, -8); ?> </span>
						</p>
					</div>
				</div>
			</div>

			<div class="row">
				<section class="panel panel-featured panel-featured-primary">
					<header class="panel-heading">
						<div class="panel-actions">
							<a href="#" class="panel-action panel-action-toggle" data-panel-toggle=""></a>
						</div>
						<h2 class="panel-title">Historial Notas:</h2>
					</header>
					<div class="panel-body" style="display: block;">
						<section>
							<table class="table table-hover">
							  <thead>
							  	<th>Periodo</th>
							  	<th>Ver notas</th>
							  </thead>

							  <tbody>
							  @foreach($periodo as $data)
							  	<tr>
								  	<td>{{ $data->periodo }}</td>
								  	<td>
								  		@foreach($bimestres as $bimestre)
								  			<code>
									  			<a class="mb-xs mt-xs mr-xs  btnDetails" data-periodo="{{ $data->idperiodo }}" data-id="{{ $bimestre->idbimestre }}"
									  			data-alumno="{!! $matricula[0]->idalumno !!}"
									  			>
									  				{{ $bimestre->nombre }}
									  			</a>
								  			</code> |
								  		@endforeach
								  	</td>
							  	</tr>
							  @endforeach
							  </tbody>
							</table>


							<div id="modalBasic" class="modal-block mfp-hide">
								<section class="panel">
									<header class="panel-heading">
										<h2 class="panel-title">Notas</h2>
									</header>
									<div class="panel-body">
										<div class="modal-wrapper">
											<div class="modal-text">
												PERIODO: <strong id="periodo"></strong>
												<table class="table table-hover mb-none">
													<thead>
														<tr>
															<th>Curso</th>
															<th>Nota</th>
															<th>Fec. Registro</th>
														</tr>
													</thead>
													<tbody id="tableajax">
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<footer class="panel-footer">
										<div class="row">
											<div class="col-md-12 text-right">
												<button class="btn btn-default modal-dismiss">Cerrar</button>
											</div>
										</div>
									</footer>
								</section>
							</div>


						</section>
					</div>

				</section>
			</div>

			<div class="row">
				<section class="panel panel-featured panel-featured-primary">
					<header class="panel-heading">
						<div class="panel-actions">
							<a href="#" class="panel-action panel-action-toggle" data-panel-toggle=""></a>
						</div>
						<h2 class="panel-title">Subir documentos:</h2>
					</header>
					@include('alertas.request')
					@include('alertas.success')
					@include('alertas.error')
					<div class="panel-body" style="display: block;">
						<section>
							<code>Descarga los documentos del alumno para subirlos con su matricula</code>
							@if($matricula[0]->id_tipopension == 1)
							<div class="btn-group btn-group-justified">
								<a href="{!! route('compromisoPdf', [$matricula[0]->idalumno, $matricula[0]->idperiodomatricula]) !!}" target="_black" class="btn btn-default" role="button">Compromiso</a>
							</div>
							@elseif($matricula[0]->id_tipopension == 2)
							<div class="btn-group btn-group-justified">
								<a href="{!! route('compromisoPdf', [$matricula[0]->idalumno, $matricula[0]->idperiodomatricula]) !!}" target="_black" class="btn btn-default" role="button">Compromiso</a>
								<a href="{!! route('especialPdf', [$matricula[0]->idalumno, $matricula[0]->idperiodomatricula]) !!}" target="_black" class="btn btn-default" role="button">Anexo</a>
							</div>
							@elseif($matricula[0]->id_tipopension == 3)
							<div class="btn-group btn-group-justified">
								<a href="{!! route('compromisoPdf', [$matricula[0]->idalumno, $matricula[0]->idperiodomatricula]) !!}" target="_black" class="btn btn-default" role="button">Compromiso</a>
								<a href="{!! route('preferencialPdf', [$matricula[0]->idalumno, $matricula[0]->idperiodomatricula]) !!}" target="_black" class="btn btn-default" role="button">Anexo</a>
							</div>
							@endif
							<br>
						</section>
						<article>
						{!! Form::open(['route' => array('saveArchivosDataUsers', $id), 'method' => 'POST', 'role' => 'form', 'enctype' => 'multipart/form-data']) !!}
						<div class="col-xs-12">
							<div class="well bloquepadding">
								<p>
								<strong>Compromiso de matricula</strong></p>
								<div class="row">
									<div class="col-xs-7">
										<div class="form-group">
											{!! Form::file('file1', ['id'=>'file1']) !!}
										</div>
									</div>
									@if(isset($archivos[0]))
										@if(!empty($archivos[0]->compromiso_url))
											<div class="col-xs-5">
												<a href="{{asset('uploads/'.$archivos[0]->compromiso_url)}}" target="_blank">Descargar</a>
											</div>
										@endif
									@endif
								</div>
							</div>
						</div>

						<div class="col-xs-12">
							<div class="well bloquepadding">
								<p>

								<strong>Anexo</strong></p>
								<div class="row">
									<div class="col-xs-7">
										<div class="form-group">
											{!! Form::file('file2', ['id'=>'file2']) !!}
										</div>
									</div>
									@if(isset($archivos[0]))
										@if(!empty($archivos[0]->anexo_url))
											<div class="col-xs-5">
												<a href="{{asset('uploads/'.$archivos[0]->anexo_url)}}" target="_blank">Descargar</a>
											</div>
										@endif
									@endif
								</div>
							</div>
						</div>

						<div class="col-xs-12">
							<div class="well bloquepadding">
								<p>

								<strong>Recibo de agua luz</strong></p>
								<div class="row">
									<div class="col-xs-7">
										<div class="form-group">
											{!! Form::file('file3', ['id'=>'file3']) !!}
										</div>
									</div>
									@if(isset($archivos[0]))
										@if(!empty($archivos[0]->reciboluz_url))
											<div class="col-xs-5">
												<a href="{{asset('uploads/'.$archivos[0]->reciboluz_url)}}" target="_blank">Descargar</a>
											</div>
										@endif
									@endif
								</div>
							</div>
						</div>

						<div class="col-xs-12">
							<div class="well bloquepadding">
								<p>
								<strong>Dni de padre o madre</strong></p>
								<div class="row">
									<div class="col-xs-7">
										<div class="form-group">
											{!! Form::file('file4', ['id'=>'file4']) !!}
										</div>
									</div>
									@if(isset($archivos[0]))
										@if(!empty($archivos[0]->dni_apoderado))
											<div class="col-xs-5">
												<a href="{{asset('uploads/'.$archivos[0]->dni_apoderado)}}" target="_blank">Descargar</a>
											</div>
										@endif
									@endif
								</div>
							</div>
						</div>

						<div class="col-md-12">
							<input type="hidden" name="action" value="multiple" />
							<button type="submit" class="btn btn-success">Subir archivos</button>
						</div>
						{!! Form::close() !!}
					</article>
					</div>

				</section>
			</div>
		</div>

	</div>

	<div class="text-right mr-lg">
		<a href="{!! route('alumno', $id) !!}" class="btn btn-default">Editar Alumno</a>
		<a href="{!! route('alumnobuscar') !!}" class="btn btn-primary ml-sm">Salir</a>
	</div>
</div>


<style type="text/css">
  .cabeza{

			text-align:center; 
  			background-color: #F7F8E0;
          	vertical-align:middle;
         	 text-transform:uppercase; 
                }

                .cuerpo{
  			text-align:center; 
          vertical-align:middle;
          text-transform:uppercase; 


                }
                </style>

<div id="modalRecepcion" class="modal-block mfp-hide">
									<section class="panel">
										<header class="panel-heading">
											<h2 class="panel-title">Historial de pagos</h2>
										</header>
										<div class="panel-body">
											<div class="modal-wrapper">
												<div class="modal-text">
													<table width="200%"class="table table-hover mb-none table-striped table-bordered">
														<thead>
															<tr>
																<th class="cabeza">Apellidos y nombres</th>
																<th class="cabeza">Referencia</th>
																<th class="cabeza">Monto</th>
																<th class="cabeza">Fecha de Pago</th>
																

						
															</tr>
														</thead>
														<tbody id="pagosprofile" class="cuerpo">
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<footer class="panel-footer">
											<div class="row">
												<div class="col-md-12 text-right">
													<button class="btn btn-default modal-dismiss">Cerrar</button>
												</div>
											</div>
										</footer>
									</section>
								</div>

@stop

@section('scripts')
@parent
<script type="text/javascript">
  $(document).ready(function(){

	

    $('.btnDetails').click(function(){
      $.ajax({
        method: "POST",
        url: "{!! route('NotasAlumnoAjax') !!}",
        dataType: 'json',
        data:
        {
          idperiodo: $(this).data('periodo'),
          idbimestre: $(this).data('id'),
          idalumno: $(this).data('alumno'),
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
            $.each(r, function(i)
            {
            	$('#periodo').html(r[i].periodo);
	            options += "<tr>";
	              options += "<td>"+r[i].nombre+"</td>";
	              options += "<td>"+r[i].nota_number+"</td>";
	              options += "<td>"+r[i].registro+"</td>";
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


 $('.recepcionpagos').click(function(){
      $.ajax({
        method: "POST",
        url: "{!! route('RecepcionPagosProfile') !!}",
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
            alert('No encontramos pagos para este alumno.');
          }
          else
          {
          	var options;
          	var estado;
            $.each(r, function(i)


            {

            	var fecha = r[i].refpago;
            	
	            options += "<tr>";
	              options += "<td>"+r[i].nomcliente+" </td>";
	              options += "<td>"+r[i].refpago+"</td>";
	              options += "<td>S/. "+r[i].importeorigen+"</td>";
	              options += "<td>"+r[i].fecpago+"</td>";
	            options += "</tr>";
            });







            $('#pagosprofile').html(options);
            $.magnificPopup.open({
                items: {
                    src: $('#modalRecepcion')[0]
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
@endsection
