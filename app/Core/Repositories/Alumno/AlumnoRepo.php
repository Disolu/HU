<?php
namespace App\Core\Repositories\Alumno;
use App\Core\Entities\Alumno;
use App\Core\Entities\Restringidos;
use App\Core\Entities\AlumnoApoderado;
use App\Core\Entities\AlumnoDatos;
use App\Core\Entities\AlumnoMatricula;
use App\Core\Entities\AlumnoObservacion;
use App\Core\Entities\Vacante;
use App\Core\Entities\AlumnoDeudas;
use App\Core\Entities\Mensualidades;
use App\Core\Entities\RecepcionPagos;
use App\Core\Repositories\PeriodoRepo;
use DB;
class AlumnoRepo {
    public function __construct(PeriodoRepo $PeriodoRepo)
    {
        $this->PeriodoRepo = $PeriodoRepo;
    }
    public function getAlumnoJoins($alumno)
    {
        return Alumno::
        leftJoin('estadoalumno', 'alumno.idestadoalumno', '=', 'estadoalumno.idestadoalumno')
        ->select('estadoalumno.nombre as nombreestado')
        ->where('idalumno','=', $alumno)
        ->get();
    }

      public function getAlumnoincidencias($alumno)
    {
      
        return Alumnodeudas::
        select(DB::raw("alumnodeudas.idalumno,sum(incidence) as incidencias"))
        ->leftJoin('alumno', 'alumno.idalumno', '=', 'alumnodeudas.idalumno')
        ->where('alumnodeudas.idalumno','=', $alumno)
        ->groupBy('alumnodeudas.idalumno')
        ->get();  
          
   
    }



