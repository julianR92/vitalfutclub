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
            width: 50%;
            /* Cambiar a un porcentaje */
            max-width: 400px;
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
                width: 95%;
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
                            <x-titulo titulo="Torneos Activos VitalFut"></x-titulo>
                        </div>
                        <div class="grid grid-cols-1 mt-4 xl:mt-4 md:grid-cols-1 xl:grid-cols-1 justify-items-end"
                            style="margin-bottom: 15px;">
                            <a href="/torneo/add"
                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition bg-black hover:bg-gray-700 text-white hover:text-white trigger">
                                Nuevo Torneo
                            </a>
                        </div>

                        <div class="grid grid-cols-1 mt-4 xl:mt-2 md:grid-cols-2 xl:grid-cols-1 div-principal">
                            <table class="cell-border compact stripe tabla" id="tabla" width="100%">

                            </table>

                        </div>
                        <div class="mt-3">
                            <a href="/" style="color: dodgerblue; text-decoration: underline ">Atras</a>

                        </div>
                </section>
            </div>
        </div>
    </div>



    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>




        <script>
            $(document).ready(function() {



                var rol = "{{ Auth::user()->rol }}";
                $('#tabla').DataTable({
                    destroy: true,
                    processing: true,
                    responsive: true,
                    //  serverSide: true,
                    ajax: {
                        url: '/torneo/getData',
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
                            data: null,
                            title: 'Torneo',
                            className: 'p-2',
                            orderable: true,
                            render: function(data, type, row) {
                                return `
                            <a href="/torneo/data/${row.id}" >
                            <div class="flex item-center justify-center" style="color: dodgerblue; text-decoration: underline ">
                                <p>${row.numero} ${row.nombre} ${row.año} - ${row.ciudad}</p>
                            </div>
                            </a>

                             `

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
                			
                			
                      <a href="/torneo/data/${row.id}" class="w-4 mx-2 transform hover:text-blue-800 hover:scale-125">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 72 72"><path fill="#FFF" d="M65 36c0 1.61-.13 3.19-.39 4.73c-.71 4.39-2.42 8.45-4.89 11.94v.01c-4.24 6.03-10.73 10.37-18.24 11.8a29.2 29.2 0 0 1-6.97.48h-.07c-.47-.03-.94-.06-1.41-.11c-.04 0-.08-.01-.12-.01q-.585-.06-1.17-.15c-.11-.02-.23-.03-.34-.05c-.3-.05-.59-.1-.89-.16c-.47-.09-.94-.19-1.41-.31c-.19-.04-.39-.09-.58-.14c-.26-.07-.52-.15-.78-.23c-.23-.07-.47-.14-.71-.22a8 8 0 0 1-.7-.24l-.57-.21c-.11-.03-.21-.07-.32-.12a31 31 0 0 1-2.7-1.23c-.23-.12-.45-.24-.68-.37c-.26-.14-.51-.28-.76-.43c-.28-.17-.56-.33-.84-.51c-.08-.05-.16-.11-.24-.16c-.39-.25-.78-.52-1.15-.79c-.32-.22-.63-.46-.93-.69a.5.5 0 0 1-.08-.07c-.27-.21-.53-.42-.78-.64c-.13-.1-.26-.21-.38-.32l-.29-.26c-.02-.01-.03-.02-.04-.03c-.03-.03-.06-.06-.09-.08c-.02-.01-.03-.03-.04-.04a.08.08 0 0 1-.04-.04a6 6 0 0 1-.37-.34c-.13-.12-.25-.23-.36-.35c-.02-.02-.04-.04-.05-.06c-.1-.1-.2-.19-.3-.28c-.152-.152-.292-.322-.44-.48l-.02-.02l.002.001c-.334-.354-.67-.705-.992-1.081c-.24-.28-.48-.57-.71-.87a28.9 28.9 0 0 1-5.8-13.26C7.12 39.11 7 37.57 7 36c0-6.17 1.92-11.89 5.22-16.59c3.19-4.58 7.68-8.19 12.93-10.3C28.5 7.74 32.16 7 36 7c3.83 0 7.49.74 10.83 2.1c2.52 1 4.86 2.36 6.97 4.02c.56.43 1.11.89 1.64 1.38h.01q.795.72 1.53 1.5c.75.77 1.44 1.58 2.09 2.44c.21.28.43.57.63.86v.01s0-.01.01 0c.5.69.97 1.42 1.39 2.17c.15.25.29.5.43.76c.17.31.33.61.47.92c.11.21.21.42.31.64c.16.32.3.64.43.96c.16.36.3.72.43 1.09c.11.28.21.56.3.85q.12.345.24.72c.1.32.19.64.28.96c.06.23.12.45.17.68c.18.71.33 1.42.44 2.15c.04.21.07.42.1.64c.05.32.09.65.12.97c.02.14.04.28.05.41c.03.35.06.7.07 1.06c.02.15.03.29.03.44c.02.42.03.84.03 1.27"/><path fill="#D0CFCE" d="M65 36c0 1.61-.13 3.19-.39 4.73c-.71 4.39-2.42 8.45-4.89 11.94v.01c-4.24 6.03-10.73 10.37-18.24 11.8a29.2 29.2 0 0 1-6.97.48h-.07c-.47-.03-.94-.06-1.41-.11c-.04 0-.08-.01-.12-.01q-.585-.06-1.17-.15c-.11-.02-.23-.03-.34-.05c-.3-.05-.59-.1-.89-.16c-.47-.09-.94-.19-1.41-.31c-.19-.04-.39-.09-.58-.14c-.26-.07-.52-.15-.78-.23c-.23-.07-.47-.14-.71-.22a8 8 0 0 1-.7-.24l-.57-.21c-.11-.03-.21-.07-.32-.12c-.39-.16-.78-.32-1.16-.49c-.26-.12-.52-.24-.77-.36c-.26-.12-.51-.25-.77-.38c-.23-.12-.45-.24-.68-.37c-.26-.14-.51-.28-.76-.43c-.28-.17-.56-.33-.84-.51c-.08-.05-.16-.11-.24-.16c-.39-.25-.78-.52-1.15-.79c-.32-.22-.63-.46-.93-.69a.5.5 0 0 1-.08-.07c-.27-.21-.53-.42-.78-.64a48 48 0 0 1-.84-.73a.08.08 0 0 1-.04-.04c-.26-.25-.53-.49-.78-.75c-.26-.26-.51-.52-.76-.78c3.99 2.34 8.6 3.77 13.52 3.95q.57.03 1.14.03c6.76 0 12.99-2.31 17.92-6.2c5.99-4.71 10.08-11.73 10.92-19.72c.11-1.01.16-2.04.16-3.08c0-2.07-.22-4.08-.63-6.02v-.01a28.9 28.9 0 0 0-7.15-13.73c1.06.63 2.09 1.33 3.06 2.08c.56.44 1.11.9 1.64 1.38c0 0 0-.01.01 0c.53.49 1.04.98 1.53 1.5c.98 1.03 1.9 2.14 2.72 3.31c.5.7.97 1.42 1.4 2.17c.15.25.29.5.43.76c.17.31.33.61.47.92c.11.21.21.42.31.64c.16.32.3.64.43.96c.16.36.3.72.43 1.09c.11.28.21.56.3.85q.12.345.24.72c.1.32.19.64.28.96c.06.23.12.45.17.68c.18.71.33 1.42.44 2.15c.04.21.07.42.1.64c.05.32.09.65.12.97c.02.14.04.28.05.41c.03.35.06.7.07 1.06c.02.15.03.29.03.44c.02.42.03.84.03 1.27"/><path fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2" d="M65 36c0 1.61-.13 3.19-.39 4.73c-.71 4.39-2.42 8.45-4.89 11.94v.01c-4.24 6.03-10.73 10.37-18.24 11.8a29.2 29.2 0 0 1-6.97.48h-.07c-.47-.03-.94-.06-1.41-.11c-.04 0-.08-.01-.12-.01q-.585-.06-1.17-.15c-.11-.02-.23-.03-.34-.05c-.3-.05-.59-.1-.89-.16c-.47-.09-.94-.19-1.41-.31c-.19-.04-.39-.09-.58-.14c-.26-.07-.52-.15-.78-.23c-.23-.07-.47-.14-.71-.22a8 8 0 0 1-.7-.24l-.57-.21c-.11-.03-.21-.07-.32-.12a31 31 0 0 1-2.7-1.23c-.23-.12-.45-.24-.68-.37c-.26-.14-.51-.28-.76-.43c-.28-.17-.56-.33-.84-.51c-.08-.05-.16-.11-.24-.16c-.39-.25-.78-.52-1.15-.79c-.32-.22-.63-.46-.93-.69a.5.5 0 0 1-.08-.07c-.27-.21-.53-.42-.78-.64c-.13-.1-.26-.21-.38-.32l-.29-.26c-.02-.01-.03-.02-.04-.03c-.03-.03-.06-.06-.09-.08c-.02-.01-.03-.03-.04-.04a.08.08 0 0 1-.04-.04a6 6 0 0 1-.37-.34c-.13-.12-.25-.23-.36-.35c-.02-.02-.04-.04-.05-.06c-.1-.1-.2-.19-.3-.28c-.152-.152-.292-.322-.44-.48l-.02-.02l.002.001c-.334-.354-.67-.705-.992-1.081c-.24-.28-.48-.57-.71-.87a28.9 28.9 0 0 1-5.8-13.26C7.12 39.11 7 37.57 7 36c0-6.17 1.92-11.89 5.22-16.59c3.19-4.58 7.68-8.19 12.93-10.3C28.5 7.74 32.16 7 36 7c3.83 0 7.49.74 10.83 2.1c2.52 1 4.86 2.36 6.97 4.02c.56.43 1.11.89 1.64 1.38h.01q.795.72 1.53 1.5c.75.77 1.44 1.58 2.09 2.44c.21.28.43.57.63.86v.01s0-.01.01 0c.5.69.97 1.42 1.39 2.17c.15.25.29.5.43.76c.17.31.33.61.47.92c.11.21.21.42.31.64c.16.32.3.64.43.96c.16.36.3.72.43 1.09c.11.28.21.56.3.85q.12.345.24.72c.1.32.19.64.28.96c.06.23.12.45.17.68c.18.71.33 1.42.44 2.15c.04.21.07.42.1.64c.05.32.09.65.12.97c.02.14.04.28.05.41c.03.35.06.7.07 1.06c.02.15.03.29.03.44c.02.42.03.84.03 1.27"/><path d="m34.237 28.073l-6.156 4.472a3 3 0 0 0-1.09 3.354l2.352 7.236a3 3 0 0 0 2.853 2.073h7.608a3 3 0 0 0 2.854-2.073l2.35-7.236a3 3 0 0 0-1.09-3.354l-6.155-4.472a3 3 0 0 0-3.526 0M46.28 10.18l-8.41 4.12c-.59.28-1.23.42-1.87.41c-.57-.01-1.14-.14-1.68-.39l-8.61-4.1c-.42-.2-.64-.67-.56-1.11C28.5 7.74 32.16 7 36 7c3.83 0 7.49.74 10.83 2.1c.08.43-.13.88-.55 1.08m-15.77 54.3c-.47-.09-.94-.19-1.41-.31c-.19-.04-.39-.09-.58-.14c-.26-.07-.52-.15-.78-.23c-.23-.07-.47-.14-.71-.22a8 8 0 0 1-.7-.24l-.57-.21c-.11-.03-.21-.07-.32-.12c-.39-.16-.78-.32-1.16-.49c-.522-.23-1.033-.48-1.539-.741q-.343-.178-.681-.366q-.385-.21-.76-.433a29 29 0 0 1-.84-.508l-.242-.161a29 29 0 0 1-7.988-7.691c.19-.34.58-.55 1.01-.5l9.34 1.14c.64.08 1.24.3 1.76.65c.49.33.91.76 1.22 1.27l2.82 4.59l2.19 3.58c.22.36.19.81-.06 1.13M15.16 31.37a4.2 4.2 0 0 1-.79 1.61l-5.9 7.3c-.28.34-.73.46-1.11.33C7.12 39.11 7 37.57 7 36c0-6.17 1.92-11.89 5.22-16.59c.42.05.79.35.88.79l2.08 9.33c.14.61.13 1.24-.02 1.84m44.56 21.3v.01c-4.24 6.03-10.73 10.37-18.24 11.8c-.26-.32-.29-.78-.07-1.15l4.99-8.14a4.1 4.1 0 0 1 2.98-1.92l9.31-1.14c.44-.05.84.18 1.03.54M65 36c0 1.61-.13 3.19-.39 4.73a1 1 0 0 1-1-.35l-5.25-6.5l-.73-.9a4.04 4.04 0 0 1-.8-3.45l1.06-4.75v-.01l1.04-4.69c.08-.39.39-.69.77-.77c0-.01 0-.01.01 0c.5.69.97 1.42 1.39 2.17c.15.25.29.5.43.76c.17.31.33.61.47.92c.11.21.21.42.31.64c.16.32.3.64.43.96c.16.36.3.72.43 1.09c.11.28.21.56.3.85q.12.345.24.72c.1.32.19.64.28.96c.06.23.12.45.17.68c.18.71.33 1.42.44 2.15c.04.21.07.42.1.64c.05.32.09.65.12.97c.02.14.04.28.05.41c.03.35.06.7.07 1.06c.02.15.03.29.03.44c.02.42.03.84.03 1.27"/><path fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2" d="M36 14.712V27.5m8.989 6.49l11.824-2.663m-15.222 13.29l6.047 9.296m-17.244-9.307l-6.051 9.307m2.658-19.894l-11.837-2.646"/></svg>
                        </a>

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




            });



            document.addEventListener('click', (e) => {
                //         if (e.target.matches('.btnEditar')|| e.target.closest('.btnEditar')) {
                //             let persona_id =e.target.dataset.persona
                //             let user_id =e.target.dataset.id
                //             $.ajax({
                //             url: `/users/edit/${persona_id}`,
                //             type: 'GET',
                //             success: function(response) {                        
                //             document.getElementById('modal-title').textContent = 'Editar Profe';
                //             document.getElementById('tipo_doc').value = response.data.tipo_doc;
                //             document.getElementById('documento').value = response.data.documento;
                //             document.getElementById('nombres').value = response.data.nombres;
                //             document.getElementById('apellidos').value = response.data.apellidos;
                //             document.getElementById('fecha_nacimiento').value = response.data.fecha_nacimiento;
                //             document.getElementById('telefono').value = response.data.telefono;
                //             document.getElementById('correo').value = response.data.correo;
                //             document.getElementById('direccion').value = response.data.direccion;
                //             document.getElementById('id').value = response.data.id;
                //             modal.classList.toggle("show-modal");

                //           },
                //              error: function(jqXHR, textStatus, errorThrown) {
                //              toastr.error('¡Se produjo el error!' + errorThrown, 'Intenta mas tarde');

                //     }
                // });
                //             // Livewire.emitTo('persona.modal', 'abrirModal', e.target.dataset.id);
                //         }

                if (e.target.matches('.btnEliminar') || e.target.closest('.btnEliminar')) {
                    let torneo_id = e.target.dataset.id;
                    Swal.fire({
                        title: '¿ Esta seguro de eliminar este torneo ?',
                        text: "Al confirmar, el torneo será eliminado permanentemente y no podrá gestionarlo. ¿Desea continuar?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, confirmar!',
                        cancelButtonText: 'Cancelar',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: `/torneo/delete/${torneo_id}`,
                                type: 'GET',
                                success: function(response) {
                                    Swal.fire({
                                        title: 'Torneo Eliminado Correctamente',
                                        text: 'Este torneo ya quedó en la historia de vitalFut',
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
                // if (e.target.matches('.btnCancha') || e.target.closest('.btnCancha')) {
                //     let user_id = e.target.dataset.id;
                //     $.ajax({
                //     url: `/users/getSedes/${user_id}`,
                //     type: 'GET',
                //     success: function(response) {
                //         $('#sede_id').val('').trigger('change');
                //         if(response.data.sedes.length>0){
                //             const sedesSeleccionadas = response.data.sedes.map(sede => sede.id);
                //             $('#sede_id').val(sedesSeleccionadas).trigger('change');
                //         }
                //         document.getElementById('profesor_name').textContent= response.data.user.name
                //         document.getElementById('user_id').value= response.data.user.id
                //         toggleModal2();                         

                //        },
                //      error: function(jqXHR, textStatus, errorThrown) {
                //      toastr.error('¡Se produjo el error!' + errorThrown, 'Intenta mas tarde');

                //   }
                // });

                // }

            });
        </script>
    @endpush

</x-app-layout>
