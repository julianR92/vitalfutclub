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
                            <x-titulo titulo="Crear Sorteo"></x-titulo>
                        </div>

                        <form class="w-full max-w-full p-2" id="myForm">



                            <div class="flex flex-wrap mt-3">
                                <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                                    <x-jet-label for="sede_id" value="Sede" />
                                    <select
                                        class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                        name="sede_id" id="sede_id" required>
                                        <option value="">Seleccione..</option>
                                        @foreach ($sedes as $sede)
                                            <option value="{{ $sede->id }}">{{ $sede->nombre_sede }}
                                            </option>
                                        @endforeach

                                    </select>
                                    <x-jet-input-error for="sede_id" class="mt-2" />
                                </div>

                                <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                                    <x-jet-label for="descripcion" value="Descripcion" />
                                    <input type="text" id="descripcion" placeholder="1er Sorteo de ..."
                                        name="descripcion"
                                        class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                        required />
                                    <x-jet-input-error for="descripcion" class="mt-2" />
                                </div>

                                <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0" style="margin-top: 25px;">
                                    <x-jet-button
                                        class="bg-green-600 hover:bg-green-700 text-white hover:text-white mr-2">
                                        Guardar
                                    </x-jet-button>
                                </div>

                            </div>
                        </form>

                    </div>
                </section>
            </div>
        </div>
    </div>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <section class="bg-white dark:bg-gray-900">
                    <div class="container px-6 py-7 mx-auto">
                        <div class="bg-slate-100/50 py-1 px-3 border-solid border-b rounded-lg">
                            <x-titulo titulo="Sorteos Activos VitalFut"></x-titulo>
                        </div>
                        <br>


                        <div class="grid grid-cols-1 mt-4 xl:mt-2 md:grid-cols-2 xl:grid-cols-1 div-principal">
                            <table class="cell-border compact stripe tabla" id="tabla" width="100%" style="display: none">

                            </table>

                        </div>
                        <div class="mt-3">
                            <a href="/" style="color: dodgerblue; text-decoration: underline ">Atras</a>

                        </div>
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
                        url: '/sorteo/getData',
                        type: 'GET'
                    },

                    columns: [{
                            data: null, // No se asocia a un dato específico
                            title: '#', // Título de la columna
                            className: 'flex item-center justify-center',
                            orderable: false, // No ordenable
                            render: function(data, type, row, meta) {
                                return meta.row + 1; // meta.row es el índice de la fila (0-based)
                            }
                        },

                        {
                            data: null,
                            title: 'Sede',
                            className: 'justify-center',
                            orderable: true,
                            render: function(data, type, row) {
                                return `${row.sede.nombre_sede}`
                            }

                        },
                        {
                            data: null,
                            title: 'Sorteo',
                            className: 'p-2',
                            orderable: true,
                            render: function(data, type, row) {
                                return `
                            <a href="/sorteo/data/${row.id}" >
                            <div class="flex item-center justify-center" style="color: dodgerblue; text-decoration: underline ">
                                <p>${row.descripcion} | ${row.sede.nombre_sede}</p>
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

            $('#myForm').validate({
                rules: {
                    sede_id: {
                        required: true
                    },
                    descripcion: {
                        required: true,
                    },

                },
                messages: {
                    sede_id: {
                        required: "Campo Requerido"
                    },
                    descripcion: {
                        required: "Campo Requerido",

                    },


                },
                submitHandler: function(form) {

                    let formData = new FormData(form);
                    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

                    Swal.fire({
                        title: '¿ Esta seguro de crear este sorteo ?',
                        text: `Se creara el sorteo y despues podrá gestionarlo`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#000000',
                        cancelButtonColor: '#f97316',
                        confirmButtonText: 'Si, confirmar!',
                        cancelButtonText: 'Cancelar',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '/sorteo/store',
                                type: 'POST',
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire({
                                            title: 'Sorteo creado',
                                            text: response.message,
                                            icon: "success",
                                            confirmButtonColor: '#3085d6',

                                        });

                                        setTimeout(() => {
                                            location.href = '/sorteo';
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

            //form sedes

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
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
                        text: "Al confirmar, el sorteo será eliminado permanentemente y no podrá gestionarlo. ¿Desea continuar?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, confirmar!',
                        cancelButtonText: 'Cancelar',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: `/sorteo/delete/${torneo_id}`,
                                type: 'GET',
                                success: function(response) {
                                    Swal.fire({
                                        title: 'Sorteo Eliminado Correctamente',
                                        text: 'Este sorteo ya quedó en la historia de vitalFut',
                                        icon: "success",
                                        confirmButtonColor: '#f97316',

                                    });
                                    setTimeout(() => {
                                        location.reload();
                                    }, 2500)

                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    toastr.error('¡Se produjo el error! ' +  textStatus,
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
