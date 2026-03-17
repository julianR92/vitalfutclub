<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <section class="bg-white dark:bg-gray-900">
                    <div class="container px-6 py-7 mx-auto">

                        <div class="bg-slate-100/50 py-1 px-3 border-solid border-b rounded-lg">
                            <x-titulo titulo="Medidas Corporales — Historial de Sesiones"></x-titulo>
                        </div>

                        <div class="grid grid-cols-1 mt-4 xl:mt-4 md:grid-cols-1 xl:grid-cols-1 justify-items-end"
                             style="margin-bottom: 15px;">
                            <a href="{{ route('medidas.seleccionar') }}"
                               class="bg-black hover:bg-gray-700 text-white hover:text-white px-4 py-2 rounded inline-flex items-center">
                                <i class="fas fa-plus mr-2"></i>Nueva Sesión
                            </a>
                        </div>

                        <div class="grid grid-cols-1 mt-4 xl:mt-2 md:grid-cols-1 xl:grid-cols-1 div-principal">
                            <table class="cell-border compact stripe tabla" id="tabla-historial" width="100%">
                            </table>
                        </div>

                    </div>
                </section>
            </div>
        </div>
    </div>

    {{-- Form oculto para DELETE --}}
    <form id="form-eliminar" method="POST" style="display:none">
        @csrf
        @method('DELETE')
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {

            @if(session('success'))
                toastr.success('{{ session('success') }}');
            @endif
            @if(session('error'))
                toastr.error('{{ session('error') }}');
            @endif

            const esAdmin = {{ auth()->user()->rol === 'admin' ? 'true' : 'false' }};

            const columns = [
                {
                    data: null,
                    title: '#',
                    className: 'p-2',
                    orderable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                { data: 'fecha',  title: 'Fecha',  className: 'p-2' },
                { data: 'sede',   title: 'Sede',   className: 'p-2' },
            ];

            if (esAdmin) {
                columns.push({ data: 'profesor', title: 'Profesor', className: 'p-2' });
            }

            columns.push(
                {
                    data: 'total',
                    title: 'Clientes',
                    className: 'p-2 text-center',
                    render: (v) => v
                },
                {
                    data: null,
                    title: 'Progreso',
                    className: 'p-2',
                    orderable: false,
                    render: function (row) {
                        const pct   = row.total > 0 ? Math.round((row.completados / row.total) * 100) : 0;
                        const color = pct === 100 ? '#22c55e' : '#f59e0b';
                        return `<div style="display:inline-flex;align-items:center;gap:6px">
                            <div style="width:80px;height:6px;background:#e5e7eb;border-radius:9999px;overflow:hidden">
                                <div style="width:${pct}%;height:100%;background:${color};border-radius:9999px"></div>
                            </div>
                            <span style="font-size:12px;color:#6b7280">${row.completados}/${row.total}</span>
                        </div>`;
                    }
                },
                {
                    data: 'nota',
                    title: 'Nota',
                    className: 'p-2',
                    render: (v) => `<span style="color:#9ca3af;font-size:12px">${v ?? '—'}</span>`
                },
                {
                    data: null,
                    title: 'Acciones',
                    className: 'p-3 text-center',
                    orderable: false,
                    render: function (data, type, row) {
                        return `
                            <div class="flex item-center justify-center">
                                <a href="/medidas/${row.id}/detalle"
                                   class="w-4 mr-2 transform hover:text-blue-500 hover:scale-110"
                                   title="Ver detalle">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="/medidas/${row.id}/editar"
                                   class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                                   title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="eliminarSesion(${row.id})"
                                        class="w-4 mr-2 transform hover:text-red-500 hover:scale-110"
                                        title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>`;
                    }
                }
            );

            $('#tabla-historial').DataTable({
                destroy: true,
                processing: true,
                responsive: true,
                ajax: {
                    url: '{{ route("medidas.historial.getData") }}',
                    type: 'GET'
                },
                columns: columns,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json'
                },
                order: [[1, 'desc']]
            });
        });

        function eliminarSesion(id) {
            Swal.fire({
                title: '¿Eliminar esta sesión?',
                text: 'Se eliminarán también todos los registros de medidas asociados. Esta acción no se puede revertir.',
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
                    form.action = `/medidas/${id}`;

                    let csrfToken = document.createElement('input');
                    csrfToken.type  = 'hidden';
                    csrfToken.name  = '_token';
                    csrfToken.value = '{{ csrf_token() }}';

                    let methodField = document.createElement('input');
                    methodField.type  = 'hidden';
                    methodField.name  = '_method';
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
