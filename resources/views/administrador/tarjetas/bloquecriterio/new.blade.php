@extends('layouts.index')

@section('cuerpo')
	<div class="col-lg-12">

	<section class="panel">
		<header class="panel-heading">
			<h2 class="panel-title">Nuevo Bloque</h2>
		</header>
		<div class="panel-body">
			@include('alertas.request')
			@include('alertas.success')
			@include('alertas.error')
			{!! Form::open(['route' => 'bloquenew', 'method' => 'post']) !!}
			{!! Form::token() !!}	
				<div class="form-group">
					<div class="col-md-6">
						<label for="Nombre"><strong>Nombre del Bloque</strong></label>
						{!! Form::text('nombre', null, ['class' => 'form-control input-sm mb-md', 'placeholder' => 'Nombre del bloque']) !!}
						<hr>
						<label for="Criterio">Criterio 1: </label>
						{!! Form::text('criterio[]', null, ['class' => 'form-control input-sm mb-md', 'placeholder' => 'Criterio 1']) !!}

						<label for="Criterio">Criterio 2: </label>
						{!! Form::text('criterio[]', null, ['class' => 'form-control input-sm mb-md', 'placeholder' => 'Criterio 2']) !!}

						<label for="Criterio">Criterio 3: </label>
						{!! Form::text('criterio[]', null, ['class' => 'form-control input-sm mb-md', 'placeholder' => 'Criterio 3']) !!}
						<p><a href="#" id="mascampos">+ Agregar más criterios</a></p>
					</div>
					<div class="col-md-6">
						<div class="form-block">
							<h5><strong>Tarjetas</strong></h5>
							<ul>
								@foreach($tarjetas as $tarjeta)
									<li>
									<input type="checkbox" name="tarjeta[]" value="{!! $tarjeta->idtarjeta !!}">
									<label for="">
										{!! $tarjeta->nivel->sede->nombre !!} | <strong>{!! $tarjeta->nivel->nombre !!}</strong> | <strong><code>{!! $tarjeta->nombre !!}</code></strong>
									</label>
									</li>
								@endforeach
							</ul>
						</div>

						<div class="form-block">
							<h5><strong>Bimestres</strong></h5>
							<ul>
								@foreach($bimestres as $bimestre)
									<li>
									<input type="radio" name="bimestre" value="{!! $bimestre->idbimestre !!}">
									<label for="">
										<strong>{!! $bimestre->nombre !!}</strong>
									</label>
									</li>
								@endforeach
							</ul>
						</div>
					</div>					
				</div>

				<p class="m-none">
					<button type="submit" class="mb-xs mt-xs mr-xs btn btn-success" OnClick="if (! confirm('¿Estás seguro que deseas hacer este registro?')) return false;">Registrar</button>
					<a class="mb-xs mt-xs mr-xs btn btn-default" href="javascript:history.back(1)">Cancelar</a>
				</p>
			{!! Form::close() !!}
		</div>
	</section>
</div>
@endsection

@section('scripts')
@parent
	<script>
	jQuery.fn.generaNuevosCampos = function(etiqueta, nombreCampo, indice){
		$(this).each(function(){
			elem = $(this);
			elem.data("etiqueta",etiqueta);
			elem.data("nombreCampo",nombreCampo);
			elem.data("indice",indice);
			
			elem.click(function(e){
				e.preventDefault();
				elem = $(this);
				etiqueta = elem.data("etiqueta");
				nombreCampo = elem.data("nombreCampo");
				indice = elem.data("indice");
				texto_insertar = '<p>' + etiqueta + ' ' + indice + ':<br><input type="text" class="form-control input-sm mb-md" name="' + nombreCampo +'" /></p>';
				indice ++;
				elem.data("indice",indice);
				nuevo_campo = $(texto_insertar);
				elem.before(nuevo_campo);
			});
		});
		return this;
	}
	$(document).ready(function(){
		$("#mascampos").generaNuevosCampos("Criterio", "criterio[]", 04);
	});
	</script>
@endsection	