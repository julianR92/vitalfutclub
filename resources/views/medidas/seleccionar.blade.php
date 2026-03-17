<x-app-layout>
    <style>
        th:not(:last-child) {
            border-bottom: none;
        }
    </style>
   <x-slot name="header">
    <div class="flex items-center justify-between">

        <h2 class="text-xl font-semibold text-gray-900 tracking-tight">
            Medidas Corporales
            <span class="block text-sm font-normal text-gray-500">
                Seleccionar clientes
            </span>
        </h2>

        <a href="{{ route('medidas.historial') }}"
           class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-xl shadow-sm transition-all duration-200 hover:bg-gray-50 hover:shadow focus:outline-none focus:ring-2 focus:ring-orange-400">

            <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>

            Ver historial
        </a>

    </div>
</x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ── Éxito ───────────────────────────────────────────────── --}}
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-lg border border-green-300">
                    {{ session('success') }}
                </div>
            @endif
            {{-- ── Acceso rápido al historial ──────────────────────────── --}}
            <a href="{{ route('medidas.historial') }}"
               class="flex items-center justify-between mb-5 px-5 py-3.5 bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-md hover:border-orange-300 transition group">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-orange-100 flex items-center justify-center flex-shrink-0 group-hover:bg-orange-200 transition">
                        <svg class="w-4 h-4 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Historial de sesiones</p>
                        <p class="text-xs text-gray-400">Ver, editar o eliminar sesiones anteriores</p>
                    </div>
                </div>
                <svg class="w-4 h-4 text-gray-400 group-hover:text-orange-500 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
            {{-- ── Sesiones con medidas pendientes ─────────────────────── --}}
            @if ($sesionesIncompletas->isNotEmpty())
                <div class="mb-6 rounded-2xl overflow-hidden border border-amber-200 shadow-sm">
                    <div class="flex items-center gap-2.5 px-5 py-3 bg-amber-50 border-b border-amber-200">
                        <svg class="w-4 h-4 text-amber-500 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                        </svg>
                        <span class="font-semibold text-amber-800 text-sm">
                            @if(auth()->user()->rol === 'admin')
                                {{ $sesionesIncompletas->count() === 1 ? 'Hay 1 sesión' : "Hay {$sesionesIncompletas->count()} sesiones" }}
                                con medidas pendientes de completar
                            @else
                                {{ $sesionesIncompletas->count() === 1 ? 'Tienes 1 sesión' : "Tienes {$sesionesIncompletas->count()} sesiones" }}
                                con medidas pendientes de completar
                            @endif
                        </span>
                    </div>
                    <div class="bg-white divide-y divide-gray-100">
                        @foreach ($sesionesIncompletas as $si)
                            <div class="flex items-center justify-between px-5 py-3 hover:bg-amber-50/60 transition">
                                <div class="flex items-center gap-4 min-w-0">
                                    <div
                                        class="flex-shrink-0 w-9 h-9 rounded-full bg-amber-100 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-gray-800">
                                            {{ $si->fecha->format('d/m/Y') }}
                                            <span class="text-gray-400 font-normal mx-1">·</span>
                                            <span class="text-gray-600 font-normal">{{ $si->sede->nombre_sede }}</span>
                                        </p>
                                        <div class="flex items-center gap-2 mt-1">
                                            {{-- Barra de progreso --}}
                                            @php
                                                $pct =
                                                    $si->detalles_count > 0
                                                        ? round(($si->completados_count / $si->detalles_count) * 100)
                                                        : 0;
                                            @endphp
                                            <div class="w-24 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                                <div class="h-full rounded-full {{ $pct === 100 ? 'bg-green-500' : 'bg-amber-400' }}"
                                                    style="width: {{ $pct }}%"></div>
                                            </div>
                                            <span class="text-xs text-gray-500">
                                                {{ $si->completados_count }}/{{ $si->detalles_count }} medidos
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('medidas.editar', $si) }}"
                                    class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-orange-500 rounded-xl shadow-sm transition-all duration-200 hover:bg-orange-600 hover:shadow-md hover:-translate-y-0.5 active:translate-y-0 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:ring-offset-1">

                                    Ir a completar

                                    <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:translate-x-0.5"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>

                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ── Formulario ──────────────────────────────────────────── --}}
            @php
                $idsEnSesion = isset($sesionActiva) ? $sesionActiva->detalles->pluck('persona_id')->toArray() : [];
            @endphp

            <form method="POST" action="{{ route('medidas.crear') }}" id="form-seleccionar">
                @csrf
                @if (isset($sesionActiva))
                    <input type="hidden" name="sesion_id" value="{{ $sesionActiva->id }}">
                @endif

                {{-- ── Datos de la sesión ──────────────────────────────── --}}
                <div class="bg-white rounded-2xl shadow p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Datos de la Sesión</h3>

                    @if (isset($sesionActiva))
                        <div class="p-3 bg-blue-50 text-blue-800 rounded-lg border border-blue-200 text-sm">
                            Agregando clientes a la sesión del
                            <strong>{{ $sesionActiva->fecha->format('d/m/Y') }}</strong>.
                            Ya tiene {{ $sesionActiva->detalles->count() }} cliente(s) registrado(s).
                        </div>
                        <input type="hidden" name="sede_id" value="{{ $sesionActiva->sede_id }}">
                        <input type="hidden" name="fecha" value="{{ $sesionActiva->fecha->format('Y-m-d') }}">
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1" for="sede_id">
                                    Sede <span class="text-red-500">*</span>
                                </label>
                                <select name="sede_id" id="sede_id" required
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                                    <option value="">— Seleccione sede —</option>
                                    @foreach ($sedes as $sede)
                                        <option value="{{ $sede->id }}"
                                            {{ old('sede_id') == $sede->id ? 'selected' : '' }}>
                                            {{ $sede->nombre_sede }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('sede_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1" for="fecha">
                                    Fecha <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="fecha" id="fecha" required
                                    value="{{ old('fecha', date('Y-m-d')) }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400"
                                    max="{{ date('Y-m-d') }}">
                                @error('fecha')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1" for="nota">
                                    Nota (opcional)
                                </label>
                                <input type="text" name="nota" id="nota" value="{{ old('nota') }}"
                                    placeholder="Observaciones generales..."
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                            </div>
                        </div>
                    @endif
                </div>

                {{-- ── Panel de seleccionados (chips) ──────────────────── --}}
                <div id="panel-chips"
                    class="hidden mb-4 bg-orange-50 border border-orange-200 rounded-2xl overflow-hidden">
                    <div class="flex items-center justify-between px-5 py-3 border-b border-orange-100">
                        <span class="flex items-center gap-2 text-sm font-semibold text-orange-700">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                            </svg>
                            Seleccionados:
                            <span id="chips-count"
                                class="inline-flex items-center justify-center w-5 h-5 text-xs bg-orange-500 text-white rounded-full font-bold">0</span>
                        </span>
                        <button type="button" id="btn-limpiar"
                            class="text-xs text-gray-400 hover:text-red-500 transition font-medium">
                            Limpiar selección
                        </button>
                    </div>
                    <div id="chips-container" class="flex flex-wrap gap-2 p-4"></div>
                </div>

                {{-- Container oculto de hidden inputs para el submit --}}
                <div id="inputs-hidden" aria-hidden="true"></div>

                {{-- ── Lista de clientes ────────────────────────────────── --}}
                <div class="bg-white rounded-2xl shadow p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                        <h3 class="text-lg font-semibold text-gray-700">
                            Clientes
                            <span id="txt-contador" class="text-sm font-normal text-orange-500"></span>
                        </h3>
                        <div class="flex items-center gap-2 flex-wrap">
                            <div class="relative">
                                <input type="text" id="buscador" placeholder="Buscar nombre o documento..."
                                    class="border border-gray-300 rounded-lg pl-8 pr-3 py-2 text-sm w-56 focus:outline-none focus:ring-2 focus:ring-orange-400">
                                {{-- <svg class="absolute left-2 top-2.5 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/>
                                </svg> --}}
                            </div>
                            <button type="button" id="btn-sel-pagina"
                                class="text-xs px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition whitespace-nowrap">
                                Sel. página
                            </button>
                            <button type="button" id="btn-sel-todos"
                                class="text-xs px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition whitespace-nowrap">
                                Sel. todos
                            </button>
                        </div>
                    </div>

                    @error('personas_ids')
                        <p class="text-red-500 text-sm mb-3">{{ $message }}</p>
                    @enderror

                    <div class="border border-gray-200 rounded-xl overflow-hidden">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left w-10">
                                        <input type="checkbox" id="check-all"
                                            class="rounded border-gray-300 text-orange-500 focus:ring-orange-400"
                                            title="Seleccionar/Deseleccionar página">
                                    </th>
                                    <th class="px-4 py-3 text-left font-medium text-gray-600">Nombre completo</th>
                                    <th class="px-4 py-3 text-left font-medium text-gray-600">Documento</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-clientes">{{-- Renderizado por JS --}}</tbody>
                        </table>
                    </div>

                    {{-- Paginación --}}
                    <div id="paginacion"></div>

                    {{-- Botón Continuar --}}
                    <div class="flex justify-end mt-6">
                        <button type="submit"
                            class="px-6 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg shadow transition focus:outline-none focus:ring-2 focus:ring-orange-400">
                            Continuar →
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <script>
        (function() {
            // ── Datos del servidor ────────────────────────────────────────
            const CLIENTES = @json($clientes);
            const IDS_EN_SESION = @json($idsEnSesion);
            const POR_PAGINA = 25;

            // ── Estado ───────────────────────────────────────────────────
            let paginaActual = 1;
            let filtro = '';
            const sel = new Map(); // persona_id (Number) => nombre_completo (String)

            // ── DOM ──────────────────────────────────────────────────────
            const tbody = document.getElementById('tbody-clientes');
            const elPag = document.getElementById('paginacion');
            const panelChips = document.getElementById('panel-chips');
            const chipsWrap = document.getElementById('chips-container');
            const inputsHidden = document.getElementById('inputs-hidden');
            const chipsCount = document.getElementById('chips-count');
            const txtContador = document.getElementById('txt-contador');
            const checkAll = document.getElementById('check-all');
            const form = document.getElementById('form-seleccionar');

            // ── Escape HTML ──────────────────────────────────────────────
            function esc(v) {
                const d = document.createElement('div');
                d.appendChild(document.createTextNode(String(v ?? '')));
                return d.innerHTML;
            }

            // ── Filtrado ─────────────────────────────────────────────────
            function filtrados() {
                if (!filtro) return CLIENTES;
                const q = filtro.toLowerCase();
                return CLIENTES.filter(c =>
                    c.nombre_completo.toLowerCase().includes(q) ||
                    String(c.documento).toLowerCase().includes(q)
                );
            }

            // ── Renderizar tabla ─────────────────────────────────────────
            function renderTabla() {
                const lista = filtrados();
                const total = lista.length;
                const totalPags = Math.max(1, Math.ceil(total / POR_PAGINA));
                if (paginaActual > totalPags) paginaActual = 1;

                const inicio = (paginaActual - 1) * POR_PAGINA;
                const pagina = lista.slice(inicio, inicio + POR_PAGINA);

                if (pagina.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="3" class="px-4 py-8 text-center text-gray-400 text-sm">
                    No se encontraron clientes con ese criterio.</td></tr>`;
                } else {
                    tbody.innerHTML = pagina.map(c => {
                        const enSesion = IDS_EN_SESION.includes(c.persona_id);
                        const checked = enSesion || sel.has(c.persona_id);
                        const rClass = enSesion ? 'bg-gray-50 opacity-60' : '';
                        return `
                    <tr class="border-t border-gray-100 hover:bg-orange-50/60 transition ${rClass}">
                        <td class="px-4 py-2.5">
                            <input type="checkbox"
                                data-pid="${c.persona_id}"
                                data-nombre="${c.nombre_completo.replace(/"/g, '&quot;')}"
                                class="check-cli rounded border-gray-300 text-orange-500 focus:ring-orange-400"
                                ${enSesion ? 'disabled checked' : (checked ? 'checked' : '')}>
                        </td>
                        <td class="px-4 py-2.5 text-gray-800">
                            ${esc(c.nombre_completo)}
                            ${enSesion ? '<span class="ml-2 text-xs text-orange-400 font-medium">ya en sesión</span>' : ''}
                        </td>
                        <td class="px-4 py-2.5 text-gray-500">${esc(c.documento)}</td>
                    </tr>`;
                    }).join('');
                }

                renderPaginacion(totalPags, total);
                syncCheckAll();
            }

            // ── Renderizar paginación ─────────────────────────────────────
            function renderPaginacion(totalPags, total) {
                if (totalPags <= 1) {
                    elPag.innerHTML = '';
                    return;
                }

                const ini = (paginaActual - 1) * POR_PAGINA + 1;
                const fin = Math.min(paginaActual * POR_PAGINA, total);
                const rango = 2;
                const pIni = Math.max(1, paginaActual - rango);
                const pFin = Math.min(totalPags, paginaActual + rango);

                const base = 'px-3 py-1.5 rounded-lg border text-sm transition';
                const activo = `${base} border-orange-400 bg-orange-500 text-white font-semibold`;
                const normal = `${base} border-gray-300 text-gray-600 hover:bg-gray-100`;
                const disable = `${base} border-gray-200 text-gray-300 cursor-not-allowed`;

                let h = `<div class="flex items-center justify-between mt-4">
                <span class="text-xs text-gray-400">Mostrando <strong class="text-gray-600">${ini}–${fin}</strong> de <strong class="text-gray-600">${total}</strong></span>
                <div class="flex items-center gap-1">`;

                h +=
                    `<button type="button" class="btn-pag ${paginaActual===1?disable:normal}" data-pag="${paginaActual-1}" ${paginaActual===1?'disabled':''}>‹</button>`;

                if (pIni > 1) {
                    h += `<button type="button" class="btn-pag ${normal}" data-pag="1">1</button>`;
                    if (pIni > 2) h += `<span class="px-1 text-gray-300">…</span>`;
                }
                for (let i = pIni; i <= pFin; i++) {
                    h +=
                        `<button type="button" class="btn-pag ${i===paginaActual?activo:normal}" data-pag="${i}">${i}</button>`;
                }
                if (pFin < totalPags) {
                    if (pFin < totalPags - 1) h += `<span class="px-1 text-gray-300">…</span>`;
                    h +=
                        `<button type="button" class="btn-pag ${normal}" data-pag="${totalPags}">${totalPags}</button>`;
                }

                h +=
                    `<button type="button" class="btn-pag ${paginaActual===totalPags?disable:normal}" data-pag="${paginaActual+1}" ${paginaActual===totalPags?'disabled':''}>›</button>`;
                h += `</div></div>`;
                elPag.innerHTML = h;
            }

            // ── Renderizar chips ──────────────────────────────────────────
            function renderChips() {
                const total = sel.size;
                txtContador.textContent = total > 0 ? `(${total} seleccionado${total !== 1 ? 's' : ''})` : '';

                if (total === 0) {
                    panelChips.classList.add('hidden');
                    chipsWrap.innerHTML = '';
                    inputsHidden.innerHTML = '';
                    return;
                }

                panelChips.classList.remove('hidden');
                chipsCount.textContent = total;

                let chipsHtml = '',
                    inputsHtml = '';
                sel.forEach((nombre, pid) => {
                    chipsHtml += `
                <span class="inline-flex items-center gap-1 bg-orange-100 border border-orange-200 text-orange-800
                             text-[11px] font-medium rounded px-2 py-1 leading-none">
                    ${esc(nombre)}
                    <button type="button" data-pid="${pid}" class="btn-rm-chip ml-1.5 text-orange-400
                            hover:text-red-500 transition leading-none" title="Quitar" style="font-size:13px;line-height:1">×</button>
                </span>`;
                    inputsHtml += `<input type="hidden" name="personas_ids[]" value="${pid}">`;
                });

                chipsWrap.innerHTML = chipsHtml;
                inputsHidden.innerHTML = inputsHtml;
            }

            // ── Marcar / desmarcar ────────────────────────────────────────
            function marcar(pid, nombre, activo) {
                pid = Number(pid);
                activo ? sel.set(pid, nombre) : sel.delete(pid);
                renderChips();
            }

            function syncCheckAll() {
                const cbs = tbody.querySelectorAll('.check-cli:not(:disabled)');
                const mrc = tbody.querySelectorAll('.check-cli:not(:disabled):checked');
                checkAll.indeterminate = mrc.length > 0 && mrc.length < cbs.length;
                checkAll.checked = cbs.length > 0 && mrc.length === cbs.length;
            }

            // ── Eventos tabla (delegados) ─────────────────────────────────
            tbody.addEventListener('change', function(e) {
                if (!e.target.classList.contains('check-cli') || e.target.disabled) return;
                marcar(e.target.dataset.pid, e.target.dataset.nombre, e.target.checked);
                syncCheckAll();
            });

            // Check-all de la cabecera → solo página actual
            checkAll.addEventListener('change', function() {
                tbody.querySelectorAll('.check-cli:not(:disabled)').forEach(cb => {
                    cb.checked = this.checked;
                    marcar(cb.dataset.pid, cb.dataset.nombre, this.checked);
                });
            });

            // Sel. página (toggle)
            document.getElementById('btn-sel-pagina').addEventListener('click', function() {
                const cbs = tbody.querySelectorAll('.check-cli:not(:disabled)');
                const todosMarcados = Array.from(cbs).every(cb => cb.checked);
                cbs.forEach(cb => {
                    cb.checked = !todosMarcados;
                    marcar(cb.dataset.pid, cb.dataset.nombre, !todosMarcados);
                });
                syncCheckAll();
            });

            // Sel. todos (todos los filtrados, sin importar la página)
            document.getElementById('btn-sel-todos').addEventListener('click', function() {
                const lista = filtrados().filter(c => !IDS_EN_SESION.includes(c.persona_id));
                const todosEnSel = lista.every(c => sel.has(c.persona_id));
                lista.forEach(c => todosEnSel ? sel.delete(c.persona_id) : sel.set(c.persona_id, c
                    .nombre_completo));
                renderChips();
                renderTabla();
            });

            // Quitar chip individualmente
            chipsWrap.addEventListener('click', function(e) {
                const btn = e.target.closest('.btn-rm-chip');
                if (!btn) return;
                sel.delete(Number(btn.dataset.pid));
                renderChips();
                renderTabla();
            });

            // Limpiar toda la selección
            document.getElementById('btn-limpiar').addEventListener('click', function() {
                sel.clear();
                renderChips();
                renderTabla();
            });

            // Buscador
            document.getElementById('buscador').addEventListener('input', function() {
                filtro = this.value;
                paginaActual = 1;
                renderTabla();
            });

            // Paginación (delegado en el contenedor)
            elPag.addEventListener('click', function(e) {
                const btn = e.target.closest('.btn-pag');
                if (!btn || btn.disabled) return;
                paginaActual = Number(btn.dataset.pag);
                renderTabla();
                tbody.closest('.border').scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            });

            // ── Validación al enviar ──────────────────────────────────────
            form.addEventListener('submit', function(e) {
                if (sel.size === 0) {
                    e.preventDefault();
                    toast('Debes seleccionar al menos 1 cliente.');
                    return;
                }
                @if (!isset($sesionActiva))
                    const sede = document.getElementById('sede_id')?.value;
                    const fecha = document.getElementById('fecha')?.value;
                    if (!sede) {
                        e.preventDefault();
                        toast('Debes seleccionar una sede.');
                        return;
                    }
                    if (!fecha) {
                        e.preventDefault();
                        toast('Debes ingresar una fecha.');
                        return;
                    }
                @endif
            });

            // ── Toast ─────────────────────────────────────────────────────
            function toast(msg) {
                const el = document.createElement('div');
                el.className =
                    'fixed bottom-5 right-5 z-50 px-5 py-3 rounded-lg shadow-lg text-sm font-medium bg-red-600 text-white transition-opacity';
                el.textContent = msg;
                document.body.appendChild(el);
                setTimeout(() => {
                    el.style.opacity = '0';
                    setTimeout(() => el.remove(), 400);
                }, 3000);
            }

            // ── Init ──────────────────────────────────────────────────────
            renderTabla();
        })();
    </script>
</x-app-layout>
