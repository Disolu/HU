@if(Session::has('message-search-alumno'))
@if(isset($getHistorial))
	

		


<div class="container">


<table width="85%" class="table table-striped table-bordered table-responsive" id="recepcion" name="recepcion">

			<thead>
			<tr class="cabeza">
			<th style="text-align:center">ID</th>
			<th style="text-align:center">FECHA DE PAGO</th>
			<!--<th>Fecha2</th>-->
			<th style="text-align:center">ALUMNO</th>
			<th style="text-align:center">CODIGO</th>
			<th style="text-align:center">MES</th>
			<th style="text-align:center">IMPORTE</th>
			<th style="text-align:center">ACCIONES</th>
			</tr>
			</thead>

			<tbody>
@foreach($getHistorial as $alumno)
			<tr>
			<td style="text-align:center">{!! $alumno->idrecepcionpagos !!}</td>
			<td style="text-align:center">{!! date('d/m/Y', strtotime($alumno->fecproceso)) !!}</td>
			<!--<td>{{ date('d / F  Y', strtotime($alumno->fecproceso)) }}</td>-->

			<td style="text-align:center">{!! $alumno->nomcliente !!}</td>
			<td style="text-align:center">{!! substr($alumno->refpago,0,10) !!}</td>
			<td style="text-align:center">{!! substr($alumno->refpago,10,20) !!}</td>
			<td style="text-align:center">S/.{!! $alumno->importeorigen !!}</td>
			<!--<td><button class="btn btn-info detallesajax" data-id="{!! substr($alumno->refpago,0,10) !!}">Ver información</button></td>-->
			<td style="text-align:center"><button class="btn btn-info detallesajax" data-id="{!! substr($alumno->refpago,0,10) !!}"><i class="fa fa-eye" aria-hidden="true"></i> Ver información</button></td>
			</tr>

			
@endforeach
</tbody>


</table>
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
		<div id="modalBasic" class="modal-block mfp-hide">
									<section class="panel">
										<header class="panel-heading">
											<h2 class="panel-title">Información de alumno</h2>
										</header>
										<div class="panel-body">
											<div class="modal-wrapper">
												<div class="modal-text">
													<table class="table table-bordered mb-none table-striped">
														<thead> 
															<tr class="cabeza">
																<th>Apellidos y nombres</th>
																<th>Vencimiento</th>
																<th>Telefonos</th>

																<th>Estado</th>
															</tr>
														</thead>
														<tbody id="recepcionpagos" class="cuerpo">
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



	
@endif
@endif
