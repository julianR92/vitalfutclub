<x-app-layout>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <section class="bg-white dark:bg-gray-900">
                    <div class="container px-6 py-7 mx-auto">
                        <div class="bg-slate-100/50 py-1 px-3 border-solid border-b rounded-lg mb-4">
                            <x-titulo titulo="Editar Plan"></x-titulo>
                        </div>

                        <div class="grid grid-cols-1 mt-4 xl:mt-4 md:grid-cols-1 xl:grid-cols-1 justify-items-end" style="margin-bottom: 15px;">
                            <div>
                                <a href="{{ route('planes.show', $plan) }}"
                                   class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded inline-flex items-center mr-2">
                                    <i class="fas fa-eye mr-2"></i>Ver Plan
                                </a>
                                <a href="{{ route('planes.index') }}"
                                   class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded inline-flex items-center">
                                    <i class="fas fa-arrow-left mr-2"></i>Volver
                                </a>
                            </div>
                        </div>

                        <form action="{{ route('planes.update', $plan) }}" method="POST" class="p-4">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Columna Izquierda -->
                                <div class="space-y-4">
                                    <div>
                                        <label for="nombre_plan" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-tag mr-1"></i>Nombre del Plan *
                                        </label>
                                        <input type="text" name="nombre_plan" id="nombre_plan"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nombre_plan') border-red-500 @enderror"
                                               value="{{ old('nombre_plan', $plan->nombre_plan) }}" required>
                                        @error('nombre_plan')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="tipo_plan" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-layer-group mr-1"></i>Tipo de Plan *
                                        </label>
                                        <select name="tipo_plan" id="tipo_plan"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tipo_plan') border-red-500 @enderror"
                                                required onchange="handleTipoPlanChange()">
                                            <option value="">Seleccione un tipo</option>
                                            <option value="prepago" {{ old('tipo_plan', $plan->tipo_plan) == 'prepago' ? 'selected' : '' }}>Prepago</option>
                                            <option value="suscripcion" {{ old('tipo_plan', $plan->tipo_plan) == 'suscripcion' ? 'selected' : '' }}>Suscripción</option>
                                        </select>
                                        @error('tipo_plan')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                        <p class="text-xs text-gray-500 mt-1">Las suscripciones tienen duración de 365 días automáticamente</p>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="numero_clases" class="block text-sm font-medium text-gray-700 mb-2">
                                                <i class="fas fa-list-ol mr-1"></i>Número de Clases *
                                            </label>
                                            <input type="number" name="numero_clases" id="numero_clases" min="1"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('numero_clases') border-red-500 @enderror"
                                                   value="{{ old('numero_clases', $plan->numero_clases) }}" required>
                                            @error('numero_clases')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="numero_dias" class="block text-sm font-medium text-gray-700 mb-2">
                                                <i class="fas fa-calendar-days mr-1"></i>Número de Días *
                                            </label>
                                            <input type="number" name="numero_dias" id="numero_dias" min="1"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('numero_dias') border-red-500 @enderror"
                                                   value="{{ old('numero_dias', $plan->numero_dias) }}">
                                            @error('numero_dias')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                            <p class="text-xs text-gray-500 mt-1" id="dias-info">Duración del plan en días</p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="valor" class="block text-sm font-medium text-gray-700 mb-2">
                                                <i class="fas fa-dollar-sign mr-1"></i>Valor *
                                            </label>
                                            <input type="number" name="valor" id="valor" min="0" step="0.01"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('valor') border-red-500 @enderror"
                                                   value="{{ old('valor', $plan->valor) }}" required>
                                            @error('valor')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="descuento" class="block text-sm font-medium text-gray-700 mb-2">
                                                <i class="fas fa-percent mr-1"></i>Descuento (%)
                                            </label>
                                            <input type="number" name="descuento" id="descuento" min="0" max="100" step="0.01"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('descuento') border-red-500 @enderror"
                                                   value="{{ old('descuento', $plan->descuento) }}">
                                            @error('descuento')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div>
                                        <label for="descripcion_corta" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-align-left mr-1"></i>Descripción Corta
                                        </label>
                                        <textarea name="descripcion_corta" id="descripcion_corta" rows="3"
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('descripcion_corta') border-red-500 @enderror">{{ old('descripcion_corta', $plan->descripcion_corta) }}</textarea>
                                        @error('descripcion_corta')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Columna Derecha -->
                                <div class="space-y-4">
                                    <div>
                                        <label for="ciudad_id" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-city mr-1"></i>Ciudad *
                                        </label>
                                        <select name="ciudad_id" id="ciudad_id"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('ciudad_id') border-red-500 @enderror"
                                                required>
                                            <option value="">Seleccione una ciudad</option>
                                            @foreach($ciudades as $ciudad)
                                                <option value="{{ $ciudad->id }}" {{ old('ciudad_id', $plan->ciudad_id) == $ciudad->id ? 'selected' : '' }}>
                                                    {{ $ciudad->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('ciudad_id')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="sede_id" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-building mr-1"></i>Sede *
                                        </label>
                                        <select name="sede_id" id="sede_id"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('sede_id') border-red-500 @enderror"
                                                required>
                                            <option value="">Seleccione una sede</option>
                                            @foreach($sedes as $sede)
                                                <option value="{{ $sede->id }}" data-ciudad="{{ $sede->ciudad_id }}" {{ old('sede_id', $plan->sede_id) == $sede->id ? 'selected' : '' }}>
                                                    {{ $sede->nombre_sede }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sede_id')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="orden" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-sort-numeric-up mr-1"></i>Orden
                                        </label>
                                        <input type="number" name="orden" id="orden" min="0"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('orden') border-red-500 @enderror"
                                               value="{{ old('orden', $plan->orden) }}">
                                        @error('orden')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                        <p class="text-xs text-gray-500 mt-1">Orden en que aparecerá en la web (menor número = mayor prioridad)</p>
                                    </div>

                                    <div class="flex items-center">
                                        <input type="checkbox" name="visible_web" id="visible_web" value="1"
                                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                               {{ old('visible_web', $plan->visible_web) ? 'checked' : '' }}>
                                        <label for="visible_web" class="ml-2 block text-sm font-medium text-gray-700">
                                            <i class="fas fa-eye mr-1"></i>Visible en página web
                                        </label>
                                    </div>

                                    <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                                        <h4 class="text-sm font-semibold text-yellow-800 mb-2">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>Advertencia
                                        </h4>
                                        <p class="text-xs text-yellow-700">
                                            Los cambios en el plan no afectarán a los clientes que ya tienen planes activos.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 flex flex-col sm:flex-row justify-end gap-3">
                                <a href="{{ route('planes.index') }}"
                                   class="bg-gray-500 hover:bg-gray-700 text-white hover:text-white px-6 py-2 rounded inline-flex items-center justify-center">
                                    <i class="fas fa-times mr-2"></i>Cancelar
                                </a>
                                <button type="submit"
                                        class="bg-purple-600 hover:bg-purple-700 text-white hover:text-white px-6 py-2 rounded inline-flex items-center justify-center">
                                    <i class="fas fa-save mr-2"></i>Actualizar Plan
                                </button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function handleTipoPlanChange() {
            const tipoPlan = document.getElementById('tipo_plan').value;
            const numeroDiasInput = document.getElementById('numero_dias');
            const diasInfo = document.getElementById('dias-info');

            if (tipoPlan === 'suscripcion') {
                numeroDiasInput.value = 365;
                numeroDiasInput.readOnly = true;
                numeroDiasInput.classList.add('bg-gray-100', 'cursor-not-allowed');
                diasInfo.textContent = 'Las suscripciones tienen duración fija de 365 días';
                diasInfo.classList.add('text-blue-600', 'font-semibold');
            } else {
                numeroDiasInput.readOnly = false;
                numeroDiasInput.classList.remove('bg-gray-100', 'cursor-not-allowed');
                diasInfo.textContent = 'Duración del plan en días';
                diasInfo.classList.remove('text-blue-600', 'font-semibold');
            }
        }

        $(document).ready(function() {
            // Trigger inicial si hay tipo_plan seleccionado
            if ($('#tipo_plan').val()) {
                handleTipoPlanChange();
            }

            // Filtrar sedes por ciudad seleccionada
            $('#ciudad_id').on('change', function() {
                var ciudadId = $(this).val();
                var $sedeSelect = $('#sede_id');

                if (ciudadId) {
                    // Mostrar solo las sedes de la ciudad seleccionada
                    $sedeSelect.find('option').each(function() {
                        var $option = $(this);
                        if ($option.val() === '') {
                            $option.show();
                        } else if ($option.data('ciudad') == ciudadId) {
                            $option.show();
                        } else {
                            $option.hide();
                        }
                    });

                    // Resetear selección si la sede actual no pertenece a la ciudad
                    var currentSede = $sedeSelect.val();
                    if (currentSede) {
                        var currentCiudad = $sedeSelect.find('option:selected').data('ciudad');
                        if (currentCiudad != ciudadId) {
                            $sedeSelect.val('');
                        }
                    }
                } else {
                    // Mostrar todas las sedes si no hay ciudad seleccionada
                    $sedeSelect.find('option').show();
                }
            });

            // Trigger inicial si hay ciudad seleccionada
            if ($('#ciudad_id').val()) {
                $('#ciudad_id').trigger('change');
            }
        });
    </script>
</x-app-layout>
