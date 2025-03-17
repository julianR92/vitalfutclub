<x-app-layout>
    <style>
        @media (max-width: 600px) {
            .modal-content2 {
                padding: 0.5rem;
                /* Reducir padding */
                width: 98%;
                /* Hacerlo casi completo */
            }
        }

        .bg-purple-500 {
            background-color: #7353B7
        }

        .error {
            color: red;
            font-size: 0.875rem;
            /* Tamaño de fuente */
        }

        .stepper-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .btn-stepper {
            width: 30px;
            height: 30px;
            background-color: #007bff;
            border: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .btn-stepper:hover {
            background-color: #0056b3;
        }

        .btn-stepper:disabled {
            background-color: #ccc !important;
            cursor: not-allowed;
            color: #666;

        }

        .input-clasificacion {
            width: 60px;
            text-align: center;
            border: 2px solid #007bff;
            border-radius: 5px;
            font-weight: bold;
            color: #007bff;
            height: 30px;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        .button {
            color: #ffffff;
            /* Blanco para contraste */
            font-size: 17px;
            background-color: #e91e63;
            /* Magenta principal */
            border: 1px solid #c2185b;
            /* Magenta oscuro */
            border-radius: 5px;
            cursor: pointer;
            padding: 10px;
            box-shadow: 0px 6px 0px #ad1457;
            /* Sombra magenta oscuro */
            transition: all 0.1s;
        }

        .button:active {
            box-shadow: 0px 2px 0px #ad1457;
            position: relative;
            top: 2px;
        }

        .button2 {
            color: #ffffff;
            /* Blanco para contraste */
            font-size: 17px;
            background-color: #04a80d;
            /* Magenta principal */
            border: 1px solid #035711;
            /* Magenta oscuro */
            border-radius: 5px;
            cursor: pointer;
            padding: 10px;
            box-shadow: 0px 6px 0px #035711;
            /* Sombra magenta oscuro */
            transition: all 0.1s;
        }

        .button2:active {
            box-shadow: 0px 2px 0px #035711;
            position: relative;
            top: 2px;
        }

        .bombita {
            position: absolute;
            top: -50px;
            /* Empieza fuera de la pantalla */
            width: 15px;
            height: 15px;
            border-radius: 50%;
            opacity: 0.8;
            animation: caer 3s linear infinite;
        }

        @keyframes caer {
            0% {
                transform: translateY(-50px) translateX(0);
                opacity: 1;
            }

            100% {
                transform: translateY(100vh) translateX(calc(-50vw + 100vw * var(--randX)));
                opacity: 0;
            }
        }

        .balon {
            position: absolute;
            top: 0;
            font-size: 2rem;
            /* Ajusta el tamaño del emoji */
            animation: caer 3s linear infinite;
        }

        .balon::before {
            content: "⚽";
            /* Usa el emoji de balón de fútbol */
        }

        @keyframes caer {
            0% {
                transform: translateY(0) translateX(calc(var(--randX) * 50px));
                opacity: 1;
            }

            100% {
                transform: translateY(100vh) translateX(calc(var(--randX) * 50px));
                opacity: 0;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />





    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-semibold text-gray-900 tracking-wide border-b-2 border-gray-300 pb-2">
                {{ $sorteo->descripcion }} | {{ $nombre_sede = $sorteo->sede ? $sorteo->sede->nombre_sede : null }}
            </h1>
            @if ($count_equipos > 0)
                <h1 class="text-2xl font-semibold text-gray-900">
                    N° de Equipos: {{ $count_equipos }} <br> N° de Jugadores: {{ $count_jugadores }}
                </h1>
            @endif
        </div>
    </div>

    @if (!$sorteo->jugadores_completos)
        <div class="py-10 animate__animated animate__backInLeft">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <section class="bg-white dark:bg-gray-900">
                        <div class="container px-6 py-7 mx-auto">
                            <div class="bg-slate-100/50 py-1 px-3 border-solid border-b rounded-lg">
                                <x-titulo titulo="Selecciona Jugadores"></x-titulo>
                            </div>

                            <div class="grid grid-cols-1 mt-4 xl:mt-2 md:grid-cols-2 xl:grid-cols-1 div-principal">
                                <table class="cell-border compact stripe tabla" id="tabla" width="100%">

                                </table>

                            </div>
                            <div class="mt-3 flex justify-end mr-4">
                                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                                    id="btnIncludePlayers">
                                    Incluir jugadores
                                </button>
                            </div>
                    </section>
                </div>
            </div>
        </div>
    @endif

    @if ($sorteo->jugadores_completos && !$sorteo->numero_equipos)
        <div class="py-10 animate__animated animate__backInUp">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <section class="bg-white dark:bg-gray-900">
                        <div class="container px-6 py-7 mx-auto">
                            <div class="bg-slate-100/50 py-1 px-3 border-solid border-b rounded-lg">
                                <x-titulo titulo="Numero de equipos"></x-titulo>
                            </div>
                            <form class="w-full max-w-full p-2" id="myForm">



                                <div class="flex flex-wrap mt-3">

                                    <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                                        <x-jet-label for="numero_equipos" value="Numero de equipos" />
                                        <input type="text" id="numero_equipos" placeholder="" name="numero_equipos"
                                            maxlength="2" max="50"
                                            class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                            required />
                                        <x-jet-input-error for="numero_equipos" class="mt-2" />
                                    </div>

                                    <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0" style="margin-top: 25px;">
                                        <input type="hidden" id="id" name="id" value="{{ $sorteo->id }}">
                                        <x-jet-button
                                            class="bg-green-600 hover:bg-green-700 text-white hover:text-white mr-2">
                                            Definir Numero de Equipos
                                        </x-jet-button>
                                    </div>

                                </div>
                            </form>


                    </section>
                </div>
            </div>
        </div>
    @endif

    @if (!$sorteo->sorteo_finalizado)
        <div class="py-10 animate__animated animate__backInDown containerTable">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <section class="bg-white dark:bg-gray-900">
                        <div class="container px-6 py-7 mx-auto">
                            <div class="bg-slate-100/50 py-1 px-3 border-solid border-b rounded-lg">
                                <x-titulo titulo="Jugadores Incluidos"></x-titulo>
                            </div>

                            <div class="grid grid-cols-1 mt-4 xl:mt-2 md:grid-cols-2 xl:grid-cols-1 div-principal">
                                <table class="cell-border compact stripe tabla hidden" id="tablaPlayers" width="100%">

                                </table>

                            </div>
                            <div class="mt-3 flex justify-end mr-4">
                                @if (!$sorteo->jugadores_completos)
                                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                        id="bntFinishSelection" data-id="{{ $sorteo->id }}">
                                        Terminar Selección
                                    </button>
                                @endif
                                @if ($sorteo->numero_equipos && !$sorteo->clasificacion_validada)
                                    <button
                                        class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded"
                                        id="btnValidateClasificacion" data-id="{{ $sorteo->id }}">
                                        Validar Calificación
                                    </button>
                                @endif
                                @if ($sorteo->clasificacion_validada)
                                    <button class="button" data-id="{{ $sorteo->id }}" id="btnSorteo">Realizar
                                        Sorteo</button>
                                @endif

                            </div>
                    </section>
                </div>
            </div>
        </div>
    @endif
    @if ($sorteo->sorteo_finalizado)
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-semibold text-gray-900">
                Sorteo Finalizado: {{ $sorteo->updated_at->format('d-m-Y') }}
            </h1>
        </div>
        <div class="flex flex-wrap gap-4 justify-center mt-6 mb-6 divFinal">
            @foreach ($equipos_jugadores as $index => $equipo)
                <div class="animate__animated animate__fadeInUp">
                    <div class="bg-white shadow-lg rounded-lg p-4">
                        <h2 class="text-lg font-bold text-center mb-2">Equipo {{ $index + 1 }}</h2>
                        <table class="table-auto w-full border-collapse border border-gray-200">
                            <thead>
                                <tr>
                                    <th class="border px-4 py-2" style="width: 5%">#</th>
                                    <th class="border px-4 py-2">Jugador</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($equipo['jugadores'] as $key => $jugador)
                                    <tr>
                                        <td class="border px-4 py-2 text-center">{{ $key + 1 }}</td>
                                        <td class="border px-4 py-2 text-center">
                                            {{ $jugador['jugador']['nombres'] }}
                                            {{ $jugador['jugador']['apellidos'] }}
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    <div id="confettiContainer" class="fixed top-0 left-0 w-full h-full pointer-events-none"></div>
    <div id="equiposContainer" class="flex flex-wrap gap-4 justify-center mt-6 mb-6">

    </div>





    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <div class="container px-6 py-7 mx-auto">
                    <div class="mt-3">
                        <a href="/sorteo" style="color: dodgerblue; text-decoration: underline ">Atras</a>

                    </div>
                </div>

            </div>
        </div>



        @push('js')
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image-more/3.5.0/dom-to-image-more.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>







            <script>
                //abrir modal


                $(document).ready(function() {

                    let jugadores = [];


                    var sorteo_id = "{{ $sorteo->id }}";
                    var numero_equipos = "{{ $sorteo->numero_equipos }}";
                    var clasificacion_validada = "{{ $sorteo->clasificacion_validada }}";
                    sorteo_id = parseInt(sorteo_id);
                    numero_equipos = parseInt(numero_equipos);
                    clasificacion_validada = parseInt(clasificacion_validada);
                    $('#tabla').DataTable({
                        destroy: true,
                        processing: true,
                        responsive: true,
                        //  serverSide: true,
                        ajax: {
                            url: `/sorteo/jugadores/getData/${sorteo_id}`,
                            type: 'GET'
                        },

                        columns: [{
                                data: null, // No se asocia a un dato específico
                                title: '#', // Título de la columna
                                className: 'text-center',
                                orderable: false, // No ordenable
                                render: function(data, type, row, meta) {
                                    return meta.row + 1; // meta.row es el índice de la fila (0-based)
                                }
                            },

                            {
                                data: 'nombres',
                                title: 'Nombres',
                                className: 'p-2',
                                orderable: true
                            },
                            {
                                data: 'apellidos',
                                title: 'Apellidos',
                                className: 'p-2',
                                orderable: true
                            },
                            {
                                data: 'documento',
                                title: 'Documento',
                                className: 'p-2',
                                orderable: true
                            },
                            {
                                data: null,
                                title: 'Seleccionar',
                                className: 'p-3 text-center',
                                orderable: false,
                                render: function(data, type, row) {
                                    return `<div class="flex items-center justify-center mb-4">
                                <input
                                    id="default-checkbox"
                                    type="checkbox"
                                    value="${row.id}"
                                    class=" selectJugador  w-8 h-8 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 cursor-pointer"

                                >
                                </div>`
                                }
                            },
                        ],
                        scrollX: true,
                        scrollY: "350px", // Habilita el scroll vertical con altura máxima de 500px
                        scrollCollapse: true, // Permite reducir la tabla si hay pocos registros
                        paging: false, // Desactiva la paginación
                        info: false, //
                        "order": [
                            [0, "asc"]
                        ],
                        language: {
                            sProcessing: "Procesando...",
                            sLengthMenu: "Mostrar _MENU_ registros",
                            sZeroRecords: "No se encontraron resultados",
                            sEmptyTable: "Ningún dato disponible en esta tabla",
                            sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
                            sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0",
                            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
                            sInfoPostFix: "",
                            sSearch: "Buscar:",
                            sUrl: "",
                            sInfoThousands: ",",
                            sLoadingRecords: "Cargando...",
                            oPaginate: {
                                sFirst: "Primero",
                                sLast: "Último",
                                sNext: "Siguiente",
                                sPrevious: "Anterior",
                            },

                            oAria: {
                                sSortAscending: ": Activar para ordenar la columna de manera ascendente",
                                sSortDescending: ": Activar para ordenar la columna de manera descendente",
                            },
                        },
                        pageLength: 5,

                    });
                    //table dos

                    $('#tablaPlayers').DataTable({
                        destroy: true,
                        processing: true,


                        responsive: true,
                        //  serverSide: true,
                        ajax: {
                            url: `/sorteo/jugadores/${sorteo_id}`,
                            type: 'GET'
                        },

                        columns: [{
                                data: null, // No se asocia a un dato específico
                                title: '#', // Título de la columna
                                className: 'text-center',
                                orderable: false, // No ordenable
                                render: function(data, type, row, meta) {
                                    return meta.row + 1; // meta.row es el índice de la fila (0-based)
                                }
                            },

                            {
                                data: null,
                                title: 'Jugador',
                                className: 'text-center',
                                orderable: true,
                                render: function(data, type, row) {
                                    return `${row.jugador.nombres} ${row.jugador.apellidos}`
                                }

                            },
                            {
                                data: null,
                                title: 'Puntaje',
                                className: 'text-center',
                                visible: clasificacion_validada != 1,
                                orderable: true,
                                render: function(data, type, row) {
                                    let disabled = (numero_equipos) ? '' : 'disabled';
                                    return `
                                <div class="stepper-container">
                                    <button class="btn-stepper btn-decrement" data-id="${row.id}" ${disabled}>-</button>
                                    <input type="number" class="input-clasificacion" data-id="${row.id}" value="${row.clasificacion}" min="1" max="5" readonly>
                                    <button class="btn-stepper btn-increment" data-id="${row.id}" ${disabled}>+</button>
                                </div>
            `;
                                }
                            },
                            {
                                data: null,
                                title: 'Acciones',
                                className: 'p-3 text-center',
                                orderable: false,
                                visible: clasificacion_validada != 1,
                                render: function(data, type, row) {
                                    return `
                		<div class="flex item-center justify-center">

                        <button data-id="${row.id}" class="w-4 mx-2 transform hover:text-blue-800 hover:scale-125 btnEliminar" title="Eliminar Sorteo">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="btnEliminar" data-id="${row.id}" >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"  data-id="${row.id}"/>
                        </svg>
                      </button>

                		</div>
                		`;
                                }
                            },
                        ],
                        scrollX: true,
                        scrollY: "350px", // Habilita el scroll vertical con altura máxima de 500px
                        scrollCollapse: true, // Permite reducir la tabla si hay pocos registros
                        paging: false, // Desactiva la paginación
                        info: false, //
                        "order": [
                            [0, "asc"]
                        ],
                        language: {
                            sProcessing: "Procesando...",
                            sLengthMenu: "Mostrar _MENU_ registros",
                            sZeroRecords: "No se encontraron resultados",
                            sEmptyTable: "Ningún dato disponible en esta tabla",
                            sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
                            sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0",
                            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
                            sInfoPostFix: "",
                            sSearch: "Buscar:",
                            sUrl: "",
                            sInfoThousands: ",",
                            sLoadingRecords: "Cargando...",
                            oPaginate: {
                                sFirst: "Primero",
                                sLast: "Último",
                                sNext: "Siguiente",
                                sPrevious: "Anterior",
                            },

                            oAria: {
                                sSortAscending: ": Activar para ordenar la columna de manera ascendente",
                                sSortDescending: ": Activar para ordenar la columna de manera descendente",
                            },
                        },
                        pageLength: 5,

                    });

                    $('#tabla tbody').on('change', '.selectJugador', function() {
                        $(this).closest('tr').toggleClass('bg-green-soft', this.checked);
                    });

                    $(document).on('change', '.selectJugador', function() {
                        const playerId = $(this).val();

                        if (this.checked) {
                            if (!jugadores.includes(playerId)) {
                                jugadores.push(playerId);
                            }
                        } else {
                            jugadores = jugadores.filter(id => id !== playerId);
                        }

                    });

                    $(document).on('click', '.btn-increment', function() {
                        let input = $(this).siblings('.input-clasificacion');
                        let id = $(this).data('id');
                        let valor = parseInt(input.val());

                        if (valor < 5) {
                            valor++;
                            input.val(valor).trigger('change');

                            //actualizarClasificacion(id, valor);
                        }
                    });

                    $(document).on('click', '.btn-decrement', function() {
                        let input = $(this).siblings('.input-clasificacion');
                        let id = $(this).data('id');
                        let valor = parseInt(input.val());

                        if (valor > 1) {
                            valor--;
                            input.val(valor).trigger('change');

                        }
                    });
                    let timeout = null;
                    // Detectar cambio en el input (por botones o edición manual)
                    $(document).on('change', '.input-clasificacion', function() {
                        let input = $(this);
                        let id = input.data('id');
                        let valor = parseInt(input.val());

                        // Validar el rango del número
                        if (valor < 1 || valor > 5 || isNaN(valor)) {
                            input.val(1);
                            valor = 1;
                        }

                        // Limpiar el timeout anterior si existe
                        clearTimeout(timeout);

                        // Esperar 1.5 segundos antes de hacer la petición
                        timeout = setTimeout(() => {
                            actualizarClasificacion(id, valor);
                        }, 1500);
                    });
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    function actualizarClasificacion(id, valor) {
                        data = {
                            'clasificacion': valor,
                            'id': id
                        };

                        $.ajax({
                            url: `/sorteo/actualizar-clasificacion`,
                            type: 'POST',
                            data: JSON.stringify(data), // Convertimos a JSON
                            contentType: 'application/json',
                            processData: false,
                            success: function(response) {
                                if (response.success) {
                                    toastr.success('Clasificación actualizada', 'Éxito');

                                } else {
                                    toastr.error('Error al actualizar la clasificación', 'Error');

                                }
                            },

                            error: function() {
                                toastr.error('Error al actualizar la clasificación', 'Error');
                            }
                        });
                    }
                    // FORMULARIOS



                    $('#myForm').validate({
                        rules: {
                            numero_equipos: {
                                required: true,
                                number: true,
                                maxlength: 2, // Corregido (antes era maxlenght)
                                max: 99,
                                min: 1
                            },
                            id: {
                                required: true
                            }
                        },
                        messages: {
                            numero_equipos: {
                                required: "Campo requerido",
                                number: "Solo se permiten números",
                                maxlength: "Máximo 2 dígitos", // Corregido (antes era maxlenght)
                                max: "Máximo 99 equipos",
                                min: "Mínimo 1 equipo"
                            }
                        },
                        submitHandler: function(form) {

                            let formData = new FormData(form);

                            Swal.fire({
                                title: '¿ Esta seguro de configurar este numero de equipos ?',
                                text: `No se podrá modificar despues y se crearan los equipos correspondientes`,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#000000',
                                cancelButtonColor: '#f97316',
                                confirmButtonText: 'Si, confirmar!',
                                cancelButtonText: 'Cancelar',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url: '/sorteo/numero-equipos',
                                        type: 'POST',
                                        data: formData,
                                        contentType: false,
                                        processData: false,
                                        success: function(response) {
                                            if (response.success) {
                                                Swal.fire({
                                                    title: response.message,
                                                    text: `Se ha configurado el numero de equipos, ahora vamos a clasificar los jugadores`,
                                                    icon: "success",
                                                    confirmButtonColor: '#3085d6',

                                                });

                                                setTimeout(() => {
                                                    location.reload();
                                                }, 2500)

                                            } else {
                                                response.errors.forEach((el) => {
                                                    toastr.error(el, 'Atencion');

                                                })
                                            }
                                        },
                                        error: function(xhr, status, error) {
                                            toastr.error('¡Se produjo el error!' + error,
                                                'Intenta mas tarde');
                                        }
                                    });


                                }

                            });

                        }
                    });

                    $(document).on('click', '#btnIncludePlayers', function() {
                        if (sorteo_id && jugadores.length > 0) {
                            data = {
                                'jugadores': jugadores,
                                'sorteo_id': sorteo_id
                            };

                            Swal.fire({
                                title: '¿ Esta seguro de incluir estos jugadores al sorteo ?',
                                text: `Se incluiran ${jugadores.length} jugadores al sorteo`,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Si, confirmar!',
                                cancelButtonText: 'Cancelar',
                            }).then((result) => {
                                if (result.isConfirmed) {

                                    Swal.fire({
                                        title: 'Procesando...',
                                        text: 'Por favor, espera...',
                                        allowOutsideClick: false, // Evita que se cierre haciendo clic fuera
                                        didOpen: () => {
                                            Swal.showLoading(); // Muestra el spinner de carga
                                        }
                                    });
                                    $.ajax({
                                        url: `/sorteo/add/players`,
                                        type: 'POST',
                                        data: JSON.stringify(data), // Convertimos a JSON
                                        contentType: 'application/json',
                                        processData: false,
                                        success: function(response) {
                                            if (response.success) {
                                                setTimeout(() => {
                                                    Swal
                                                        .close(); // 🔴 Cierra el loader después de unos segundos

                                                    // Muestra el mensaje de éxito después de cerrar el loader
                                                    Swal.fire({
                                                        title: 'Jugadores incluidos!',
                                                        text: response.message,
                                                        icon: 'success',
                                                        timer: 2500,
                                                        showConfirmButton: false
                                                    });

                                                    // Recargar la DataTable después de un pequeño retraso
                                                    setTimeout(() => {
                                                        location.reload();
                                                    }, 2600);

                                                }, 2500);
                                            } else {
                                                response.errors.forEach((el) => {
                                                    toastr.error(el, 'Atencion');

                                                })
                                            }

                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            toastr.error('¡Se produjo el error!' + errorThrown,
                                                'Intenta mas tarde');

                                        }
                                    });


                                }
                            })

                        } else {
                            toastr.error('Seleccione al menos un jugador', 'Atencion');
                            return
                        }

                    });







                });



                document.addEventListener('click', (e) => {

                    if (e.target.matches('#bntFinishSelection') || e.target.closest('#bntFinishSelection')) {
                        let sorteo_id = e.target.dataset.id;
                        var table = $('#tablaPlayers').DataTable();
                        var totalFilas = table.rows().count();

                        if (sorteo_id && totalFilas > 10) {

                            Swal.fire({
                                title: '¿ Esta seguro de terminar la seleccion de jugadores ?',
                                text: `No podra ingresar mas jugadores al torneo. Al momento tiene ${parseInt(totalFilas)} jugadores ¿Desea continuar?`,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Si, confirmar!',
                                cancelButtonText: 'Cancelar',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url: `/finish/selection/${sorteo_id}`,
                                        type: 'GET',
                                        success: function(response) {
                                            Swal.fire(
                                                'Seleccion Finalizada con éxito!',
                                                'Ahora deberá ingresar los equipos.',
                                                'success',
                                            )
                                            setTimeout(() => {
                                                location.reload();
                                            }, 2500)

                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            toastr.error('¡Se produjo el error!' + error,
                                                'Intenta mas tarde');

                                        }
                                    });


                                }
                            })
                        } else {
                            toastr.error('Seleccione al menos 10 jugadores', 'Atencion');
                            return
                        }


                    }
                    if (e.target.matches('.btnEliminar') || e.target.closest('.btnEliminar')) {

                        let torneo_id = e.target.dataset.id;
                        Swal.fire({
                            title: '¿ Esta seguro de eliminar este jugador del sorteo ?',
                            text: "Al confirmar, el jugador será eliminado permanentemente de este sorteo. ¿Desea continuar?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Si, confirmar!',
                            cancelButtonText: 'Cancelar',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: `/jugador/delete/${torneo_id}`,
                                    type: 'GET',
                                    success: function(response) {
                                        Swal.fire({
                                            title: 'Jugador Eliminado Correctamente',
                                            text: 'El jugador ha sido eliminado correctamente, tendras que volver a agregarlo en el sorteo',
                                            icon: "success",
                                            confirmButtonColor: '#f97316',

                                        });
                                        setTimeout(() => {
                                            location.reload();
                                        }, 2500)

                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        toastr.error('¡Se produjo el error! ' + textStatus,
                                            'Intenta mas tarde');

                                    }
                                });


                            }
                        })

                    }
                    if (e.target.matches('#btnValidateClasificacion') || e.target.closest('#btnValidateClasificacion')) {
                        let sorteo_id = e.target.dataset.id;
                        if (sorteo_id) {
                            $('#tablaPlayers').DataTable().ajax.reload(null, false);
                            Swal.fire({
                                title: '¿ Esta seguro de validar los jugadores ?',
                                text: "Se validará la clasificación de los jugadores este acorde con el # de equipos. ¿Desea continuar?",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Si, confirmar!',
                                cancelButtonText: 'Cancelar',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url: `/sorteo/validate/${sorteo_id}`,
                                        type: 'GET',
                                        success: function(response) {

                                            if (response.success) {

                                                Swal.fire({
                                                    title: 'Clasificación Validada Correctamente',
                                                    text: '¡Es momento de realizar el sorteo! 🥳',
                                                    icon: "success",
                                                    confirmButtonColor: '#f97316',

                                                });
                                                setTimeout(() => {
                                                    location.reload();
                                                }, 2500)

                                            } else {
                                                toastr.error('¡Se produjo la inconsistencia ! ' +
                                                    response.message,
                                                    'Corrigelo y vuelva a intentarlo', {
                                                        timeOut: 5000
                                                    });


                                            }


                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            toastr.error('¡Se produjo el error! ' + textStatus,
                                                'Intenta mas tarde');

                                        }
                                    });


                                }
                            })

                        }

                    }
                    if (e.target.matches('#btnRepeat') || e.target.closest('#btnRepeat')) {
                        location.reload();

                    }
                    if (e.target.matches('#btnDescargar') || e.target.closest('#btnDescargar')) {
                        captureTablesToPDF();

                    }
                    if (e.target.matches('.divFinal') || e.target.closest('.divFinal')) {
                        setInterval(crearBalon, 200);

                    }
                    if (e.target.matches('#btnFinalizar') || e.target.closest('#btnFinalizar')) {
                        const datos = JSON.parse(localStorage.getItem("equipos"));
                        var sorteo_id = "{{ $sorteo->id }}";
                        const requestData = {
                            id: parseInt(sorteo_id),
                            equipos: datos
                        };
                        if (datos) {

                            Swal.fire({
                                title: '¿ Esta seguro de finalizar este sorteo  ?',
                                text: "Se cerrara el sorteo y se guardará la configuración . ¿Desea continuar?",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Si, confirmar!',
                                cancelButtonText: 'Cancelar',
                            }).then((result) => {
                                if (result.isConfirmed) {

                                    $.ajax({
                                        url: `/sorteo/finalizar`,
                                        type: 'POST',
                                        data: JSON.stringify(requestData),
                                        contentType: 'application/json',
                                        processData: false,
                                        success: function(response) {

                                            if (response.success) {

                                                Swal.fire({
                                                    title: 'Sorteo Cerrado exitosamente',
                                                    text: 'Hasta pronto',
                                                    icon: "success",
                                                    confirmButtonColor: '#f97316',

                                                });
                                                setTimeout(() => {
                                                    location.href = '/sorteo'
                                                }, 2000)

                                            } else {
                                                toastr.error('¡Se produjo un error ! ' +
                                                    response.message,
                                                    'Intenta mas tarde', {
                                                        timeOut: 3000
                                                    });


                                            }


                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            toastr.error('¡Se produjo el error! ' + textStatus,
                                                'Intenta mas tarde');

                                        }
                                    });


                                }
                            })
                        }



                    }
                    if (e.target.matches('#btnSorteo') || e.target.closest('#btnSorteo')) {
                        let sorteo_id = e.target.dataset.id;
                        Swal.fire({
                            title: 'Sorteando los equipos...⚽⚽',
                            text: '¡La suerte está echada! 🎲🔥 Prepárate para conocer a tu equipo. 🎉',
                            allowOutsideClick: false, // Evita que se cierre haciendo clic fuera
                            didOpen: () => {
                                Swal.showLoading(); // Muestra el spinner de carga
                            }
                        });
                        $.ajax({
                            url: `/sorteo/create/${sorteo_id}`,
                            type: 'GET',
                            success: function(response) {
                                if (response.success) {
                                    toastr.success(response.message, 'Éxito');
                                    var tabla = $('#tablaPlayers').DataTable();
                                    $('#tablaPlayers').parent().hide();
                                    tabla.destroy();
                                    $('.containerTable').addClass('hidden')
                                    localStorage.removeItem('equipos');
                                    localStorage.setItem('equipos', JSON.stringify(response.equipos));
                                    setTimeout(() => {
                                        Swal.close();
                                        renderizarEquipos(response.equipos);
                                        setInterval(crearBombita, 200);
                                        setInterval(crearBalon, 200);



                                    }, 4000)



                                } else {
                                    Swal.close();
                                    toastr.error(response.message, 'Error');
                                    return;

                                }


                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                Swal.close();
                                toastr.error('¡Se produjo el error! ' + textStatus,
                                    'Intenta mas tarde');

                            }
                        });

                    }

                    function renderizarEquipos(equipos) {
                        let container = document.getElementById('equiposContainer');
                        container.innerHTML = '';
                        let buttonsHTML = `
                    <div class="w-full flex justify-center gap-4 mb-4 animate__animated animate__fadeInDown">
                        <button class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 transition" id="btnRepeat">Sortear de nuevo</button>
                        <button class="px-4 py-2 bg-green-500 text-white rounded-lg shadow-md hover:bg-green-600 transition" id="btnFinalizar">Finalizar</button>
                        <button class="px-4 py-2 bg-orange-500 text-white rounded-lg shadow-md hover:bg-orange-600 transition" id="btnDescargar">Descargar</button>
                    </div>
                `;

                        container.innerHTML = buttonsHTML;

                        Object.values(equipos).forEach((equipo, index) => {

                            let jugadoresHTML = equipo.jugadores.map((jugador, id) => `
            <tr>
                <td class="border px-4 py-2 text-center">${id + 1}</td>
                <td class="border px-4 py-2 text-center">${jugador.nombre}</td>
                <td class="border px-4 py-2 text-center">${jugador.clasificacion}</td>
            </tr>
        `).join('');

                            let equipoHTML = `
            <div class="animate__animated animate__fadeInUp divTablas">
                <div class="bg-white shadow-lg rounded-lg p-4">
                    <h2 class="text-lg font-bold text-center mb-2">Equipo ${index + 1}</h2>
                    <table class="table-auto w-full border-collapse border border-gray-200">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2" styre="width: 5%">#</th>
                                <th class="border px-4 py-2">Jugador</th>
                                <th class="border px-4 py-2">Clasificación</th>
                            </tr>
                        </thead>
                        <tbody>${jugadoresHTML}</tbody>
                    </table>
                </div>
            </div>
        `;

                            container.innerHTML += equipoHTML;
                        });
                    }

                    function crearBombita() {
                        const bombita = document.createElement("div");
                        bombita.classList.add("bombita");

                        // Colores aleatorios
                        const colores = ["bg-red-500", "bg-blue-500", "bg-green-500", "bg-yellow-500", "bg-orange-500",
                            "bg-purple-500"
                        ];
                        bombita.classList.add(colores[Math.floor(Math.random() * colores.length)]);

                        // Posición aleatoria
                        bombita.style.left = `${Math.random() * 100}vw`;
                        bombita.style.setProperty('--randX', Math.random());

                        document.getElementById("confettiContainer").appendChild(bombita);

                        // Elimina después de la animación
                        setTimeout(() => {
                            bombita.remove();
                        }, 3000);
                    }

                    function crearBalon() {
                        const balon = document.createElement("div");
                        balon.classList.add("balon");

                        // Posición aleatoria
                        balon.style.left = `${Math.random() * 100}vw`;
                        balon.style.setProperty('--randX', Math.random());

                        document.getElementById("confettiContainer").appendChild(balon);

                        // Elimina después de la animación
                        setTimeout(() => {
                            balon.remove();
                        }, 3000);
                    }

                    // Generar bombitas cada 300ms
                    //setInterval(crearBombita, 200);

                    function captureTablesToPDF() {
                        const tables = document.querySelectorAll(".divTablas");
                        const {
                            jsPDF
                        } = window.jspdf;
                        const pdf = new jsPDF("p", "mm", "a4");
                        let yPosition = 10;

                        const captureTable = (table) => {
                            return domtoimage.toPng(table, {
                                quality: 1
                            }).then(dataUrl => {
                                return new Promise((resolve) => {
                                    const img = new Image();
                                    img.src = dataUrl;
                                    img.onload = () => {
                                        let imgWidth = 150;
                                        let imgHeight = (img.height * imgWidth) / img.width;

                                        // Ajustamos el tamaño si la imagen es muy alta
                                        if (imgHeight > 180) {
                                            const scale = 180 / imgHeight;
                                            imgHeight *= scale;
                                            imgWidth *= scale;
                                        }

                                        // Si la imagen no cabe, agregamos una nueva página
                                        if (yPosition + imgHeight > 280) {
                                            pdf.addPage();
                                            yPosition = 10;
                                        }

                                        pdf.addImage(img, "PNG", 10, yPosition, imgWidth,
                                        imgHeight);
                                        yPosition += imgHeight + 10;
                                        resolve();
                                    };
                                });
                            }).catch(error => console.error("Error al capturar la tabla:", error));
                        };

                        Promise.all([...tables].map(captureTable))
                            .then(() => pdf.save("Sorteo-vital-fut.pdf"));
                    }



                });
            </script>
        @endpush

</x-app-layout>