    public function getAlumnoByID($alumno)
    {
         return Alumno::
         leftJoin('alumnomatricula', 'alumno.idalumno', '=', 'alumnomatricula.idalumno')
         ->select('nombres', 'apellido_paterno', 'apellido_materno', 'codigo','impedimento','idalumnomatricula','alumno.idalumno as alumnoid')
         ->where('nombres','LIKE','%'.$alumno.'%')
         ->orWhere('apellido_paterno','LIKE','%'.$alumno.'%')
         ->orWhere('apellido_materno','LIKE','%'.$alumno.'%')
         ->orWhere('dni', $alumno)
         ->get();
    }
    public function getAlumno($alumno)
    {
         return Alumno::
         leftJoin('alumnomatricula', 'alumno.idalumno', '=', 'alumnomatricula.idalumno')
         ->select('fullname','codigo','impedimento','idalumnomatricula','alumno.idalumno as alumnoid','idperiodomatricula',
             DB::raw('(select observacion from restringidos as rt where rt.dni = alumno.dni LIMIT 0,1) observacion '))
         ->where('fullname','LIKE','%'.$alumno.'%')
         ->orWhere('dni', $alumno)
         ->orWhere('codigo', $alumno)
         ->orderBy('idperiodomatricula','desc')
         ->get();
    }
public function getAlumnoRestricciones($alumno){
 return Restringidos::where('fullname','LIKE',$alumno.'%')
                ->orWhere('dni', $alumno)
                ->get();
}
    public function getAlumnoRestricciones2($alumno)
    {
        DB::enableQueryLog();
        //Ignored the view
        $date = date('Y-m-d');
        $current = $this->PeriodoRepo->getLastPeriodo();;
        //current = 2016 o último periodo
        if($current){
            $inicio = $current[0]->inicio;
            $fin = $current[0]->fin;
        }else{
            $inicio = date('Y-m-d');
            $fin = date('Y-m-d');
        }
        $idAlumnos = array();
        $observaciones =  AlumnoObservacion::where('idtipoobservacion',4)
                            ->whereBetween('created_at',array($inicio,$fin))
                            ->get();
        $alumnoOb = array();
        foreach($observaciones as $ob){
            if(!in_array($ob->idalumno, $idAlumnos)){
                $idAlumnos[] = $ob->idalumno;
            }
            $alumnoOb[$ob->idalumno] = $ob;
        }
        if($alumno){
            $restringidos = Alumno::whereIn('idalumno',$idAlumnos)
                ->where('nombres','LIKE','%'.$alumno.'%')
                ->orWhere('dni', $alumno)
                ->orWhere('codigo', $alumno)
                ->get();
        }else{
            $restringidos = Alumno::whereIn('idalumno',$idAlumnos)->get();
        }
        foreach($restringidos as &$r){
            $r->observacion = $alumnoOb[$r->idalumno];
        }
        return $restringidos;
    }
public function getAllObservaciones($id)
    {
        return AlumnoObservacion::
        leftJoin('tipoobservacion', 'alumnoobservacion.idtipoobservacion', '=', 'tipoobservacion.idtipoobservacion')
         ->select('titulo','observacion','alumnoobservacion.idtipoobservacion','alumnoobservacion.created_at','nombre as nombretipoobservacion')
         ->where('idalumno','=',$id)
         ->orderBy('alumnoobservacion.created_at','desc')
         ->get();
    }
    public function SaveDeudasAlumno($iduser, $alumno, $periodo)
    {
        for ($i=4; $i <= 12 ; $i++) {
            $deuda = new AlumnoDeudas;
            $deuda->mes                 = str_pad($i, 2, '0', STR_PAD_LEFT);
            $deuda->idalumno            = $alumno;
            $deuda->usercreate          = $iduser;
            $deuda->idperiodomatricula  = $periodo;
            $deuda->status              = 0;
            $deuda->created_at          = date('Y-m-d H:i:s');
            $deuda->save();
        }
    }
    public function SavePensionesAlumno($iduser, $alumno, $periodo, $pension)
    {
            $mensualidades = new Mensualidades;
            $mensualidades->mes                 = 3;
            $mensualidades->idpension           = $pension;
            $mensualidades->idalumno            = $alumno;
            $mensualidades->usercreate          = $iduser;
            $mensualidades->created_at          = date('Y-m-d H:i:s');
            $mensualidades->idperiodomatricula  = $periodo;
            $mensualidades->save();
    }
    public function SaveAlumno($idperiodomatricula,$iduser, $rawAlumno)
    {
       $codigoAlumno = Alumno::select('codigo')->orderBy('idalumno','=','desc')->take(1)->get();
        /*
            Armar el nuevo codigo del alumno
        */
        if($codigoAlumno->isEmpty())
        { $numero = 000; }
        else
        { $numero = substr($codigoAlumno[0]->codigo,7,5); }
        $anio = date('Y')."-";
        $newcode = $numero+1;
            $existingAlumno = new Alumno;
            $existingAlumno->nombres = $rawAlumno['alu_nonbres'];
            if($rawAlumno['alu_codigo'])
            {
                $codealumno = DB::table('alumno')->where('codigo',$rawAlumno['alu_codigo'])->take(1)->get();
                if($codealumno)
                {
                  return false;
                }
                $existingAlumno->codigo = $rawAlumno['alu_codigo'];
            }
            else
            {
                $existingAlumno->codigo = "HU".$anio.(str_pad($newcode,3,"0",STR_PAD_LEFT));
            }
            $existingAlumno->apellido_paterno = $rawAlumno['alu_apellido_paterno'];
            $existingAlumno->apellido_materno = $rawAlumno['alu_apellido_materno'];
            $existingAlumno->fullname = $rawAlumno['alu_nonbres']." ".$rawAlumno['alu_apellido_paterno']." ".$rawAlumno['alu_apellido_materno'];
            $existingAlumno->sexo = $rawAlumno['alu_sexo'];
            $existingAlumno->impedimento = 0;
            $existingAlumno->fecha_nacimiento = $rawAlumno['alu_fecha_nac'];
            $existingAlumno->dni = $rawAlumno['alu_dni'];
            $existingAlumno->telefono = $rawAlumno['alu_telefono'];
            $existingAlumno->direccion = $rawAlumno['alu_direccion'];
            $existingAlumno->iddepartamento = $rawAlumno['alu_departamento'];
            $existingAlumno->idprovincia = $rawAlumno['alu_provincia'];
            $existingAlumno->iddistrito = $rawAlumno['alu_distrito'];
            $existingAlumno->idestadoalumno = $rawAlumno['alu_estadoalumno'];
            $existingAlumno->usercreate = $iduser;
            $existingAlumno->save();
        //registro el Alumno Matricula, pedimos a esta alumno registrado
            $lastAlumno = Alumno::select('idalumno')->orderBy('idalumno','desc')->take(1)->get();
            $alumnoMatricula = new AlumnoMatricula;
                $alumnoMatricula->idalumno = $lastAlumno[0]->idalumno;
                $alumnoMatricula->idseccion = $rawAlumno['alu_seccion'];
                $alumnoMatricula->idnivel = $rawAlumno['alu_nivel'];
                $alumnoMatricula->idsede = $rawAlumno['alu_sede'];
                $alumnoMatricula->idperiodomatricula = $idperiodomatricula;
                $alumnoMatricula->idgrado = $rawAlumno['alu_grado'];
                $alumnoMatricula->idpension = $rawAlumno['alu_pension'];
                $alumnoMatricula->idestadomatricula = $rawAlumno['alu_estado'];
                $alumnoMatricula->vencimiento = $rawAlumno['alu_vencimiento'];
                $alumnoMatricula->idtipopension = $rawAlumno['alu_tipopension'];
                $alumnoMatricula->usercreate = $iduser;
                $alumnoMatricula->updated_at = '';
                $alumnoMatricula->save();
        //registro de la Vacante,
            $lastVacante = Vacante::
                select('idvacante','qty_matriculados')
                ->where('idseccion','=', $rawAlumno['alu_seccion'])
                ->where('idgrado','=', $rawAlumno['alu_grado'])
                ->where('idnivel','=', $rawAlumno['alu_nivel'])
                ->where('idsede','=',  $rawAlumno['alu_sede'])
                ->where('idperiodomatricula','=',$idperiodomatricula)
                ->orderBy('idvacante','desc')
                ->take(1)
                ->get();
            $newMatriculados = ($lastVacante[0]->qty_matriculados + 1);
            $alumnoVacante = Vacante::
                where('idvacante',$lastVacante[0]->idvacante)
                ->update(['qty_matriculados' => $newMatriculados]);
            return true;
    }
    public function SaveApoderado($iduser, $rawApoderados)
    {
        $lastAlumno = Alumno::select('idalumno')->orderBy('idalumno','desc')->take(1)->get();
        $existingApo = AlumnoApoderado::where('idalumnoapoderado','=', $rawApoderados['apo_id'])->first();
        if(!$existingApo){
            $existingApo = new AlumnoApoderado;
        }
        $existingApo->p_nombres         = $rawApoderados['p_nombre'];
        $existingApo->p_apellidos       = $rawApoderados['p_apellido'];
        $existingApo->p_dni             = $rawApoderados['p_dni'];
        $existingApo->p_estadocivil     = $rawApoderados['p_estadocivil'];
        $existingApo->p_lugarresidencia = $rawApoderados['p_lugarresidencia'];
        $existingApo->p_telefonofijo    = $rawApoderados['p_telefonofijo'];
        $existingApo->p_telefonotrabajo = $rawApoderados['p_telefonotrabajo'];
        $existingApo->p_celular         = $rawApoderados['p_celular'];
        $existingApo->p_email           = $rawApoderados['p_email'];
        $existingApo->m_nombres         = $rawApoderados['m_nombres'];
        $existingApo->m_apellidos       = $rawApoderados['m_apellido'];
        $existingApo->m_dni             = $rawApoderados['m_dni'];
        $existingApo->m_estadocivil     = $rawApoderados['m_estadocivil'];
        $existingApo->m_lugarresidencia = $rawApoderados['m_lugarresidencia'];
        $existingApo->m_telefonofijo    = $rawApoderados['m_telefonofijo'];
        $existingApo->m_telefonotrabajo = $rawApoderados['m_telefonotrabajo'];
        $existingApo->m_celular         = $rawApoderados['m_celular'];
        $existingApo->m_email           = $rawApoderados['m_email'];
        $existingApo->a_nombres         = $rawApoderados['a_nombres'];
        $existingApo->a_apellidos       = $rawApoderados['a_apellido'];
        $existingApo->a_dni             = $rawApoderados['a_dni'];
        $existingApo->a_estadocivil     = $rawApoderados['a_estadocivil'];
        $existingApo->a_lugarresidencia = $rawApoderados['a_lugarresidencia'];
        $existingApo->a_telefonofijo    = $rawApoderados['a_telefonofijo'];
        $existingApo->a_telefonotrabajo = $rawApoderados['a_telefonotrabajo'];
        $existingApo->a_celular         = $rawApoderados['a_celular'];
        $existingApo->a_email           = $rawApoderados['a_email'];
        $existingApo->idalumno          = $lastAlumno[0]->idalumno;
        $existingApo->usercreate        = $iduser;
        $existingApo->save();
        return true;
    }
    public function SaveOtrosDatos($iduser, $rawOtherData)
    {
        $lastAlumno = Alumno::select('idalumno')->orderBy('idalumno','desc')->take(1)->get();
        $existingOther = AlumnoDatos::where('idalumnodatos','=', $rawOtherData['datos_id'])->first();
        if (!$existingOther){
          $existingOther = new AlumnoDatos;
        }
        $existingOther->tiposangre  = $rawOtherData['tipo_sangre'];
        $existingOther->idreligion   = $rawOtherData['religion'];
        $existingOther->email        = $rawOtherData['email'];
        $existingOther->qty_hermanos = $rawOtherData['qty_hermanos'];
        $existingOther->celular      = $rawOtherData['celular'];
        $existingOther->seguro       = $rawOtherData['seguro'];
        $existingOther->foto         = "";
        $existingOther->thumbnail_foto = "";
        $existingOther->idalumno     = $lastAlumno[0]->idalumno;
        $existingOther->usercreate   = $iduser;
        $existingOther->save();
        return true;
    }
    public function LastAlumno()
    {
        return Alumno::
         select('idalumno')
         ->take(1)
         ->orderBy('idalumno','desc')
         ->get();
    }
    
