<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>PENSION GENERAL</title>
     {!! Html::style('assets/css/pdf.css') !!}
    <link rel="stylesheet" type="text/css" href="assets/css/boletas.css">


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
                <p ><h2 style="text-align:center">BOLETA DE PAGO PENSIÓN – {!! $meses[$beca->mes] !!}  {!! $beca->periodo !!}</h2></p></center>
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
        <li> Si no se cumple con el pago en las fecha antes señalada se incurrirá automáticamente en mora, aplicándose la tasa de interés moratorio más alta permitida por el Banco Central de Reserva del Perú (BCRP), la misma que será aplicable desde el día siguiente de la fecha de vencimiento de la pensión de enseñanza. Se le recuerda que los intereses moratorios se generan por cada mes de pensión incumplida de forma independiente.</li> <br/> <br/>
         <li>La información de montos y fechas de pago ya han sido remitidas al Banco por tanto <b>no es posible</b> ningún tipo de modificación..</li> <br/> <br/>
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