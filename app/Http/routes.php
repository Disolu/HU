<?php

//RUTAS LIBRES, CON LOGIN
Route::group( ['middleware' => ['auth'], 'prefix'=>'alumno'], function() {
	//REPORTES
	Route::post('reportes', ['as' => 'reportesAlumnos', 'uses' => 'Administrador\ReportesController@getAlumnos']);
	Route::get('reportesexcel/{periodo}/{sede}/{nivel}/{grado}/{seccion}', ['as' => 'reportesexcel', 'uses' => 'Administrador\ReportesController@getAlumnosExcel']);

	//OBSERVACION
	Route::get('observacion/{id}', ['as' => 'observacion', 'uses' => 'Alumno\ObservacionController@show'])->where('id', '[0-9]+');
	Route::post('observacion/{id}', ['as' => 'observacion', 'uses' => 'Alumno\ObservacionController@store'])->where('id', '[0-9]+');
	
	//Archivos Alumnos PDF
	Route::get('pdfcompromiso/{id}/{periodo}', ['as' => 'compromisoPdf', 'uses' => 'PdfController@compromiso'])->where('id', '[0-9]+');
	Route::get('pdfpreferencial/{id}/{periodo}', ['as' => 'preferencialPdf', 'uses' => 'PdfController@anexoPreferencial'])->where('id', '[0-9]+');
	Route::get('pdfespecial/{id}/{periodo}', ['as' => 'especialPdf', 'uses' => 'PdfController@anexoEspecial'])->where('id', '[0-9]+');

	//Ver detalles del alumno, step 2 matricula
	Route::get('/{id}', ['as' => 'alumnodetalle', 'uses' => 'Matricula\AlumnosController@show'])->where('id', '[0-9]+');
	Route::post('saveArchivosDataUsers/{id}', ['as' => 'saveArchivosDataUsers', 'uses' => 'Matricula\AlumnoUploadController@saveArchivosDataUsers'])->where('id', '[0-9]+');
	
	//Buscando al alumno
	Route::get('buscar', ['as' => 'alumnobuscar', 'uses' => 'Matricula\AlumnosController@buscar']);
	Route::post('buscar', ['as' => 'alumnobuscar', 'uses' => 'Matricula\AlumnosController@getAlumno']);
	
	//Nombre del alumno
	Route::get('name', ['as' => 'name', 'uses' => 'Matricula\AlumnosController@getNameAlumno']);
	
	//Editar Alumno
	Route::get('edit/{id}', ['as' => 'alumno', 'uses' => 'Matricula\AlumnosController@edit'])->where('id', '[0-9]+');
	Route::put('edit/{id}', ['as' => 'updatealumno', 'uses' => 'Matricula\AlumnosController@update'])->where('id', '[0-9]+');

	//Consultar Vacante para un alumno existente
	Route::get('searchvacante/{id}', ['as' => 'searchvacante', 'uses' => 'Matricula\VacanteController@viewVacante'])->where('id', '[0-9]+');
	Route::get('vacante', ['as' => 'vacante', 'uses' => 'Matricula\VacanteController@getVacante']);

	//Consultar Vacante para un alumno nuevo
	Route::get('searchvacantes', ['as' => 'searchvacantes', 'uses' => 'Matricula\VacanteController@viewVacantes']);
	
	//CRUD alumno
	Route::get('matricular/{id}', ['as' => 'matricular', 'uses' => 'Matricula\AlumnosController@showMatricula'])->where('id', '[0-9]+');
	Route::post('matricular/{id}', ['as' => 'matricular', 'uses' => 'Matricula\AlumnosController@registerMatricula'])->where('id', '[0-9]+');

	//Informes
	Route::post('informes',['as' => 'informes', 'uses' => 'InformesController@registerInforme']);
	Route::get('informes', ['as' => 'informes', 'uses' => 'InformesController@showInformes']);
	Route::get('informes/listar',['as' => 'listInformes', 'uses' => 'InformesController@listInformes']);

	//Matricular Alumno
	Route::get('matricula', ['as' => 'matricula', 'uses' => 'Matricula\AlumnosController@showNewMatricula']);

	//Vista para la ruta inicial.
	Route::get('/', function () { return view('administrador.index'); });

	//API para la consulta de vacantes
	Route::group( ['middleware' => ['auth'], 'prefix'=>'api/v1'], function() {
		// Cargardores de Data para Consulta de Vacantes
	    Route::get('getPeriodos','Matricula\VacanteController@getPeriodos');
	    Route::get('getSedes', 'Matricula\VacanteController@getSedes');
	    Route::get('getNivel', 'Matricula\VacanteController@getNivel');
	    Route::get('getGrados', 'Matricula\VacanteController@getGrados');	    
	    Route::get('getSecciones', 'Matricula\VacanteController@getSecciones');	 
	    Route::get('getAulas', 'Matricula\VacanteController@getAulas');
	    Route::get('getVacantes', 'Matricula\VacanteController@getVacantes');	

	    // Respuesta para la consulta de alumnos
	    Route::get('responsebuscar', ['as' => 'responsebuscar', 'uses' => 'Matricula\AlumnosController@getAlumno']);
	    Route::get('getAlumnoByID', 	['as' => 'getOtherDataByID', 'uses' => 'Matricula\AlumnosController@getAlumnoByID']);    
	    Route::get('getApoderadosByID', ['as' => 'getApoderadosByID','uses' => 'Matricula\AlumnosController@getApoderadosByID']); 
	    Route::get('getOtherDataByID',  ['as' => 'getOtherDataByID', 'uses' => 'Matricula\AlumnosController@getOtherDataByID']);    

	    //Registrar alumno
	    Route::get('addAlumno', 'Matricula\AlumnosController@addAlumno');

	    //Traer las pensiones con filtros
		Route::get('getPensiones',  ['as' => 'getPensiones', 'uses' => 'Administrador\PensionController@getPensiones']);    	    
    });

});

