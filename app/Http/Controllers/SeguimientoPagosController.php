<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Core\Repositories\Administrador\ReportesRepo;
use App\Core\Entities\Grado;
use App\Core\Entities\AlumnoMatricula;
use DB;
use Auth;
use Redirect;

class SeguimientoPagosController extends Controller
{
  protected $reporteRepo;
  public function __construct(ReportesRepo $reporteRepo)
  {
    $this->reporteRepo = $reporteRepo;
  }

  public function showSeguimientoPagos()
  {
    $periodo = DB::table('periodomatricula')->take(1)->orderBy('idperiodomatricula','desc')->get();
    $pagos = array();

    $request = array('sede'=>'','grado'=>'','nivel'=>'');

    return view('administrador.pagos.seguimiento', compact('pagos','request'));
  }

   public function showboletas()
  {
    $periodo = DB::table('periodomatricula')->take(1)->orderBy('idperiodomatricula','desc')->get();
    $pagos = array();
    $request = array('sede'=>'','grado'=>'','nivel'=>'');

    return view('administrador/boletas/boletas', compact('pagos','request'));
  }


  public function showpespecial()
  {
    $periodo = DB::table('periodomatricula')->take(1)->orderBy('idperiodomatricula','desc')->get();
    $pagos = array();
    $request = array('sede'=>'','grado'=>'','nivel'=>'');

    return view('administrador/boletas/pespecial', compact('pagos','request'));
  }

   public function shownormal()
  {
    $periodo = DB::table('periodomatricula')->take(1)->orderBy('idperiodomatricula','desc')->get();
    $pagos = array();
    $request = array('sede'=>'','grado'=>'','nivel'=>'');

    return view('administrador/boletas/normal', compact('pagos','request'));
  }

    public function showadvmb()
  {
    $periodo = DB::table('periodomatricula')->take(1)->orderBy('idperiodomatricula','desc')->get();
    $pagos = array();
    $request = array('sede'=>'','grado'=>'','nivel'=>'');

    return view('administrador/boletas/advmb', compact('pagos','request'));
  }

  public function showadvpe()
  {
    $periodo = DB::table('periodomatricula')->take(1)->orderBy('idperiodomatricula','desc')->get();
    $pagos = array();
    $request = array('sede'=>'','grado'=>'','nivel'=>'');

    return view('administrador/boletas/advpe', compact('pagos','request'));
  }

   

  public function SeguimientoPagosAjax(Request $request)
  {
      $alumno = $request['idalumno'];

      $periodo = DB::table('periodomatricula')->take(1)->get();
      $alumno  = DB::table('alumnodeudas')
        ->select('p.monto as montopagar','alumnodeudas.mes as mesdeuda','status','alumnodeudas.idalumno as idalumnodeuda','alumnomatricula.idnivel as nivel')
        ->leftJoin('mensualidades as m','alumnodeudas.idalumno','=','m.idalumno')
        ->leftJoin('pension as p','m.idpension','=','p.idpension')
        ->leftJoin('alumnomatricula','alumnomatricula.idalumno','=','alumnodeudas.idalumno')

        ->where('alumnodeudas.idalumno', $alumno)
        ->where('alumnodeudas.idperiodomatricula', $periodo[0]->idperiodomatricula)
        ->get();
    
      return response()->json($alumno)->setCallback($request->input('callback'));
  }

  public function searchSeguimientoPagos(Request $request)
  {

    $request = $request->all();
    $pagos = $this->reporteRepo->SeguimientoPagos($request);

    $periodo = DB::table('periodomatricula')->take(1)->orderBy('idperiodomatricula','desc')->get();
    $grado = Grado::with('sede')->with('nivel')->where('idgrado',$request['grado'])->first();

    $meses = array( '01'=> 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo',
              '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Setiembre', '10' => 'Octubre',
              '11' => 'Noviembre', '12' => 'Diciembre'
            );

    return view('administrador.pagos.seguimiento', compact('pagos','request','grado','periodo','meses'));
  }


