<?php

namespace App\Http\Controllers;

use App\Models\MedidaDetalle;
use App\Models\MedidaSesion;
use App\Models\Sede;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MedidaController extends Controller
{
    // ─── Historial: listado de sesiones ─────────────────────────────

    public function index(): View
    {
        return view('medidas.index');
    }

    // ─── Historial: datos para DataTables (AJAX) ──────────────────────

    public function getData(): JsonResponse
    {
        $user  = auth()->user();
        $esAdmin = $user->rol === 'admin';

        $sesiones = MedidaSesion::with(['sede', 'user'])
            ->withCount([
                'detalles',
                'detalles as completados_count' => fn($q) => $q->where('completado', true),
            ])
            ->when(!$esAdmin, fn($q) => $q->where('user_id', $user->id))
            ->orderByDesc('fecha')
            ->get()
            ->map(fn($s) => [
                'id'          => $s->id,
                'fecha'       => $s->fecha->format('d/m/Y'),
                'sede'        => $s->sede->nombre_sede ?? '—',
                'profesor'    => $s->user->name ?? '—',
                'total'       => $s->detalles_count,
                'completados' => $s->completados_count ?? 0,
                'nota'        => $s->nota ?? '—',
            ]);

        return response()->json(['data' => $sesiones]);
    }

    // ─── Detalle de una sesión ────────────────────────────────────────

    public function show(MedidaSesion $sesion): View
    {
        $user = auth()->user();
        if ($user->rol !== 'admin' && $sesion->user_id !== $user->id) {
            abort(403, 'No tienes permiso para ver esta sesión.');
        }

        $sesion->load([
            'sede',
            'user',
            'detalles' => fn($q) => $q->orderBy('orden')->with('persona'),
        ]);

        return view('medidas.show', compact('sesion'));
    }

    // ─── Eliminar sesión y sus detalles ───────────────────────────────

    public function destroy(MedidaSesion $sesion): RedirectResponse
    {
        $user = auth()->user();
        if ($user->rol !== 'admin' && $sesion->user_id !== $user->id) {
            abort(403, 'No tienes permiso para eliminar esta sesión.');
        }

        $sesion->detalles()->delete();
        $sesion->delete();

        return redirect()->route('medidas.historial')
            ->with('success', 'Sesión eliminada correctamente.');
    }

    // ─── Paso 1: Mostrar formulario de selección ──────────────────────

    public function seleccionarPersonas(Request $request): View
    {
        $sedes = Sede::orderBy('nombre_sede')->get();

        $clientes = User::with('people')
            ->where('rol', 'cliente')
            ->whereHas('people')
            ->orderBy('name')
            ->get()
            ->map(fn($u) => [
                'id'              => $u->id,
                'persona_id'      => $u->people->id,
                'nombre_completo' => $u->people->nombre_completo,
                'documento'       => $u->people->documento,
            ])
            ->values(); // garantiza array 0-indexed para JSON

        $sesionActiva = null;
        if ($request->has('sesion_id')) {
            $sesionActiva = MedidaSesion::with('detalles')->findOrFail($request->sesion_id);
        }

        // Sesiones con al menos 1 detalle sin completar
        // Admin ve todas; profesor/otros solo las propias
        $esAdmin = auth()->user()->rol === 'admin';

        $sesionesIncompletas = MedidaSesion::with('sede')
            ->when(!$esAdmin, fn($q) => $q->where('user_id', auth()->id()))
            ->whereHas('detalles', fn($q) => $q->where('completado', false))
            ->withCount([
                'detalles',
                'detalles as completados_count' => fn($q) => $q->where('completado', true),
            ])
            ->when($sesionActiva, fn($q) => $q->where('id', '!=', $sesionActiva->id))
            ->orderByDesc('fecha')
            ->limit(5)
            ->get();

        return view('medidas.seleccionar', compact('sedes', 'clientes', 'sesionActiva', 'sesionesIncompletas'));
    }

    // ─── Paso 1: Crear sesión con personas seleccionadas ──────────────

    public function crearSesion(Request $request): RedirectResponse
    {
        $request->validate([
            'sede_id'      => 'required|exists:sedes,id',
            'fecha'        => 'required|date',
            'nota'         => 'nullable|string|max:500',
            'personas_ids' => 'required|array|min:1',
            'personas_ids.*' => 'exists:personas,id',
        ]);

        // Si viene sesion_id, agregar personas a sesión existente
        if ($request->filled('sesion_id')) {
            $sesion = MedidaSesion::findOrFail($request->sesion_id);

            $idsExistentes = $sesion->detalles()->pluck('persona_id')->toArray();
            $nuevosIds = array_diff($request->personas_ids, $idsExistentes);

            if (!empty($nuevosIds)) {
                $ordenMaximo = $sesion->detalles()->max('orden') ?? 0;
                $detalles = collect($nuevosIds)->values()->map(fn($id, $i) => [
                    'medida_sesion_id' => $sesion->id,
                    'persona_id'       => $id,
                    'orden'            => $ordenMaximo + $i + 1,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ])->all();

                MedidaDetalle::insert($detalles);
            }

            return redirect()->route('medidas.editar', $sesion);
        }

        $sesion = MedidaSesion::crearConPersonas(
            auth()->id(),
            $request->sede_id,
            $request->fecha,
            $request->personas_ids,
        );

        if ($request->filled('nota')) {
            $sesion->update(['nota' => $request->nota]);
        }

        return redirect()->route('medidas.editar', $sesion);
    }

    // ─── Paso 2: Mostrar tabla de medidas ─────────────────────────────

    public function editar(MedidaSesion $sesion): View
    {
        $sesion->load([
            'sede',
            'user',
            'detalles' => fn($q) => $q->orderBy('orden')->with('persona'),
        ]);

        return view('medidas.editar', compact('sesion'));
    }

    // ─── AJAX: Actualizar un detalle ──────────────────────────────────

    public function actualizarMedida(Request $request, MedidaDetalle $detalle): JsonResponse
    {
        $validated = $request->validate([
            'altura_cm'              => 'nullable|numeric|min:0|max:300',
            'peso_kg'                => 'nullable|numeric|min:0|max:500',
            'imc'                    => 'nullable|numeric|min:0|max:100',
            'edad_al_momento'        => 'nullable|integer|min:0|max:120',
            'metabolismo_basal'      => 'nullable|integer|min:0',
            'porcentaje_grasa'       => 'nullable|numeric|min:0|max:100',
            'porcentaje_musculo'     => 'nullable|numeric|min:0|max:100',
            'grasa_visceral'         => 'nullable|numeric|min:0',
            'sentadillas'            => 'nullable|integer|min:0',
            'abdominales'            => 'nullable|integer|min:0',
            'flexiones'              => 'nullable|integer|min:0',
            'elasticidad'            => 'nullable|numeric|min:0',
            'notas'                  => 'nullable|string|max:1000',
            'status'                 => 'nullable|boolean',
            // Campos desactivados (mantenidos por compatibilidad)
            // 'circunferencia_brazo'   => 'nullable|numeric|min:0',
            // 'circunferencia_cintura' => 'nullable|numeric|min:0',
            // 'circunferencia_muslo'   => 'nullable|numeric|min:0',
        ]);

        // Excluir nulls sin perder el valor 0 (ej. status = 0)
        $campos = array_filter($validated, fn($v) => $v !== null);

        $detalle->fill($campos);
        $detalle->save();

        return response()->json([
            'imc'               => $detalle->imc,
            'metabolismo_basal' => $detalle->metabolismo_basal,
            'edad_al_momento'   => $detalle->edad_al_momento,
            'completado'        => $this->estaCompleto($detalle),
            'status'            => $detalle->status,
        ]);
    }

    // ─── Finalizar sesión ─────────────────────────────────────────────

    public function finalizarSesion(MedidaSesion $sesion): RedirectResponse
    {
        // Marcar todos los detalles con datos básicos como completados
        $sesion->detalles()
            ->whereNotNull('peso_kg')
            ->whereNotNull('altura_cm')
            ->update(['completado' => true]);

        return redirect()->route('medidas.seleccionar')
            ->with('success', 'Sesión de medidas finalizada correctamente.');
    }

    // ─── Helpers privados ─────────────────────────────────────────────

    private function estaCompleto(MedidaDetalle $detalle): bool
    {
        return !empty($detalle->peso_kg) && !empty($detalle->altura_cm);
    }
}
