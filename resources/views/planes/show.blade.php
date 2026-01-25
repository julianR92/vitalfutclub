<x-app-layout>
    <x-slot name="header">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
        <style>
            #modalDetalle {
                opacity: 0;
                transition: opacity 0.3s ease-in-out;
            }

            #modalDetalle .bg-white {
                transform: scale(0.95);
                transition: transform 0.3s ease-in-out;
            }

            #modalDetalle:not(.hidden) {
                opacity: 1;
            }

            #modalDetalle:not(.hidden) .bg-white {
                transform: scale(1);
            }
        </style>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <section class="bg-white dark:bg-gray-900">
                    <div class="container px-6 py-7 mx-auto">
                        <div class="bg-slate-100/50 py-1 px-3 border-solid border-b rounded-lg mb-4">
                            <x-titulo titulo="Detalles del Plan"></x-titulo>
                        </div>

                        <div class="grid grid-cols-1 mt-4 xl:mt-4 md:grid-cols-1 xl:grid-cols-1 justify-items-end"
                            style="margin-bottom: 15px;">
                            <div>
                                <a href="{{ route('planes.edit', $plan) }}"
                                    class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded inline-flex items-center mr-2">
                                    <i class="fas fa-edit mr-2"></i>Editar
                                </a>
                                <a href="{{ route('planes.index') }}"
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
                                            <p class="text-gray-900 font-semibold">{{ $plan->id }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="block text-sm font-medium text-gray-600">Nombre:</label>
                                            <p class="text-gray-900 text-lg font-bold">{{ $plan->nombre_plan }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="block text-sm font-medium text-gray-600">Tipo de Plan:</label>
                                            <p class="text-gray-900 font-semibold">
                                                @if ($plan->tipo_plan === 'suscripcion')
                                                    <span
                                                        class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                                        <i class="fas fa-calendar-check mr-1"></i>Suscripción
                                                    </span>
                                                @else
                                                    <span
                                                        class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        <i class="fas fa-credit-card mr-1"></i>Prepago
                                                    </span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="block text-sm font-medium text-gray-600">Ciudad:</label>
                                            <p class="text-gray-900 font-semibold">
                                                @if ($plan->ciudad)
                                                    <i
                                                        class="fas fa-city mr-1 text-blue-500"></i>{{ $plan->ciudad->nombre }}
                                                @else
                                                    <span class="text-gray-400">Sin ciudad</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="block text-sm font-medium text-gray-600">Sede:</label>
                                            <p class="text-gray-900 font-semibold">
                                                @if ($plan->sede)
                                                    <i
                                                        class="fas fa-building mr-1 text-indigo-500"></i>{{ $plan->sede->nombre_sede }}
                                                @else
                                                    <span class="text-gray-400">Sin sede</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="block text-sm font-medium text-gray-600">Descripción:</label>
                                            <p class="text-gray-700">
                                                {{ $plan->descripcion_corta ?? 'Sin descripción' }}
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="block text-sm font-medium text-gray-600">Visible en
                                                Web:</label>
                                            @if ($plan->visible_web)
                                                <span
                                                    class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    <i class="fas fa-check-circle mr-1"></i>Visible
                                                </span>
                                            @else
                                                <span
                                                    class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    <i class="fas fa-times-circle mr-1"></i>Oculto
                                                </span>
                                            @endif
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-600">Orden:</label>
                                            <p class="text-gray-900 font-semibold">{{ $plan->orden }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-2">
                                        <i class="fas fa-dollar-sign mr-2"></i>Información de Precio
                                    </h3>
                                    <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                                        <div class="bg-white p-3 rounded shadow-sm">
                                            <label class="block text-sm font-medium text-gray-600 mb-1">Número de
                                                Clases:</label>
                                            <p class="text-blue-600 text-2xl font-bold">{{ $plan->numero_clases }}
                                                clases</p>
                                        </div>
                                        <div class="bg-white p-3 rounded shadow-sm">
                                            <label
                                                class="block text-sm font-medium text-gray-600 mb-1">Duración:</label>
                                            <p class="text-purple-600 text-2xl font-bold">{{ $plan->numero_dias }} días
                                            </p>
                                        </div>
                                        <div class="bg-white p-3 rounded shadow-sm">
                                            <label class="block text-sm font-medium text-gray-600 mb-1">Valor
                                                Original:</label>
                                            <p class="text-gray-600 text-xl font-semibold">
                                                ${{ number_format($plan->valor, 0, ',', '.') }}</p>
                                        </div>
                                        @if ($plan->descuento > 0)
                                            <div class="bg-orange-50 p-3 rounded shadow-sm border border-orange-200">
                                                <label
                                                    class="block text-sm font-medium text-orange-600 mb-1">Descuento:</label>
                                                <p class="text-orange-600 text-xl font-bold">{{ $plan->descuento }}%
                                                </p>
                                                <p class="text-xs text-orange-500 mt-1">Ahorro:
                                                    ${{ number_format($plan->ahorro, 0, ',', '.') }}</p>
                                            </div>
                                            <div class="bg-green-50 p-3 rounded shadow-sm border-2 border-green-300">
                                                <label class="block text-sm font-medium text-green-600 mb-1">Precio
                                                    Final:</label>
                                                <p class="text-green-600 text-3xl font-bold">
                                                    ${{ number_format($plan->precio_final, 0, ',', '.') }}</p>
                                            </div>
                                        @else
                                            <div class="bg-green-50 p-3 rounded shadow-sm border-2 border-green-300">
                                                <label
                                                    class="block text-sm font-medium text-green-600 mb-1">Precio:</label>
                                                <p class="text-green-600 text-3xl font-bold">
                                                    ${{ number_format($plan->valor, 0, ',', '.') }}</p>
                                            </div>
                                        @endif
                                        <div class="bg-blue-50 p-3 rounded shadow-sm">
                                            <label class="block text-sm font-medium text-blue-600 mb-1">Clientes
                                                Activos:</label>
                                            <p class="text-blue-600 text-2xl font-bold">{{ $clientesActivos }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sección de Detalles del Plan -->
                            <div class="mb-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">
                                        <i class="fas fa-list-check mr-2"></i>Detalles del Plan
                                        ({{ $plan->detalles->count() }})
                                    </h3>
                                    <button onclick="mostrarModalDetalle()"
                                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded inline-flex items-center">
                                        <i class="fas fa-plus-circle mr-2"></i>Agregar Detalle
                                    </button>
                                </div>

                                @if ($plan->detalles->count() > 0)
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="overflow-x-auto">
                                            <table class="cell-border compact stripe tabla" id="tabla-detalles"
                                                width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Orden</th>
                                                        <th>Icono</th>
                                                        <th>Título</th>
                                                        <th>Descripción</th>
                                                        <th>Tipo</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($plan->detalles as $detalle)
                                                        <tr>
                                                            <td class="text-center">{{ $detalle->orden }}</td>
                                                            <td class="text-center">
                                                                @if ($detalle->icono)
                                                                    <i
                                                                        class="{{ $detalle->icono }} text-blue-500 text-xl"></i>
                                                                @else
                                                                    <span class="text-gray-400">-</span>
                                                                @endif
                                                            </td>
                                                            <td class="font-semibold">{{ $detalle->titulo }}</td>
                                                            <td>{{ $detalle->descripcion ?? '-' }}</td>
                                                            <td>
                                                                @if ($detalle->tipo)
                                                                    <span
                                                                        class="px-2 py-1 text-xs rounded bg-purple-100 text-purple-800">
                                                                        {{ $detalle->tipo }}
                                                                    </span>
                                                                @else
                                                                    <span class="text-gray-400">-</span>
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                <button
                                                                    onclick="editarDetalle({{ $detalle->id }}, '{{ $detalle->titulo }}', '{{ $detalle->descripcion }}', '{{ $detalle->icono }}', {{ $detalle->orden }}, '{{ $detalle->tipo }}')"
                                                                    class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded inline-flex items-center mr-1"
                                                                    title="Editar">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                                <button onclick="eliminarDetalle({{ $detalle->id }})"
                                                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded inline-flex items-center"
                                                                    title="Eliminar">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @else
                                    <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200 text-center">
                                        <i class="fas fa-info-circle text-yellow-600 text-3xl mb-2"></i>
                                        <p class="text-yellow-700">No hay detalles agregados a este plan.</p>
                                        <p class="text-xs text-yellow-600 mt-1">Los detalles aparecerán en la página
                                            web</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Fechas -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                                <div>
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    <strong>Creado:</strong> {{ $plan->created_at->format('d/m/Y H:i') }}
                                </div>
                                <div>
                                    <i class="far fa-clock mr-1"></i>
                                    <strong>Actualizado:</strong> {{ $plan->updated_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Modal para agregar/editar detalle -->
    <div id="modalDetalle"
        class="fixed inset-0 bg-black bg-opacity-60 hidden overflow-y-auto h-full w-full z-50 transition-opacity duration-300"
        onclick="cerrarModalSiClickFuera(event)">
        <div class="relative top-10 sm:top-20 mx-auto p-0 w-11/12 sm:w-10/12 md:w-3/4 lg:w-2/3 xl:w-1/2 max-w-3xl"
            onclick="event.stopPropagation()">
            <div class="bg-white rounded-lg shadow-2xl transform transition-all duration-300">
                <!-- Header del modal -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 rounded-t-lg">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-bold text-white flex items-center" id="modalTitulo">
                            <i class="fas fa-plus-circle mr-2"></i>
                            Agregar Detalle
                        </h3>
                        <button onclick="cerrarModalDetalle()"
                            class="text-white hover:text-gray-200 transition-colors duration-200">
                            <i class="fas fa-times text-2xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Contenido del modal -->
                <div class="p-6">

                    <form id="formDetalle" method="POST">
                        @csrf
                        <input type="hidden" id="detalleId" name="detalle_id" value="">
                        <input type="hidden" id="metodoPut" name="_method" value="">

                        <div class="space-y-5">
                            <div>
                                <label for="titulo" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-heading mr-2 text-blue-600"></i>Título *
                                </label>
                                <input type="text" name="titulo" id="titulo" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('titulo') border-red-500 @enderror"
                                    placeholder="Ingrese el título del detalle">
                                @error('titulo')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="descripcion" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-align-left mr-2 text-blue-600"></i>Descripción
                                </label>
                                <textarea name="descripcion" id="descripcion" rows="3"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 resize-none"
                                    placeholder="Ingrese una descripción (opcional)"></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">
                                    <i class="fas fa-icons mr-2 text-blue-600"></i>Seleccione un Icono *
                                </label>
                                <input type="hidden" name="icono" id="icono" required>
                                <div class="flex flex-wrap gap-2 max-h-48 overflow-y-auto p-3 border border-gray-200 rounded-lg bg-gray-50">
                                    <!-- Iconos de fútbol y entrenamiento -->
                                    <button type="button" onclick="seleccionarIcono('fas fa-futbol')" data-icon="fas fa-futbol"
                                        class="icon-option p-2 border-2 border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all duration-200 cursor-pointer"
                                        title="Balón">
                                        <i class="fas fa-futbol text-xl text-gray-600"></i>
                                    </button>
                                    <button type="button" onclick="seleccionarIcono('fas fa-trophy')" data-icon="fas fa-trophy"
                                        class="icon-option p-2 border-2 border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all duration-200 cursor-pointer"
                                        title="Trofeo">
                                        <i class="fas fa-trophy text-xl text-gray-600"></i>
                                    </button>
                                    <button type="button" onclick="seleccionarIcono('fas fa-medal')" data-icon="fas fa-medal"
                                        class="icon-option p-2 border-2 border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all duration-200 cursor-pointer"
                                        title="Medalla">
                                        <i class="fas fa-medal text-xl text-gray-600"></i>
                                    </button>
                                    <button type="button" onclick="seleccionarIcono('fas fa-dumbbell')" data-icon="fas fa-dumbbell"
                                        class="icon-option p-2 border-2 border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all duration-200 cursor-pointer"
                                        title="Pesas">
                                        <i class="fas fa-dumbbell text-xl text-gray-600"></i>
                                    </button>
                                    <button type="button" onclick="seleccionarIcono('fas fa-running')" data-icon="fas fa-running"
                                        class="icon-option p-2 border-2 border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all duration-200 cursor-pointer"
                                        title="Correr">
                                        <i class="fas fa-running text-xl text-gray-600"></i>
                                    </button>
                                    <button type="button" onclick="seleccionarIcono('fas fa-heartbeat')" data-icon="fas fa-heartbeat"
                                        class="icon-option p-2 border-2 border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all duration-200 cursor-pointer"
                                        title="Cardio">
                                        <i class="fas fa-heartbeat text-xl text-gray-600"></i>
                                    </button>
                                    <button type="button" onclick="seleccionarIcono('fas fa-stopwatch')" data-icon="fas fa-stopwatch"
                                        class="icon-option p-2 border-2 border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all duration-200 cursor-pointer"
                                        title="Tiempo">
                                        <i class="fas fa-stopwatch text-xl text-gray-600"></i>
                                    </button>
                                    <button type="button" onclick="seleccionarIcono('fas fa-users')" data-icon="fas fa-users"
                                        class="icon-option p-2 border-2 border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all duration-200 cursor-pointer"
                                        title="Grupo">
                                        <i class="fas fa-users text-xl text-gray-600"></i>
                                    </button>
                                    <button type="button" onclick="seleccionarIcono('fas fa-user-shield')" data-icon="fas fa-user-shield"
                                        class="icon-option p-2 border-2 border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all duration-200 cursor-pointer"
                                        title="Coach">
                                        <i class="fas fa-user-shield text-xl text-gray-600"></i>
                                    </button>
                                    <button type="button" onclick="seleccionarIcono('fas fa-chart-line')" data-icon="fas fa-chart-line"
                                        class="icon-option p-2 border-2 border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all duration-200 cursor-pointer"
                                        title="Progreso">
                                        <i class="fas fa-chart-line text-xl text-gray-600"></i>
                                    </button>
                                    <button type="button" onclick="seleccionarIcono('fas fa-fire')" data-icon="fas fa-fire"
                                        class="icon-option p-2 border-2 border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all duration-200 cursor-pointer"
                                        title="Intenso">
                                        <i class="fas fa-fire text-xl text-gray-600"></i>
                                    </button>
                                    <button type="button" onclick="seleccionarIcono('fas fa-calendar-check')" data-icon="fas fa-calendar-check"
                                        class="icon-option p-2 border-2 border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all duration-200 cursor-pointer"
                                        title="Horario">
                                        <i class="fas fa-calendar-check text-xl text-gray-600"></i>
                                    </button>
                                    <button type="button" onclick="seleccionarIcono('fas fa-clipboard-list')" data-icon="fas fa-clipboard-list"
                                        class="icon-option p-2 border-2 border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all duration-200 cursor-pointer"
                                        title="Plan">
                                        <i class="fas fa-clipboard-list text-xl text-gray-600"></i>
                                    </button>
                                    <button type="button" onclick="seleccionarIcono('fas fa-star')" data-icon="fas fa-star"
                                        class="icon-option p-2 border-2 border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all duration-200 cursor-pointer"
                                        title="Premium">
                                        <i class="fas fa-star text-xl text-gray-600"></i>
                                    </button>
                                    <button type="button" onclick="seleccionarIcono('fas fa-shield-alt')" data-icon="fas fa-shield-alt"
                                        class="icon-option p-2 border-2 border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all duration-200 cursor-pointer"
                                        title="Protección">
                                        <i class="fas fa-shield-alt text-xl text-gray-600"></i>
                                    </button>
                                </div>
                                <p class="text-xs text-gray-500 mt-2" id="icono-seleccionado">
                                    <i class="fas fa-info-circle mr-1"></i>Seleccione un icono de la lista
                                </p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="orden_detalle" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-sort-numeric-up mr-2 text-blue-600"></i>Orden
                                    </label>
                                    <input type="number" name="orden" id="orden_detalle" min="0"
                                        value="0"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                </div>
                            </div>

                            <div>
                                <label for="tipo" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-tag mr-2 text-blue-600"></i>Tipo*
                                </label>

                                <select name="tipo" id="tipo"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                    required>
                                    <option value="">Seleccione..</option>
                                    <option value="caracteristica">caracteristica</option>
                                    <option value="beneficio">beneficio</option>
                                    <option value="restriccion">restriccion</option>

                                </select>
                            </div>
                        </div>

                        <!-- Botones del modal -->
                        <div class="mt-6 flex flex-col sm:flex-row justify-end gap-3 pt-4 border-t border-gray-200">
                            <button type="button" onclick="cerrarModalDetalle()"
                                class="bg-gray-500 hover:bg-gray-600 text-white hover:text-white px-6 py-2.5 rounded-lg inline-flex items-center justify-center transition-colors duration-200">
                                <i class="fas fa-times mr-2"></i>Cancelar
                            </button>
                            <button type="submit"
                                class="bg-black hover:bg-gray-700 text-white hover:text-white px-6 py-2.5 rounded-lg inline-flex items-center justify-center transition-colors duration-200">
                                <i class="fas fa-save mr-2"></i>Guardar Detalle
                            </button>
                        </div>
                    </form>
                </div>
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
            @if ($plan->detalles->count() > 0)
                $('#tabla-detalles').DataTable({
                    responsive: true,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json'
                    },
                    order: [
                        [0, 'asc']
                    ],
                    pageLength: 10
                });
            @endif

            // Mostrar mensaje de éxito si existe
            @if (session('success'))
                toastr.success('{{ session('success') }}');
            @endif

            // Mostrar errores de validación
            @if ($errors->any())
                toastr.error('{{ $errors->first() }}');
                // Reabrir el modal si hay errores
                setTimeout(() => mostrarModalDetalle(), 100);
            @endif
        });

        function seleccionarIcono(iconClass) {
            // Actualizar el campo hidden
            document.getElementById('icono').value = iconClass;

            // Remover selección anterior
            document.querySelectorAll('.icon-option').forEach(btn => {
                btn.classList.remove('border-blue-600', 'bg-blue-100', 'ring-2', 'ring-blue-400');
                btn.classList.add('border-gray-300');
            });

            // Marcar el icono seleccionado
            const selectedBtn = document.querySelector(`[data-icon="${iconClass}"]`);
            if (selectedBtn) {
                selectedBtn.classList.remove('border-gray-300');
                selectedBtn.classList.add('border-blue-600', 'bg-blue-100', 'ring-2', 'ring-blue-400');
            }

            // Actualizar mensaje
            document.getElementById('icono-seleccionado').innerHTML =
                `<i class="${iconClass} mr-1 text-blue-600"></i>Icono seleccionado: <strong>${iconClass}</strong>`;
        }

        function mostrarModalDetalle() {
            const modal = document.getElementById('modalDetalle');
            const modalTitulo = document.getElementById('modalTitulo');

            modalTitulo.innerHTML = '<i class="fas fa-plus-circle mr-2"></i>Agregar Detalle';
            document.getElementById('formDetalle').action = '{{ route('planes.detalles.store', $plan) }}';
            document.getElementById('metodoPut').value = '';
            document.getElementById('detalleId').value = '';
            document.getElementById('titulo').value = '';
            document.getElementById('descripcion').value = '';
            document.getElementById('icono').value = '';
            document.getElementById('orden_detalle').value = '0';
            document.getElementById('tipo').value = '';

            // Remover selección de iconos
            document.querySelectorAll('.icon-option').forEach(btn => {
                btn.classList.remove('border-blue-600', 'bg-blue-100', 'ring-2', 'ring-blue-400');
                btn.classList.add('border-gray-300');
            });
            document.getElementById('icono-seleccionado').innerHTML =
                '<i class="fas fa-info-circle mr-1"></i>Seleccione un icono de la lista';

            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.style.opacity = '1';
                modal.querySelector('.bg-white').style.transform = 'scale(1)';
            }, 10);

            // Focus en el primer campo
            setTimeout(() => document.getElementById('titulo').focus(), 300);
        }

        function editarDetalle(id, titulo, descripcion, icono, orden, tipo) {
            const modal = document.getElementById('modalDetalle');
            const modalTitulo = document.getElementById('modalTitulo');

            modalTitulo.innerHTML = '<i class="fas fa-edit mr-2"></i>Editar Detalle';
            document.getElementById('formDetalle').action = `/planes/{{ $plan->id }}/detalles/${id}`;
            document.getElementById('metodoPut').value = 'PUT';
            document.getElementById('detalleId').value = id;
            document.getElementById('titulo').value = titulo;
            document.getElementById('descripcion').value = descripcion || '';
            document.getElementById('icono').value = icono || '';
            document.getElementById('orden_detalle').value = orden;
            document.getElementById('tipo').value = tipo || '';

            // Seleccionar el icono actual
            if (icono) {
                setTimeout(() => seleccionarIcono(icono), 100);
            }

            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.style.opacity = '1';
                modal.querySelector('.bg-white').style.transform = 'scale(1)';
            }, 10);

            // Focus en el primer campo
            setTimeout(() => document.getElementById('titulo').focus(), 300);
        }

        function cerrarModalDetalle() {
            const modal = document.getElementById('modalDetalle');
            modal.style.opacity = '0';
            modal.querySelector('.bg-white').style.transform = 'scale(0.95)';
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        function cerrarModalSiClickFuera(event) {
            if (event.target.id === 'modalDetalle') {
                cerrarModalDetalle();
            }
        }

        function eliminarDetalle(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción no se puede revertir",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/planes/{{ $plan->id }}/detalles/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message);
                                location.reload();
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function(xhr) {
                            toastr.error('Error al eliminar el detalle');
                        }
                    });
                }
            });
        }

        // Cerrar modal con tecla ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !document.getElementById('modalDetalle').classList.contains('hidden')) {
                cerrarModalDetalle();
            }
        });
    </script>
</x-app-layout>
