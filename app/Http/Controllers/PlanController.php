<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\PlanDetalle;
use App\Models\Ciudad;
use App\Models\Sede;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('planes.index');
    }

    /**
     * Get data for DataTables
     */
    public function getData()
    {
        try {
            $planes = Plan::with(['ciudad', 'sede', 'detalles'])
                ->select('planes.*')
                ->get()
                ->sort(function ($a, $b) {
                    // 1. Primero por visible_web (visibles primero: 1, luego 0)
                    if ($a->visible_web != $b->visible_web) {
                        return $b->visible_web <=> $a->visible_web;
                    }

                    // 2. Luego por tipo_plan (suscripción primero, prepago después)
                    if ($a->tipo_plan != $b->tipo_plan) {
                        // 'suscripcion' viene antes que 'prepago' alfabéticamente invertido
                        return $a->tipo_plan === 'suscripcion' ? -1 : 1;
                    }

                    // 3. Finalmente por orden ascendente (1, 2, 3... y 0 al final)
                    $ordenA = $a->orden == 0 ? PHP_INT_MAX : $a->orden;
                    $ordenB = $b->orden == 0 ? PHP_INT_MAX : $b->orden;

                    return $ordenA <=> $ordenB;
                })
                ->values()
                ->map(function ($plan) {
                    return [
                        'id' => $plan->id,
                        'nombre_plan' => $plan->nombre_plan,
                        'tipo_plan' => $plan->tipo_plan,
                        'ciudad' => $plan->ciudad->nombre ?? 'N/A',
                        'sede' => $plan->sede->nombre_sede ?? 'N/A',
                        'numero_dias' => $plan->numero_dias,
                        'valor' => '$' . number_format($plan->valor, 0, ',', '.'),
                        'precio_final' => '$' . number_format($plan->precio_final, 0, ',', '.'),
                        'descuento' => $plan->descuento > 0 ? $plan->descuento . '%' : '-',
                        'visible_web' => $plan->visible_web,
                        'orden' => $plan->orden,
                        'detalles_count' => $plan->detalles->count(),
                    ];
                });

            return response()->json(['data' => $planes]);
        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'error' => 'Error al obtener los planes: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ciudades = Ciudad::where('estado', 1)->orderBy('nombre')->get();
        $sedes = Sede::orderBy('nombre_sede')->get();

        return view('planes.create', compact('ciudades', 'sedes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre_plan' => 'required|string|max:255',
                'numero_clases' => 'required|integer|min:1',
                'numero_dias' => 'nullable|integer|min:1',
                'valor' => 'required|numeric|min:0',
                'sede_id' => 'required|exists:sedes,id',
                'ciudad_id' => 'required|exists:ciudades,id',
                'descripcion_corta' => 'nullable|string|max:500',
                'visible_web' => 'boolean',
                'orden' => 'nullable|integer|min:0',
                'descuento' => 'nullable|numeric|min:0|max:100',
                'tipo_plan' => 'required|in:suscripcion,prepago',
            ]);

            $validated['visible_web'] = $request->has('visible_web') ? 1 : 0;
            $validated['orden'] = $validated['orden'] ?? 0;
            $validated['descuento'] = $validated['descuento'] ?? 0;

            // Si es suscripción, establecer numero_dias en 365 automáticamente
            if ($validated['tipo_plan'] === 'suscripcion') {
                $validated['numero_dias'] = 365;
            }

            Plan::create($validated);

            return redirect()->route('planes.index')
                ->with('success', 'Plan creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al crear el plan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        try {
            $plan->load(['ciudad', 'sede', 'detalles' => function ($query) {
                $query->orderBy('orden');
            }]);

            // Contar clientes activos con este plan
            $clientesActivos = $plan->perPlanes()->where('estado', 1)->count();

            return view('planes.show', compact('plan', 'clientesActivos'));
        } catch (\Exception $e) {
            return redirect()->route('planes.index')
                ->with('error', 'Error al cargar el plan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan)
    {
        $ciudades = Ciudad::where('estado', 1)->orderBy('nombre')->get();
        $sedes = Sede::orderBy('nombre_sede')->get();

        return view('planes.edit', compact('plan', 'ciudades', 'sedes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plan $plan)
    {
        try {
            $validated = $request->validate([
                'nombre_plan' => 'required|string|max:255',
                'numero_clases' => 'required|integer|min:1',
                'numero_dias' => 'nullable|integer|min:1',
                'valor' => 'required|numeric|min:0',
                'sede_id' => 'required|exists:sedes,id',
                'ciudad_id' => 'required|exists:ciudades,id',
                'descripcion_corta' => 'nullable|string|max:500',
                'visible_web' => 'boolean',
                'orden' => 'nullable|integer|min:0',
                'descuento' => 'nullable|numeric|min:0|max:100',
                'tipo_plan' => 'required|in:suscripcion,prepago',
            ]);

            $validated['visible_web'] = $request->has('visible_web') ? 1 : 0;
            $validated['orden'] = $validated['orden'] ?? 0;
            $validated['descuento'] = $validated['descuento'] ?? 0;

            // Si es suscripción, establecer numero_dias en 365 automáticamente
            if ($validated['tipo_plan'] === 'suscripcion') {
                $validated['numero_dias'] = 365;
            }

            $plan->update($validated);

            return redirect()->route('planes.index')
                ->with('success', 'Plan actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al actualizar el plan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        try {
            // Verificar si tiene clientes activos
            $clientesActivos = $plan->perPlanes()->where('estado', 1)->count();

            if ($clientesActivos > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar el plan porque tiene ' . $clientesActivos . ' cliente(s) activo(s).'
                ], 400);
            }

            // Eliminar los detalles primero
            $plan->detalles()->delete();

            // Eliminar el plan
            $plan->delete();

            return response()->json([
                'success' => true,
                'message' => 'Plan eliminado exitosamente.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el plan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a new detail for the plan
     */
    public function storeDetalle(Request $request, Plan $plan)
    {
        try {
            $validated = $request->validate([
                'titulo' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('planes_detalles', 'titulo')->where(function ($query) use ($plan) {
                        return $query->where('plan_id', $plan->id);
                    })
                ],
                'descripcion' => 'nullable|string|max:1000',
                'icono' => 'required|string|max:100',
                'orden' => 'nullable|integer|min:0',
                'tipo' => 'required|string|max:50',
            ], [
                'titulo.unique' => 'Ya existe un detalle con este título para este plan.',
                'icono.required' => 'Debe seleccionar un icono.'
            ]);

            $validated['plan_id'] = $plan->id;
            $validated['orden'] = $validated['orden'] ?? 0;

            PlanDetalle::create($validated);

            return redirect()->route('planes.show', $plan)
                ->with('success', 'Detalle agregado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al agregar el detalle: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Update the specified detail
     */
    public function updateDetalle(Request $request, Plan $plan, PlanDetalle $detalle)
    {
        try {
            // Verificar que el detalle pertenece al plan
            if ($detalle->plan_id != $plan->id) {
                abort(404);
            }

            $validated = $request->validate([
                'titulo' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('planes_detalles', 'titulo')->where(function ($query) use ($plan) {
                        return $query->where('plan_id', $plan->id);
                    })->ignore($detalle->id)
                ],
                'descripcion' => 'nullable|string|max:1000',
                'icono' => 'required|string|max:100',
                'orden' => 'nullable|integer|min:0',
                'tipo' => 'required|string|max:50',
            ], [
                'titulo.unique' => 'Ya existe un detalle con este título para este plan.',
                'icono.required' => 'Debe seleccionar un icono.'
            ]);

            $validated['orden'] = $validated['orden'] ?? 0;

            $detalle->update($validated);

            return redirect()->route('planes.show', $plan)
                ->with('success', 'Detalle actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al actualizar el detalle: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified detail
     */
    public function destroyDetalle(Plan $plan, PlanDetalle $detalle)
    {
        try {
            // Verificar que el detalle pertenece al plan
            if ($detalle->plan_id != $plan->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'El detalle no pertenece a este plan.'
                ], 404);
            }

            $detalle->delete();

            return response()->json([
                'success' => true,
                'message' => 'Detalle eliminado exitosamente.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el detalle: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get sedes by ciudad
     */
    public function getSedesByCiudad($ciudadId)
    {
        try {
            $sedes = Sede::where('ciudad_id', $ciudadId)
                ->orderBy('nombre_sede')
                ->get(['id', 'nombre_sede']);

            return response()->json($sedes);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener las sedes: ' . $e->getMessage()
            ], 500);
        }
    }
}
