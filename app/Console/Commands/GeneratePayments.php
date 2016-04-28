<?php

namespace App\Console\Commands;

use DB;
use File;
use DateTime;
use DateInterval;
use Illuminate\Console\Command;

class GeneratePayments extends Command
{

    protected $signature = 'payments:generate-payments';
    protected $description = 'Generate payments of students';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
      $numeration = array('1' =>'001503' , '2'=>'004893' );
      $today=date('Ymd');

      
      //TRAEMOS TODAS LAS SEDES 
      $sedes= DB::table('sede')->get();
       
        //RECORREMOS POR LAS SEDES
        foreach ($sedes as $key => $sede)
        {
            //VARIABLERS PARA CONDIGURACIONES
            $file_contents_final="";
            $file_name  = "RC_{$numeration[$sede->idsede]}_{$today}.TXT"; // RC_000_YYYYMMDD.TXT
            $source_file = config('app.urlupload').$file_name;       
            
            //TRAEMOS TODOS LOS ESTUDIANTES
            $students= $this->getStudentsbySede($sede->idsede);   
            $incidences= $this->incidence(); 
            //dd($incidences);
           
              
          

            //SI ESTUDIANTES NO ESTA VACIO
            if (!empty($students))
            {
              $file_contents ="";
              $header ="";

              if($sede->idsede == 1)
              {
                //ESTRUCTURA TXT
                  $header=str_pad($sede->idsede, 2, '0', STR_PAD_LEFT) .'20547453035' .'100' .'PEN' .str_pad($today, 8, ' ', STR_PAD_LEFT) .'000' .str_pad(' ', 330, ' ', STR_PAD_LEFT) .PHP_EOL;  
              
              }
              else
              {
                //ESTRUCTURA TXT
                  $header=str_pad($sede->idsede, 2, '0', STR_PAD_LEFT) .'20547453035' .'300' .'PEN' .str_pad($today, 8, ' ', STR_PAD_LEFT) .'000' .str_pad("T", 8, " ", STR_PAD_LEFT) .str_pad(' ', 322, ' ', STR_PAD_LEFT) .PHP_EOL;

              }

              $countreg=0;
              $sum_max=0;
              $sum_min=0;

              foreach ($students as $key => $student){
                
                //Transformar el mes en string
                $months_pending= $this->getPendingMonths($student->mesdeuda);

                //Obtener nombre parseado
                $nombres__completos=$this->processNames($student); 
                $decimal=100;

                 //AQUI ESTA EL PROBLEMA PEEE
                 //foreach ($months_pending as $period => $nameMonth){

                    $codigo=str_pad($student->codigo, "10"," ",STR_PAD_LEFT);
                    $especificacion = strtoupper($codigo).$this->getNameMonth($student->mesdeuda);
                    $countreg++;
                    $year= date('Y');

                    //$fec_ref= $fec_ref=$year.'-'.$student->mesdeuda.'-03';


                    

                    $fec_ref= "";

                    $counter=$student->mesdeuda+1;
                    $counterformat=number_format($counter);
                    $fecspec=$student->vencimiento;
                    
                    if(strlen($fecspec)==1){
                      $fecspec="-0".$fecspec;
                    }
                    else{
                      $fecspec="-".$fecspec;
                    }
          


                    switch(true)
                      {
                        //Caso Mensualidad+1 entre los valores del 1 al 9 y diferente de 8, es decir Julio y Fechaespecial=1=no
                        case (strlen($counter)==1 && $counter!=8):
                          $fec_ref=$year.'-'."0".$counterformat.$fecspec;
                          break;
                        //Caso mensualidad+1 entre valores 1 al 9 y que no sea julio pero si tiene fecha especial.
                        case (strlen($counter)==1 && $counter!=8):
                          $fec_ref=$year.'-'."0".$counterformat.$fecspec;
                          break;
                          //Caso mensualidad entre 10,11 y menor igual a 12 y sin fecha especial (venc=03 del siguiente mes)
                        case (strlen($counter) == 2 && $counter<=12):
                          $fec_ref=$year.'-'.$counterformat.$fecspec;
                          break;
                          //Caso mensualidad entre 10,11 y menor a 12 y con fecha especial(vence 05 del siguiente mes)
                        case (strlen($counter)==2 && $counter<=12):
                           $fec_ref=$year.'-'.$counterformat.$fecspec;
                          break;
                          //Caso mensualidad mayor 12 (exp)
                        case ($counter>12):
                           $fec_ref=$year.'-'.number_format($student->mesdeuda).'-15';
                          break;  
                     case ($counter==8):
                           $fec_ref=$year.'-'."0".number_format($student->mesdeuda).'-15';
                          break;  

                        default:
                          echo 'nothing';
                          break;
                      }



                    
                    $fec_serv=new DateTime($today.'+1 year');
                    $comparative=$fec_serv->format('Ymd');
                    $fec_ven = new DateTime( $fec_ref.'+1 year' );

                    $last_day = $fec_ven->format('Ymd'); 
                    $fec=$fec_ven->format('Y-m-d');
                    $fec_foo= new DateTime($fec_ref.'+1 year +1 months');
                    $fec_bloqueo=$fec_foo->format('Ymt');

                    

                    $line = array(
                      'sede'           => str_pad('2', "2","0",STR_PAD_LEFT), //2
                      'nombre'         => str_pad($nombres__completos,'30'," ", STR_PAD_RIGHT), //30
                      'especificacion' => str_pad($especificacion, '48'," ", STR_PAD_RIGHT), //48
                      'fec_ven'        => str_pad($last_day, '8'," ", STR_PAD_RIGHT),
                      'fec_bloqueo'    => str_pad($fec_bloqueo, '8'," ", STR_PAD_RIGHT),
                      'periodo'        => str_pad("0", '2',"0", STR_PAD_LEFT),

                      //CONTROLADO POR 3 CONDICIONES, NIVEL, FECHA VENCIMIENTO Y MES
                      'monto_max'      =>str_pad(number_format($student->monto * $decimal, 0, '', ''), 15, '0', STR_PAD_LEFT),
                      'monto_min'      => str_pad(number_format($student->monto * $decimal, 0, '', ''), 15, '0', STR_PAD_LEFT), 
                      'relleno'        => str_pad( "0", '160',"0", STR_PAD_RIGHT),
                      'tail'           => str_pad( "0", '20',"0", STR_PAD_RIGHT),
                      'tail_'          => str_pad( "L", '16',"0", STR_PAD_RIGHT),
                      'tail__'          => str_pad( " ", '36'," ", STR_PAD_LEFT),
                    );


                    if($comparative>$last_day)
                    {
                      DB::table('alumnodeudas')
                      ->where('mes','=',$student->mesdeuda)
                      ->where('status','=','0')
                      ->where('incidence','=','0')
                      ->update(['incidence'=>1]);

                    }

                 

//CONTROLANDO VENCIMIENTOS
                if($comparative>$last_day && $student->idnivel==1 or $student->mesdeuda==07 && $student->idnivel==1 or $student->mesdeuda==12 && $student->idnivel==1){

                    $line['monto_max'] =str_pad(number_format(350.0 * $decimal, 0, '', ''), 15, '0', STR_PAD_LEFT);
                    $line['monto_min'] =str_pad(number_format(350.0 * $decimal, 0, '', ''), 15, '0', STR_PAD_LEFT);

                  }
                  elseif($comparative>$last_day && $student->idnivel==2 or $student->mesdeuda==07 && $student->idnivel==2 or $student->mesdeuda==12 && $student->idnivel==2){

                    $line['monto_max'] =str_pad(number_format(380.0 * $decimal, 0, '', ''), 15, '0', STR_PAD_LEFT);
                     $line['monto_min'] =str_pad(number_format(380.0 * $decimal, 0, '', ''), 15, '0', STR_PAD_LEFT);

                  }
                   elseif($comparative>$last_day && $student->idnivel==3 or $student->mesdeuda==07 && $student->idnivel==3 or $student->mesdeuda==12 && $student->idnivel==3){

                    $line['monto_max'] =str_pad(number_format(400.0 * $decimal, 0, '', ''), 15, '0', STR_PAD_LEFT);
                    $line['monto_min'] =str_pad(number_format(400.0 * $decimal, 0, '', ''), 15, '0', STR_PAD_LEFT);

                  }

                 $sum_max +=$line['monto_min'];
                 $sum_min += $line['monto_max'];
//CONTROLANDO VENCIMIENTOS AL TERCER DÍA



  
                    $file_contents .= implode($line) . PHP_EOL;

                 //}

              }

              $footer="03".str_pad($countreg, 9,"0",STR_PAD_LEFT).
              str_pad(number_format($sum_max * $decimal, 0, '', ''), 20, '0', STR_PAD_LEFT).
              str_pad(number_format($sum_min * $decimal, 0, '', ''), 18, '0', STR_PAD_LEFT).
              str_pad( "0", 16,"0", STR_PAD_LEFT).
              str_pad( " ", 295," ", STR_PAD_LEFT). PHP_EOL;
            }
            //ESTUDIANTES VACIOS
            else
            {

                return false;
                exit();
            }

                //GENERAMOS EL TXT.
                $file_contents_final.= $header.$file_contents.$footer. PHP_EOL;
                File::put($source_file, $file_contents_final);
        }
    }

    private function getStudentsbySede($sede){
  

      $query = DB::table('alumnodeudas')
      ->select('*','alumnodeudas.mes as mesdeuda')
      ->leftjoin('alumnomatricula', 'alumnomatricula.idalumno', '=', 'alumnodeudas.idalumno')
      ->leftjoin('pension', 'pension.idpension', '=', 'alumnomatricula.idpension')
      ->leftJoin('alumno','alumnodeudas.idalumno','=', 'alumno.idalumno')
      ->leftJoin('alumnoapoderado','alumnodeudas.idalumno','=','alumnoapoderado.idalumno')

      //->where('alumnodeudas.idalumno', 1)
      ->where('alumnodeudas.status',   0)
      ->where('alumnomatricula.idsede', $sede)

      ->where('alumnodeudas.idperiodomatricula', 1)
      ->where('alumnomatricula.idperiodomatricula', 1);
      return $query->get();      
     
    }

    private function getPendingMonths($month){
      $months_array=array();
      for ($i=$month; $i<=12; $i++) 
      { 
        $period= str_pad($i,"2","0", STR_PAD_LEFT);
        $months_array[$period]=$this->getNameMonth($i);
      }
      return $months_array;
    }


 

    private function processNames($student){

        $nombres_completos=trim($student->nombres).' '.trim($student->apellido_paterno).' '.trim($student->apellido_materno);

        $nombres_completos=str_replace('Á','A',$nombres_completos);
        $nombres_completos=str_replace('É','E',$nombres_completos);
        $nombres_completos=str_replace('Í','I',$nombres_completos);
        $nombres_completos=str_replace('Ó','O',$nombres_completos);
        $nombres_completos=str_replace('Ú','U',$nombres_completos);
        $nombres_completos=str_replace('Ñ','N',$nombres_completos);
        $nombres_completos=str_replace('&','Y',$nombres_completos);
        $nombres_completos=str_replace('À','A',$nombres_completos);
        $nombres_completos=str_replace('È','E',$nombres_completos);
        $nombres_completos=str_replace('Ì','I',$nombres_completos);
        $nombres_completos=str_replace('Ò','O',$nombres_completos);
        $nombres_completos=str_replace('Ù','U',$nombres_completos);
        $nombres_completos=str_replace('Ä','A',$nombres_completos);
        $nombres_completos=str_replace('Ë','E',$nombres_completos);
        $nombres_completos=str_replace('Ï','I',$nombres_completos);
        $nombres_completos=str_replace('Ö','O',$nombres_completos);
        $nombres_completos=str_replace('Ñ','n',$nombres_completos);
        $nombres_completos=str_replace('Ü','u',$nombres_completos);
        $nombres_completos=strtolower($nombres_completos);
        $nombres_completos=str_replace(array('.',',',':','_','¿','?','-'),'',$nombres_completos);
        $nombres_completos=str_replace('á','a',$nombres_completos);
        $nombres_completos=str_replace('é','e',$nombres_completos);
        $nombres_completos=str_replace('í','i',$nombres_completos);
        $nombres_completos=str_replace('ó','o',$nombres_completos);
        $nombres_completos=str_replace('ú','u',$nombres_completos);
        $nombres_completos=str_replace('ñ','n',$nombres_completos);
        $nombres_completos=str_replace('&','y',$nombres_completos);
        $nombres_completos=str_replace('à','a',$nombres_completos);
        $nombres_completos=str_replace('è','e',$nombres_completos);
        $nombres_completos=str_replace('ì','i',$nombres_completos);
        $nombres_completos=str_replace('ò','o',$nombres_completos);
        $nombres_completos=str_replace('ù','u',$nombres_completos);
        $nombres_completos=str_replace('ä','a',$nombres_completos);
        $nombres_completos=str_replace('ë','e',$nombres_completos);
        $nombres_completos=str_replace('ï','i',$nombres_completos);
        $nombres_completos=str_replace('ö','o',$nombres_completos);
        $nombres_completos=str_replace('ü','u',$nombres_completos);
        $nombres_completos=str_replace('Ñ','n',$nombres_completos);

  
       
        
        if (strlen($nombres_completos)>=30) {
         $nombres_completos=substr($nombres_completos, 0, 30);
        }

        $nom=strtoupper($nombres_completos);
        return $nom;

    }

    private function getNameMonth($monthNum){

        /*setlocale(LC_ALL,"es_ES@euro","es_ES","esp","ES_es","ES_ES");
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->getTimestamp();
        return strftime("%B");*/

        switch ($monthNum) {
            case 1:
                $th='ENERO';
                break;
            case 2:
                $th='FEBRERO';
                break;
            case 3:
                $th='MARZO';
                break;
            case 4:
                $th='ABRIL';
                break;
            case 5:
                $th='MAYO';
                break;
            case 6:
                $th='JUNIO';
                break;
            case 7:
                $th='JULIO';
                break;
            case 8:
                $th='AGOSTO';
                break;
            case 9:
                $th='SETIEMBRE';
                break;
            case 10:
                $th='OCTUBRE';
                break;
            case 11:
                $th='NOVIEMBRE';
                break;
            case 12:
                $th='DICIEMBRE';
                break;           
        }

        return $th;
    } 




private function incidence()
{
   $incidence=DB::table('alumnodeudas')
        ->select(DB::raw("idalumno,sum(incidence) as incidencias"))
        ->groupBy('idalumno')
        ->having('incidencias','>=',1);
         return $incidence->get();    
}






}