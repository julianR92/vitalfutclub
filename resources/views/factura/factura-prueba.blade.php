<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Factura Vital Fut</title>
        {{-- <link href="{{asset('css/bootstrap.css')}} " rel="stylesheet" type="text/css"> --}}
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        {{-- {{-- <link href="{{asset('css/bootstrap.css')}} " rel="stylesheet" type="text/css"> --}}
        <link rel="stylesheet" href="{{ public_path('vendor/invoices/bootstrap.min.css') }}">

        <style type="text/css" media="screen">
            * {
                font-family: "DejaVu Sans";
            }
            @page {
      size: 8.5in 11in;
      margin: .5in;

      
    }body {
    /* background-color: #000 */
   }

   .page-break {
    page-break-after: always;
}

/* .padding {
    padding: 2rem !important
} */

.card {
    margin-bottom: 30px;
    border: none;
    -webkit-box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22);
    -moz-box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22);
    box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22)
}

.card-header {
    background-color: #fff;
    border-bottom: 1px solid #e6e6f2
}

h3 {
    font-size: 20px
}

h5 {
    font-size: 15px;
    line-height: 26px;
    color: #3d405c;
    margin: 0px 0px 15px 0px;
    font-family: 'Circular Std Medium'
}

.text-dark {
    color: #3d405c !important
}

hr {
  height: 3px;
  background-color: #E56608;
}

.center {
  text-align: center;
  
}


        </style>
    </head>

    <body oncontextmenu='return false' class='snippet-body'>
<div class="col-lg-12 col-md-12 col-sm-12 col-12 padding" style="padding-top:10px;">
<hr>
<div class="card">
<div class="card-header p-4"></div>
<a target="_blank" href="https://lobianijs.com" style="padding-top:20px!important;">
    <img  style="padding-top:30px!important;border-radius: 50%;" alt="logo" height="90" width="90" class="img-fluid rounded-circle" src="{{asset('img/logo.jpg')}}" data-holder-rendered="true" />
    </a>
    
<div style="float:right">
<h3>Factura: #123</h3>
<p>Elaboracion: 12-12-2023</p>
</div>


<div style="">
    
    <div style="width:100%!important;padding-top:8px!important;">
    <div style="float: left;width:65%;">     
            <h4 class="text-dark" style="float: left;">VitalFutClub</h4><br> 
            <div style="float: left; line-height:5px; padding-bottom:15px!important;">1098719559</div><br><br>
            <div style="float: left">Cliente: <b>Oscar Julian Rincon Vargas</b></div><br>
            <div style="float: left">CC o Nit: <b>1098699832</b></div><br>
            <div style="float: left">Direccion: <b>Carrera 28#19-19</b></div><br>
            <div style="float: left">Tel: <b>3168706182</b></div><br>
            <div style="float: left">Correo: <b>julian@gmail.com</b></div><br>
    </div>

<div style="float:right;width:35%;">
    <br><br>
<h3 class="text-dark mb-0" style="float:right;"></h3><br>
<div style="float:right;">Inicio:<b>01-12-2023</b></div><br>
<div style="float:right;">Fin: <b>01-12-12</b></div><br>

</div>
    </div>
</div>

</div>
<div style="position:absolute;top:350px;">
<table class="table table-bordered table-sm" style="border: 2px solid black; width:100%">
<thead  style="border-collapse:collapse; border: 2px solid black;" class="thead-dark">
<tr>
    <th class="center">#</th>    
    <th>Plan</th>
    <th class="right">Valor</th>
    
</tr>
</thead>
<tbody  style="border: 2px solid black;">
    {{-- @foreach($plan_activo as $plan) --}}
<tr>
    <td class="center">1</td>
    
    <td class="left">Plan Basico</td>
    <td class="right">${{number_format(100000, 2)}}</td>
    
</tr>
{{-- @endforeach --}}



</tbody>
</table>
<div class="position:absolute;top:450px;">
<table style="padding-left:480px!important;width:100%">
<tbody style="padding-left:480px!important;">
    <tr>
        <td class="">
            <strong class="text-dark">Total</strong> </td>
        <td class="">
            <strong class="text-dark">${{number_format(100000, 2)}}</strong>
        </td>
    </tr>
</tbody>
</table>
</div>
</div>
<div>
 <div style="position:absolute;top:500px;">
  <p><b>Contacto:</b>  314-2172666</p><br>
  <p><b>Correo:</b> vitalfutclub@gmail.com</p>
 </div><br>
  <div style="position:absolute;top:580px;">
     <hr> 
  </div>
  <div  style="position:absolute;top:590px;text-align:center">
        <p style="font-size:10px; font-weigth:bold;"><b>El servicio es personal e intransferible, una vez cancelado no es reembolsable ni congelable</b></p><br>
    <p style="font-size:14px; font-weigth:bold;"><b>#LaFelicidadSeEntrena</b></p>
  </div>
</div>


</div>


</body>

  
</html>