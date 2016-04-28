<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Media Beca</title>
     {!! Html::style('assets/css/pdf.css') !!}
    <link rel="stylesheet" type="text/css" href="assets/css/boletas.css">
   <script type="text/javascript">

  $(document).ready(function(){
    function TranslateDate(theDate)
    {
        var date;
        switch(theDate)
        {
            case '01':
                date = "Enero";
                break;
            case '02':
                date = "Febrero";
                break;
            case '03':
                date = "Marzo";
                break;
            case '04':
                date = "Abril";
                break;
            case '05':
                date = "Mayo";
                break;
            case '06':
                date = "Junio";
                break;
            case '07':
                date = "Julio";
                break;
            case '08':
                date = "Agosto";
                break;
            case '09':
                date = "Septiembre";
                break;
            case '10':
                date = "Octubre";
                break;
            case '11':
                date = "Noviembre";
                break;
            case '12':
                date = "Diciembre";
                break;

            default:
                  date = "No found";
                  break;
        }
        return "Pagos: "+date;
    }
    </script>

</head>
@foreach($advmediabeca as $beca)
<body>
    <div class="pag1">
        <header>
            <div class="logo">
                <img src="assets/img/logo.jpg" />
            </div>
            <div class="info">
                <br/>
                <br/>
                <center><p style="text-align:center">COLEGIO PRIVADO HIPOLITO UNANUE</p>
                <p ><h2 style="text-align:center">ADVERTENCIA DE PÉRDIDA DE BENEFICIO PENSIÓN PREFERENCIAL</h2></p>
            </center>
            </div>
          
        </header>
        <div class="content">

       
        
             
          
            <div class="tb">

     
     <br>     
     <br/>
     <br/>  
        <span><b>SRES PADRES DE FAMILIA:</b></span>
        <br/>
        <br/>
        <br/>
        <b>ALUMNO(A)(S):    {!!$beca->fullname!!}</b>


                <ol>
                    <p class="text14">
                        Mediante la presente le recordamos que el pago de la pensión del mes de <b>{!!$meses[$beca->mes]!!}</b> lo realizó fuera de fecha
                        por ello le recomendamos tener en cuenta que las pensiones de los meses siguientes deberá cancelarlos de
                    
                        manera puntual, en caso contrario perderá el beneficio de su <b>Media Beca</b>.<br/>

                        Dicha condición se le informó en el momento de la matrícula y consta así en el anexo de Media Beca 
                     
                        que usted suscribió al momento de la matrícula y que a continuación transcribimos para su recordación:</p> <br/>
                   

                    <I class="text16">
                        El padre de familia perderá de manera automática y definitiva el beneficio de su Media Beca cuando no cancele <u>puntualmente</u> dos (02) mensualidades consecutivas o alternadas en las fechas comprometidas.</I>
                        <b class="text16">De incurrirse en este supuesto el PP.FF deberá pagar el costo real de la pensión para el resto del año escolar 2015 y no podrá solicitar beneficios similares en el futuro”.</b>
                     <br/> <br/>

                    <p class="text14">
                       Por lo tanto, confiamos que en el resto de los meses del año pueda seguir manteniendo su beneficio en la medida que no se genere ni un retraso más.</p>
                    <p class="text14">
                        Para cualquier consulta adicional al respecto podrá comunicarse al <b>287-8513 (Sede 2do sector)</b> o al <b>715-1987 (Sede Las Brisas)</b> en el horario de lunes a viernes de 08:00 am a 05:00 pm y sábados de 08:00 a 01:00 pm.

                    </p>



                    
                    
                    
                </ol>

<br/>
<br/>
<br/>
<p class="text14"><b>Atentamente, LA ADMINISTRACION</b></p>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
 </div>
    </div>
</body>
@endforeach
</html>