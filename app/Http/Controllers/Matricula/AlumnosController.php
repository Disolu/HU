<?php
namespace App\Http\Controllers\Matricula;

use App\Core\Entities\Alumno;
use App\Core\Entities\AlumnoApoderado;
use App\Core\Entities\AlumnoMatricula;
use App\Core\Entities\AlumnoDatos;
use App\Core\Entities\Vacante;
use App\Core\Entities\Mensualidades;

use App\Core\Repositories\Alumno\AlumnoRepo;
use App\Core\Repositories\Matricula\PeriodoMatriculaRepo;
use App\Core\Repositories\Matricula\VacanteMatriculaRepo;
use App\Core\Repositories\Matricula\AlumnoMatriculaRepo;

use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use Redirect;
use App\Http\Requests\AlumnosRequest;
use App\Http\Requests\MatriculaRequest;
use App\Http\Requests\BuscarAlumnoRequest;
use App\Http\Controllers\Controller;
use DB;

class AlumnosController extends Controller
{

  protected $AlumnoRepo;
  protected $PeriodoMatriculaRepo;
  protected $VacanteRepo;
  protected $AlumnoMatriculaRepo;

  public function __construct(
    AlumnoRepo $AlumnoRepo, 
    PeriodoMatriculaRepo $PeriodoMatriculaRepo,
    VacanteMatriculaRepo $VacanteRepo,
    AlumnoMatriculaRepo $AlumnoMatriculaRepo
    )
  {
    $this->AlumnoRepo = $AlumnoRepo;
    $this->PeriodoMatriculaRepo = $PeriodoMatriculaRepo;
    $this->VacanteRepo = $VacanteRepo;
    $this->AlumnoMatriculaRepo = $AlumnoMatriculaRepo;
  }

  public function viewselectmatricula(Request $request)
  {
      $sede = DB::table('sede')->where('idsede', $request['sede'])->get();
      $nivel = DB::table('nivel')->where('idnivel', $request['nivel'])->get();
      $grado = DB::table('grado')->where('idgrado', $request['grado'])->get();
      $seccion = DB::table('seccion')->where('idseccion', $request['seccion'])->get();

      return response()->json(['sede' =>$sede[0]->nombre ,'nivel' => $nivel[0]->nombre, 'grado' => $grado[0]->nombre, 'seccion' => $seccion[0]->nombre])
          ->setCallback($request->input('callback'));
  }

  public function getAlumno(BuscarAlumnoRequest $request)
  {
    $alumno = $request['alumno'];
    $fecha = date("Y-m-d");

    //Informacion del alumno por (nombre, apellidos, dni)
    $getAlumno = $this->AlumnoRepo->getAlumno($alumno);


    //Existe periodo de matricula activo.
    $getPeriodoMatricula = $this->PeriodoMatriculaRepo->getPeriodoMatricula($fecha);  

    if( $getAlumno->isEmpty() )
    {    
      Session::flash('message-danger', 'El Alumno no se encuentra');            
      return Redirect::back()->withInput();                         
    }
    else
    {
      Session::flash('message-search-alumno', 'El alumno ha sido encontrado');  
      return view('matricula.alumnos.buscar', compact('getAlumno','getPeriodoMatricula'));
    }    
  }





  public function getAlumnoByID(Request $request)
  {
    $idalumno = $_GET['alu_id'];
    $matchingalumno = $this->AlumnoRepo->getAlumnoByID($idalumno);

    return response()->json([
      'error' =>  false,
      'alumno' => $matchingalumno,
      ], 200)
    ->setCallback($request->input('callback'));
  }

  public function getApoderadosByID(Request $request)
  {
    $idalumno = $_GET['alu_id'];
    $matchingalumno = $this->AlumnoApoderadoRepo->getApoderadosByID($idalumno);

    return response()->json([
      'error' =>  false,
      'alumno' => $matchingalumno,
      ], 200)
    ->setCallback($request->input('callback'));
  }

  public function getOtherDataByID(Request $request)
  {
    $idalumno = $_GET['alu_id'];
    $matchingalumno = $this->AlumnoDataRepo->getOtherDataByID($idalumno);

    return response()->json([
      'error' =>  false,
      'alumno' => $matchingalumno,
      ], 200)
    ->setCallback($request->input('callback'));
  }

