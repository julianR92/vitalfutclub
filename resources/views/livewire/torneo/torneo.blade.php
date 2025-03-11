<x-app-layout>
    <style>
        .modal {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            opacity: 0;
            visibility: hidden;
            transform: scale(1.1);
            transition: visibility 0s linear 0.25s, opacity 0.25s 0s, transform 0.25s;
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 1rem 1.5rem;
            width: 90%;
            /* Cambiar a un porcentaje */
            max-width: 600px;
            /* Establecer un ancho máximo */
            border-radius: 0.5rem;
        }

        .close-button {
            float: right;
            width: 1.5rem;
            line-height: 1.5rem;
            text-align: center;
            cursor: pointer;
            border-radius: 0.25rem;
            background-color: lightgray;
        }

        .close-button:hover {
            background-color: darkgray;
        }

        .show-modal {
            opacity: 1;
            visibility: visible;
            transform: scale(1.0);
            transition: visibility 0s linear 0s, opacity 0.25s 0s, transform 0.25s;
        }

        /* MODAL 2 */
        .modal2 {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            opacity: 0;
            visibility: hidden;
            transform: scale(1.1);
            transition: visibility 0s linear 0.25s, opacity 0.25s 0s, transform 0.25s;
        }

        .modal-content2 {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 1rem 1.5rem;
            width: 60%;
            /* Cambiar a un porcentaje */
            max-width: 450px;
            /* Establecer un ancho máximo */
            border-radius: 0.5rem;
        }

        .close-button2 {
            float: right;
            width: 1.5rem;
            line-height: 1.5rem;
            text-align: center;
            cursor: pointer;
            border-radius: 0.25rem;
            background-color: lightgray;
        }

        .close-button2:hover {
            background-color: darkgray;
        }

        .show-modal2 {
            opacity: 1;
            visibility: visible;
            transform: scale(1.0);
            transition: visibility 0s linear 0s, opacity 0.25s 0s, transform 0.25s;
        }

        @media (max-width: 600px) {
            .modal-content2 {
                padding: 0.5rem;
                /* Reducir padding */
                width: 98%;
                /* Hacerlo casi completo */
            }
        }

        .error {
            color: red;
            font-size: 0.875rem;
            /* Tamaño de fuente */
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />



    <meta name="csrf-token" content="{{ csrf_token() }}">


    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <section class="bg-white dark:bg-gray-900">
                    <div class="container px-6 py-7 mx-auto">
                        <div class="bg-slate-100/50 py-1 px-3 border-solid border-b rounded-lg">
                            <x-titulo
                                titulo="{{ $torneo->numero }} {{ $torneo->nombre }} {{ $torneo->año }} - {{ $torneo->ciudad }}"></x-titulo>
                        </div>
                        <div class="grid grid-cols-1 mt-4 xl:mt-4 md:grid-cols-1 xl:grid-cols-1 justify-items-end"
                            style="margin-bottom: 15px;">
                            <x-jet-secondary-button
                                class="bg-black hover:bg-gray-700 text-white hover:text-white trigger">
                                Agregar Jugador
                            </x-jet-secondary-button>
                        </div>

                        <div class="grid grid-cols-1 mt-4 xl:mt-2 md:grid-cols-2 xl:grid-cols-1 div-principal">
                            <table class="cell-border compact stripe tabla" id="tabla" width="100%">

                            </table>

                        </div>
                        <div class="mt-3">
                            <a href="/torneos" style="color: dodgerblue; text-decoration: underline ">Atras</a>

                        </div>
                </section>
            </div>
        </div>
    </div>


    <div class="modal2">
        <div class="modal-content2">
            <span class="close-button2">×</span>

            <form class="w-full max-w-full p-2" id="myForm">

                <div class="text-center sm:text-left">
                    <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-sedes">
                        Agregar Jugador
                    </h3>
                    <hr>
                    <hr>
                </div>

                <div class="flex flex-wrap mt-3">
                    <div class="w-full md:w-3/3 px-1 mb-2 md:mb-0">
                        <x-jet-label for="jugador_id" value="Jugadores" />
                        <select
                            class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            name="jugador_id" id="jugador_id">
                            <option value="">Seleccione..</option>
                            @foreach ($personas as $item)
                                <option value="{{ $item['id'] }}">{{ $item['nombres'] }} {{ $item['apellidos'] }} |
                                    {{ $item['documento'] }}</option>
                            @endforeach

                        </select>
                        <x-jet-input-error for="jugador_id" class="mt-2" />
                    </div>

                </div>




                <div class="flex md:justify-end xl:justify-end justify-center mt-4" style="margin-top: 30px!important;">
                    <input type="hidden" id="torneo_id" name="torneo_id" value="{{ $torneo->id }}" />
                    <x-jet-button class="bg-green-600 hover:bg-green-700 text-white hover:text-white mr-2">
                        Guardar
                    </x-jet-button>
                    <x-jet-secondary-button class="bg-gray-500 hover:bg-gray-700 text-white hover:text-white"
                        onclick="cerrar2()">
                        Cerrar
                    </x-jet-secondary-button>
                </div>
            </form>
        </div>
    </div>

    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>




        <script>
            //abrir modal

            var trigger = document.querySelector(".trigger");



            // MODAL-2
            var modal2 = document.querySelector(".modal2");
            var closeButton2 = document.querySelector(".close-button2");

            function toggleModal2() {
                modal2.classList.toggle("show-modal2");
            }

            function windowOnClick2(event) {
                if (event.target === modal) {
                    toggleModal2();
                }
            }
            trigger.addEventListener("click", toggleModal2);
            closeButton2.addEventListener("click", toggleModal2);
            window.addEventListener("click", windowOnClick2);


            function cerrar2() {
                toggleModal2();
                $('#jugador_id').val(null).trigger('change');

            }

            $(document).ready(function() {

                $('#jugador_id').select2({
                    placeholder: "Selecciona un jugador",
                    allowClear: true
                })

                var torneo_id = @json($torneo->id);
                $('#tabla').DataTable({
                    destroy: true,
                    processing: true,
                    responsive: true,
                    //  serverSide: true,
                    ajax: {
                        url: `/torneo/loadData/${torneo_id}`,
                        type: 'GET'
                    },

                    columns: [{
                            data: null, // No se asocia a un dato específico
                            title: '#', // Título de la columna
                            className: 'p-2',
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
                            data: 'fecha_fin',
                            title: 'Fecha Fin',
                            className: 'p-2',
                            orderable: true,
                            render: function(data) {
                                return data ? data :
                                    'Sin plan activo';
                            }
                        },
                        {
                            data: null,
                            title: 'Acciones',
                            className: 'p-3 text-center',
                            orderable: false,
                            render: function(data, type, row) {
                                return `
                		<div class="flex item-center justify-center">
                			
                        <button data-id="${row.id}" class="w-4 mx-2 transform hover:text-blue-800 hover:scale-125 btnEliminar">
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
                    rowCallback: function(row, data, index) {
                        // Obtener la fecha de 'fecha_fin'
                        const fechaFin = data.fecha_fin;

                        // Obtener la fecha actual
                        const fechaActual = new Date();

                        if (!fechaFin || fechaFin.trim() === "") {
                            // Si 'fecha_fin' es nulo o vacío, colorear la fila de rojo
                            $(row).css('background-color', '#e74c3c');
                        } else {
                            // Convertir 'fecha_fin' a un objeto Date
                            const fechaFinDate = new Date(fechaFin);
                            const diferenciaDias = (fechaFinDate - fechaActual) / (1000 * 60 * 60 *
                                24); // Diferencia en días

                            if (diferenciaDias <= 0) {
                                $(row).css('background-color', '#e74c3c');
                            }
                            if (diferenciaDias > 0 && diferenciaDias < 5) {
                                $(row).css('background-color', 'orange');
                            }
                        }
                    },
                    scrollX: true,
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
                    pageLength: 25,

                });

                

                $('#myForm').validate({
                    rules: {
                        jugador_id: {
                            required: true
                        },
                        torneo_id: {
                            required: true,

                        },

                    },
                    messages: {
                        jugador_id: {
                            required: "Campo Requerido"
                        },
                        id: {
                            required: "Campo Requerido",
                        },

                    },
                    submitHandler: function(form) {

                        let formData = new FormData(form);
                        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

                        Swal.fire({
                            title: '¿ Esta seguro de agregar este jugador?',
                            text: "Al confirmar, el jugador será agregado a este torneo. ¿Desea continuar?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Si, confirmar!',
                            cancelButtonText: 'Cancelar',
                        }).then((result) => {
                            if (result.isConfirmed) {

                                $.ajax({
                                    url: '/jugador/store',
                                    type: 'POST',
                                    data: formData,
                                    contentType: false,
                                    processData: false,
                                    success: function(response) {
                                        if (response.success) {
                                            toggleModal2();
                                            Swal.fire({
                                                title: response.message,
                                                text: response.addMessage,
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
                        })
                    }
                });

                //         //form sedes

                //         $.ajaxSetup({
                //         headers: {
                //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //         }
                //    });

                //     $('#myFormSedes').submit(function(event) {
                //         event.preventDefault(); // Evitar el envío tradicional del formulario

                //         const sedesSeleccionadas = $('#sede_id').val()|| [];
                //         let user_id = document.getElementById('user_id').value
                //         $.ajax({
                //             url: '/sedes/users', // Reemplaza con tu URL de destino
                //             type: 'POST',
                //             data: {
                //                 sedes: sedesSeleccionadas,
                //                 user_id: user_id
                //             },
                //             success: function(response) {
                //                 if (response.success){
                //                             toggleModal2();
                //                             Swal.fire({
                //                             title: response.message,
                //                             text: 'Operación Exitosa',
                //                             icon: "success"
                //                             });

                //                             setTimeout(() => {
                //                     location.reload();
                //                 }, 2500)

                //                         }  else {
                //                             response.errors.forEach((el) => {
                //                                 toastr.error(el ,'Atencion');

                //                             })
                //                         }

                //             },
                //             error: function(xhr, status, error) {
                //                 toastr.error('¡Se produjo el error!' + error, 'Intenta mas tarde');

                //             }
                //         });
                //     })



            });



            document.addEventListener('click', (e) => {
                // if (e.target.matches('.btnEditar') || e.target.closest('.btnEditar')) {
                //     let persona_id = e.target.dataset.persona
                //     let user_id = e.target.dataset.id
                //     $.ajax({
                //         url: `/users/edit/${persona_id}`,
                //         type: 'GET',
                //         success: function(response) {
                //             document.getElementById('modal-title').textContent = 'Editar Profe';
                //             document.getElementById('tipo_doc').value = response.data.tipo_doc;
                //             document.getElementById('documento').value = response.data.documento;
                //             document.getElementById('nombres').value = response.data.nombres;
                //             document.getElementById('apellidos').value = response.data.apellidos;
                //             document.getElementById('fecha_nacimiento').value = response.data
                //                 .fecha_nacimiento;
                //             document.getElementById('telefono').value = response.data.telefono;
                //             document.getElementById('correo').value = response.data.correo;
                //             document.getElementById('direccion').value = response.data.direccion;
                //             document.getElementById('id').value = response.data.id;
                //             modal.classList.toggle("show-modal");

                //         },
                //         error: function(jqXHR, textStatus, errorThrown) {
                //             toastr.error('¡Se produjo el error!' + errorThrown, 'Intenta mas tarde');

                //         }
                //     });
                //     // Livewire.emitTo('persona.modal', 'abrirModal', e.target.dataset.id);
                // }

                if (e.target.matches('.btnEliminar') || e.target.closest('.btnEliminar')) {
                    let id = e.target.dataset.id;
                    Swal.fire({
                        title: '¿ Esta seguro de eliminar este jugador del torneo ?',
                        text: "Al confirmar, el jugador será eliminado permanentemente de este torneo. ¿Desea continuar?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, confirmar!',
                        cancelButtonText: 'Cancelar',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: `/jugador/delete/${id}`,
                                type: 'GET',
                                success: function(response) {
                                    Swal.fire({
                                        title: 'Jugador Eliminado Correctamente',
                                        text: 'Este jugador ya no hace parte de este torneo',
                                        icon: "success",
                                        confirmButtonColor: '#f97316',

                                    });
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

                }


            });
        </script>
    @endpush

</x-app-layout>
