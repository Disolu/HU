<!doctype html>
<html class="fixed">
<head>
	<!-- Basic -->
	<meta charset="UTF-8">
	<title>Hipolito Unanue - Intranet</title>
	<meta name="keywords" content="Colegio Privado" />
	<meta name="description" content="Hipolito Unanue - Colegio">
	<meta name="author" content="LaravelPeru">

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

@section('css')
	<!-- Vendor CSS -->
	<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker/css/datepicker3.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/vendor/magnific-popup/magnific-popup.css') }}" />
	<!-- Specific Page Vendor CSS -->		
	<link rel="stylesheet" href="{{ asset('assets/vendor/morris/morris.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css') }}" />	
	<!-- Theme CSS -->
	<link rel="stylesheet" href="{{ asset('assets/stylesheets/theme.css') }}" />
	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="{{ asset('assets/stylesheets/theme-custom.css') }}">

	<link rel="stylesheet" href="{{ asset('assets/vendor/chartist/chartist.css') }}">		
	<!-- Head Libs -->
	<script src="{{ asset('assets/vendor/modernizr/modernizr.js') }}"></script>
	
@show	
</head>
<body>
	<section class="body">

		<!-- start: header -->
		@section('header')
		<header class="header">
			<div class="logo-container">
				<a href="{{ route('home')}}" class="logo">
					<img src="{{ asset('assets/images/logo.png') }}" height="35" alt="Hipolito Unanue" />
				</a>
				<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
					<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
				</div>
			</div>
			
			<!-- start: search & user box -->
			<div class="header-right">
				
				<form action="#" class="search nav-form">
					<div class="input-group input-search">
						<input type="text" class="form-control" name="q" id="q" placeholder="Search...">
						<span class="input-group-btn">
							<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
						</span>
					</div>
				</form>			
				
				<span class="separator"></span>
				
				<div id="userbox" class="userbox">
					<a href="#" data-toggle="dropdown">
						<figure class="profile-picture">
							<img src="{{ asset('assets/images/%21logged-user.jpg') }}" alt="Joseph Doe" class="img-circle" data-lock-picture="{{ asset('assets/images/%21logged-user.jpg') }}" />
						</figure>
						<div class="profile-info" data-lock-name="Juan Carlos" data-lock-email="juan@gmail.com">
							<span class="name">{!! Auth::user()->nombre !!}</span>
						</div>
						
						<i class="fa custom-caret"></i>
					</a>
					
					<div class="dropdown-menu">
						<ul class="list-unstyled">
							<li class="divider"></li>
							<li>
								<a role="menuitem" tabindex="-1" href="{!! route('logout'); !!}"><i class="fa fa-power-off"></i> Salir</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!-- end: search & user box -->
		</header>
		@show
		<!-- end: header -->

		<div class="inner-wrapper">
			<!-- start: sidebar -->
			
			<aside id="sidebar-left" class="sidebar-left">
				
				<div class="sidebar-header">
					<div class="sidebar-title">
						Navegación
					</div>
					<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
						<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>
				
				<div class="nano">
					<div class="nano-content">
						<nav id="menu" class="nav-main" role="navigation">
							@section('menu')
							<ul class="nav nav-main">
								<li class="nav-active">
									<a href="{{ route('home')}}">
										<i class="fa fa-home" aria-hidden="true"></i>
										<span>Intranet - Hipolito Unanue</span>
									</a>
								</li>

								<li class="nav-parent">
									<a>
										<i class="fa fa-copy" aria-hidden="true"></i>
										<span>Alumnos</span>
									</a>
									<ul class="nav nav-children">
										<li>
											<a href="{{ route('alumnobuscar') }}">
												Buscar alumno
											</a>
										</li>
										<li>
                                            <a href="{{route('generarlibretas')}}">
                                                Generar libretas
                                            </a>
                                        </li>
									</ul>
								</li>

								<li class="nav-parent">
									<a>
										<i class="fa fa-copy" aria-hidden="true"></i>
										<span>Matriculas</span>
									</a>
									<ul class="nav nav-children">
										<li>
											<a href="{!! route('listInformes') !!}">
												Informes
											</a>
										</li>
										<li>
											<a href="{!! route('searchvacantes') !!}">
												Consulta vacante
											</a>
										</li>
										<li>
											<a href="{!! route('searchrestringidos') !!}">
												Consulta restringidos
											</a>
										</li>
									</ul>
								</li>

								<li class="nav-parent">
									<a>
										<i class="fa fa-copy" aria-hidden="true"></i>
										<span>Administrador</span>
									</a>
									<ul class="nav nav-children">
										<li>
											<a href="{!! route('bancoPagos') !!}">
												Pagos
											</a>
										</li>
										
										<li>
											<a href="{!! route('periodo') !!}">
												Periodo Matricula
											</a>
										</li>

										<li>
											<a href="{!! route('fechanotas') !!}">
												Periodo Ingreso Notas
											</a>
										</li>

										<li class="nav-parent">
											<a>
												Reportes
											</a>
											<ul class="nav nav-children">
												<li>
													<a href="{!! route('Reportegraficos') !!}">
														Gráficos
													</a>
												</li>
												<li>
													<a href="{!! route('reportes') !!}">
														Alumno por sección
													</a>
												</li>
												<li>
													<a href="{!! route('alumnosMatriculados') !!}">
														Alumnos matriculados
													</a>
												</li>
												<li>
													<a href="{!! route('matriculaInformes') !!}">
														Informes vs Matriculados
													</a>
												</li>
												<li>
													<a href="{!! route('seguimientoPagos') !!}">
														Seguimiento de pagos
													</a>
												</li>
											</ul>
										</li>

										<li class="nav-parent">
											<a>
												Institución
											</a>
											<ul class="nav nav-children">
												<li>
													<a href="{!! route('sede') !!}">
														Sede
													</a>
												</li>
												<li>
													<a href="{!! route('nivel') !!}">
														Nivel
													</a>
												</li>
												<li>
													<a href="{!! route('grado') !!}">
														Grado
													</a>
												</li>
												<li>
													<a href="{!! route('seccion') !!}">
														Sección
													</a>
												</li>
												<li>
													<a href="{!! route('pension') !!}">
														Pensiones
													</a>
												</li>
												<li>
													<a href="{!! route('vacante') !!}">
														Vacantes
													</a>
												</li>
											</ul>
										</li>

										<li class="nav-parent">
											<a>
												Mantenimiento
											</a>
											<ul class="nav nav-children">
												<li>
													<a href="{!! route('asignaturas') !!}">
														Asignaturas
													</a>
												</li>
												
												<li>
													<a href="{!! route('showprofesor') !!}">
														Profesor Asignatura
													</a>
												</li>

												<li class="nav-parent">
													<a>
														Tarjetas
													</a>
													<ul class="nav nav-children">
														<li>
															<a href="{!! route('tarjetabloques') !!}">
																Tarjetas y bloques
															</a>
														</li>
														<li>
															<a href="{!! route('bloque') !!}">
																Bloques y criterios
															</a>
														</li>
													</ul>
												</li>		
											</ul>
										</li>
									</ul>
								</li>

								<li class="nav-parent">
									<a>
										<i class="fa fa-copy" aria-hidden="true"></i>
										<span>Seguridad</span>
									</a>
									<ul class="nav nav-children">
										<li>
											<a href="{!! route('usuarios') !!}">
												Usuarios
											</a>
										</li>
									</ul>
								</li>

									<li class="nav-parent">
									<a>
										<i class="fa fa-copy" aria-hidden="true"></i>
										<span>Boletas</span>
									</a>
									<ul class="nav nav-children">
										<li>
											<a href="{!! route('boletasnormal') !!}">
												Pensión Normal
											</a>
										</li>
										<li>
											<a href="{!! route('boletasmb') !!}">
												Media Beca
											</a>
										</li>
										<li>
											<a href="{!! route('boletaspe') !!}">
												Pensión Especial
											</a>
										</li>
									
									</ul>
								</li>


									<li class="nav-parent">
									<a>
										<i class="fa fa-copy" aria-hidden="true"></i>
										<span>Advertencias</span>
									</a>
									<ul class="nav nav-children">
										<li>
											<a href="{!! route('advmb') !!}">
												Advertencia Media Beca
											</a>
										</li>
										<li>
											<a href="{!! route('advpe') !!}">
												Advertencia Pensión Especial
											</a>
										</li>
									</ul>
								</li>
						<li class="nav-parent">
									<a>
										<i class="fa fa-copy" aria-hidden="true"></i>
										<span>Pérdida de Beneficio</span>
									</a>
									<ul class="nav nav-children">
										<li>
											<a href="{!! route('incidenciasbuscar') !!}">
												Busqueda de incidencias
											</a>
										</li>
									</ul>
								</li>
								<li class="nav">
									<a href="{!! route('recepcionpagosbuscar') !!}">
										<i class="fa fa-copy" aria-hidden="true"></i>
										Búsqueda de Pagos BBVA
									</a>
									
								</li>




							</ul>
							@show
						</nav>
						
						<hr class="separator" />
						

					</div>				
				</div>				
			</aside>
			
			<!-- end: sidebar -->

			<section role="main" class="content-body">
				<header class="page-header">
					<h2>HIPOLITO UNANUE</h2>
					
					<div class="right-wrapper pull-right">
						<ol class="breadcrumbs">
							<li>
								<a href="#">
									<i class="fa fa-home"></i>
								</a>
							</li>
							<li><span>Home</span></li>
						</ol>
						
						<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
					</div>
				</header>

				<!-- start: page -->
				<div class="row">
					@section('cuerpo')
					<p>Bienvenido Administrador</p>
					@show	
				</div>


				<!-- end: page -->
			</section>
		</div>

		<aside id="sidebar-right" class="sidebar-right">
			<div class="nano">
				<div class="nano-content">
					<a href="#" class="mobile-close visible-xs">
						Collapse <i class="fa fa-chevron-right"></i>
					</a>
					
					<div class="sidebar-right-wrapper">
						
						<div class="sidebar-widget widget-calendar">
							<h6>Upcoming Tasks</h6>
							<div data-plugin-datepicker data-plugin-skin="dark" ></div>
							
							<ul>
								<li>
									<time datetime="2014-04-19T00:00+00:00">04/19/2014</time>
									<span>Company Meeting</span>
								</li>
							</ul>
						</div>
						
						<div class="sidebar-widget widget-friends">
							<h6>Friends</h6>
							<ul>
								<li class="status-online">
									<figure class="profile-picture">
										<img src="{{ asset('assets/images/%21sample-user.jpg') }}" alt="Joseph Doe" class="img-circle">
									</figure>
									<div class="profile-info">
										<span class="name">Joseph Doe Junior</span>
										<span class="title">Hey, how are you?</span>
									</div>
								</li>
								<li class="status-online">
									<figure class="profile-picture">
										<img src="{{ asset('assets/images/%21sample-user.jpg') }}" alt="Joseph Doe" class="img-circle">
									</figure>
									<div class="profile-info">
										<span class="name">Joseph Doe Junior</span>
										<span class="title">Hey, how are you?</span>
									</div>
								</li>
								<li class="status-offline">
									<figure class="profile-picture">
										<img src="{{ asset('assets/images/%21sample-user.jpg') }}" alt="Joseph Doe" class="img-circle">
									</figure>
									<div class="profile-info">
										<span class="name">Joseph Doe Junior</span>
										<span class="title">Hey, how are you?</span>
									</div>
								</li>
								<li class="status-offline">
									<figure class="profile-picture">
										<img src="{{ asset('assets/images/%21sample-user.jpg') }}" alt="Joseph Doe" class="img-circle">
									</figure>
									<div class="profile-info">
										<span class="name">Joseph Doe Junior</span>
										<span class="title">Hey, how are you?</span>
									</div>
								</li>
							</ul>
						</div>
						
					</div>
				</div>
			</div>
		</aside>
	</section>
	@section('scripts')
	
	<!-- Vendor -->
	<script src="{{ asset('assets/vendor/jquery/jquery.js') }}"></script>		
	<script src="{{ asset('assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js') }}"></script>		
	<script src="{{ asset('assets/vendor/jquery-cookie/jquery.cookie.js') }}"></script>		
	<script src="{{ asset('assets/vendor/style-switcher/style-switcher.js') }}"></script>		
	<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.js') }}"></script>		
	<script src="{{ asset('assets/vendor/nanoscroller/nanoscroller.js') }}"></script>		
	<script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>		
	<script src="{{ asset('assets/vendor/magnific-popup/magnific-popup.js') }}"></script>		
	<script src="{{ asset('assets/vendor/jquery-placeholder/jquery.placeholder.js') }}"></script>
	<!-- Specific Page Vendor -->		
	<script src="{{ asset('assets/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js') }}"></script>		
	<script src="{{ asset('assets/vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js') }}"></script>		
	<script src="{{ asset('assets/vendor/jquery-appear/jquery.appear.js') }}"></script>		
	<script src="{{ asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>		
	<script src="{{ asset('assets/vendor/jquery-easypiechart/jquery.easypiechart.js') }}"></script>		
	<script src="{{ asset('assets/vendor/flot/jquery.flot.js') }}"></script>		
	<script src="{{ asset('assets/vendor/flot-tooltip/jquery.flot.tooltip.js') }}"></script>		
	<script src="{{ asset('assets/vendor/flot/jquery.flot.pie.js') }}"></script>		
	<script src="{{ asset('assets/vendor/flot/jquery.flot.categories.js') }}"></script>		
	<script src="{{ asset('assets/vendor/flot/jquery.flot.resize.js') }}"></script>		
	<script src="{{ asset('assets/vendor/jquery-sparkline/jquery.sparkline.js') }}"></script>		
	<script src="{{ asset('assets/vendor/raphael/raphael.js') }}"></script>		
	<script src="{{ asset('assets/vendor/morris/morris.js') }}"></script>		
	<script src="{{ asset('assets/vendor/gauge/gauge.js') }}"></script>		
	<script src="{{ asset('assets/vendor/snap-svg/snap.svg.js') }}"></script>		
	<script src="{{ asset('assets/vendor/liquid-meter/liquid.meter.js') }}"></script>		
	
	<!-- Theme Base, Components and Settings -->
	<script src="{{ asset('assets/javascripts/theme.js') }}"></script>
	<!-- Theme Custom -->
	<script src="{{ asset('assets/javascripts/theme.custom.js') }}"></script>
	<!-- Theme Initialization Files -->
	<script src="{{ asset('assets/javascripts/theme.init.js') }}"></script>	
	<!-- Examples -->
	<script src="{{ asset('assets/javascripts/dashboard/examples.dashboard.js') }}"></script>
	<script src="{{ asset('assets/javascripts/ui-elements/examples.modals.js') }}"></script>
	@show		
</body>
</html>