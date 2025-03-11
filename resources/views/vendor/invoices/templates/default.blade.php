<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{{ $invoice->name }}</title>
        {{-- <link href="{{asset('css/bootstrap.css')}} " rel="stylesheet" type="text/css"> --}}
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link href="{{asset('css/bootstrap.css')}} " rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{{ public_path('vendor/invoices/bootstrap.min.css') }}">

        <style type="text/css" media="screen">
            * {
                font-family: "DejaVu Sans";
            }
            @page {
      /* size: 8.5in 11in;
      margin: .5in; */

      
    }body {
    /* background-color: #000 */
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
<div class="col-lg-12 col-md-12 col-sm-12 col-12 padding" style="padding-top:35px;">
<hr>
<div class="card">
<div class="card-header p-4"></div>
<a target="_blank" href="https://lobianijs.com" style="padding-top:20px!important;">
    <img  style="padding-top:30px!important;border-radius: 50%;" alt="logo" height="90" width="90" class="img-fluid rounded-circle" src="{{ $invoice->getLogo() }}" data-holder-rendered="true" />
    </a>
    @if($invoice->logo)
            {{-- <img src="{{ $invoice->getLogo() }}" alt="logo" height="100"> --}}
        @endif
<div style="float:right">
<h3>Invoice #BBB10234</h3>

<p style=" line-height: 2px;">Date: 12 Jun,2019</p>
<div style="padding-top:30px;"> 
<h3 class="text-dark" >Tejinder Singh</h3>  
    <div>29, Singla Street</div>
    <div>Sikeston,New Delhi 110034</div>
    <div>Email: contact@bbbootstrap.com</div>
    <div>Phone: +91 9897 989 989</div>
    </div>
</div>
</div>
</div>
<div class="card-body">


<div class="col-sm-6">
<h5 class="mb-3"></h5>
<h3 class="text-dark mb-1">Akshay Singh</h3>
<div>478, Nai Sadak</div>
<div>Chandni chowk, New delhi, 110006</div>
<div>Email: info@tikon.com</div>
<div>Phone: +91 9895 398 009</div>
</div>
</div>
<div class="table-responsive-sm" style="padding-top:30px;">
<table class="table table-bordered" style="border-collapse:collapse; border: 1px solid black; width:100%">
<thead  style="border-collapse:collapse; border: 1px solid black;">
<tr>
    <th class="center">#</th>
    <th>Item</th>
    <th>Description</th>
    <th class="right">Price</th>
    <th class="center">Qty</th>
    <th class="right">Total</th>
</tr>
</thead>
<tbody  style="border-collapse:collapse; border: 1px solid black;">
<tr>
    <td class="center">1</td>
    <td class="left strong">Iphone 10X</td>
    <td class="left">Iphone 10X with headphone</td>
    <td class="right">$1500</td>
    <td class="center">10</td>
    <td class="right">$15,000</td>
</tr>
<tr>
    <td class="center">2</td>
    <td class="left">Iphone 8X</td>
    <td class="left">Iphone 8X with extended warranty</td>
    <td class="right">$1200</td>
    <td class="center">10</td>
    <td class="right">$12,000</td>
</tr>
<tr>
    <td class="center">3</td>
    <td class="left">Samsung 4C</td>
    <td class="left">Samsung 4C with extended warranty</td>
    <td class="right">$800</td>
    <td class="center">10</td>
    <td class="right">$8000</td>
</tr>
<tr>
    <td class="center">4</td>
    <td class="left">Google Pixel</td>
    <td class="left">Google prime with Amazon prime membership</td>
    <td class="right">$500</td>
    <td class="center">10</td>
    <td class="right">$5000</td>
</tr>
</tbody>
</table>
</div>
<div class="row">
<div class="col-lg-12 col-sm-12">
<table class="table table-clear" style="padding-left:480px!important;width:100%">
<tbody style="padding-left:480px!important;">
    <tr class="right">
        <td class="left">
            <strong class="text-dark">Subtotal</strong>
        </td>
        <td class="right">$28,809,00</td>
    </tr>    
   
    <tr>
        <td class="left">
            <strong class="text-dark">Total</strong> </td>
        <td class="right">
            <strong class="text-dark">$20,744,00</strong>
        </td>
    </tr>
</tbody>
</table>
</div>
</div>
</div>
<div>
<p class="" style=" line-height: 2px;padding-top:50px!important;"><b>Contacto:</b>  314-2172666</p>
<p class="" style="line-height: 2px;"><b>Correo:</b> vitalfutclub@gmail.com</p>
</div>
<hr>
<div class="center">
    <p style="font-size:12px; font-weigth:bold;inline-heigth:2px; padding-top:0px!important;">#LaFelicidadSeEntrena</p>
  </div>
</div>
</div>
       </body>

  
</html>
