<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Sorteos VitalFut</title>
    <style>
        body {
            text-align: center;
            font-family: 'Trebuchet MS', sans-serif;
        }


        /* 📌 Cada equipo ocupa 32% del ancho */
        .equipo-container {
            display: inline-block;
            width: 45%;
            vertical-align: top;
            margin-bottom: 10px;
            padding: 10px;
            border: 3px solid #0c0c0b;
            /* Marco naranja */
            border-radius: 10px;
            /* Bordes redondeados */
            background-color: #ffffff;
            page-break-inside: avoid;


        }

        /* 📌 Asegurar que no se desborde */
        .equipo-container table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
        }

        /* 📋 Encabezados */
        .equipo-container thead th {
            background-color: #f97316;
            /* Naranja */
            color: white;
            font-weight: bold;
            padding: 5px;
            border: 1px solid #000;
        }

        /* 📌 Filas */
        .equipo-container td {
            padding: 5px;
            text-align: center;
            border: 1px solid #000;
        }


        * {
            font-family: 'Trebuchet MS', sans-serif;
        }

        @page {
            size: 8.5in 11in;
            margin: .3in;



        }

        hr {
            height: 3px;
            background-color: #E56608;
        }

        /* 📌 Header */
        .header {
            position: static;
            top: -10px
                /* Ajuste para que siempre aparezca en la parte superior */
                left: 0;
            right: 0;
            height: 60px;
            text-align: center;
            width: 100%
        }

        /* 📌 Footer */
        .footer {
            position: fixed;
            bottom: -50px;
            /* Ajuste para que siempre aparezca en la parte inferior */
            left: 0;
            right: 0;
            height: 50px;
            font-size: 10px;
            color: gray;
            text-align: center;
        }



    </style>
</head>

<body>
    <header class="header">
        <a target="_blank">
            <img style="border-radius: 50%;" alt="logo" height="80" width="80" class=""
                src="{{ asset('img/logo.jpg') }}" />
        </a>
        <hr>
        <h4>{{ $datos[0]->sorteo->descripcion ?? '' }} <br> Sede:
            {{ $datos->first()->sorteo->sede->nombre_sede ?? '' }}
        </h4>
    </header>

    <div class="divFinal" style="margin-top: 100px">

        @foreach ($equipos as $index => $equipo)
            <div class="equipo-container">
                <h2 class="equipo-title">Equipo {{ $loop->iteration}}</h2>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 10%;">#</th>
                            <th>Jugador</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            shuffle($equipo['jugadores']); // Mezcla aleatoriamente el array de jugadores
                        @endphp
                        @foreach ($equipo['jugadores'] as $key => $jugador)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $jugador['nombre'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- 📌 Salto de página cada 3 equipos -->
        @endforeach
    </div>
    <br>
    <footer class="footer">Generado automáticamente - {{ date('d/m/Y H:i') }}</footer>
</body>

</html>