//ADMINISTRADOR
Route::group( ['middleware' => ['auth','administrador'], 'prefix'=>'admin'], function() {

	Route::get('/', function () {
	    return view('administrador.index');
	});

	//Área de Institución
	Route::group( ['middleware' => ['auth','administrador'], 'prefix'=>'institucion'], function() {
		Route::get('sede', ['as' => 'sede', 'uses' => 'Administrador\SedeController@index']);
		Route::get('sede/new',  ['as' => 'sedenew', 'uses' => 'Administrador\SedeController@create']);
		Route::post('sede/new', ['as' => 'sedenew', 'uses' => 'Administrador\SedeController@store']);
		Route::get('sede/{id}', ['as' => 'deletesede', 'uses' => 'Administrador\SedeController@destroy']);

		Route::get('nivel', ['as' => 'nivel', 'uses' => 'Administrador\NivelController@index']);
		Route::get('nivel/new',  ['as' => 'nivelnew', 'uses' => 'Administrador\NivelController@create']);
		Route::post('nivel/new', ['as' => 'nivelnew', 'uses' => 'Administrador\NivelController@store']);
		Route::get('nivel/{id}', ['as' => 'deletenivel', 'uses' => 'Administrador\NivelController@destroy']);

		Route::get('grado', ['as' => 'grado', 'uses' => 'Administrador\GradoController@index']);
		Route::get('grado/new',  ['as' => 'gradonew', 'uses' => 'Administrador\GradoController@create']);
		Route::post('grado/new', ['as' => 'gradonew', 'uses' => 'Administrador\GradoController@store']);
		Route::get('grado/{id}', ['as' => 'deletegrado', 'uses' => 'Administrador\GradoController@destroy']);

		Route::get('seccion', ['as' => 'seccion', 'uses' => 'Administrador\SeccionController@index']);
		Route::get('seccion/new',  ['as' => 'seccionnew', 'uses' => 'Administrador\SeccionController@create']);
		Route::post('seccion/new', ['as' => 'seccionnew', 'uses' => 'Administrador\SeccionController@store']);
		Route::get('seccion/{id}', ['as' => 'deleteseccion', 'uses' => 'Administrador\SeccionController@destroy']);
		
		Route::get('vacante', ['as' => 'vacante', 'uses' => 'Administrador\VacanteController@index']);
		Route::get('vacante/new',  ['as' => 'vacantenew', 'uses' => 'Administrador\VacanteController@create']);
		Route::post('vacante/new', ['as' => 'vacantenew', 'uses' => 'Administrador\VacanteController@store']);
		Route::get('vacante/{id}', ['as' => 'deletevacante', 'uses' => 'Administrador\VacanteController@destroy']);
		
		Route::get('pension', ['as' => 'pension', 'uses' => 'Administrador\PensionController@index']);
		Route::post('pension', ['as' => 'pension', 'uses' => 'Administrador\PensionController@create']);
		
		Route::get('tipopension/new',  ['as' => 'tipopensionnew', 'uses' => 'Administrador\TipoPensionController@create']);
		Route::post('tipopension/new', ['as' => 'tipopensionnew', 'uses' => 'Administrador\TipoPensionController@store']);
	});
	
	//Registro de Periodos de matricula
	Route::get('periodo', ['as' => 'periodo', 'uses' => 'Administrador\PeriodoMatriculaController@create']);
	Route::post('periodo', ['as' => 'periodo', 'uses' => 'Administrador\PeriodoMatriculaController@store']);
	Route::get('periodo/{id}', ['as' => 'deleteperiodo', 'uses' => 'Administrador\PeriodoMatriculaController@destroy']);
	Route::get('periodo/edit/{id}', ['as' => 'editperiodo', 'uses' => 'Administrador\PeriodoMatriculaController@edit']);
	Route::put('periodo/edit/{id}', ['as' => 'updateperiodo', 'uses' => 'Administrador\PeriodoMatriculaController@update']);

	//Reportes
	Route::get('reportes', ['as' => 'reportes', 'uses' => 'Administrador\ReportesController@getAlumnosxSeccion']);
	
	//Registro de Usuarios
	Route::get('usuarios', ['as' => 'usuarios', 'uses' => 'Administrador\UsuariosController@create']);
	Route::post('usuarios', ['as' => 'usuarios', 'uses' => 'Administrador\UsuariosController@store']);
	Route::get('usuario/{id}', ['as' => 'deleteusuario', 'uses' => 'Administrador\UsuariosController@destroy']);
	Route::get('usuario/edit/{id}', ['as' => 'editusuarios', 'uses' => 'Administrador\UsuariosController@edit']);
	Route::put('usuario/edit/{id}', ['as' => 'updateusuarios', 'uses' => 'Administrador\UsuariosController@update']);

	//Registro de Usuarios
	Route::get('periodomatricula', ['as' => 'periodomatricula', 'uses' => 'Administrador\PeriodoMatriculaController@create']);
	Route::post('periodomatricula', ['as' => 'periodomatricula', 'uses' => 'Administrador\PeriodoMatriculaController@store']);

	//Registro de Cursos
	Route::get('asignaturas', ['as' => 'asignaturas', 'uses' => 'Administrador\AsignaturaController@create']);
	Route::post('asignaturas', ['as' => 'asignaturas', 'uses' => 'Administrador\AsignaturaController@store']);
	Route::get('asignatura/{id}', ['as' => 'deleteasignatura', 'uses' => 'Administrador\AsignaturaController@destroy']);
	
	//Registro de Fechas de Notas
	Route::get('fechanotas', ['as' => 'fechanotas', 'uses' => 'Administrador\NotasController@create']);
	Route::post('fechanotas', ['as' => 'fechanotas', 'uses' => 'Administrador\NotasController@store']);
	Route::get('fechanotas/{id}', ['as' => 'deletefechanotas', 'uses' => 'Administrador\NotasController@destroy']);
	
	//Profesor - Curso
	Route::get('profesorasignatura', ['as' => 'profesorasignatura', 'uses' => 'Administrador\ProfesorController@create']);
	Route::post('profesorasignatura', ['as' => 'profesorasignatura', 'uses' => 'Administrador\ProfesorController@store']);

	//Tarjetas de Notas
	Route::get('tarjetas', 	    ['as' => 'tarjetas', 'uses' => 'Administrador\TarjetasController@index']);
	Route::get('tarjetas/new',  ['as' => 'tarjetasnew', 'uses' => 'Administrador\TarjetasController@create']);
	Route::post('tarjetas/new', ['as' => 'tarjetasnew', 'uses' => 'Administrador\TarjetasController@store']);

	Route::get('bloque', 	  ['as' => 'bloque', 'uses' => 'Administrador\BloqueController@index']);
	Route::get('bloque/new',  ['as' => 'bloquenew', 'uses' => 'Administrador\BloqueController@create']);
	Route::post('bloque/new', ['as' => 'bloquenew', 'uses' => 'Administrador\BloqueController@store']);

	Route::get('tarjetas/bloques', ['as' => 'tarjetabloques', 'uses' => 'Administrador\TarjetasController@show']);
	Route::get('tarjetas/{id}',    ['as' => 'tarjetadelete', 'uses' => 'Administrador\TarjetasController@destroy']);
	Route::get('tarjetas/bloque/{id}',['as' => 'tarjetabloquedelete', 'uses' => 'Administrador\TarjetasController@bloquedestroy']);
});

