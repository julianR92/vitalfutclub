<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <section class="bg-white dark:bg-gray-900">
                    <div class="container px-6 py-7 mx-auto">
                        <div class="bg-slate-100/50 py-1 px-3 border-solid border-b rounded-lg">
                            <x-titulo titulo="Gestión de Ciudades"></x-titulo>
                        </div>

                        <div class="grid grid-cols-1 mt-4 xl:mt-4 md:grid-cols-1 xl:grid-cols-1 justify-items-end"
                            style="margin-bottom: 15px;">
                            <a href="{{ route('ciudades.create') }}"
                               class="bg-black hover:bg-gray-700 text-white hover:text-white px-4 py-2 rounded inline-flex items-center">
                                <i class="fas fa-plus mr-2"></i>Nueva Ciudad
                            </a>
                        </div>

                        <div class="grid grid-cols-1 mt-4 xl:mt-2 md:grid-cols-2 xl:grid-cols-1 div-principal">
                            <table class="cell-border compact stripe tabla" id="tabla-ciudades" width="100%">
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
            $('#tabla-ciudades').DataTable({
                destroy: true,
                processing: true,
                responsive: true,
                ajax: {
                    url: '/ciudades/getData',
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
                        data: 'nombre',
                        title: 'Nombre',
                        className: 'p-2',
                        orderable: true
                    },
                    {
                        data: 'codigo',
                        title: 'Código',
                        className: 'p-2',
                        orderable: true
                    },
                    {
                        data: 'estado',
                        title: 'Estado',
                        className: 'p-2',
                        orderable: true,
                        render: function(data, type, row) {
                            if (data == 1) {
                                return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Activa</span>';
                            } else {
                                return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactiva</span>';
                            }
                        }
                    },
                    {
                        data: 'sedes',
                        title: 'Sedes',
                        className: 'p-2 text-center',
                        orderable: false,
                        render: function(data, type, row) {
                            return data ? data.length : 0;
                        }
                    },
                    {
                        data: 'sedes',
                        title: 'Planes Activos',
                        className: 'p-2 text-center',
                        orderable: false,
                        render: function(data, type, row) {
                            console.log(row);
                             let totalPlanes = 0;
                             if (row.sedes && row.sedes.length > 0) {
                                 row.sedes.forEach(function(sede) {
                                     if (sede.per_planes_activos && sede.per_planes_activos.length > 0) {
                                         totalPlanes += sede.per_planes_activos.length;
                                     }
                                 });
                             }
                             return totalPlanes;
                            return data ? data.length : 0;
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
                                    <a href="/ciudades/${row.id}"
                                       class="w-4 mr-2 transform hover:text-blue-500 hover:scale-110"
                                       title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="/ciudades/${row.id}/edit"
                                       class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="eliminarCiudad(${row.id})"
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

        function eliminarCiudad(id) {
            Swal.fire({
                title: '¿Está seguro de eliminar esta ciudad?',
                text: "Esta acción no se puede revertir",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Crear formulario y enviarlo
                    let form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/ciudades/${id}`;

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