  public function mediabeca(Request $request)
  {

    $request = $request->all();

    $mediabeca = $this->reporteRepo->boletas($request);


$meses = array( '01'=> 'ENERO', '02' => 'FEBRERO', '03' => 'MARZO', '04' => 'ABRIL', '05' => 'MAYO',
              '06' => 'JUNIO', '07' => 'JULIO', '08' => 'AGOSTO', '09' => 'SETIEMBRE', '10' => 'OCTUBRE',
              '11' => 'NOVIEMBRE', '12' => 'DICIEMBRE','1'=> 'ENERO', '2' => 'FEBRERO', '3' => 'MARZO', '4' => 'ABRIL', '5' => 'MAYO',
              '6' => 'JUNIO', '7' => 'JULIO', '8' => 'AGOSTO', '9' => 'SETIEMBRE'
            );
    $periodo = DB::table('periodomatricula')->take(1)->orderBy('idperiodomatricula','desc')->get();
    $grado = Grado::with('sede')->with('nivel')->where('idgrado',$request['grado'])->first();



  
$view = \View::make('pdf/boletamediabeca', compact('mediabeca','request','grado','periodo','meses'))->render();
    $pdf  = \App::make('dompdf.wrapper');
    $pdf->loadHTML($view);
    return $pdf->stream('invoice');
   // return view('pdf.boletamediabeca', compact('mediabeca','request','grado','periodo','meses'));
  }



   public function pespecial(Request $request)
  {

    $request = $request->all();
    $mediabeca = $this->reporteRepo->boletas($request);


    $meses = array( '01'=> 'ENERO', '02' => 'FEBRERO', '03' => 'MARZO', '04' => 'ABRIL', '05' => 'MAYO',
              '06' => 'JUNIO', '07' => 'JULIO', '08' => 'AGOSTO', '09' => 'SETIEMBRE', '10' => 'OCTUBRE',
              '11' => 'NOVIEMBRE', '12' => 'DICIEMBRE','1'=> 'ENERO', '2' => 'FEBRERO', '3' => 'MARZO', '4' => 'ABRIL', '5' => 'MAYO',
              '6' => 'JUNIO', '7' => 'JULIO', '8' => 'AGOSTO', '9' => 'SETIEMBRE'
            );
    $periodo = DB::table('periodomatricula')->take(1)->orderBy('idperiodomatricula','desc')->get();
    $grado = Grado::with('sede')->with('nivel')->where('idgrado',$request['grado'])->first();

  
    $view = \View::make('pdf/pespecial', compact('mediabeca','request','grado','periodo','meses'))->render();
    $pdf  = \App::make('dompdf.wrapper');
    $pdf->loadHTML($view);
    return $pdf->stream('invoice');
   // return view('pdf.boletamediabeca', compact('mediabeca','request','grado','periodo','meses'));
  }


//COPIAR ESTO PARA PERDIDA ADVERTENCIA Y LLAMARLO ADVMEDIABECA
   public function normal(Request $request)
  {

    $request = $request->all();
    $mediabeca = $this->reporteRepo->boletas($request);
  


    $meses = array( '01'=> 'ENERO', '02' => 'FEBRERO', '03' => 'MARZO', '04' => 'ABRIL', '05' => 'MAYO',
              '06' => 'JUNIO', '07' => 'JULIO', '08' => 'AGOSTO', '09' => 'SETIEMBRE', '10' => 'OCTUBRE',
              '11' => 'NOVIEMBRE', '12' => 'DICIEMBRE','1'=> 'ENERO', '2' => 'FEBRERO', '3' => 'MARZO', '4' => 'ABRIL', '5' => 'MAYO',
              '6' => 'JUNIO', '7' => 'JULIO', '8' => 'AGOSTO', '9' => 'SETIEMBRE'
            );
    $periodo = DB::table('periodomatricula')->take(1)->orderBy('idperiodomatricula','desc')->get();
    $grado = Grado::with('sede')->with('nivel')->where('idgrado',$request['grado'])->first();

  
    $view = \View::make('pdf/normal', compact('mediabeca','request','grado','periodo','meses'))->render();
    $pdf  = \App::make('dompdf.wrapper');
    $pdf->loadHTML($view);
    return $pdf->stream('invoice');
   // return view('pdf.boletamediabeca', compact('mediabeca','request','grado','periodo','meses'));
  }


  public function advmediabeca(Request $request)
  {

    $request = $request->all();
    $advmediabeca = $this->reporteRepo->advertencia($request);

    $meses = array( '01'=> 'ENERO', '02' => 'FEBRERO', '03' => 'MARZO', '04' => 'ABRIL', '05' => 'MAYO',
              '06' => 'JUNIO', '07' => 'JULIO', '08' => 'AGOSTO', '09' => 'SETIEMBRE', '10' => 'OCTUBRE',
              '11' => 'NOVIEMBRE', '12' => 'DICIEMBRE','1'=> 'ENERO', '2' => 'FEBRERO', '3' => 'MARZO', '4' => 'ABRIL', '5' => 'MAYO',
              '6' => 'JUNIO', '7' => 'JULIO', '8' => 'AGOSTO', '9' => 'SETIEMBRE'
            );
 
    $periodo = DB::table('periodomatricula')->take(1)->orderBy('idperiodomatricula','desc')->get();


  
    $view = \View::make('pdf/advmediabeca', compact('advmediabeca','request','periodo','meses'))->render();
    $pdf  = \App::make('dompdf.wrapper');
    $pdf->loadHTML($view);
    return $pdf->stream('invoice');
   // return view('pdf.boletamediabeca', compact('mediabeca','request','grado','periodo','meses'));
  }