//AREA RESPONSABLE
Route::group( ['middleware' => ['auth','responsable'], 'prefix'=>'responsable'], function() {
	Route::get('/', function () {
	    return view('responsable.index');
	});
});

//AREA PROFESOR
Route::group( ['middleware' => ['auth','profesor'], 'prefix'=>'profesor'], function() {
	Route::get('/', function () {
	    return view('profesor.index');
	});

	//Registro de Usuarios
	Route::get('listacursos', ['as' => 'listacursos', 'uses' => 'Administrador\NotasController@index']);
	Route::post('listacursos', ['as' => 'listacursos', 'uses' => 'Administrador\NotasController@store']);

	//Registro de Notas
	Route::get('notas/{grado}/{idcurso}/{idseccion}', ['as' => 'addnotas', 'uses' => 'Administrador\NotasController@register']);
	Route::post('notas', ['as' => 'notas', 'uses' => 'Administrador\NotasController@store']);
	Route::post('registernotas', ['as' => 'registernotas', 'uses' => 'Administrador\NotasController@registerNotas']);

});

//AREA SECRETARIA
Route::group( ['middleware' => ['auth','secretaria'], 'prefix'=>'secretaria'], function() {
	Route::get('/', function () {
	    return view('secretaria.index');
	});
});

//AREA LEGAL
Route::group( ['middleware' => ['auth','legal'], 'prefix'=>'legal'], function() {
	Route::get('/', function () {
	    return view('legal.index');
	});
});

//LOGIN
Route::get('/', ['as' => 'login', 'uses' => 'LoginController@getLogin']);
Route::post('auth/login', ['middleware' => 'guest', 'as' => 'login', 'uses' => 'LoginController@postLogin']);
Route::get('auth/logout', ['as' => 'logout', 'uses' => 'LoginController@getLogout']);