<?php
namespace App\Core\Repositories\Administrador;
use App\Core\Entities\AlumnoMatricula;
use App\Core\Entities\PeriodoMatricula;
use App\Core\Entities\Alumno;

class ReportesRepo {
    
  public function getAlumnos($array)
  {
    $query = AlumnoMatricula::
    select('fullname as Nombres','codigo','idestadoalumno as Estado','monto as Pension','users.nombre as Personal','sede.nombre as Sede','nivel.nombre as Nivel','grado.nombre as Grado',
      DB::raw('(select count(*) from notacurso where notacurso.idalumno = alumnomatricula.idalumno) as notas'))
     ->leftJoin('alumno', 'alumnomatricula.idalumno', '=', 'alumno.idalumno')
     ->leftJoin('pension', 'alumnomatricula.idpension', '=', 'pension.idpension')
     ->leftJoin('nivel','alumnomatricula.idnivel','=','nivel.idnivel')
     ->leftJoin('grado','alumnomatricula.idgrado','=','grado.idgrado')
     ->leftJoin('sede','alumnomatricula.idsede','=','sede.idsede')
     ->leftJoin('users', 'alumnomatricula.usercreate', '=', 'users.id');
     
    if($array['idperiodo']) {
        $query->where('alumnomatricula.idperiodomatricula','=',$array['idperiodo']);
    }
    if ($array['idsede']) {
        $query->where('alumnomatricula.idsede','=',$array['idsede']);
    }
    if ($array['idnivel']) {
        $query->where('alumnomatricula.idnivel','=',$array['idnivel']);
    }
    if ($array['idgrado']) {
        $query->where('alumnomatricula.idgrado','=',$array['idgrado']);
    }
    if($array['filtro'])
    {
      if($array['filtro'] == 2){
        $query->havingRaw('notas > 0'); 
      }
    }
    return $query->get();
  }

  public function getAlumnosxSede($idsede, $idperiodomatricula)
  {
      return AlumnoMatricula::            
       select('idalumnomatricula')
       ->where('idsede','=',$idsede)
       ->where('idperiodomatricula','=',$idperiodomatricula)          
       ->get();
  }

  public function getAlumnosxSeccion()
  {
      return AlumnoMatricula::with(['seccion','nivel','sede','grado','alumno'])
      ->select('*', \DB::raw('count(*) as total'))
      ->groupBy('idseccion')
      ->groupBy('idnivel')
      ->groupBy('idgrado')
      ->get();
  }

  public function getAlumnosxGrado($idgrado, $idperiodomatricula)
  {
      return AlumnoMatricula::            
       select('idalumnomatricula')
       ->where('idgrado','=',$idgrado)
       ->where('idperiodomatricula','=',$idperiodomatricula)  
       ->get();
  }

  public function getAlumnosxNivel($idnivel, $idperiodomatricula)
  {
      return AlumnoMatricula::            
       select('idalumnomatricula')
       ->where('idnivel','=',$idnivel)
       ->where('idperiodomatricula','=',$idperiodomatricula)  
       ->get();
  }

  public function SeguimientoPagos($request)
  {
    $idperiodo = $request['periodo'];
    $idsede    = $request['sede'];
    $idnivel   = $request['nivel'];
    $idgrado   = $request['grado'];
    $dni       = $request['dni'];
    $mensualidades=$request['mensualidad'];

    $periodo = PeriodoMatricula::take(1)->orderBy('idperiodomatricula','desc')->get();
    
    $pagos = AlumnoMatricula::
    select('alumno.idalumno','fullname','codigo','idestadoalumno','monto','users.nombre as nameregister','telefono','alumnodeudas.mes')
     
     ->leftJoin('alumno', 'alumnomatricula.idalumno', '=', 'alumno.idalumno')
     ->leftJoin('alumnodeudas','alumnodeudas.idalumno','=','alumno.idalumno')
     ->leftJoin('mensualidades as m', 'alumno.idalumno', '=', 'm.idalumno')
     ->leftJoin('pension as p', 'm.idpension', '=', 'p.idpension')
     ->leftJoin('users', 'alumnomatricula.usercreate', '=', 'users.id')
     ->where('alumnodeudas.idperiodomatricula', $periodo[0]->idperiodomatricula);

      if($idperiodo) {
          $pagos->where('alumnomatricula.idperiodomatricula','=',$idperiodo);
      }
      if ($idsede) {
          $pagos->where('alumnomatricula.idsede','=',$idsede);
      }
      if ($idnivel) {
          $pagos->where('alumnomatricula.idnivel','=',$idnivel);
      }
      if ($idgrado) {
          $pagos->where('alumnomatricula.idgrado','=',$idgrado);
      }
      if ($dni) {
          $pagos->where('alumno.dni','=',$dni);
      }
       if ($mensualidades) {
         $pagos->where('alumnodeudas.mes','=',$mensualidades);
          $pagos->where('alumnodeudas.status','=','0');
      }

      
      $pagos->where('alumno.impedimento','<>','1');
      $pagos->groupBy('alumno.idalumno');

      return $pagos->get();

      
  }

  

