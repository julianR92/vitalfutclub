<x-app-layout>
    <x-slot name="header">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    </x-slot>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <section class="bg-white dark:bg-gray-900">
                    <div class="container px-6 py-7 mx-auto">
                        <div class="bg-slate-100/50 py-1 px-3 border-solid border-b rounded-lg mb-4">
                            <x-titulo titulo="Detalles de Sede"></x-titulo>
                        </div>

                        <div class="grid grid-cols-1 mt-4 xl:mt-4 md:grid-cols-1 xl:grid-cols-1 justify-items-end"
                            style="margin-bottom: 15px;">
                            <div>
                                <a href="{{ route('sedes.edit', $sede) }}"
                                    class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded inline-flex items-center mr-2">
                                    <i class="fas fa-edit mr-2"></i>Editar
                                </a>
                                <a href="{{ route('sedes.index') }}"
                                    class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded inline-flex items-center">
                                    <i class="fas fa-arrow-left mr-2"></i>Volver
                                </a>
                            </div>
                        </div>

                        <div class="p-2">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-2">
                                        <i class="fas fa-info-circle mr-2"></i>Información General
                                    </h3>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="mb-3">
                                            <label class="block text-sm font-medium text-gray-600">ID:</label>
                                            <p class="text-gray-900 font-semibold">{{ $sede->id }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="block text-sm font-medium text-gray-600">Nombre:</label>
                                            <p class="text-gray-900 text-lg font-bold">{{ $sede->nombre_sede }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="block text-sm font-medium text-gray-600">Ciudad:</label>
                                            <p class="text-gray-900 font-semibold">
                                                @if ($sede->ciudad)
                                                    <i
                                                        class="fas fa-map-marker-alt mr-1 text-blue-500"></i>{{ $sede->ciudad->nombre }}
                                                @else
                                                    <span class="text-gray-400">Sin ciudad</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="block text-sm font-medium text-gray-600">Profesor
                                                Asignado:</label>
                                            <p class="text-gray-900 font-semibold">
                                                @if ($sede->profesor)
                                                    <i
                                                        class="fas fa-user-tie mr-1 text-indigo-500"></i>{{ $sede->profesor->name }}
                                                @else
                                                    <span class="text-gray-400">Sin asignar</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="block text-sm font-medium text-gray-600">Dirección:</label>
                                            <p class="text-gray-900">
                                                @if ($sede->direccion)
                                                    <i class="fas fa-location-dot mr-1"></i>{{ $sede->direccion }}
                                                @else
                                                    <span class="text-gray-400">Sin dirección</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="block text-sm font-medium text-gray-600">Teléfono:</label>
                                            <p class="text-gray-900">
                                                @if ($sede->telefono)
                                                    <i class="fas fa-phone mr-1"></i>{{ $sede->telefono }}
                                                @else
                                                    <span class="text-gray-400">Sin teléfono</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-600">Persona a
                                                Cargo:</label>
                                            <p class="text-gray-900">
                                                @if ($sede->persona_cargo)
                                                    <i class="fas fa-user mr-1"></i>{{ $sede->persona_cargo }}
                                                @else
                                                    <span class="text-gray-400">Sin persona a cargo</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-2">
                                        <i class="fas fa-chart-bar mr-2"></i>Estadísticas
                                    </h3>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        {{-- <div class="mb-4 bg-white p-3 rounded shadow-sm">
                                            <label class="block text-sm font-medium text-gray-600 mb-1">Total de Planes:</label>
                                            <p class="text-green-600 text-3xl font-bold">{{ $sede->planes()->

                                            () }}</p>
                                        </div> --}}
                                        <div class="mb-4 bg-white p-3 rounded shadow-sm">
                                            <label class="block text-sm font-medium text-gray-600 mb-1">Clientes con
                                                Plan Activo:</label>
                                            <p class="text-blue-600 text-3xl font-bold">
                                                {{ $sede->perPlanesActivos()->count() }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="block text-sm font-medium text-gray-600">Fecha de
                                                Creación:</label>
                                            <p class="text-gray-900"><i
                                                    class="far fa-calendar-alt mr-1"></i>{{ $sede->created_at->format('d/m/Y H:i') }}
                                            </p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-600">Última
                                                Actualización:</label>
                                            <p class="text-gray-900"><i
                                                    class="far fa-clock mr-1"></i>{{ $sede->updated_at->format('d/m/Y H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if ($planesActivos->count() > 0)
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-2">
                                        <i class="fas fa-users mr-2"></i>Clientes con Planes Activos
                                        ({{ $planesActivos->count() }})
                                    </h3>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="overflow-x-auto">
                                            <table class="cell-border compact stripe tabla" id="tabla-planes-activos"
                                                width="100%">
                                                <thead>
                                                    <tr>
                                                        <th class="p-2">#</th>
                                                        <th class="p-2">Nombres</th>
                                                        <th class="p-2">Apellidos</th>
                                                        <th class="p-2">Cédula</th>
                                                        <th class="p-2">Plan</th>
                                                        <th class="p-2">Fecha Inicio</th>
                                                        <th class="p-2">Fecha Fin</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($planesActivos as $index => $perPlan)
                                                        <tr>
                                                            <td class="p-2">{{ $index + 1 }}</td>
                                                            <td class="p-2">
                                                                {{ $perPlan->persona->nombres ?? 'N/A' }}</td>
                                                            <td class="p-2">
                                                                {{ $perPlan->persona->apellidos ?? 'N/A' }}</td>
                                                            <td class="p-2">
                                                                {{ $perPlan->persona->documento ?? 'N/A' }}</td>
                                                            <td class="p-2">
                                                                {{ $perPlan->planes->nombre_plan ?? 'N/A' }}</td>
                                                            <td class="p-2">
                                                                {{ \Carbon\Carbon::parse($perPlan->fecha_inicio)->format('d/m/Y') }}
                                                            </td>
                                                            <td class="p-2" data-fecha="{{ $perPlan->fecha_fin }}">
                                                                {{ \Carbon\Carbon::parse($perPlan->fecha_fin)->format('d/m/Y') }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function() {
            @if ($planesActivos->count() > 0)
                var table = $('#tabla-planes-activos').DataTable({
                    responsive: true,
                    dom: 'Bfrtip',

                    buttons: [{
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel mr-1"></i> Exportar a Excel',
                        className: 'bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded inline-flex items-center',
                        title: 'Planes Activos - {{ $sede->nombre_sede }}',
                        exportOptions: {
                            columns: ':visible'
                        }
                    }],
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json',
                        emptyTable: 'No hay planes activos',
                        zeroRecords: 'No se encontraron resultados',
                        search: 'Buscar:',
                        paginate: {
                            first: 'Primero',
                            last: 'Último',
                            next: 'Siguiente',
                            previous: 'Anterior'
                        },
                        info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
                        infoEmpty: 'Mostrando 0 a 0 de 0 registros',
                        infoFiltered: '(filtrado de _MAX_ registros totales)',
                        lengthMenu: 'Mostrar _MENU_ registros'
                    },
                    order: [
                        [1, 'asc']
                    ],
                    pageLength: 10,
                    lengthMenu: [
                        [10, 25, 50, -1],
                        [10, 25, 50, "Todos"]
                    ],
                    createdRow: function(row, data, dataIndex) {
                        // Obtener la fecha de fin de la celda
                        var fechaFinCell = $(row).find('td').eq(6);
                        var fechaFin = fechaFinCell.data('fecha');

                        if (fechaFin) {
                            var hoy = new Date();
                            hoy.setHours(0, 0, 0, 0);
                            var fechaFinDate = new Date(fechaFin);
                            fechaFinDate.setHours(0, 0, 0, 0);

                            // Calcular días restantes
                            var diffTime = fechaFinDate - hoy;
                            var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                            // Si faltan 7 días o menos, poner en naranja
                            if (diffDays <= 7 && diffDays >= 0) {
                                $(row).css('background-color', '#FED7AA'); // naranja claro
                                $(row).css('color', '#9A3412'); // texto naranja oscuro
                            }
                            // Si ya venció, poner en rojo claro
                            else if (diffDays < 0) {
                                $(row).css('background-color', '#FEE2E2'); // rojo claro
                                $(row).css('color', '#991B1B'); // texto rojo oscuro
                            }
                        }
                    }
                });
            @endif
        });
    </script>
</x-app-layout>
