<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <section class="bg-white dark:bg-gray-900">
                    <div class="container px-6 py-7 mx-auto">
                        <div class="bg-slate-100/50 py-1 px-3 border-solid border-b rounded-lg">
                            <x-titulo titulo="Gestión de Sedes"></x-titulo>
                        </div>

                        <div class="grid grid-cols-1 mt-4 xl:mt-4 md:grid-cols-1 xl:grid-cols-1 justify-items-end"
                            style="margin-bottom: 15px;">
                            <a href="{{ route('sedes.create') }}"
                               class="bg-black hover:bg-gray-700 text-white hover:text-white px-4 py-2 rounded inline-flex items-center">
                                <i class="fas fa-plus mr-2"></i>Nueva Sede
                            </a>
                        </div>

                        <div class="grid grid-cols-1 mt-4 xl:mt-2 md:grid-cols-2 xl:grid-cols-1 div-principal">
                            <table class="cell-border compact stripe tabla" id="tabla-sedes" width="100%">
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Mostrar mensajes de sesión
            @if(session('success'))
                toastr.success('{{ session('success') }}');
            @endif

            @if(session('error'))
                toastr.error('{{ session('error') }}');
            @endif

            // Inicializar DataTable
            $('#tabla-sedes').DataTable({
                destroy: true,
                processing: true,
                responsive: true,
                ajax: {
                    url: '/sedes/getData',
                    type: 'GET'
                },
                columns: [
                    {
                        data: null,
                        title: '#',
                        className: 'p-2',
                        orderable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'nombre_sede',
                        title: 'Nombre',
                        className: 'p-2',
                        orderable: true
                    },
                    {
                        data: 'ciudad',
                        title: 'Ciudad',
                        className: 'p-2',
                        orderable: true,
                        render: function(data, type, row) {
                            return data ? data.nombre : '<span class="text-gray-400">Sin ciudad</span>';
                        }
                    },
                    {
                        data: 'profesor',
                        title: 'Profesor',
                        className: 'p-2',
                        orderable: false,
                        render: function(data, type, row) {
                            return data ? data.name : '<span class="text-gray-400">Sin asignar</span>';
                        }
                    },
                    {
                        data: 'direccion',
                        title: 'Dirección',
                        className: 'p-2',
                        orderable: false,
                        render: function(data, type, row) {
                            return data ? data : '<span class="text-gray-400">-</span>';
                        }
                    },
                    {
                        data: 'telefono',
                        title: 'Teléfono',
                        className: 'p-2',
                        orderable: false,
                        render: function(data, type, row) {
                            return data ? data : '<span class="text-gray-400">-</span>';
                        }
                    },
                    // {
                    //     data: 'planes',
                    //     title: 'Planes',
                    //     className: 'p-2 text-center',
                    //     orderable: false,
                    //     render: function(data, type, row) {
                    //         return data ? data.length : 0;
                    //     }
                    // },
                    {
                        data: null,
                        title: 'Acciones',
                        className: 'p-3 text-center',
                        orderable: false,
                        render: function(data, type, row) {
                            return `
                                <div class="flex item-center justify-center">
                                    <a href="/sedes/${row.id}"
                                       class="w-4 mr-2 transform hover:text-blue-500 hover:scale-110"
                                       title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="/sedes/${row.id}/edit"
                                       class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="eliminarSede(${row.id})"
                                            class="w-4 mr-2 transform hover:text-red-500 hover:scale-110"
                                            title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            `;
                        }
                    }
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json'
                },
                order: [[1, 'asc']]
            });
        });

        function eliminarSede(id) {
            Swal.fire({
                title: '¿Está seguro de eliminar esta sede?',
                text: "Esta acción no se puede revertir",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/sedes/${id}`;

                    let csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';

                    let methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';

                    form.appendChild(csrfToken);
                    form.appendChild(methodField);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
</x-app-layout>
