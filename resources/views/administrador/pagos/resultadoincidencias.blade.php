@if(Session::has('message-search-alumno'))
@if(isset($getIncidencias))
	

<div class="container">


<table style="width:95%" class="table table-striped table-bordered table-responsive"  id="recepcion" name="recepcion">

			<thead>
			<tr class="cabeza">
			<th style="text-align:center">ALUMNO</th>
			<th style="text-align:center">CODIGO</th>
			<!--<th>Fecha2</th>-->
			
			<th style="text-align:center">NIVEL</th>
			<th style="text-align:center">GRADO</th>
			<th style="text-align:center">SECCION</th>
			<th style="text-align:center">TIPO DE PENSION</th>
			<th style="text-align:center">MONTO</th>
			<th style="text-align:center">INCIDENCIAS</th>
			<th style="text-align:center">OPCIONES</th>

			</tr>
			</thead>

			<tbody>
@foreach($getIncidencias as $i)
			<tr>
			<td style="text-align:center">{!! $i->fullname !!}</td>
			<td style="text-align:center">{!! $i->codigo !!}</td>
			<!--<td>{{ date('d / F  Y', strtotime($i->fecproceso)) }}</td>-->

			<td id="idnivel" name="idnivel" data-id="{!! $i->idnivel !!}"style="text-align:center">{!! $i->nivel !!}</td>
			<td style="text-align:center">{!! $i->grado !!}</td>
			<td style="text-align:center">{!! $i->seccion !!}</td>
			<td style="text-align:center">{!! $i->tipopension !!}</td>
			<td style="text-align:center">S/.{!! $i->monto !!}</td>
			<td style="text-align:center">{!! $i->incidencia !!}</td>
			@if($i->incidencia >=2 && $i->tipopension<>'General')
			<td style="text-align:center;">
				<div class="dropdown">
 				 <button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Acciones
  					<span class="caret"></span></button>
  					<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
   					 <li role="presentation">
    					 	<a style="color:red;" role="menuitem" href="#" class="perdida" data-id="{!! $i->idalumno !!}"><i class="fa fa-times" aria-hidden="true"></i> Eliminar Beneficio</a>
					    <li role="presentation" class="divider"></li>
					    <li role="presentation">
					    	<a role="menuitem" href="{!! route('advmb') !!}"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Generar documento de pérdida</a></li>
					  </ul>
					</div>
			@elseif($i->incidencia >=2 && $i->tipopension=='General')
			<td style="text-align:center">No tiene beneficios</td>
			</td>
			@else
			<td style="text-align:center">No hay Acciones Disponibles</td>

			@endif
			<!--<td><button class="btn btn-info detallesajax" data-id="{!! substr($i->refpago,0,10) !!}">Ver información</button></td>-->
			
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
