@extends('layouts.index')

@section('cuerpo')
	<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading">
			<h2 class="panel-title">Bloque - Criterio</h2>
			<div class="text-right">
				<a href="{!! route('bloquenew') !!}" class="btn btn-primary text-right" onclick="if (! confirm('¿Estás seguro que deseas agregar un nuevo bloque?, esto afectará a toda la institución.')) return false;"><i class="glyphicon-plus"></i> Agregar nuevo</a>
			</div>
		</header>
		<div class="panel-body">
		@include('alertas.success')
			<div class="row">
				<div class="col-md-12">
					<section class="panel">
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table mb-none">
									<thead>
										<tr>
											<th>Nombre</th>
											<th>Bimestre</th>
											<th>Tarjeta</th>
											<th>Criterios</th>
										</tr>
									</thead>
									<tbody>
									@foreach($bloques as $bloque)
										<tr>
											<td>
												<code>{!! $bloque->tarjeta->nivel->sede->nombre !!}</code>
												<strong>{!! $bloque->bloque->nombre !!}</strong>
											</td>
											<td>{!! $bloque->bimestre->nombre !!}</td>
											<td class="text-warning">{!! $bloque->tarjeta->nombre !!}</td>
											<td>
											@if($bloque->bloque->criterios)
												<ul>
												@foreach($bloque->bloque->criterios as $criterios)
													<li class="text-info"><strong>{!! $criterios->criterio !!}</strong></li>
												@endforeach
												</ul>
											@endif
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
	</section>

</div>
@endsection