   public function advpe(Request $request)
  {

    $request = $request->all();
    $advpe = $this->reporteRepo->advertencia($request);
    
    $meses = array( '01'=> 'ENERO', '02' => 'FEBRERO', '03' => 'MARZO', '04' => 'ABRIL', '05' => 'MAYO',
              '06' => 'JUNIO', '07' => 'JULIO', '08' => 'AGOSTO', '09' => 'SETIEMBRE', '10' => 'OCTUBRE',
              '11' => 'NOVIEMBRE', '12' => 'DICIEMBRE','1'=> 'ENERO', '2' => 'FEBRERO', '3' => 'MARZO', '4' => 'ABRIL', '5' => 'MAYO',
              '6' => 'JUNIO', '7' => 'JULIO', '8' => 'AGOSTO', '9' => 'SETIEMBRE'
            );
 
    $periodo = DB::table('periodomatricula')->take(1)->orderBy('idperiodomatricula','desc')->get();


  
    $view = \View::make('pdf/advpe', compact('advpe','request','periodo','meses'))->render();
    $pdf  = \App::make('dompdf.wrapper');
    $pdf->loadHTML($view);
    return $pdf->stream('invoice');
   // return view('pdf.boletamediabeca', compact('mediabeca','request','grado','periodo','meses'));
  }











  public function pagosObservacion($id)
  {
    $alumnos = DB::table('alumno')
    ->leftJoin('alumnodatos as ad','ad.idalumno','=','alumno.idalumno')
    ->where('alumno.idalumno',$id)->get();

    $incidencias = DB::table('alumnoincidenciapagos')
        ->select('titulo','observacion','idtipoincidencia','ru.idroluser as rolpe')
        ->leftJoin('users as u','u.id','=','alumnoincidenciapagos.usercreate')
        ->leftJoin('roluser as ru','ru.idroluser','=','u.idrol')
        ->where('alumnoincidenciapagos.idalumno',$id)
        ->get();
    return view('administrador.pagos.observacion', compact('alumnos','incidencias'));
  }

  public function SeguimientoIncidencia(Request $request, $id)
  {
    DB::table('alumnoincidenciapagos')->insert(
      [
      'titulo' => $request['titulo'], 
      'observacion' => $request['incidencia'],
      //'idtipoincidencia' => $request['tipoincidencia'],
      'idalumno' => $id,
      'usercreate' => Auth::user()->id,
      'created_at' => date('Y-m-d H:i:s')
      ]
    );
    return Redirect::back();
  }





    public function RecepcionPagosAjax(Request $request)
  {
      $alumno = $request['idalumno'];
      
  

      $periodo = DB::table('periodomatricula')->take(1)->get();

      $alumno=DB::table('alumno')
      
      ->leftJoin('alumnomatricula','alumnomatricula.idalumno','=','alumno.idalumno')
      ->where('alumno.codigo','=',$alumno)
      ->where('alumnomatricula.idperiodomatricula', $periodo[0]->idperiodomatricula)
      ->get();

      return response()->json($alumno)->setCallback($request->input('callback')); 
  }




   public function PerdidaBeneficioAjax(Request $request)
  {

      $alumno = $request['idalumno'];
      $idnivel=$request['idnivel'];
  $periodo = DB::table('periodomatricula')->take(1)->get();

   if($idnivel==1){
     $alumno = AlumnoMatricula::
                where('idalumno','=',$alumno)
                ->update(['idtipopension'=>1,'idpension'=>1]);
                
            return true;

    }
    elseif($idnivel==2){
       $alumno = AlumnoMatricula::
                where('idalumno','=',$alumno)
                 //->update(['vencimiento'=>92,'userupdate'=>2]);
                 ->update(['idtipopension'=>1,'idpension'=>2]);
              
            return true;

        
    }   

    else{
       $alumno = AlumnoMatricula::
                where('idalumno','=',$alumno)
                // ->update(['vencimiento'=>97]);
               ->update(['idtipopension'=>1,'idpension'=>3]);
            return true;

    }



   
      
  }












  public function RecepcionPagosProfile(Request $request)
  {
      $alumno = $request['idalumno'];
      $alumno=DB::table('recepcionpagos')
      ->select('nomcliente','refpago','importeorigen','fecpago')
      ->where('refpago','like',$alumno.'%')
      ->get();


      return response()->json($alumno)->setCallback($request->input('callback'));

      
  }



}