  public function showMatricula($idalumno)
  {
    return view('matricula.alumnos.index',compact('idalumno'));
  }

  public function showNewMatricula()
  {
    $TipoPension     = $this->VacanteRepo->getTipoPension();
    $EstadoMatricula = $this->VacanteRepo->getEstadoMatricula();
    $EstadoAlumno    = $this->VacanteRepo->getEstadoAlumno();
    return view('matricula.alumnos.registrar', compact('TipoPension','EstadoMatricula','EstadoAlumno'));   
  }
  
  //Matricula de alumno existente
  public function registerMatricula(MatriculaRequest $request, $id)
  {
    //dd($request->all());

    //Matriculando al Alumno
    $alumno = AlumnoMatricula::create([
      'idalumno'   => $id,
      'idseccion'  => $request['seccion'],
      'idnivel'    => $request['nivel'],
      'idsede'     => $request['sede'],            
      'idgrado'    => $request['grado'],
      'idperiodomatricula'=> $request['periodo'],
      'idestadomatricula'=> $request['estado'],
      'idtipopension'=> $request['alu_tipopension'],
      'idpension'  => $request['pension'],
      'usercreate' => $request->user()->id
      ]);

    //Actualizando Vacantes
    if($alumno)
    {
      $getVacante = $this->VacanteRepo->getLastVacante();
      $newqty_matriculados = ($getVacante[0]->qty_matriculados + 1);              
      Vacante::
      where('idperiodomatricula', $request['periodo'])
      ->update(['qty_matriculados' => $newqty_matriculados]);

      Session::flash('message-success', 'El Alumno fue matriculado con éxito');            
      return redirect()->route('alumnobuscar');
    }
    else{
      Session::flash('message-danger', 'error inesperado');            
      return redirect()->route('alumnobuscar');
    }      
  }

  public function buscar(){
    return view('matricula.alumnos.buscar');
  }




  public function searchrestringidos(Request $request)
  {
    $alumno = $request['alumno'];
    $getAlumno = $this->AlumnoRepo->getAlumnoRestricciones($alumno);
    return view('matricula.alumnos.buscarRestringidos', compact('getAlumno'));
  }

  //Matricula de alumno Nuevo
  public function addAlumno(Request $request)
  { 
    
    $iduser = $request->user()->id;
    $rawUser       = $_GET['alumno'];
    $rawApoderados = $_GET['apoderados'];
    $rawOtherData  = $_GET['otherdata'];

    //Último Periodo Disponible
    $periodomatricula = $this->PeriodoMatriculaRepo->getLastPeriodoMatricula();            

    //Guarda en las tablas, matricula, descuenta vacante
      
    /*
    Se podria separar el guardar matricula y descuento de vacante aqui afuera, preguntando
    si se registro correctamente el alumno
    */

    if($rawUser['alu_pension'])
    {
      $result    = $this->AlumnoRepo->SaveAlumno($periodomatricula[0]->idperiodomatricula, $iduser, $rawUser);
      $resultApo = $this->AlumnoRepo->SaveApoderado($iduser, $rawApoderados);
      $resultOth = $this->AlumnoRepo->SaveOtrosDatos($iduser, $rawOtherData);  
    }
    //Si se registro al alumno & al apoderado y otros datos correctamente
    if($result && $resultApo && $resultOth)
    {
      $lastAlumno = $this->AlumnoRepo->LastAlumno();  
      $pensiones = $this->AlumnoRepo->SavePensionesAlumno($iduser, $lastAlumno[0]->idalumno, $periodomatricula[0]->idperiodomatricula, $rawUser['alu_pension']);  
      $deudas = $this->AlumnoRepo->SaveDeudasAlumno($iduser, $lastAlumno[0]->idalumno, $periodomatricula[0]->idperiodomatricula);  
    }
    return response()->json([
      'result'    => $result,
      'resultApo' => $resultApo,
      'resultOth' => $resultOth,
      'alumnope'    => $lastAlumno[0]->idalumno
      ], 200)
    ->setCallback($request->input('callback'));
  }

  public function index()
  {
    return view('matricula.alumnos.index');
  }

