<!DOCTYPE html>
<html>
<head>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>QR Code</title>
    <style>
        body {
            text-align: center;
            font-family: 'Trebuchet MS', sans-serif;
        }

        .qr-code-container {
            margin: 20px auto;
            text-align: center;
        }
        
        
        * {
         font-family: 'Trebuchet MS', sans-serif;
            }
              @page {
              size: 8.5in 11in;
              margin: .5in;

      
        }
        hr {
      height: 3px;
      background-color: #E56608;
    }
    </style>
</head>
<body>
    <div  style="padding:15px;">
     <a target="_blank" style="padding-top:5px;">
    <img  style="border-radius: 50%;" alt="logo" height="90" width="90" class="" src="{{asset('img/logo.jpg')}}"  />
    </a>
    <hr>
    <h3>Hola {{ $nombres }}</h1>
     <h4>Documento: {{$documento}} <br>Plan Activo Desde: {{$plan['fecha_inicio']}} Hasta: {{$plan['fecha_fin']}}</h4>
    <p>Este será tu ticket de entrada a tus clases, recuerda que es único e intransferible</p><br>
    <div class="qr-code-container">
        <img src="{{ $qrCodeDataUri }}" alt="QR Code">
    </div>
    <br>
     <hr>
    </div>
</body>
</html>