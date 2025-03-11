<x-app-layout>
    <style>
        .bg-green-soft {
            background-color: #a3e4d7 !important;
            /* Color verde suave */
        }
        .error {
            color: red;
            font-size: 0.875rem;
            /* Tamaño de fuente */
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">



    <meta name="csrf-token" content="{{ csrf_token() }}">


    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <section class="bg-white dark:bg-gray-900">
                    <div class="container px-6 py-7 mx-auto">
                        <div class="bg-slate-100/50 py-1 px-3 border-solid border-b rounded-lg">
                            <x-titulo titulo="Crear Torneo"></x-titulo>
                        </div>
                        <div class="grid grid-cols-1 mt-4 xl:mt-4 md:grid-cols-1 xl:grid-cols-1 justify-items-end"
                            style="margin-bottom: 15px;">
                            {{-- <x-jet-secondary-button
                                class="bg-black hover:bg-gray-700 text-white hover:text-white trigger">
                                Nuevo Profesor
                            </x-jet-secondary-button> --}}
                        </div>

                        <form class="w-full max-w-full p-2" id="myForm">
                            <div class="text-center sm:text-left">
                                <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">
                                    Agregar jugadores
                                </h3>
                                <hr>
                            </div>

                            <div class="flex flex-wrap mt-3">
                                <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                                    <x-jet-label for="ciudad" value="Ciudad*" />
                                    <select
                                        class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                        name="ciudad" id="ciudad" placeholder="Seleccione tipo de documento...">
                                        <option value="">Seleccione</option>
                                        <option value="{{ 'Bucaramanga' }}">Bucaramanga</option>
                                        <option value="Cucuta">Cucuta</option>

                                    </select>
                                    <x-jet-input-error for="ciudad" class="mt-2" />
                                </div>

                                <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                                    <x-jet-label for="año" value="Año del torneo" />
                                    <input type="text" id="año" placeholder="Número de año" name="año"
                                        class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                        value="{{ date('Y') }}" readonly required />
                                    <x-jet-input-error for="Año" class="mt-2" />
                                </div>

                                <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                                    <x-jet-label for="numero" value="Numero" />
                                    <select
                                        class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                        name="numero" id="numero" placeholder="Seleccione numero" required>
                                        <option value="">Seleccione</option>
                                        <option value="PRIMER 1°">PRIMER 1°</option>
                                        <option value="SEGUNDO 2°">SEGUNDO 2°</option>
                                        <option value="TERCER 3°">TERCER 3°</option>
                                        <option value="CUARTO 4°">CUARTO 4°</option>

                                    </select>
                                    <x-jet-input-error for="numero" class="mt-2" />
                                </div>
                                <div class="flex md:justify-end xl:justify-end justify-center mt-5">
                                    <x-jet-button
                                        class="bg-green-600 hover:bg-green-700 text-white hover:text-white mr-2">
                                        Guardar
                                    </x-jet-button>

                                </div>
                            </div>




                        </form>


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




    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>




        <script>
            //abrir modal



            $(document).ready(function() {

                let jugadores = [];


                var rol = "{{ Auth::user()->rol }}";
                $('#tabla').DataTable({
                    destroy: true,
                    processing: true,
                    responsive: true,
                    //  serverSide: true,
                    ajax: {
                        url: '/jugadores/getData',
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

                //form 

                $('#myForm').validate({
                    rules: {
                        ciudad: {
                            required: true
                        },
                        año: {
                            required: true,
                        },
                        numero: {
                            required: true,

                        }
                    },
                    messages: {
                        ciudad: {
                            required: "Campo Requerido"
                        },
                        año: {
                            required: "Campo Requerido",

                        },
                        numero: {
                            required: "Campo Requerido",

                        },

                    },
                    submitHandler: function(form) {

                        let formData = new FormData(form);
                        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                         console.log(jugadores.length);                       
                        formData.append('jugadores', JSON.stringify(jugadores));
                        
                          
                        Swal.fire({
                        title: '¿ Esta seguro de crear este torneo ?',
                        text: `Esta agregando ${jugadores.length} jugadores al torneo`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#f97316',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, confirmar!',
                        cancelButtonText: 'Cancelar',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '/torneo/store',
                                type: 'POST',
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire({
                                            title: response.message,
                                            text: response.addMessage,
                                            icon: "success",
                                            confirmButtonColor: '#3085d6',

                                        });
    
                                        setTimeout(() => {
                                            location.href = '/torneos';
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





            });



            document.addEventListener('click', (e) => {


                if (e.target.matches('.btnEliminar') || e.target.closest('.btnEliminar')) {
                    let user_id = e.target.dataset.id;
                    Swal.fire({
                        title: '¿ Esta seguro de desactivar este usuario ?',
                        text: "El usuario no podrá ingresar al sistema",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, confirmar!',
                        cancelButtonText: 'Cancelar',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: `/users/delete/${user_id}`,
                                type: 'GET',
                                success: function(response) {
                                    Swal.fire(
                                        'Usuario desactivado!',
                                        'Este usuario ya no podrá volver a ingresar.',
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

                }
                if (e.target.matches('.btnCancha') || e.target.closest('.btnCancha')) {
                    let user_id = e.target.dataset.id;
                    $.ajax({
                        url: `/users/getSedes/${user_id}`,
                        type: 'GET',
                        success: function(response) {
                            $('#sede_id').val('').trigger('change');
                            if (response.data.sedes.length > 0) {
                                const sedesSeleccionadas = response.data.sedes.map(sede => sede.id);
                                $('#sede_id').val(sedesSeleccionadas).trigger('change');
                            }
                            document.getElementById('profesor_name').textContent = response.data.user.name
                            document.getElementById('user_id').value = response.data.user.id
                            toggleModal2();

                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            toastr.error('¡Se produjo el error!' + errorThrown, 'Intenta mas tarde');

                        }
                    });

                }

            });
        </script>
    @endpush

</x-app-layout>