  public function store(AlumnosRequest $request)
  {
    $alumno = \App\Alumno::create([
      'nombres'          => $request['nombres'],
      'apellido_paterno' => $request['apellido_paterno'],
      'apellido_materno' => $request['apellido_materno'],
      'sexo'             => $request['sexo'],
      'fecha_nacimiento' => $request['fecha_nacimiento'],
      'dni'              => $request['dni'],
      'telefono'         => $request['telefono'],
      'direccion'        => $request['direccion'],            
      'iddepartamento'   => '1',
      'idprovincia'      => '1',
      'iddistrito'       => '1',
      'iduser'           => $request->user()->id
      ]);

    if($alumno){
      Session::flash('message-success', 'Registro con éxito'); 
      return Redirect::back()->withInput();
    }
    else{
      Session::flash('message-danger', 'Los datos son incorrectos');
      return Redirect::back()->withInput();    
    }                
  }

  public function show($id)
  {
    $periodomatricula = $this->PeriodoMatriculaRepo->getLastPeriodoMatricula();
    
    $archivos = $this->AlumnoMatriculaRepo->getFilesAlumno($id, $periodomatricula[0]->idperiodomatricula);
    $matricula = $this->AlumnoMatriculaRepo->getAllDataAlumno($id, $periodomatricula[0]->idperiodomatricula);
    $incidencia    = $this->AlumnoRepo-> getAlumnoincidencias($id,$periodomatricula[0]->idperiodomatricula);  
  
    

    $alumno    = $this->AlumnoRepo->getAlumnoJoins($id);    


    $periodo = DB::table('periodomatricula')
        ->select('a.fullname','a.codigo','periodomatricula.nombre as periodo','a.idalumno','n.*','periodomatricula.idperiodomatricula as idperiodo')

        ->leftJoin('alumnomatricula as am','am.idperiodomatricula','=','periodomatricula.idperiodomatricula')
        ->leftJoin('alumno as a','a.idalumno','=','am.idalumno')
        ->leftJoin('notacurso as n','n.idperiodomatricula','=','periodomatricula.idperiodomatricula')
        ->where('a.idalumno',$id)
        ->groupBy('periodomatricula.idperiodomatricula')
        ->get();
    $bimestres = DB::table('bimestre')->get();
        
    if($matricula->isEmpty() or $alumno->isEmpty()){
      Session::flash('message-danger', ' No hemos encontrado suficientes datos para mostrar la pagina solicitada, consulte con el administrador de sistemas');
      return redirect()->back();            
    }else{            
      return view('matricula.alumnos.perfil', compact('id','matricula','alumno','archivos','periodo','bimestres','incidencia'));
    }
  }

  public function editAcademico($id)
  {
    $alumno = Alumno::find($id);
    $TipoPension = $this->VacanteRepo->getTipoPension();
    $dataMatricula = DB::table('alumnomatricula as ma')
      ->select(
        's.nombre as sede',
        'n.nombre as nivel','n.idnivel',
        'g.nombre as grado','g.idgrado',
        'se.nombre as seccion','se.idseccion',
        'p.monto as pension','p.idpension',
        'tp.nombre as tipopension')

      ->leftJoin('sede as s','s.idsede','=','ma.idsede')
      ->leftJoin('nivel as n','n.idnivel','=','ma.idnivel')
      ->leftJoin('grado as g','g.idgrado','=','ma.idgrado')
      ->leftJoin('seccion as se','se.idseccion','=','ma.idseccion')
      ->leftJoin('pension as p','p.idpension','=','ma.idpension')
      ->leftJoin('tipopension as tp','tp.idtipopension','=','ma.idtipopension')
      ->where('idalumno', $id)
      ->orderBy('idalumnomatricula','desc')
      ->take(1)
      ->get();

    return view('matricula.alumnos.actualizarAcademico', compact('dataMatricula','TipoPension','alumno','id'));   
  }

