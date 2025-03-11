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
                            <x-titulo titulo="Listar Profesores"></x-titulo>
                        </div>
                        <div class="grid grid-cols-1 mt-4 xl:mt-4 md:grid-cols-1 xl:grid-cols-1 justify-items-end"
                            style="margin-bottom: 15px;">
                            <x-jet-secondary-button
                                class="bg-black hover:bg-gray-700 text-white hover:text-white trigger">
                                Nuevo Profesor
                            </x-jet-secondary-button>
                        </div>

                        <div class="grid grid-cols-1 mt-4 xl:mt-2 md:grid-cols-2 xl:grid-cols-1 div-principal">
                            <table class="cell-border compact stripe tabla" id="tabla" width="100%">

                            </table>

                        </div>
                </section>
            </div>
        </div>
    </div>

    <div class="modal">
        <div class="modal-content">
            <span class="close-button">×</span>

            <form class="w-full max-w-full p-2" id="myForm">

                <div class="text-center sm:text-left">
                    <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">
                        Registrar Profesor
                    </h3>
                    <hr>
                </div>

                <div class="flex flex-wrap mt-3">
                    <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                        <x-jet-label for="tipo_doc" value="Tipo de documento" />
                        <select
                            class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            name="tipo_doc" id="tipo_doc" placeholder="Seleccione tipo de documento...">
                            <option value="">Seleccione</option>
                            <option value="{{ 'Tarjeta de identidad' }}">Tarjeta
                                de identidad</option>
                            <option value="Cedula de ciudadanía">Cedula de ciudadanía</option>
                            <option value="Pasaporte">Pasaporte</option>
                            <option value="Cedula extranjería">Cedula extranjería</option>
                        </select>
                        <x-jet-input-error for="tipo_doc" class="mt-2" />
                    </div>

                    <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                        <x-jet-label for="documento" value="Documento" />
                        <input type="text" id="documento" placeholder="Número de documento" name="documento"
                            class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                        <x-jet-input-error for="documento" class="mt-2" />
                    </div>

                    <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                        <x-jet-label for="nombres" value="Nombres" />
                        <input id="nombres" type="text" placeholder="Nombres" name="nombres"
                            class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                        <x-jet-input-error for="nombres" class="mt-2" />
                    </div>
                </div>

                <div class="flex flex-wrap mt-3">
                    <div class="w-full md:w-2/3 px-1 mb-2 md:mb-0">
                        <x-jet-label for="apellidos" value="Apellidos" />
                        <input type="text" id="apellidos" placeholder="Apelidos" name="apellidos"
                            class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                        <x-jet-input-error for="apellidos" class="mt-2" />

                    </div>
                    <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                        <x-jet-label for="fecha_nacimiento" value="Fecha de nacimiento*" />
                        <input type="date" id="fecha_nacimiento" placeholder="Dirección" name="fecha_nacimiento"
                            class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                        <x-jet-input-error for="fecha_nacimiento" class="mt-2" />
                    </div>

                </div>

                <div class="flex flex-wrap mt-3">
                    <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                        <x-jet-label for="telefono" value="Teléfono" />
                        <input type="text" id="telefono" placeholder="Teléfono" name="telefono"
                            class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                        <x-jet-input-error for="telefono" class="mt-2" />

                    </div>
                    <div class="w-full md:w-2/3 px-1 mb-2 md:mb-0">
                        <x-jet-label for="correo" value="Correo electrónico" />
                        <input type="text" id="correo" placeholder="Correo electrónico" name="correo"
                            class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                        <x-jet-input-error for="correo" class="mt-2" />
                    </div>
                </div>

                <div class="flex flex-wrap mt-3">
                    <div class="w-full md:w-3/3 px-1 mb-2 md:mb-0">
                        <x-jet-label for="direccion" value="Dirección" />
                        <input type="text" id="direccion" placeholder="Dirección" name="direccion"
                            class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                        <x-jet-input-error for="direccion" class="mt-2" />
                    </div>
                </div>

                <div class="flex md:justify-end xl:justify-end justify-center mt-3">
                    <input type="hidden" id="id" name="id"/>
                    <x-jet-button class="bg-green-600 hover:bg-green-700 text-white hover:text-white mr-2">
                        Guardar
                    </x-jet-button>
                    <x-jet-secondary-button class="bg-gray-500 hover:bg-gray-700 text-white hover:text-white"
                        onclick="cerrar()">
                        Cerrar
                    </x-jet-secondary-button>
                </div>
            </form>
        </div>
    </div>
    {{--  --}}
    <div class="modal2">
        <div class="modal-content2">
            <span class="close-button2">×</span>

            <form class="w-full max-w-full p-2" id="myFormSedes">

                <div class="text-center sm:text-left">
                    <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-sedes">
                        Agregar Sedes
                    </h3>
                    <hr>
                    <p style="text-align: left" id="profesor_name"></p>
                    <hr>
                </div>

                <div class="flex flex-wrap mt-3">
                    <div class="w-full md:w-3/3 px-1 mb-2 md:mb-0">
                        <x-jet-label for="sede_id" value="Sedes" />
                        <select
                            class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            name="sede_id" id="sede_id" multiple>
                            @foreach ($sedes as $item)
                                <option value="{{$item->id}}">{{$item->nombre_sede}} | {{$item->direccion}}</option>
                            @endforeach
                          
                        </select>
                        <x-jet-input-error for="sede_id" class="mt-2" />
                    </div>
                   
                </div>

              

               


                <div class="flex md:justify-end xl:justify-end justify-center mt-3">
                    <input type="hidden" id="user_id" name="user_id"/>
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

            var modal = document.querySelector(".modal");
            var trigger = document.querySelector(".trigger");
            var closeButton = document.querySelector(".close-button");

            function toggleModal() {
                document.getElementById('modal-title').textContent = 'Registrar Profe';
                let form = document.getElementById('myForm');
                form.reset();
                $("#myForm").validate().resetForm();

                modal.classList.toggle("show-modal");
            }

            function windowOnClick(event) {
                if (event.target === modal) {
                    toggleModal();
                }
            }

            trigger.addEventListener("click", toggleModal);
            closeButton.addEventListener("click", toggleModal);
            window.addEventListener("click", windowOnClick);

            function cerrar() {
                toggleModal();
            }
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

            closeButton2.addEventListener("click", toggleModal2);
            window.addEventListener("click", windowOnClick2);
            
            function cerrar() {
                toggleModal();
            }
            function cerrar2() {
                toggleModal2();
            }

            $(document).ready(function() {
                  
        $('#sede_id').select2({
            placeholder: "Selecciona una o más opciones",
            allowClear: true
        })

                var rol = "{{ Auth::user()->rol }}";
                $('#tabla').DataTable({
                    destroy: true,
                    processing: true,
                    responsive: true,
                    //  serverSide: true,
                    ajax: {
                        url: '/user/data',
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
                            data: 'people.nombres',
                            title: 'Nombres',
                            className: 'p-2',
                            orderable: true
                        },
                        {
                            data: 'people.apellidos',
                            title: 'Apellidos',
                            className: 'p-2',
                            orderable: true
                        },
                        {
                            data: 'people.documento',
                            title: 'Documento',
                            className: 'p-2',
                            orderable: true
                        },
                        {
                            data: 'people.correo',
                            title: 'Email/Usuario',
                            className: 'p-2',
                            orderable: true
                        },
                        {
                            data: null,
                            title: 'Sedes',
                            className: 'p-2',
                            orderable: false,
                            render: function(data, type, row) {
                                let html = `<ul>`
                                row.sedes.forEach(el=>{
                                    html += `<li>${el.nombre_sede}</li>`
                                })
                                html += `</ul>`
                                return `${html}`;
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
                			<button data-id="${row.id}" class="w-4 mx-2 transform hover:text-blue-800 hover:scale-125 btnCancha" title="añadir sedes">
                				<svg data-id="${row.id}" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><g data-id="${row.id}" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path  data-id="${row.id}" d="M9 12a3 3 0 1 0 6 0a3 3 0 1 0-6 0M3 9h3v6H3zm15 0h3v6h-3z"/><path data-id="${row.id}" d="M3 7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2zm9-2v14"/></g></svg>
                			</button>
                			${rol === 'admin' ? `
                           <button data-id="${row.id}" data-persona="${row.persona_id}" class="w-4 mx-2 transform hover:text-blue-800 hover:scale-125 btnEditar">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="btnEditar" data-id="${row.id}" data-persona="${row.persona_id}">
                    <path data-id="${row.id}" data-persona="${row.persona_id}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                        </button>
                        <button data-id="${row.id}" class="w-4 mx-2 transform hover:text-blue-800 hover:scale-125 btnEliminar">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="btnEliminar" data-id="${row.id}" >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"  data-id="${row.id}"/>
                            </svg>
                            </button>
                                                                                			` : ''}
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

                //form 

                $('#myForm').validate({
                    rules: {
                        tipo_doc: {
                            required: true
                        },
                        documento: {
                            required: true,
                            digits: true,
                            minlength: 5 // Ajusta según la longitud mínima de documento
                        },
                        nombres: {
                            required: true,
                            minlength: 2
                        },
                        apellidos: {
                            required: true,
                            minlength: 2
                        },
                        fecha_nacimiento: {
                            required: true,
                            date: true
                        },
                        telefono: {
                            required: true,
                            digits: true,
                            minlength: 10, // Ajusta según la longitud mínima de teléfono
                            maxlength: 15
                        },
                        correo: {
                            required: true,
                            email: true
                        },
                        direccion: {
                            required: true
                        }
                    },
                    messages: {
                        tipo_doc: {
                            required: "Campo Requerido"
                        },
                        documento: {
                            required: "Campo Requerido",
                            digits: "El documento debe ser solo números.",
                            minlength: "El documento debe tener al menos 5 dígitos."
                        },
                        nombres: {
                            required: "Campo Requerido",
                            minlength: "Los nombres deben tener al menos 2 caracteres."
                        },
                        apellidos: {
                            required: "Por favor, ingresa tus apellidos.",
                            minlength: "Los apellidos deben tener al menos 2 caracteres."
                        },
                        fecha_nacimiento: {
                            required: "Campo Requerido",
                            date: "Por favor, ingresa una fecha válida."
                        },
                        telefono: {
                            required: "Campo Requerido",
                            digits: "El teléfono debe ser solo números.",
                            minlength: "El teléfono debe tener al menos 10 dígitos.",
                            maxlength: "El teléfono no puede tener más de 15 dígitos."
                        },
                        correo: {
                            required: "Campo Requerido",
                            email: "Por favor, ingresa un correo electrónico válido."
                        },
                        direccion: {
                            required: "Campo Requerido"
                        }
                    },
                    submitHandler: function(form) {

                        let formData = new FormData(form);
                        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

                        $.ajax({
                            url: '/user/store',
                            type: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                             if (response.success){
                                    toggleModal();
                                    Swal.fire({
                                    title: response.message,
                                    text: response.addMessage,
                                    icon: "success"
                                    });

                                    setTimeout(() => {
                            location.reload();
                        }, 2500)

                                }  else {
                                    response.errors.forEach((el) => {
                                        toastr.error(el ,'Atencion');

                                    })
                                }
                            },
                            error: function(xhr, status, error) {
                                toastr.error('¡Se produjo el error!' + error, 'Intenta mas tarde');

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

            $('#myFormSedes').submit(function(event) {
                event.preventDefault(); // Evitar el envío tradicional del formulario

                const sedesSeleccionadas = $('#sede_id').val()|| [];
                let user_id = document.getElementById('user_id').value
                $.ajax({
                    url: '/sedes/users', // Reemplaza con tu URL de destino
                    type: 'POST',
                    data: {
                        sedes: sedesSeleccionadas,
                        user_id: user_id
                    },
                    success: function(response) {
                        if (response.success){
                                    toggleModal2();
                                    Swal.fire({
                                    title: response.message,
                                    text: 'Operación Exitosa',
                                    icon: "success"
                                    });

                                    setTimeout(() => {
                            location.reload();
                        }, 2500)

                                }  else {
                                    response.errors.forEach((el) => {
                                        toastr.error(el ,'Atencion');

                                    })
                                }
                       
                    },
                    error: function(xhr, status, error) {
                        toastr.error('¡Se produjo el error!' + error, 'Intenta mas tarde');

                    }
                });
            })



            });

         

            document.addEventListener('click', (e) => {
                if (e.target.matches('.btnEditar')|| e.target.closest('.btnEditar')) {
                    let persona_id =e.target.dataset.persona
                    let user_id =e.target.dataset.id
                    $.ajax({
                    url: `/users/edit/${persona_id}`,
                    type: 'GET',
                    success: function(response) {                        
                    document.getElementById('modal-title').textContent = 'Editar Profe';
                    document.getElementById('tipo_doc').value = response.data.tipo_doc;
                    document.getElementById('documento').value = response.data.documento;
                    document.getElementById('nombres').value = response.data.nombres;
                    document.getElementById('apellidos').value = response.data.apellidos;
                    document.getElementById('fecha_nacimiento').value = response.data.fecha_nacimiento;
                    document.getElementById('telefono').value = response.data.telefono;
                    document.getElementById('correo').value = response.data.correo;
                    document.getElementById('direccion').value = response.data.direccion;
                    document.getElementById('id').value = response.data.id;
                    modal.classList.toggle("show-modal");

                  },
                     error: function(jqXHR, textStatus, errorThrown) {
                     toastr.error('¡Se produjo el error!' + errorThrown, 'Intenta mas tarde');

            }
        });
                    // Livewire.emitTo('persona.modal', 'abrirModal', e.target.dataset.id);
                }

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
                     toastr.error('¡Se produjo el error!' + error, 'Intenta mas tarde');

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
                        if(response.data.sedes.length>0){
                            const sedesSeleccionadas = response.data.sedes.map(sede => sede.id);
                            $('#sede_id').val(sedesSeleccionadas).trigger('change');
                        }
                        document.getElementById('profesor_name').textContent= response.data.user.name
                        document.getElementById('user_id').value= response.data.user.id
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