    public function boletas($request)
  {
    $idperiodo = $request['periodo'];
    $idsede    = $request['sede'];
    $idnivel   = $request['nivel'];
    $idgrado   = $request['grado'];
    $tipo =$request['tipo'];
    $mensualidades=$request['mensualidad'];

    $periodo = PeriodoMatricula::take(1)->orderBy('idperiodomatricula','desc')->get();
    
    $mediabeca = AlumnoMatricula::
    select('alumno.idalumno','fullname','vencimiento as venc','nivel.nombre as niveno','grado.nombre as grano',
      'seccion.nombre as seno','codigo','idestadoalumno','monto','users.nombre as nameregister','telefono',
      'alumnodeudas.mes','periodomatricula.nombre as periodo')
     
     ->leftJoin('alumno', 'alumnomatricula.idalumno', '=', 'alumno.idalumno')
     ->leftJoin('alumnodeudas','alumnodeudas.idalumno','=','alumno.idalumno')
     ->leftJoin('mensualidades as m', 'alumno.idalumno', '=', 'm.idalumno')
     ->leftJoin('pension as p', 'm.idpension', '=', 'p.idpension')
     ->leftJoin('users', 'alumnomatricula.usercreate', '=', 'users.id')
     ->leftJoin('nivel','alumnomatricula.idnivel','=','nivel.idnivel')
     ->leftJoin('grado','alumnomatricula.idgrado','=','grado.idgrado')
     ->leftJoin('seccion','alumnomatricula.idseccion','=','seccion.idseccion')
     ->leftJoin('periodomatricula','alumnomatricula.idperiodomatricula','=','periodomatricula.idperiodomatricula')


     ->where('alumnomatricula.idtipopension','=',$tipo)
     ->where('alumnodeudas.idperiodomatricula', $periodo[0]->idperiodomatricula);

      if($idperiodo) {
          $mediabeca->where('alumnomatricula.idperiodomatricula','=',$idperiodo);
      }
      if ($idsede) {
          $mediabeca->where('alumnomatricula.idsede','=',$idsede);
      }
      if ($idnivel) {
          $mediabeca->where('alumnomatricula.idnivel','=',$idnivel);
      }
      if ($idgrado) {
          $mediabeca->where('alumnomatricula.idgrado','=',$idgrado);
      }
       if ($mensualidades) {
         $mediabeca->where('alumnodeudas.mes','=',$mensualidades);
          $mediabeca->where('alumnodeudas.status','=','0');
      }

      
      $mediabeca->where('alumno.impedimento','<>','1');
      $mediabeca->groupBy('alumno.idalumno');
      $tipo="";
      return $mediabeca->get();
      
      
  }


   public function advertencia($request)
  {
    $idperiodo = $request['periodo'];
    $tipo =$request['tipo'];
    $mensualidades=$request['mensualidad'];
  

    $periodo = PeriodoMatricula::take(1)->orderBy('idperiodomatricula','desc')->get();
    
    $advertencia = Alumno::
    select('alumno.idalumno','fullname','alumnodeudas.mes as mes','alumnodeudas.incidence as incidencias','nivel.nombre as nivel','grado.nombre as grado')
      ->leftJoin('alumnodeudas', 'alumnodeudas.idalumno', '=', 'alumno.idalumno')
      ->leftJoin('alumnomatricula','alumnomatricula.idalumno','=','alumno.idalumno')
      ->leftJoin('nivel','alumnomatricula.idnivel','=','nivel.idnivel')
      ->leftJoin('grado','alumnomatricula.idgrado','=','grado.idgrado')

     ->where('alumnomatricula.idtipopension','=',$tipo)
     ->where('alumnodeudas.mes','=',$mensualidades)
     ->where('alumnodeudas.idperiodomatricula', $periodo[0]->idperiodomatricula)
     ->groupBy('alumno.idalumno')
    ->having('incidence', '=', 1);
    $tipo="";
     return $advertencia->get();


      
  }


}


