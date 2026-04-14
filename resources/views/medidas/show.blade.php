<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('medidas.historial') }}"
                   class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    Detalle de Sesión
                </h2>
            </div>
            <a href="{{ route('medidas.editar', $sesion) }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-orange-100 hover:bg-orange-200 text-orange-700 text-sm font-semibold rounded-lg transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Editar sesión
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ── Encabezado informativo ──────────────────────────────────────── --}}
            <div class="bg-white rounded-2xl shadow p-5 mb-6">
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 text-sm">
                    <div>
                        <span class="text-gray-400 text-xs block mb-0.5">Sede</span>
                        <span class="font-semibold text-gray-800">{{ $sesion->sede->nombre_sede }}</span>
                    </div>
                    <div>
                        <span class="text-gray-400 text-xs block mb-0.5">Fecha</span>
                        <span class="font-semibold text-gray-800">{{ $sesion->fecha->format('d/m/Y') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-400 text-xs block mb-0.5">Registrado por</span>
                        <span class="font-semibold text-gray-800">{{ $sesion->user->name }}</span>
                    </div>
                    <div>
                        <span class="text-gray-400 text-xs block mb-0.5">Clientes</span>
                        @php
                            $total       = $sesion->detalles->count();
                            $completados = $sesion->detalles->where('completado', true)->count();
                            $pct = $total > 0 ? round(($completados / $total) * 100) : 0;
                        @endphp
                        <div class="flex items-center gap-2">
                            <span class="font-semibold text-gray-800">{{ $completados }}/{{ $total }} medidos</span>
                            <div class="w-20 h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full rounded-full {{ $pct === 100 ? 'bg-green-500' : 'bg-amber-400' }}"
                                     style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                @if($sesion->nota)
                    <p class="mt-3 text-sm text-gray-500">
                        <span class="font-medium">Nota:</span> {{ $sesion->nota }}
                    </p>
                @endif
            </div>

            {{-- ── Tabla de detalles ───────────────────────────────────────────── --}}
            <div class="bg-white rounded-2xl shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                                <th class="px-4 py-3 text-left sticky left-0 bg-gray-50 z-10 min-w-[200px] border-r border-gray-200">#  Cliente</th>
                                <th class="px-3 py-3 text-center">Altura<br><span class="normal-case font-normal">(cm)</span></th>
                                <th class="px-3 py-3 text-center">Peso<br><span class="normal-case font-normal">(kg)</span></th>
                                <th class="px-3 py-3 text-center">IMC</th>
                                <th class="px-3 py-3 text-center">Edad</th>
                                <th class="px-3 py-3 text-center">TMB<br><span class="normal-case font-normal text-gray-400">(kcal)</span></th>
                                <th class="px-3 py-3 text-center">% Grasa</th>
                                <th class="px-3 py-3 text-center">% Músculo</th>
                                <th class="px-3 py-3 text-center">Gr. Visceral</th>
                                <th class="px-3 py-3 text-center">Sentadillas</th>
                                <th class="px-3 py-3 text-center">Abdominales</th>
                                <th class="px-3 py-3 text-center">Flexiones</th>
                                <th class="px-3 py-3 text-center">Elasticidad<br><span class="normal-case font-normal">(cm)</span></th>
                                <th class="px-3 py-3 text-center">Test Resist.<br><span class="normal-case font-normal text-gray-400">(pts)</span></th>
                                <th class="px-3 py-3 text-center min-w-[160px]">Notas</th>
                                <th class="px-3 py-3 text-center">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sesion->detalles as $detalle)
                                <tr class="border-t border-gray-100 hover:bg-gray-50/70 transition
                                    {{ $detalle->status ? '' : 'opacity-40' }}">

                                    {{-- Nombre --}}
                                    <td class="px-4 py-3 sticky left-0 bg-white z-10 border-r border-gray-200">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2.5 h-2.5 rounded-full flex-shrink-0
                                                {{ $detalle->completado ? 'bg-green-500' : 'bg-red-400' }}">
                                            </span>
                                            <div class="leading-tight">
                                                <span class="font-medium text-gray-800 block">{{ $detalle->persona->nombre_completo }}</span>
                                                <span class="text-xs text-gray-400">{{ $detalle->persona->documento }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    @php
                                        $num = fn($v, $dec = 1) => $v !== null ? number_format($v, $dec) : '—';
                                        $ent = fn($v) => $v !== null ? $v : '—';
                                    @endphp

                                    <td class="px-3 py-3 text-center text-gray-700">{{ $num($detalle->altura_cm, 1) }}</td>
                                    <td class="px-3 py-3 text-center text-gray-700">{{ $num($detalle->peso_kg, 1) }}</td>
                                    <td class="px-3 py-3 text-center text-gray-700">{{ $num($detalle->imc, 2) }}</td>
                                    <td class="px-3 py-3 text-center text-gray-700">{{ $ent($detalle->edad_al_momento) }}</td>
                                    <td class="px-3 py-3 text-center text-gray-700">{{ $ent($detalle->metabolismo_basal) }}</td>
                                    <td class="px-3 py-3 text-center text-gray-700">{{ $num($detalle->porcentaje_grasa, 1) }}</td>
                                    <td class="px-3 py-3 text-center text-gray-700">{{ $num($detalle->porcentaje_musculo, 1) }}</td>
                                    <td class="px-3 py-3 text-center text-gray-700">{{ $num($detalle->grasa_visceral, 1) }}</td>
                                    <td class="px-3 py-3 text-center text-gray-700">{{ $ent($detalle->sentadillas) }}</td>
                                    <td class="px-3 py-3 text-center text-gray-700">{{ $ent($detalle->abdominales) }}</td>
                                    <td class="px-3 py-3 text-center text-gray-700">{{ $ent($detalle->flexiones) }}</td>
                                    <td class="px-3 py-3 text-center text-gray-700">{{ $num($detalle->elasticidad, 1) }}</td>                                    <td class="px-3 py-3 text-center text-gray-700">{{ $num($detalle->test_resistencia, 1) }}</td>                                    <td class="px-3 py-3 text-gray-500 text-xs">{{ $detalle->notas ?? '—' }}</td>

                                    {{-- Estado (activo = status 1, quitado = status 0) --}}
                                    <td class="px-3 py-3 text-center">
                                        @if($detalle->status)
                                            <span class="inline-block px-2 py-0.5 rounded-full bg-green-100 text-green-700 text-xs font-medium">Activo</span>
                                        @else
                                            <span class="inline-block px-2 py-0.5 rounded-full bg-gray-100 text-gray-400 text-xs font-medium">Quitado</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="16" class="py-10 text-center text-gray-400 text-sm">
                                        No hay registros en esta sesión.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pie con conteo --}}
                <div class="flex items-center justify-between px-5 py-3 border-t border-gray-100 text-xs text-gray-500">
                    <span>{{ $sesion->detalles->count() }} cliente(s) en total ·
                          {{ $sesion->detalles->where('status', true)->count() }} activos ·
                          {{ $sesion->detalles->where('completado', true)->count() }} completados</span>
                    <a href="{{ route('medidas.historial') }}"
                       class="text-orange-600 hover:underline font-medium">
                        ← Volver al historial
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
