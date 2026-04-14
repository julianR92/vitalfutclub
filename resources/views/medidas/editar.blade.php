<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                Medidas Corporales — Registro de Sesión
            </h2>
            <div class="flex items-center gap-2">
                <a href="{{ route('medidas.historial') }}"
                   class="inline-flex items-center gap-1 text-sm px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Historial
                </a>
                <a href="{{ route('medidas.seleccionar', ['sesion_id' => $sesion->id]) }}"
                   class="inline-flex items-center gap-1 text-sm px-4 py-2 bg-orange-100 hover:bg-orange-200 text-orange-700 font-medium rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v16m8-8H4"/>
                    </svg>
                    Agregar más clientes
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ── Encabezado informativo ──────────────────────────────────────── --}}
            <div class="bg-white rounded-2xl shadow p-5 mb-6">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500 block">Sede</span>
                        <span class="font-semibold text-gray-800">{{ $sesion->sede->nombre_sede }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Fecha</span>
                        <span class="font-semibold text-gray-800">{{ $sesion->fecha->format('d/m/Y') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Registrado por</span>
                        <span class="font-semibold text-gray-800">{{ $sesion->user->name }}</span>
                    </div>
                </div>
                @if($sesion->nota)
                    <p class="mt-3 text-sm text-gray-500">
                        <span class="font-medium">Nota:</span> {{ $sesion->nota }}
                    </p>
                @endif
            </div>

            {{-- ── Leyenda ──────────────────────────────────────────────────────── --}}
            <div class="flex items-center gap-4 text-xs text-gray-500 mb-3">
                <span class="flex items-center gap-1">
                    <span class="w-3 h-3 rounded-full bg-green-500 inline-block"></span>
                    Fila completa (tiene peso y altura)
                </span>
                <span class="flex items-center gap-1">
                    <span class="w-3 h-3 rounded-full bg-red-400 inline-block"></span>
                    Faltan datos básicos
                </span>
            </div>

            {{-- ── Tabla ────────────────────────────────────────────────────────── --}}
            <div class="bg-white rounded-2xl shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border-collapse" id="tabla-medidas">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wide">
                                <th class="px-3 py-3 text-left sticky left-0 bg-gray-50 z-20 min-w-[180px] border-r border-gray-200">Cliente</th>
                                <th class="px-3 py-3 text-center min-w-[80px]">Altura<br><span class="normal-case font-normal">(cm)</span></th>
                                <th class="px-3 py-3 text-center min-w-[80px]">Peso<br><span class="normal-case font-normal">(kg)</span></th>
                                <th class="px-3 py-3 text-center min-w-[75px]">IMC</th>
                                <th class="px-3 py-3 text-center min-w-[65px]">Edad</th>
                                <th class="px-3 py-3 text-center min-w-[85px]">TMB<br><span class="normal-case font-normal text-gray-400">(kcal)</span></th>
                                <th class="px-3 py-3 text-center min-w-[80px]">% Grasa</th>
                                <th class="px-3 py-3 text-center min-w-[80px]">% Músculo</th>
                                <th class="px-3 py-3 text-center min-w-[80px]">Gr. Visceral</th>
                                <th class="px-3 py-3 text-center min-w-[80px]">Sentadillas</th>
                                <th class="px-3 py-3 text-center min-w-[80px]">Abdominales</th>
                                <th class="px-3 py-3 text-center min-w-[80px]">Flexiones</th>
                                <th class="px-3 py-3 text-center min-w-[80px]">Elasticidad<br><span class="normal-case font-normal">(cm)</span></th>
                                <th class="px-3 py-3 text-center min-w-[85px]">Test Resist.<br><span class="normal-case font-normal text-gray-400">(Course Nav.)</span></th>
                                <th class="px-3 py-3 text-center min-w-[160px]">Notas</th>
                                <th class="px-3 py-3 text-center w-10"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sesion->detalles->where('status', 1) as $detalle)
                                <tr class="fila-medida border-t border-gray-100 hover:bg-orange-50/30 transition"
                                    data-id="{{ $detalle->id }}">

                                    {{-- Nombre + indicador --}}
                                    <td class="px-3 py-2 sticky left-0 bg-white z-10 border-r border-gray-200">
                                        <div class="flex items-center gap-2">
                                            <span class="indicador w-2.5 h-2.5 rounded-full flex-shrink-0
                                                {{ ($detalle->peso_kg && $detalle->altura_cm) ? 'bg-green-500' : 'bg-red-400' }}">
                                            </span>
                                            <div class="leading-tight">
                                                <span class="font-medium text-gray-800 block">{{ $detalle->persona->nombre_completo }}</span>
                                                <span class="text-xs text-gray-400">{{ $detalle->persona->documento }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Altura --}}
                                    <td class="p-0">
                                        <input type="number" step="0.1" min="0" max="300"
                                            class="input-medida w-full px-2 py-2 text-center"
                                            data-campo="altura_cm" value="{{ $detalle->altura_cm ?? '' }}" placeholder="—">
                                    </td>

                                    {{-- Peso --}}
                                    <td class="p-0">
                                        <input type="number" step="0.1" min="0" max="500"
                                            class="input-medida w-full px-2 py-2 text-center"
                                            data-campo="peso_kg" value="{{ $detalle->peso_kg ?? '' }}" placeholder="—">
                                    </td>

                                    {{-- IMC (ingreso manual — fórmula desactivada) --}}
                                    <td class="p-0">
                                        <input type="number" step="0.01" min="0" max="100"
                                            class="input-medida w-full px-2 py-2 text-center"
                                            data-campo="imc" value="{{ $detalle->imc ?? '' }}" placeholder="—">
                                    </td>

                                    {{-- Edad (ingreso manual — fórmula desactivada) --}}
                                    <td class="p-0">
                                        <input type="number" step="1" min="0" max="120"
                                            class="input-medida w-full px-2 py-2 text-center"
                                            data-campo="edad_al_momento" value="{{ $detalle->edad_al_momento ?? '' }}" placeholder="—">
                                    </td>

                                    {{-- TMB (ingreso manual — fórmula desactivada) --}}
                                    <td class="p-0">
                                        <input type="number" step="1" min="0"
                                            class="input-medida w-full px-2 py-2 text-center"
                                            data-campo="metabolismo_basal" value="{{ $detalle->metabolismo_basal ?? '' }}" placeholder="—">
                                    </td>

                                    {{-- % Grasa --}}
                                    <td class="p-0">
                                        <input type="number" step="0.1" min="0" max="100"
                                            class="input-medida w-full px-2 py-2 text-center"
                                            data-campo="porcentaje_grasa" value="{{ $detalle->porcentaje_grasa ?? '' }}" placeholder="—">
                                    </td>

                                    {{-- % Músculo --}}
                                    <td class="p-0">
                                        <input type="number" step="0.1" min="0" max="100"
                                            class="input-medida w-full px-2 py-2 text-center"
                                            data-campo="porcentaje_musculo" value="{{ $detalle->porcentaje_musculo ?? '' }}" placeholder="—">
                                    </td>

                                    {{-- Grasa Visceral --}}
                                    <td class="p-0">
                                        <input type="number" step="0.1" min="0"
                                            class="input-medida w-full px-2 py-2 text-center"
                                            data-campo="grasa_visceral" value="{{ $detalle->grasa_visceral ?? '' }}" placeholder="—">
                                    </td>

                                    {{-- Sentadillas --}}
                                    <td class="p-0">
                                        <input type="number" step="1" min="0"
                                            class="input-medida w-full px-2 py-2 text-center"
                                            data-campo="sentadillas" value="{{ $detalle->sentadillas ?? '' }}" placeholder="—">
                                    </td>

                                    {{-- Abdominales --}}
                                    <td class="p-0">
                                        <input type="number" step="1" min="0"
                                            class="input-medida w-full px-2 py-2 text-center"
                                            data-campo="abdominales" value="{{ $detalle->abdominales ?? '' }}" placeholder="—">
                                    </td>

                                    {{-- Flexiones --}}
                                    <td class="p-0">
                                        <input type="number" step="1" min="0"
                                            class="input-medida w-full px-2 py-2 text-center"
                                            data-campo="flexiones" value="{{ $detalle->flexiones ?? '' }}" placeholder="—">
                                    </td>

                                    {{-- Elasticidad (cm) --}}
                                    <td class="p-0">
                                        <input type="number" step="0.1" min="-100"
                                            class="input-medida w-full px-2 py-2 text-center"
                                            data-campo="elasticidad" value="{{ $detalle->elasticidad ?? '' }}" placeholder="—">
                                    </td>

                                    {{-- Test Resistencia (Course Navette) --}}
                                    <td class="p-0">
                                        <input type="number" step="0.5" min="0" max="15"
                                            class="input-medida w-full px-2 py-2 text-center"
                                            data-campo="test_resistencia" value="{{ $detalle->test_resistencia ?? '' }}" placeholder="—">
                                    </td>

                                    {{-- Notas --}}
                                    <td class="p-0">
                                        <input type="text"
                                            class="input-medida w-full px-2 py-2"
                                            data-campo="notas" value="{{ $detalle->notas ?? '' }}"
                                            placeholder="—" maxlength="1000">
                                    </td>

                                    {{-- Acción: poner status = 0 (quitar de la sesión) --}}
                                    <td class="px-2 py-2 text-center">
                                        <button type="button" class="btn-quitar text-gray-300 hover:text-red-500 transition"
                                            title="Quitar de la sesión">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-start p-4 border-t border-gray-100">
                    <a href="{{ route('medidas.seleccionar') }}"
                       class="text-orange-600 hover:underline font-medium">
                        ← Volver a seleccionar
                    </a>
                </div>

                {{-- Botón finalizar --}}
                <div class="flex justify-end p-4 border-t border-gray-100">
                    <button type="button" id="btn-finalizar"
                        class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow transition focus:outline-none focus:ring-2 focus:ring-green-500">
                        Finalizar sesión
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Modal de confirmación ────────────────────────────────────────────── --}}
    <div id="modal-finalizar" class="fixed inset-0 z-50 hidden flex items-center justify-center">
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/40" id="modal-backdrop"></div>
        {{-- Contenido --}}
        <div class="relative bg-white rounded-2xl shadow-2xl p-8 max-w-sm w-full mx-4 z-10">
            <h3 class="text-lg font-bold text-gray-800 mb-2">¿Finalizar sesión?</h3>
            <p class="text-sm text-gray-500 mb-6">
                Se marcarán como completados los clientes que tengan peso y altura registrados.
                Esta acción no se puede deshacer.
            </p>
            <div class="flex gap-3 justify-end">
                <button type="button" id="modal-cancelar"
                    class="px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">
                    Cancelar
                </button>
                <form method="POST" action="{{ route('medidas.finalizar', $sesion) }}" id="form-finalizar">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 text-sm bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition">
                        Sí, finalizar
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ── Modal: quitar cliente de la sesión ────────────────────────────── --}}
    <div id="modal-quitar" class="fixed inset-0 z-50 hidden flex items-center justify-center">
        <div class="absolute inset-0 bg-black/40" id="modal-quitar-backdrop"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl p-8 max-w-sm w-full mx-4 z-10">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-800">Quitar cliente</h3>
                    <p class="text-xs text-gray-400" id="modal-quitar-nombre"></p>
                </div>
            </div>
            <p class="text-sm text-gray-500 mb-6">
                Se quitará este cliente de la sesión actual. Los datos ingresados
                <span class="font-medium text-gray-700">se eliminarán</span> del sistema.
            </p>
            <div class="flex gap-3 justify-end">
                <button type="button" id="modal-quitar-cancelar"
                    class="px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">
                    Cancelar
                </button>
                <button type="button" id="modal-quitar-confirmar"
                    class="px-4 py-2 text-sm bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                    Sí, quitar
                </button>
            </div>
        </div>
    </div>

    <style>
    .input-medida {
        border: none;
        outline: none;
        background: transparent;
        font-size: 0.875rem;
        color: #374151;
        transition: background 0.15s, box-shadow 0.15s;
        min-width: 80px;
    }
    .input-medida:focus {
        background: #fff7ed;
        box-shadow: inset 0 0 0 2px #f97316;
        outline: none;
        z-index: 5;
        position: relative;
    }
    .input-medida::placeholder {
        color: #d1d5db;
    }
    /* Alinear inputs de texto igual */
    td.p-0 {
        padding: 0 !important;
    }
    </style>

    <script>
    (function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // ── Recopilar todos los inputs editables por fila ──────────────────
        const filas = Array.from(document.querySelectorAll('.fila-medida'));

        // Construir lista plana de inputs (solo editables, no calculados)
        function getInputsEditables() {
            return Array.from(document.querySelectorAll('.input-medida'));
        }

        // ── Guardar campo al salir del input (blur) ────────────────────────
        document.addEventListener('blur', async function (e) {
            if (!e.target.classList.contains('input-medida')) return;

            const input  = e.target;
            const fila   = input.closest('.fila-medida');
            const detalleId = fila.dataset.id;
            const campo  = input.dataset.campo;
            // Normalizar: reemplazar coma por punto para campos numéricos
            const valor  = input.value.trim().replace(',', '.');

            // No enviar si el valor no cambió (guardamos valor previo)
            if (input.dataset.previo === valor) return;
            input.dataset.previo = valor;

            const body = {};
            body[campo] = valor === '' ? null : valor;

            try {
                const res = await fetch(`/medidas/${detalleId}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(body),
                });

                if (!res.ok) {
                    const err = await res.json().catch(() => ({}));
                    mostrarToast(err.message || 'Error al guardar el dato.', 'error');
                    return;
                }

                const data = await res.json();

                // Fórmulas desactivadas — los campos imc, edad y tmb se ingresan manualmente.
                // Las celdas calculadas ya no existen; no hay nada que actualizar en el DOM.
                // (Código conservado por referencia)
                // fila.querySelector('.campo-calculado-imc').textContent = ...
                // fila.querySelector('.campo-calculado-edad').textContent = ...
                // fila.querySelector('.campo-calculado-tmb').textContent = ...

                // Actualizar indicador color
                actualizarIndicador(fila, data.completado);

                // Flash breve de guardado en la celda
                input.style.background = '#dcfce7';
                setTimeout(() => { input.style.background = ''; }, 600);

            } catch (err) {
                mostrarToast('Error de red. Verifica tu conexión.', 'error');
            }
        }, true); // captura en fase de captura para blur

        // Guardar valor previo al hacer focus
        document.addEventListener('focus', function (e) {
            if (e.target.classList.contains('input-medida')) {
                e.target.dataset.previo = e.target.value.trim();
            }
        }, true);

        // ── Navegación tipo Excel ──────────────────────────────────────────
        document.addEventListener('keydown', function (e) {
            if (!e.target.classList.contains('input-medida')) return;

            const inputs = getInputsEditables();
            const idx    = inputs.indexOf(e.target);

            if (e.key === 'Tab') {
                // Comportamiento nativo del Tab ya funciona bien; podemos dejarlo
                return;
            }

            if (e.key === 'Enter') {
                e.preventDefault();

                // Contar columnas editables por fila
                const filaActual = e.target.closest('.fila-medida');
                const inputsFila = Array.from(filaActual.querySelectorAll('.input-medida'));
                const colIdx     = inputsFila.indexOf(e.target);
                const numCols    = inputsFila.length;

                // Bajar a la misma columna en la siguiente fila
                const siguienteIdx = idx + numCols;
                if (siguienteIdx < inputs.length) {
                    inputs[siguienteIdx].focus();
                    inputs[siguienteIdx].select();
                }
            }
        });

        // ── Indicador visual por fila ──────────────────────────────────────
        function actualizarIndicador(fila, completado) {
            const indicador = fila.querySelector('.indicador');
            indicador.classList.toggle('bg-green-500', !!completado);
            indicador.classList.toggle('bg-red-400', !completado);
        }

        // ── Modal de finalizar ─────────────────────────────────────────────
        const modal           = document.getElementById('modal-finalizar');
        const btnFinalizar    = document.getElementById('btn-finalizar');
        const btnCancelar     = document.getElementById('modal-cancelar');
        const modalBackdrop   = document.getElementById('modal-backdrop');

        btnFinalizar.addEventListener('click', () => {
            // Validar que todos los campos numéricos estén completos
            const inputs = Array.from(document.querySelectorAll('.input-medida[type="number"]'));
            const vacios  = inputs.filter(i => i.value.trim() === '');

            if (vacios.length > 0) {
                vacios.forEach(i => {
                    i.style.boxShadow = 'inset 0 0 0 2px #ef4444';
                    i.style.background = '#fef2f2';
                });
                mostrarToast(
                    `Faltan ${vacios.length} campo${vacios.length > 1 ? 's' : ''} por completar. Completa todos los valores antes de finalizar.`,
                    'error'
                );
                vacios[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                vacios[0].focus();
                setTimeout(() => vacios.forEach(i => {
                    i.style.boxShadow = '';
                    i.style.background = '';
                }), 3500);
                return;
            }

            modal.classList.remove('hidden');
        });
        btnCancelar.addEventListener('click', () => modal.classList.add('hidden'));
        modalBackdrop.addEventListener('click', () => modal.classList.add('hidden'));

        // ── Modal: quitar fila (status = 0) ────────────────────────────────
        let filaAQuitar = null;

        const modalQuitar          = document.getElementById('modal-quitar');
        const btnQuitarConfirmar   = document.getElementById('modal-quitar-confirmar');
        const btnQuitarCancelar    = document.getElementById('modal-quitar-cancelar');
        const modalQuitarBackdrop  = document.getElementById('modal-quitar-backdrop');
        const labelQuitarNombre    = document.getElementById('modal-quitar-nombre');

        function cerrarModalQuitar() {
            modalQuitar.classList.add('hidden');
            filaAQuitar = null;
        }

        // Abrir modal al pulsar el botón papelera
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.btn-quitar');
            if (!btn) return;
            filaAQuitar = btn.closest('.fila-medida');
            const nombre = filaAQuitar.querySelector('.font-medium.text-gray-800')?.textContent?.trim() ?? '';
            labelQuitarNombre.textContent = nombre;
            modalQuitar.classList.remove('hidden');
        });

        btnQuitarCancelar.addEventListener('click', cerrarModalQuitar);
        modalQuitarBackdrop.addEventListener('click', cerrarModalQuitar);

        // Confirmar → PATCH status = 0
        btnQuitarConfirmar.addEventListener('click', async function () {
            if (!filaAQuitar) return;
            const fila      = filaAQuitar;
            const detalleId = fila.dataset.id;
            cerrarModalQuitar();

            try {
                const res = await fetch(`/medidas/${detalleId}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ status: 0 }),
                });

                if (!res.ok) {
                    mostrarToast('No se pudo quitar el registro.', 'error');
                    return;
                }

                // Animar y remover fila del DOM
                fila.style.transition = 'opacity 0.3s, transform 0.3s';
                fila.style.opacity    = '0';
                fila.style.transform  = 'translateX(16px)';
                setTimeout(() => fila.remove(), 300);

            } catch (err) {
                mostrarToast('Error de red. Verifica tu conexión.', 'error');
            }
        });

        // ── Toast ──────────────────────────────────────────────────────────
        function mostrarToast(mensaje, tipo = 'error') {
            const colores = tipo === 'error'
                ? 'bg-red-600 text-white'
                : 'bg-green-600 text-white';

            const toast = document.createElement('div');
            toast.className = `fixed bottom-5 right-5 z-50 px-5 py-3 rounded-lg shadow-lg text-sm font-medium transition-opacity duration-400 ${colores}`;
            toast.textContent = mensaje;
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 400);
            }, 3000);
        }

        // Exponer para uso externo si se necesita
        window.mostrarToast = mostrarToast;
    })();
    </script>
</x-app-layout>
