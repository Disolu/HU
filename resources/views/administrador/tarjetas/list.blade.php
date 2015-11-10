@extends('layouts.index')

@section('cuerpo')
	<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading">
			<h2 class="panel-title">Tarjetas Registradas</h2>
			<div class="text-right">
				<a href="{!! route('tarjetasnew') !!}" class="btn btn-primary text-right" onclick="if (! confirm('¿Estás seguro que deseas agregar una nueva tarjeta ?, esto afectará a toda la institución.')) return false;"><i class="glyphicon-plus"></i> Agregar nuevo</a>
			</div>
		</header>
		<div class="panel-body">
		@foreach($tarjetas as $tarjeta)
			<div class="col-md-4 col-xl-6">
				<section class="panel panel-group">
					<header class="panel-heading bg-primary">

						<div class="widget-profile-info">
							<div class="profile-picture">
								<img src="../../assets/images/%21logged-user.jpg">
							</div>
							<div class="profile-info">
								<h4 class="name text-semibold">
								
								{!! $tarjeta->nombre !!}</h4>
								<h5 class="role">{!! $tarjeta->nivel->nombre !!}</h5>
								<a href="{{ route('tarjetadelete',$tarjeta->idtarjeta) }}" style="color:red">Eliminar</a>
							</div>
						</div>

					</header>
					<div id="accordion">
						<div class="panel panel-accordion panel-accordion-first">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse1One">
										<i class="fa fa-check"></i> Bloques
									</a>
								</h4>
							</div>
							<div id="collapse1One" class="accordion-body collapse in">
								<div class="panel-body">
									<ul class="widget-todo-list ui-sortable">
										@if($tarjeta->tarjetabloque)
											@foreach($tarjeta->tarjetabloque as $bloques)
											<li>
												<div class="checkbox-custom checkbox-default">
													<a href="{{ route('tarjetabloquedelete', $bloques->idtarjetabloque) }}">x</a> 
													<span>{{ $bloques->bloque->nombre }}</span>
												</div>
											</li>
											@endforeach
										@endif
									</ul>
								</div>
							</div>
						</div>
						
					</div>
				</section>
			</div>
		@endforeach
		</div>
	</section>

</div>
@endsection