  public function edit($id)
  {
    $alumno = Alumno::find($id);
    $apoderado = Alumno::find($id)->apoderado;
    $otherdata = Alumno::find($id)->otherdata;
    $archivos  = Alumno::find($id)->archivos;        
    $matricula  = Alumno::find($id)->matricula; 
    $TipoPension = $this->VacanteRepo->getTipoPension();

    $dataMatricula = DB::table('alumnomatricula as ma')
      ->select(
        's.nombre as sede',
        'n.nombre as nivel','n.idnivel',
        'g.nombre as grado','g.idgrado',
        'se.nombre as seccion','se.idseccion',
        'p.monto as pension','p.idpension',
        'tp.nombre as tipopension')

      ->leftJoin('sede as s','s.idsede','=','ma.idsede')
      ->leftJoin('nivel as n','n.idnivel','=','ma.idnivel')
      ->leftJoin('grado as g','g.idgrado','=','ma.idgrado')
      ->leftJoin('seccion as se','se.idseccion','=','ma.idseccion')
      ->leftJoin('pension as p','p.idpension','=','ma.idpension')
      ->leftJoin('tipopension as tp','tp.idtipopension','=','ma.idtipopension')
      ->where('idalumno', $id)
      ->orderBy('idalumnomatricula','desc')
      ->take(1)
      ->get();

    //Si no existen relaciones con este alumno.
    /*
      Esto puede suceder, porque metieron info en la tabla de forma manual y no se creearon las relaciones
    */
    if($apoderado or $otherdata or $archivos){
      $EstadoAlumno    = $this->VacanteRepo->getEstadoAlumno();
      $EstadoMatricula = $this->VacanteRepo->getEstadoMatricula();
      return view('matricula.alumnos.actualizar', compact('dataMatricula','TipoPension','matricula','alumno','apoderado','otherdata','archivos','EstadoAlumno','EstadoMatricula','id'));   
    }
    else{
      Session::flash('message-danger', 'No existen relaciones suficientes con el alumno que se desea editar'); 
      return redirect()->route('alumnobuscar'); 
    }
  }

  public function update(AlumnosRequest $request, $id)
  {

    //Alumno
      Alumno::
      where('idalumno', $id)
      ->update
      ([
        "nombres" => $request->input('nombres'),
        "apellido_paterno" => $request->input('apellido_paterno'),
        "apellido_materno" => $request->input('apellido_materno'),
        "sexo"         => $request->input('sexo'),
        "impedimento"  => $request->input('impedimento'),
        "fecha_nacimiento" => $request->input('fecha_nacimiento'),
        "dni"          => $request->input('dni'),
        "telefono"     => $request->input('telefono'),
        "direccion"    => $request->input('direccion'),
        "iddepartamento" => $request->input('departamento'),
        "idprovincia"  => $request->input('provincia'),
        "iddistrito"   => $request->input('distrito'),
        "idestadoalumno" => $request->input('estadoalumno'),

        "fullname" => $request->input('nombres')." ".$request->input('apellido_paterno')." ".$request->input('apellido_materno')
      ]); 

    //Alumno Matricula  
      $periodomatricula = $this->PeriodoMatriculaRepo->getLastPeriodoMatricula(); 
      AlumnoMatricula::
      where('idalumno', $id)
      ->where('idperiodomatricula', $periodomatricula[0]->idperiodomatricula)
      ->update
      ([
        "idestadomatricula" => $request->input('alu_estado'),
      ]); 

    //Padre    
      AlumnoApoderado::
      where('idalumno', $id)
      ->update
      ([
        "p_nombres" => $request->input("p_nombre"),
        "p_apellidos" => $request->input("p_apellidos"),
        "p_dni" => $request->input("p_dni"),
        "p_estadocivil" => $request->input("p_estadocivil"),
        "p_lugarresidencia" => $request->input("p_lugarresidencia"),
        "p_telefonofijo" => $request->input("p_telefonofijo"),
        "p_telefonotrabajo" => $request->input("p_telefonotrabajo"),
        "p_celular" => $request->input("p_celular"),
        "p_email" => $request->input("p_email"),
      
    //Madre    
        "m_nombres" => $request->input("m_nombres"),
        "m_apellidos" => $request->input("m_apellidos"),
        "m_dni" => $request->input("m_dni"),
        "m_estadocivil" => $request->input("m_estadocivil"),
        "m_lugarresidencia" => $request->input("m_lugarresidencia"),
        "m_telefonofijo" => $request->input("m_telefonofijo"),
        "m_telefonotrabajo" => $request->input("m_telefonotrabajo"),
        "m_celular" => $request->input("m_celular"),
        "m_email" => $request->input("m_email"),
  
    //Apoderado    
        "a_nombres" => $request->input("a_nombre"),
        "a_apellidos" => $request->input("a_apellido"),
        "a_dni" => $request->input("a_dni"),
        "a_estadocivil" => $request->input("a_estadocivil"),
        "a_lugarresidencia" => $request->input("a_lugarresidencia"),
        "a_telefonofijo" => $request->input("a_telefonofijo"),
        "a_telefonotrabajo" => $request->input("a_telefonotrabajo"),
        "a_celular" => $request->input("a_celular"),
        "a_email" => $request->input("a_email")
      ]);

    //Otro   
    AlumnoDatos::
      where('idalumno', $id)
      ->update
      ([            
        "tiposangre" => $request->input("tiposangre"),
        "idreligion" => $request->input("religion"),
        "email" => $request->input("email"),
        "qty_hermanos" => $request->input("qty_hermanos"),
        "celular" => $request->input("celular"),
        "seguro" => $request->input("seguro")
      ]);
    Session::flash('message-success', 'Se actualizo con éxito al alumno'); 
    return redirect()->route('alumnobuscar'); 
  }

