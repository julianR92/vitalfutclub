<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<title>Email</title>

<style type="text/css">

body {margin: 0; padding: 0; min-width: 100%!important;}

img {height: auto;}

.content {width: 100%; max-width: 600px;}

.header {padding: 40px 30px 20px 30px;}

.innerpadding {padding: 30px 30px 30px 30px;}

.borderbottom {border-bottom: 1px solid #f2eeed;}

.subhead {font-size: 15px; color: #ffffff; font-family: sans-serif; letter-spacing: 10px;}

.h1, .h2, .bodycopy {color: #153643; font-family: sans-serif;}

.h1 {font-size: 33px; line-height: 38px; font-weight: bold;}

.h2 {padding: 0 0 15px 0; font-size: 24px; line-height: 28px; font-weight: bold;}

.bodycopy {font-size: 16px; line-height: 22px;}

.button {text-align: center; font-size: 18px; font-family: sans-serif; font-weight: bold; padding: 0 30px 0 30px;}

.button a {color: #ffffff; text-decoration: none;}

.footer {padding: 20px 30px 15px 30px;}

.footercopy {font-family: sans-serif; font-size: 14px; color: #ffffff;}

.footercopy a {color: #ffffff; text-decoration: underline;}

@media only screen and (max-width: 550px), screen and (max-device-width: 550px) {

body[yahoo] .hide {display: none!important;}

body[yahoo] .buttonwrapper {background-color: transparent!important;}

body[yahoo] .button {padding: 0px!important;}

body[yahoo] .button a {background-color: #effb41; padding: 15px 15px 13px!important;}

body[yahoo] .unsubscribe {display: block; margin-top: 20px; padding: 10px 50px; background: #2f3942; border-radius: 5px; text-decoration: none!important; font-weight: bold;}

}

/*@media only screen and (min-device-width: 601px) {

.content {width: 600px !important;}

.col425 {width: 425px!important;}

.col380 {width: 380px!important;}

}*/

</style>

</head>

<body yahoo bgcolor="#ffffff">

<table width="100%" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">

<tr>

  <td>

    <!--[if (gte mso 9)|(IE)]>

      <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">

      <tr>

      <td>

      <![endif]-->

    <table bgcolor="#ffffff" class="content" align="center" cellpadding="0" cellspacing="0" border="0">

    <tr>

      <td bgcolor="#000" class="header">

        <table width="70" align="left" border="0" cellpadding="0" cellspacing="0">

        

        </table>

        <!--[if (gte mso 9)|(IE)]>

          <table width="425" align="left" cellpadding="0" cellspacing="0" border="0">

          <tr>

          <td>

          <![endif]-->

        <table class="col425" align="left" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 425px;">

        <tr>

          <td height="20">

            <table width="100%" border="0" cellspacing="0" cellpadding="0">

            <tr>

              <td class="subhead" style="padding: 0 0 0 3px;">

                 VitalFutClub

              </td>

            </tr>

            

            </table>

          </td>

        </tr>

        </table>

        <!--[if (gte mso 9)|(IE)]>

          </td>

          </tr>

          </table>

          <![endif]-->

      </td>

    </tr>

    @if($detalleCorreo['mensaje'] == null)

    <tr>

      <td class="innerpadding borderbottom">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">

            <br>

        <tr>

          <td class="h2">

             Estimado(a) VitalFutbolero

          </td>

        </tr>

        <tr>

          <td class="bodycopy">

            El motivo de este correo electrónico es notificarle que Vital Fut Club, le ha enviado una factura de venta identificada con el número: {{$detalleCorreo['numero_factura']}} .

          </td>

        </tr>

        <br>
        
       
        <tr>

          <td class="bodycopy">
            <b>Datos de la compra: </b> <br><br>

            
            <b>Cliente:</b> {{$detalleCorreo['nombres']}} <br>
            <b>Documento:</b> {{$detalleCorreo['documento']}} <br>
            <b>Plan:</b> {{$detalleCorreo['plan']}} <br>
            <b>Sede:</b> {{$detalleCorreo['sede']}}
             
          </td>

        </tr>

        <br>
        

        <tr>

            <td class="bodycopy">

                <br>

                También podrá consultar y descargar el documento haciendo clic <a href="#">aquí</a> y accediendo a su cuenta con las credenciales respectivas.

            </td>

          </tr>

          <tr>

            <td class="bodycopy">

                <br>

                Le recordamos que este un mensaje automatico, recomendamos no responder este correo.

            </td>

          </tr>

          <tr>

            <td class="bodycopy">

                <br>

                <b>Gracias por tu confianza.<br>

                #LaFelicidadSeEntrena</b>

            </td>

          </tr>

        </table>

      </td>

    </tr>

    @elseif($detalleCorreo['mensaje'] == 'BIRTHDAY')

    <tr>
      <td class="innerpadding borderbottom">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <br>
        <tr>
          <td class="h2">
             VITAL-CUMPLEAÑOS
          </td>
        </tr>
        <tr>
          <td class="bodycopy">
          Hoy tenemos estos vitalcumpleañeros:<br>

          <ol>

          @foreach($detalleCorreo['nombres'] as  $dato)
          <li>{{$dato['nombres']}} - {{$dato['edad']}} años</li>          

          @endforeach
          </ol>

          </td>
        </tr>
        <br>
        <tr>
            <td class="bodycopy">                
                            
            </td>
          </tr>
          <tr>
            <td class="bodycopy">
                <br>
                Le recordamos que este un mensaje automatico, recomendamos no responder este correo.
            </td>
          </tr>
          <tr>
            <td class="bodycopy">
                <br>
                <b>Gracias por tu confianza.<br>
                #LaFelicidadSeEntrena</b>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <!--{{-- lo nuevo 01-03-30 --}}-->
    
    @elseif($detalleCorreo['mensaje'] == 'PROFESOR')

    <tr>
      <td class="innerpadding borderbottom">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <br>
        <tr>
          <td class="h2">
             Bienvenido a la familia Vitalfut Profe {{$detalleCorreo['nombres']}}
          </td>
        </tr>
        <tr>
          <td class="bodycopy">
          Estas son las credeciales de ingreso a la plataforma de gestión:<br>
          <b>User:</b> {{$detalleCorreo['plan']}} <br>
          <b>Password:</b> {{$detalleCorreo['sede']}} <br>
          Plataforma : <a href="{{$detalleCorreo['numero_factura']}}" target="_blank">CLIC AQUÍ</a>
       

          </td>
        </tr>
        <br>
        <tr>
            <td class="bodycopy">                
                            
            </td>
          </tr>
          <tr>
            <td class="bodycopy">
                <br>
                Le recordamos que este un mensaje automatico, recomendamos no responder este correo.
            </td>
          </tr>
          <tr>
            <td class="bodycopy">
                <br>
                <b>Gracias por tu confianza.<br>
                #LaFelicidadSeEntrena</b>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <!--{{-- lo nuevo 01-03-30 --}}-->

    @else

    <tr>

      <td class="innerpadding borderbottom">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">

            <br>

        <tr>

          <td class="h2">

             Estimado(a) VitalFutbolero

          </td>

        </tr>

        <tr>

          <td class="bodycopy">

           {{$detalleCorreo['mensaje']}}

          </td>

        </tr>

        <br>

        <tr>

            <td class="bodycopy">                

                            

            </td>

          </tr>

          <tr>

            <td class="bodycopy">

                <br>

                Le recordamos que este un mensaje automatico, recomendamos no responder este correo.

            </td>

          </tr>

          <tr>

            <td class="bodycopy">

                <br>

                <b>Gracias por tu confianza.<br>

                #LaFelicidadSeEntrena</b>

            </td>

          </tr>

        </table>

      </td>

    </tr>



    @endif

    <tr>

      <td class="innerpadding borderbottom">

        <table width="115" align="left" border="0" cellpadding="0" cellspacing="0">

        {{-- <tr>

          <td height="115" style="padding: 0 20px 20px 0;">

            <img class="fix" src="http://placehold.it/115x115" width="115" height="115" border="0" alt=""/>

          </td>

        </tr> --}}

        </table>

        <!--[if (gte mso 9)|(IE)]>

          <table width="380" align="left" cellpadding="0" cellspacing="0" border="0">

          <tr>

          <td>

          <![endif]-->

        <table class="col380" align="left" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 380px;">

        <tr>

          <td>

            <table width="100%" border="0" cellspacing="0" cellpadding="0">

            {{-- <tr>

              <td class="bodycopy">

                 Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tempus adipiscing felis, sit amet blandit ipsum volutpat sed. Morbi porttitor, eget accumsan dictum, nisi libero ultricies ipsum, in posuere mauris neque at erat.

              </td>

            </tr> --}}

           

            </table>

          </td>

        </tr>

        </table>

        <!--[if (gte mso 9)|(IE)]>

          </td>

          </tr>

          </table>

          <![endif]-->

      </td>

    </tr>

   

   

    <tr>

      <td class="footer" bgcolor="#f97316">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

          <td align="center" class="footercopy">

            &copy;  VitalApp<br/>

            {{-- <a href="#" class="unsubscribe"><font color="#ffffff">Unsubscribe</font></a> --}}

            <span class="hide"></span>

          </td>

        </tr>

        <tr>

          <td align="center" style="padding: 20px 0 0 0;">

            <table border="0" cellspacing="0" cellpadding="0">

            <tr>

              {{-- <td width="37" style="text-align: center; padding: 0 10px 0 10px;">

                <a href="https://www.facebook.com/">

                <img src="http://placehold.it/37x37" width="37" height="37" alt="Facebook" border="0"/>

                </a>

              </td> --}}

              {{-- <td width="37" style="text-align: center; padding: 0 10px 0 10px;">

                <a href="https://www.twitter.com/">

                <img src="http://placehold.it/37x37" width="37" height="37" alt="Twitter" border="0"/>

                </a>

              </td> --}}

            </tr>

            </table>

          </td>

        </tr>

        </table>

      </td>

    </tr>

    </table>

    <!--[if (gte mso 9)|(IE)]>

</td>

</tr>

</table>

<![endif]-->

  </td>

</tr>

</table>

</body>