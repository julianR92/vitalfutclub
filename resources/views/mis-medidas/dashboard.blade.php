<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div>
                <h2 class="text-xl font-bold text-gray-800 leading-tight">
                    Mis Medidas Corporales
                </h2>
                <p class="text-sm text-gray-500 mt-0.5">{{ $persona->nombre_completo }}</p>
            </div>
            @if($sesiones->isNotEmpty())
                <span class="inline-flex items-center gap-1.5 text-xs text-gray-500 bg-white border border-gray-200 px-3 py-1.5 rounded-full shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-green-400 inline-block"></span>
                    {{ $sesiones->count() }} sesión(es) registrada(s)
                </span>
            @endif
        </div>
    </x-slot>

    {{-- Fuentes + Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@3.0.1/dist/chartjs-plugin-annotation.min.js"></script>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- ── Sin datos ─────────────────────────────────────────────────── --}}
            @if($sesiones->isEmpty())
                <div class="bg-white rounded-2xl shadow p-10 text-center">
                    <div class="mx-auto w-16 h-16 rounded-full bg-orange-100 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-1">Aún no tienes medidas registradas</h3>
                    <p class="text-sm text-gray-400">Habla con tu entrenador para comenzar a registrar tu progreso.</p>
                    <br>
                    <a href="{{ route('inicio') }}"
                       class="text-orange-600 hover:underline font-medium mt-4" style="margin-top: 15px;">
                        ← Volver
                    </a>
                </div>
            @else

            {{-- ── Tarjetas resumen ──────────────────────────────────────────── --}}
            <div id="cards-resumen" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                @php
                    $cards = [
                        ['label'=>'Peso',        'key'=>'peso_kg',           'unit'=>'kg',   'icon'=>'M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3',   'color'=>'orange'],
                        ['label'=>'IMC',         'key'=>'imc',               'unit'=>'',     'icon'=>'M9 7h6m0 10v-3m-3 3h.01M9 17v-3m-3-4h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v4a2 2 0 002 2z',                                                  'color'=>'blue'],
                        ['label'=>'% Grasa',     'key'=>'porcentaje_grasa',  'unit'=>'%',    'icon'=>'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',                       'color'=>'red'],
                        ['label'=>'% Músculo',   'key'=>'porcentaje_musculo','unit'=>'%',    'icon'=>'M13 10V3L4 14h7v7l9-11h-7z',                                                                                                                          'color'=>'green'],
                        ['label'=>'Gr. Visceral','key'=>'grasa_visceral',    'unit'=>'',     'icon'=>'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'color'=>'purple'],
                    ];
                    $colorMap = [
                        'orange' => ['bg'=>'bg-orange-100','text'=>'text-orange-600','dot'=>'bg-orange-400'],
                        'blue'   => ['bg'=>'bg-blue-100',  'text'=>'text-blue-600',  'dot'=>'bg-blue-400'],
                        'red'    => ['bg'=>'bg-red-100',   'text'=>'text-red-600',   'dot'=>'bg-red-400'],
                        'green'  => ['bg'=>'bg-green-100', 'text'=>'text-green-600', 'dot'=>'bg-green-400'],
                        'purple' => ['bg'=>'bg-purple-100','text'=>'text-purple-600','dot'=>'bg-purple-400'],
                    ];
                @endphp

                @foreach($cards as $c)
                    @php $cm = $colorMap[$c['color']]; @endphp
                    <div class="bg-white rounded-2xl shadow p-4 flex flex-col gap-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500 font-medium">{{ $c['label'] }}</span>
                            <div class="w-8 h-8 rounded-xl {{ $cm['bg'] }} flex items-center justify-center">
                                <svg class="w-4 h-4 {{ $cm['text'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $c['icon'] }}"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <span data-card="{{ $c['key'] }}" class="text-2xl font-bold text-gray-800">—</span>
                            <span class="text-sm text-gray-400 ml-0.5">{{ $c['unit'] }}</span>
                        </div>
                        <div data-card-diff="{{ $c['key'] }}" class="text-xs text-gray-400"></div>
                    </div>
                @endforeach
            </div>

            {{-- ── Gráficos principales ──────────────────────────────────────── --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Peso en el tiempo --}}
                <div class="bg-white rounded-2xl shadow p-5">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4">📈 Evolución del Peso</h3>
                    <div class="relative" style="height:220px">
                        <canvas id="chart-peso"></canvas>
                    </div>
                </div>

                {{-- IMC --}}
                <div class="bg-white rounded-2xl shadow p-5">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4">⚖️ Índice de Masa Corporal (IMC)</h3>
                    <div class="relative" style="height:220px">
                        <canvas id="chart-imc"></canvas>
                    </div>
                </div>

                {{-- Composición corporal --}}
                <div class="bg-white rounded-2xl shadow p-5">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4">💪 Composición Corporal</h3>
                    <div class="relative" style="height:220px">
                        <canvas id="chart-composicion"></canvas>
                    </div>
                </div>

                {{-- Rendimiento físico --}}
                <div class="bg-white rounded-2xl shadow p-5">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4">🏋️ Rendimiento Físico</h3>
                    <div class="relative" style="height:220px">
                        <canvas id="chart-rendimiento"></canvas>
                    </div>
                </div>
            </div>

            {{-- ── Últimos datos: donut + stats ─────────────────────────────── --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- Donut composición corporal --}}
                <div class="bg-white rounded-2xl shadow p-5 flex flex-col items-center">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4 w-full">🔵 Composición (última medición)</h3>
                    <div class="relative" style="height:180px;width:180px">
                        <canvas id="chart-donut"></canvas>
                        <div id="donut-center"
                             class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                            <span class="text-2xl font-bold text-gray-800" id="donut-imc-val">—</span>
                            <span class="text-xs text-gray-400">IMC</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-2 mt-4 w-full text-center text-xs">
                        <div>
                            <div class="w-3 h-3 rounded-full bg-red-400 mx-auto mb-1"></div>
                            <span class="text-gray-500">Grasa</span>
                            <p id="stat-grasa" class="font-bold text-gray-800">—</p>
                        </div>
                        <div>
                            <div class="w-3 h-3 rounded-full bg-green-400 mx-auto mb-1"></div>
                            <span class="text-gray-500">Músculo</span>
                            <p id="stat-musculo" class="font-bold text-gray-800">—</p>
                        </div>
                        <div>
                            <div class="w-3 h-3 rounded-full bg-gray-300 mx-auto mb-1"></div>
                            <span class="text-gray-500">Resto</span>
                            <p id="stat-resto" class="font-bold text-gray-800">—</p>
                        </div>
                    </div>
                </div>

                {{-- Stats tarjetas --}}
                <div class="md:col-span-2 bg-white rounded-2xl shadow p-5">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4">📊 Rendimiento (última medición)</h3>
                    <div class="grid grid-cols-2 gap-4">
                        @php
                            $rendCards = [
                                ['id'=>'stat-sentadillas', 'label'=>'Sentadillas', 'unit'=>'reps', 'color'=>'orange'],
                                ['id'=>'stat-abdominales', 'label'=>'Abdominales', 'unit'=>'reps', 'color'=>'blue'],
                                ['id'=>'stat-flexiones',   'label'=>'Flexiones',   'unit'=>'reps', 'color'=>'green'],
                                ['id'=>'stat-elasticidad', 'label'=>'Elasticidad', 'unit'=>'cm',   'color'=>'purple'],
                            ];
                        @endphp
                        @foreach($rendCards as $rc)
                            @php $cm = $colorMap[$rc['color']]; @endphp
                            <div class="flex items-center gap-3 p-3 rounded-xl {{ $cm['bg'] }}">
                                <div class="w-2 h-10 rounded-full {{ $cm['dot'] }}"></div>
                                <div>
                                    <p class="text-xs text-gray-500">{{ $rc['label'] }}</p>
                                    <p class="text-xl font-bold text-gray-800">
                                        <span id="{{ $rc['id'] }}">—</span>
                                        <span class="text-xs font-normal text-gray-400 ml-0.5">{{ $rc['unit'] }}</span>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ── Tabla historial completo ──────────────────────────────────── --}}
            <div class="bg-white rounded-2xl shadow overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between flex-wrap gap-2">
                    <h3 class="text-sm font-semibold text-gray-700">📋 Historial completo de medidas</h3>
                    <input id="buscador-tabla" type="text" placeholder="Buscar por fecha o sede…"
                           class="text-sm border border-gray-200 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-orange-300 w-48">
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm" id="tabla-medidas">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                            <tr>
                                <th class="px-4 py-3 text-left">Fecha</th>
                                <th class="px-4 py-3 text-left">Sede</th>
                                <th class="px-3 py-3 text-center">Altura<br><small class="normal-case">(cm)</small></th>
                                <th class="px-3 py-3 text-center">Peso<br><small class="normal-case">(kg)</small></th>
                                <th class="px-3 py-3 text-center">IMC</th>
                                <th class="px-3 py-3 text-center">%&nbsp;Grasa</th>
                                <th class="px-3 py-3 text-center">%&nbsp;Músculo</th>
                                <th class="px-3 py-3 text-center hidden sm:table-cell">Gr.&nbsp;Visceral</th>
                                <th class="px-3 py-3 text-center hidden md:table-cell">Sent.</th>
                                <th class="px-3 py-3 text-center hidden md:table-cell">Abd.</th>
                                <th class="px-3 py-3 text-center hidden md:table-cell">Flex.</th>
                                <th class="px-3 py-3 text-center hidden md:table-cell">Elast.</th>
                                <th class="px-3 py-3 text-center">TMB</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-historial">
                            <tr id="fila-cargando">
                                <td colspan="13" class="py-8 text-center text-gray-400 text-sm">
                                    <svg class="animate-spin w-5 h-5 mx-auto mb-2 text-orange-400" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                                    </svg>
                                    Cargando datos…
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="pie-tabla"
                     class="px-5 py-3 border-t border-gray-100 text-xs text-gray-400 flex items-center justify-between flex-wrap gap-2 hidden">
                    <span id="pie-info"></span>
                    <div class="flex gap-1" id="pag-tabla"></div>
                </div>
            </div>
            <br>
            <a href="{{ route('inicio') }}"
                   class="text-orange-600 hover:underline font-medium" style="padding-top: 25px">
                    ← Volver
                </a>

            @endif {{-- fin @if sesiones --}}
        </div>
    </div>

    {{-- ── Estilos adicionales ───────────────────────────────────────────────── --}}
    <style>
        [data-card] { transition: all .4s ease; }
        .diff-up   { color: #ef4444; }
        .diff-down { color: #22c55e; }
        .diff-eq   { color: #9ca3af; }
        #tabla-medidas tbody tr:hover { background: #fff7ed; }
        #tabla-medidas tbody td { padding: 10px 12px; vertical-align: middle; border-bottom: 1px solid #f3f4f6; }
        .badge-imc {
            display: inline-block; padding: 2px 8px;
            border-radius: 9999px; font-size: 11px; font-weight: 600;
        }
    </style>

    {{-- ── Script principal ─────────────────────────────────────────────────── --}}
    <script>
    (function () {
        // ── Config Chart.js global ──────────────────────────────────────────
        Chart.defaults.font.family = "'Inter', system-ui, sans-serif";
        Chart.defaults.font.size   = 12;
        Chart.defaults.color       = '#6b7280';

        const PALETTE = {
            orange : { line: '#f97316', fill: 'rgba(249,115,22,.12)' },
            blue   : { line: '#3b82f6', fill: 'rgba(59,130,246,.12)' },
            red    : { line: '#ef4444', fill: 'rgba(239,68,68,.12)'  },
            green  : { line: '#22c55e', fill: 'rgba(34,197,94,.12)'  },
            purple : { line: '#a855f7', fill: 'rgba(168,85,247,.12)' },
            gray   : { line: '#9ca3af', fill: 'rgba(156,163,175,.12)'},
        };

        function lineDataset(label, data, color) {
            const c = PALETTE[color];
            return {
                label,
                data,
                borderColor      : c.line,
                backgroundColor  : c.fill,
                borderWidth      : 2.5,
                pointRadius      : 4,
                pointHoverRadius : 6,
                pointBackgroundColor: c.line,
                tension          : 0.35,
                fill             : true,
            };
        }

        const baseLineOpts = (labels) => ({
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false }, tooltip: { mode: 'index', intersect: false } },
            scales: {
                x: { grid: { display: false }, ticks: { maxRotation: 30 } },
                y: { grid: { color: '#f3f4f6' }, beginAtZero: false },
            },
        });

        // ── Carga de datos ──────────────────────────────────────────────────
        fetch('{{ route("mis-medidas.datos") }}')
            .then(r => r.json())
            .then(d => {
                if (!d.labels || d.labels.length === 0) {
                    document.getElementById('fila-cargando').innerHTML =
                        `<td colspan="13" class="py-8 text-center text-gray-400 text-sm">
                            No hay mediciones registradas aún.
                         </td>`;
                    return;
                }

                inicializarCards(d);
                inicializarGraficos(d);
                inicializarTabla(d.tabla);
            })
            .catch(() => {
                document.getElementById('fila-cargando').innerHTML =
                    `<td colspan="13" class="py-6 text-center text-red-400 text-sm">Error al cargar los datos.</td>`;
            });

        // ── Tarjetas ────────────────────────────────────────────────────────
        function inicializarCards(d) {
            const campos = {
                peso_kg            : d.peso,
                imc                : d.imc,
                porcentaje_grasa   : d.porcentaje_grasa,
                porcentaje_musculo : d.porcentaje_musculo,
                grasa_visceral     : d.grasa_visceral,
            };

            Object.entries(campos).forEach(([key, arr]) => {
                const vals   = arr.filter(v => v !== null);
                if (!vals.length) return;

                const ultimo   = vals[vals.length - 1];
                const anterior = vals.length > 1 ? vals[vals.length - 2] : null;

                const el = document.querySelector(`[data-card="${key}"]`);
                if (el) el.textContent = parseFloat(ultimo).toFixed(1);

                const elDiff = document.querySelector(`[data-card-diff="${key}"]`);
                if (elDiff && anterior !== null) {
                    const diff = parseFloat(ultimo) - parseFloat(anterior);
                    const sign = diff > 0 ? '▲ +' : diff < 0 ? '▼ ' : '→ ';
                    const cls  = diff > 0 ? 'diff-up' : diff < 0 ? 'diff-down' : 'diff-eq';
                    elDiff.innerHTML = `<span class="${cls}">${sign}${Math.abs(diff).toFixed(1)}</span> vs anterior`;
                }
            });
        }

        // ── Gráficos ────────────────────────────────────────────────────────
        function inicializarGraficos(d) {
            const L = d.labels;

            // Peso
            new Chart('chart-peso', {
                type: 'line',
                data: { labels: L, datasets: [lineDataset('Peso (kg)', d.peso, 'orange')] },
                options: {
                    ...baseLineOpts(L),
                    plugins: {
                        ...baseLineOpts(L).plugins,
                        legend: { display: true, position: 'top' },
                        tooltip: { callbacks: { label: ctx => ` ${ctx.parsed.y} kg` } },
                    },
                    scales: {
                        ...baseLineOpts(L).scales,
                        y: { ...baseLineOpts(L).scales.y, ticks: { callback: v => v + ' kg' } },
                    },
                },
            });

            // IMC con zonas de color
            new Chart('chart-imc', {
                type: 'line',
                data: { labels: L, datasets: [lineDataset('IMC', d.imc, 'blue')] },
                options: {
                    ...baseLineOpts(L),
                    plugins: {
                        ...baseLineOpts(L).plugins,
                        legend: { display: true, position: 'top' },
                        annotation: {
                            annotations: {
                                normal: {
                                    type: 'box', yMin: 18.5, yMax: 24.9,
                                    backgroundColor: 'rgba(34,197,94,.08)',
                                    borderColor: 'rgba(34,197,94,.3)', borderWidth: 1,
                                    label: { display: true, content: 'Normal (18.5–24.9)', color: '#22c55e', font: { size: 10 } },
                                },
                            },
                        },
                    },
                },
            });

            // Composición corporal (multi-línea)
            new Chart('chart-composicion', {
                type: 'line',
                data: {
                    labels: L,
                    datasets: [
                        lineDataset('% Grasa',   d.porcentaje_grasa,   'red'),
                        lineDataset('% Músculo', d.porcentaje_musculo, 'green'),
                    ],
                },
                options: {
                    ...baseLineOpts(L),
                    plugins: {
                        ...baseLineOpts(L).plugins,
                        legend: { display: true, position: 'top' },
                        tooltip: { callbacks: { label: ctx => ` ${ctx.parsed.y}%` } },
                    },
                    scales: {
                        ...baseLineOpts(L).scales,
                        y: { ...baseLineOpts(L).scales.y, ticks: { callback: v => v + '%' } },
                    },
                },
            });

            // Rendimiento físico (barras)
            new Chart('chart-rendimiento', {
                type: 'bar',
                data: {
                    labels: L,
                    datasets: [
                        { label: 'Sentadillas', data: d.sentadillas, backgroundColor: 'rgba(249,115,22,.7)',  borderRadius: 4 },
                        { label: 'Abdominales', data: d.abdominales, backgroundColor: 'rgba(59,130,246,.7)',  borderRadius: 4 },
                        { label: 'Flexiones',   data: d.flexiones,   backgroundColor: 'rgba(34,197,94,.7)',   borderRadius: 4 },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: true, position: 'top' },
                        tooltip: { mode: 'index', intersect: false },
                    },
                    scales: {
                        x: { grid: { display: false }, stacked: false },
                        y: { grid: { color: '#f3f4f6' }, beginAtZero: true },
                    },
                },
            });

            // Donut — último registro
            const lastGrasa   = ultimoValido(d.porcentaje_grasa)   ?? 0;
            const lastMusculo = ultimoValido(d.porcentaje_musculo) ?? 0;
            const resto       = Math.max(0, 100 - lastGrasa - lastMusculo);
            const lastImc     = ultimoValido(d.imc);

            document.getElementById('donut-imc-val').textContent = lastImc ? parseFloat(lastImc).toFixed(1) : '—';
            document.getElementById('stat-grasa').textContent    = lastGrasa   ? lastGrasa + '%'   : '—';
            document.getElementById('stat-musculo').textContent  = lastMusculo ? lastMusculo + '%' : '—';
            document.getElementById('stat-resto').textContent    = lastGrasa || lastMusculo ? Math.round(resto) + '%' : '—';

            // Stats rendimiento último
            document.getElementById('stat-sentadillas').textContent = ultimoValido(d.sentadillas) ?? '—';
            document.getElementById('stat-abdominales').textContent = ultimoValido(d.abdominales) ?? '—';
            document.getElementById('stat-flexiones').textContent   = ultimoValido(d.flexiones)   ?? '—';
            document.getElementById('stat-elasticidad').textContent = ultimoValido(d.elasticidad) !== null
                ? parseFloat(ultimoValido(d.elasticidad)).toFixed(1) : '—';

            new Chart('chart-donut', {
                type: 'doughnut',
                data: {
                    labels   : ['Grasa', 'Músculo', 'Resto'],
                    datasets : [{
                        data            : [lastGrasa, lastMusculo, resto],
                        backgroundColor : ['#ef4444', '#22c55e', '#e5e7eb'],
                        borderWidth     : 0,
                        hoverOffset     : 6,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout   : '72%',
                    plugins  : {
                        legend  : { display: false },
                        tooltip : { callbacks: { label: ctx => ` ${ctx.label}: ${ctx.parsed}%` } },
                    },
                },
            });
        }

        function ultimoValido(arr) {
            if (!arr) return null;
            for (let i = arr.length - 1; i >= 0; i--) {
                if (arr[i] !== null && arr[i] !== undefined) return arr[i];
            }
            return null;
        }

        // ── Tabla ───────────────────────────────────────────────────────────
        let filasTodas = [];
        let paginaTabla = 1;
        const POR_PAG = 10;

        function inicializarTabla(tabla) {
            filasTodas = tabla;
            renderTabla();

            document.getElementById('buscador-tabla').addEventListener('input', function () {
                const q = this.value.toLowerCase();
                filasTodas = tabla.filter(r =>
                    r.fecha.toLowerCase().includes(q) || (r.sede ?? '').toLowerCase().includes(q)
                );
                paginaTabla = 1;
                renderTabla();
            });
        }

        function n(v, dec = 1) {
            return v !== null && v !== undefined ? parseFloat(v).toFixed(dec) : '—';
        }

        function badgeImc(imc) {
            if (!imc) return '—';
            const v = parseFloat(imc);
            let cls = 'bg-green-100 text-green-700';
            let label = 'Normal';
            if (v < 18.5)       { cls = 'bg-blue-100 text-blue-700';   label = 'Bajo'; }
            else if (v >= 25 && v < 30) { cls = 'bg-yellow-100 text-yellow-700'; label = 'Sobrepeso'; }
            else if (v >= 30)   { cls = 'bg-red-100 text-red-700';     label = 'Obesidad'; }
            return `<span class="badge-imc ${cls}">${n(imc, 2)}</span><br><small class="text-gray-400">${label}</small>`;
        }

        function renderTabla() {
            const tbody = document.getElementById('tbody-historial');
            const total = filasTodas.length;
            const pags  = Math.max(1, Math.ceil(total / POR_PAG));
            if (paginaTabla > pags) paginaTabla = 1;

            const slice = filasTodas.slice((paginaTabla - 1) * POR_PAG, paginaTabla * POR_PAG);

            if (!slice.length) {
                tbody.innerHTML = `<tr><td colspan="13" class="py-8 text-center text-gray-400">Sin resultados.</td></tr>`;
                document.getElementById('pie-tabla').classList.add('hidden');
                return;
            }

            tbody.innerHTML = slice.map((r, i) => `
                <tr class="transition-colors">
                    <td class="font-medium text-gray-800">${r.fecha}</td>
                    <td class="text-gray-500">${r.sede}</td>
                    <td class="text-center">${n(r.altura_cm)}</td>
                    <td class="text-center font-semibold text-gray-800">${n(r.peso_kg)}</td>
                    <td class="text-center">${badgeImc(r.imc)}</td>
                    <td class="text-center">${r.grasa !== null ? n(r.grasa) + '%' : '—'}</td>
                    <td class="text-center">${r.musculo !== null ? n(r.musculo) + '%' : '—'}</td>
                    <td class="text-center hidden sm:table-cell">${n(r.grasa_visceral)}</td>
                    <td class="text-center hidden md:table-cell">${r.sentadillas ?? '—'}</td>
                    <td class="text-center hidden md:table-cell">${r.abdominales ?? '—'}</td>
                    <td class="text-center hidden md:table-cell">${r.flexiones ?? '—'}</td>
                    <td class="text-center hidden md:table-cell">${r.elasticidad !== null ? n(r.elasticidad) : '—'}</td>
                    <td class="text-center">${r.tmb ?? '—'}</td>
                </tr>
            `).join('');

            // Pie
            const pie = document.getElementById('pie-tabla');
            pie.classList.remove('hidden');
            const ini = (paginaTabla - 1) * POR_PAG + 1;
            const fin = Math.min(paginaTabla * POR_PAG, total);
            document.getElementById('pie-info').textContent = `Mostrando ${ini}–${fin} de ${total}`;

            const pagDiv = document.getElementById('pag-tabla');
            const base   = 'px-2.5 py-1 rounded-lg border text-xs transition';
            const act    = `${base} bg-orange-500 text-white border-orange-400 font-semibold`;
            const nor    = `${base} border-gray-200 text-gray-600 hover:bg-gray-50`;
            const dis    = `${base} border-gray-100 text-gray-300 cursor-not-allowed`;
            let h = `<button class="btn-pag-t ${paginaTabla===1?dis:nor}" data-p="${paginaTabla-1}" ${paginaTabla===1?'disabled':''}>‹</button>`;
            for (let i = 1; i <= pags; i++) {
                h += `<button class="btn-pag-t ${i===paginaTabla?act:nor}" data-p="${i}">${i}</button>`;
            }
            h += `<button class="btn-pag-t ${paginaTabla===pags?dis:nor}" data-p="${paginaTabla+1}" ${paginaTabla===pags?'disabled':''}>›</button>`;
            pagDiv.innerHTML = h;

            pagDiv.onclick = function (e) {
                const btn = e.target.closest('.btn-pag-t');
                if (!btn || btn.disabled) return;
                paginaTabla = Number(btn.dataset.p);
                renderTabla();
                document.getElementById('tabla-medidas').scrollIntoView({ behavior: 'smooth', block: 'start' });
            };
        }
    })();
    </script>
</x-app-layout>