    public function getObservacionImpedimento($id)
    {
        return AlumnoObservacion::
        select('titulo','observacion','alumnoobservacion.idtipoobservacion','alumnoobservacion.created_at','nombre as nombretipoobservacion')
         ->where('idalumno','=',$id)
         ->where('idtipoobservacion','=',4)
         ->orderBy('alumnoobservacion.created_at','desc')
         ->get();
    }


    //RECEPCIONPAGOS



     public function getRecepcionPagos($alumno)
    {

         return RecepcionPagos::
     

         where('nomcliente','LIKE','%'.$alumno.'%')

         ->get();
       

    }


    public function getIncidencias($alumno)
    {

         return Alumnomatricula::
            select('a.idalumno as idalumno','a.codigo','fullname',DB::raw('sum(incidence) as incidencia'),'n.nombre as nivel','g.nombre as grado','s.nombre as seccion','t.nombre as tipopension','p.monto','n.idnivel')
            ->leftJoin('alumnodeudas as ad','ad.idalumno','=','alumnomatricula.idalumno')
            ->leftJoin('alumno as a','a.idalumno','=','alumnomatricula.idalumno')
            ->leftJoin('nivel as n','n.idnivel','=','alumnomatricula.idnivel')
            ->leftJoin('grado as g','g.idgrado','=','alumnomatricula.idgrado')
            ->leftJoin('seccion as s','s.idseccion','=','alumnomatricula.idseccion')
            ->leftJoin('tipopension as t','t.idtipopension','=','alumnomatricula.idtipopension')
            ->leftJoin('pension as p','p.idpension','=','alumnomatricula.idpension')
            ->groupBy('a.idalumno')
            ->having('incidencia','=',$alumno)
         ->get();
       

    }




}


