<x-app-layout>
    <x-slot name="header">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <section class="bg-white dark:bg-gray-900">
                    <div class="container px-6 py-7 mx-auto">
                        <div class="bg-slate-100/50 py-1 px-3 border-solid border-b rounded-lg mb-4">
                            <x-titulo titulo="Gestión de Planes"></x-titulo>
                        </div>

                        <div class="grid grid-cols-1 mt-4 xl:mt-4 md:grid-cols-1 xl:grid-cols-1 justify-items-end" style="margin-bottom: 15px;">
                            <a href="{{ route('planes.create') }}"
                               class="bg-black hover:bg-gray-700 text-white hover:text-white px-4 py-2 rounded inline-flex items-center">
                                <i class="fas fa-plus mr-2"></i>Nuevo Plan
                            </a>
                        </div>

                        <div class="p-2">
                            <div class="overflow-x-auto">
                                <table class="cell-border compact stripe tabla" id="tabla-planes" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre del Plan</th>
                                            <th>Orden</th>
                                            <th>Tipo</th>
                                            <th>Ciudad</th>
                                            <th>Sede</th>
                                            <th>Días</th>
                                            <th>Descuento</th>
                                            <th>Precio Final</th>
                                            <th>Detalles</th>
                                            <th>Visible Web</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            var table = $('#tabla-planes').DataTable({
                responsive: true,
                ajax: {
                    url: '{{ route('planes.getData') }}',
                    dataSrc: 'data'
                },
                columns: [
                    { data: 'id' },
                    { data: 'nombre_plan',className: 'text-center'},
                     {
                        data: 'orden',
                        className: 'text-center'
                    },
                    {
                        data: 'tipo_plan',
                        className: 'text-center',
                        render: function(data, type, row) {
                            if (data === 'suscripcion') {
                                return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800"><i class="fas fa-calendar-check mr-1"></i>Suscripción</span>';
                            } else {
                                return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800"><i class="fas fa-credit-card mr-1"></i>Prepago</span>';
                            }
                        }
                    },
                    { data: 'ciudad' },
                    { data: 'sede' },

                    {
                        data: 'numero_dias',
                        className: 'text-center'
                    },
                    {
                        data: 'descuento',
                        className: 'text-center'
                    },
                    {
                        data: 'precio_final',
                        className: 'text-right font-bold'
                    },
                    {
                        data: 'detalles_count',
                        className: 'text-center',
                        render: function(data, type, row) {
                            return '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">' + data + '</span>';
                        }
                    },
                    {
                        data: 'visible_web',
                        className: 'text-center',
                        render: function(data, type, row) {
                            if (data) {
                                return '<span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"><i class="fas fa-check-circle mr-1"></i>Visible</span>';
                            } else {
                                return '<span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800"><i class="fas fa-times-circle mr-1"></i>Oculto</span>';
                            }
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function(data, type, row) {
                            return `
                                <div class="flex justify-center space-x-2">
                                    <a href="/planes/${row.id}" class="bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded inline-flex items-center" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="/planes/${row.id}/edit" class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded inline-flex items-center" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="eliminarPlan(${row.id})" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded inline-flex items-center" title="Eliminar">
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
                order: [],
                // order: [[10, 'asc'], [1, 'asc']],
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]]
            });

            // Mostrar mensaje de éxito si existe
            @if(session('success'))
                toastr.success('{{ session('success') }}');
            @endif
        });

        function eliminarPlan(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción no se puede revertir. Si el plan tiene detalles, también serán eliminados.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/planes/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message);
                                $('#tabla-planes').DataTable().ajax.reload();
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function(xhr) {
                            const message = xhr.responseJSON?.message || 'Error al eliminar el plan';
                            toastr.error(message);
                        }
                    });
                }
            });
        }
    </script>
</x-app-layout>
