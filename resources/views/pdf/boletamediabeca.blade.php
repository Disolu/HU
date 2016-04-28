<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>MEDIA BECA</title>
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
@foreach($mediabeca as $beca)
<body>
    <div class="pag1">
        <header>
            <div class="logo">
                <img src="assets/img/logo.jpg" />
            </div>
            <div class="info">
                <center><p style="text-align:center">COLEGIO PRIVADO HIPOLITO UNANUE</p>
                <p ><h2 style="text-align:center">BOLETA DE PAGO PENSIÓN – {!! $meses[$beca->mes] !!}</h2></p></center>
            </div>
          
        </header>
        <div class="content">

       
        <br>
             
            <div class="centro">
                <TABLE width="100%">
                <thead>
                    <tr>
                    <th with="25%"><h3>NIVEL</h3></th>
                    <th with="25%"><h3>GRADO</h3></th>
                    <th with="25%"><h3>APELLIDOS Y NOMBRES</h3></th>
                    <th with="25%"><h3>CODIGO DE PAGO</h3></th>
                    </tr>
                  </thead>
                  <TBODY>
                    <tr>
                    <td>{!! $beca->niveno !!}</td>
                    <td>{!! $beca->grano !!} "{!! $beca->seno !!}" </td>
                    <td>{!! $beca->fullname !!}</td>
                    <td>{!! $beca->codigo !!}</td>
                </tr>
                @if($beca->mes === '07' or $beca->mes==='12')
                <tr>
                    <td colspan="4">VENCIMIENTO: 15 DE {!! $meses[$beca->mes] !!}</td>
                </tr>
                @else
                 <tr>
                    <td colspan="4">VENCIMIENTO: {!! $beca->venc !!} DE {!! $meses[$beca->mes+1] !!}</td>
                </tr>
                @endif
                <tr>
                    <td colspan="2"><h4>CONCEPTO</h4></td>
                    <td colspan="2"><h4>MONTO</h4></td>
                </tr>
                <tr>
                   
                    <td style="text-align:center" colspan="2">PENSIÓN {!! $meses[$beca->mes] !!}</td>
                    <td style="text-align:center" colspan="2">S/. {!! $beca->monto !!}</td>

                </tr>

                  </TBODY>
               
                </TABLE>
            </div>
            <div class="tb">

     
     <br>       
        <span class="sub">INFORMACIÓN IMPORTANTE A TOMAR EN CUENTA</span>
                <ol>
                    <li>Le recordamos que para cancelar en el banco deberá indicar el código del alumno, nombre del colegio y que realizará un pago por recaudación.</li> <br/> <br/>
                   

                    <li>Se le recuerda que por el servicio de recaudación, el banco cobra una comisión de <b>S/. 2.50 (dos con 50/100 nuevos soles)</b> por cada pensión que se cancele. Esto fue informado al momento de la matrícula</li> <br/> <br/>
                    <li>Asimismo, se le recuerda las condiciones a cumplir para acceder al beneficio del pago de una media beca las mismas que fueron informadas en el momento de la matrícula y que fuera suscrita por ud en un anexo al compromiso de matrícula</li> <br/> <br/>
                    <p><b class="pr">“El padre de familia deberá cancelar el costo de su Media Beca los fines de cada mes o cuando haya concluido el servicio educativo del mes correspondiente. Teniendo la posibilidad de cancelarlo hasta los 03 días calendarios posteriores a la fecha de vencimiento sin recargo alguno”.</b></p>
                    <p><b class="pr">“No obstante, perderá el beneficio de su Media Beca si cancela la mensualidad fuera de la fecha descrita en el punto anterior, es decir, desde el día 04 hacia adelante, debiendo cancelar el costo real de la pensión previsto para el año escolar 2015 (inicial: S/.330.00, primaria: S/.340.00 y secundaria: S/.350.00)”.</b></p>
                    <li>Una vez realizado el abono de su pensión en el banco podrá solicitar su <b>comprobante de pago</b> en la secretaría de la institución. Para ello deberá entregar el voucher original respectivo.</li> <br/> <br/>
                    <li>Cualquier información adicional podrá solicitarla al teléfono <b>287-8513 (secretaría sede 2do sector), 715-1987 (secretaría sede Las Brisas)</b> horario de atención: <b>Lunes a Viernes (7:30 a.m.-5:00 p.m.) y Sábado (8:00 a.m.-1:00 p.m.). DOMINGO: No hay atención.</b></li> <br/> <br/>
                    
                </ol>

<br/>
<br/>
<br/>
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