  public function updatealumnoAcademico(Request $request, $id)
  {
    $matricula = DB::table('alumnomatricula')->where('idalumno', $id)->orderBy('idalumnomatricula','desc')->take(1)->get();

    if($request['sede'] && $request['nivel'] && $request['grado'] && $request['seccion'] && $request['pension'] && $request['alu_tipopension'])
    {
      DB::table('alumnomatricula')
        ->where('idalumnomatricula', $matricula[0]->idalumnomatricula)
        ->update([
          'idsede'      => $request['sede'],
          'idnivel'     => $request['nivel'],
          'idgrado'     => $request['grado'],
          'idseccion'   => $request['seccion'],
          'idpension'   => $request['pension'],
          'idtipopension' => $request['alu_tipopension'],
          'vencimiento' => $request['vencimiento'],
          'updated_at'  => date('Y-m-d H:i:s')
          ]);
    Session::flash('message-success', 'Se actualizo con éxito al alumno'); 
    return redirect()->route('alumnobuscar'); 
    }
    Session::flash('message-danger', 'Se deben seleccionar todas las opciones'); 
    return redirect()->back(); 
  }


//RECEPCIONPAGOS

   public function getRecepcionPagos(BuscarAlumnoRequest $request)
  {
    $alumno = $request['alumno'];
    $fecha = date("Y-m-d");
  

    //Informacion del alumno por (nombre, apellidos, dni)
    $getHistorial = $this->AlumnoRepo->getRecepcionPagos($alumno);
  
    //Existe periodo de matricula activo.
    $getPeriodoMatricula = $this->PeriodoMatriculaRepo->getPeriodoMatricula($fecha);  

    if( $getHistorial->isEmpty() )
    {    
      Session::flash('message-danger', 'El Alumno no se encuentra');            
      return Redirect::back()->withInput();                         
    }
    else
    {
      Session::flash('message-search-alumno', 'El alumno ha sido encontrado');  
      return view('administrador.pagos.recepcionpagos', compact('getHistorial','getPeriodoMatricula'));
    }    
  }


  public function buscarRecepcionPagos(){
    return view('administrador.pagos.recepcionpagos');
  }




   public function getIncidencias(Request $request)
  {
    $alumno = $request['alumno'];
    $fecha = date("Y-m-d");
  

    //Informacion del alumno por (nombre, apellidos, dni)
    $getIncidencias= $this->AlumnoRepo->getIncidencias($alumno);

    //Existe periodo de matricula activo.
    $getPeriodoMatricula = $this->PeriodoMatriculaRepo->getPeriodoMatricula($fecha);  

    if( $getIncidencias->isEmpty() )
    {    
      Session::flash('message-danger', 'No existe la cantidad de incidencias mostradas');            
      return Redirect::back()->withInput();                         
    }
    else
    {
      Session::flash('message-search-alumno', 'El alumno ha sido encontrado');  
      return view('administrador.pagos.incidencias', compact('getIncidencias','getPeriodoMatricula'));
    }    
  }


  public function buscarIncidencias(){
    return view('administrador.pagos.incidencias');
  }

}
