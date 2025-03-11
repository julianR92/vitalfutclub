<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\PerPLanes;
use App\Models\Persona;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PlanApiController extends Controller
{
    /**
     * Verify if a client has an active plan within a specified date range
     *
     * This method checks the per_planes table for active plans (estado = 1)
     * that overlap with the requested date range. Date overlap detection
     * prevents double-booking and ensures data integrity.
     *
     * @param Request $request Request containing documento, fecha_inicio, fecha_fin
     * @return \Illuminate\Http\JsonResponse JSON response with verification result
     *
     * @throws \Illuminate\Validation\ValidationException When input validation fails
     * @throws \Exception When database errors occur
     *
     * @response 200 {
     *   "success": true,
     *   "has_active_plan": true,
     *   "message": "Cliente tiene un plan activo en el rango de fechas especificado",
     *   "plan_details": {
     *     "id": 5,
     *     "persona_id": 1,
     *     "plan_id": 2,
     *     "fecha_inicio": "2025-01-15",
     *     "fecha_fin": "2025-06-15",
     *     "numero_clase": 12,
     *     "cantidad_plan": 1,
     *     "estado": 1,
     *     "observacion": null,
     *     "plan": {
     *       "id": 2,
     *       "nombre_plan": "Plan Premium",
     *       "numero_clases": 12,
     *       "numero_dias": 180,
     *       "valor": 500000,
     *       "tipo_plan": "prepago"
     *     }
     *   }
     * }
     */
    public function verifyPlan(Request $request): JsonResponse
    {
        try {
            // Step 1: Validate input
            $validator = Validator::make($request->all(), [
                'documento' => 'required|string|max:20',
                'fecha_inicio' => 'required|date|after_or_equal:today',
                'fecha_fin' => 'required|date|after:fecha_inicio',
            ], [
                'documento.required' => 'El documento es obligatorio',
                'fecha_inicio.required' => 'La fecha de inicio es obligatoria',
                'fecha_inicio.after_or_equal' => 'La fecha de inicio debe ser hoy o posterior',
                'fecha_fin.required' => 'La fecha de fin es obligatoria',
                'fecha_fin.after' => 'La fecha de fin debe ser posterior a la fecha de inicio',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos de entrada inválidos',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Step 2: Find cliente by documento
            $persona = Persona::where('documento', $request->documento)->first();

            if (!$persona) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cliente no encontrado con el documento proporcionado'
                ], 404);
            }

            // Step 3: Check for active plans with date overlap
            $fechaInicio = Carbon::parse($request->fecha_inicio);
            $fechaFin = Carbon::parse($request->fecha_fin);

            $planActivo = PerPLanes::with(['planes:id,nombre_plan,numero_clases,numero_dias,valor,tipo_plan'])
                ->where('persona_id', $persona->id)
                ->where('estado', 1) // Solo planes activos
                ->where(function ($query) use ($fechaInicio, $fechaFin) {
                    // Date overlap logic: (start1 <= end2) AND (end1 >= start2)
                    $query->where(function ($q) use ($fechaInicio, $fechaFin) {
                        $q->where('fecha_inicio', '<=', $fechaFin)
                          ->where('fecha_fin', '>=', $fechaInicio);
                    });
                })
                ->first();

            // Step 4: Return response based on verification result
            if ($planActivo) {
                return response()->json([
                    'success' => true,
                    'has_active_plan' => true,
                    'message' => 'Cliente tiene un plan activo en el rango de fechas especificado',
                    'plan_details' => [
                        'id' => $planActivo->id,
                        'persona_id' => $planActivo->persona_id,
                        'plan_id' => $planActivo->plan_id,
                        'fecha_inicio' => $planActivo->fecha_inicio,
                        'fecha_fin' => $planActivo->fecha_fin,
                        'numero_clase' => $planActivo->numero_clase,
                        'cantidad_plan' => $planActivo->cantidad_plan,
                        'estado' => $planActivo->estado,
                        'observacion' => $planActivo->observacion,
                        'plan' => $planActivo->planes ? [
                            'id' => $planActivo->planes->id,
                            'nombre_plan' => $planActivo->planes->nombre_plan,
                            'numero_clases' => $planActivo->planes->numero_clases,
                            'numero_dias' => $planActivo->planes->numero_dias,
                            'valor' => $planActivo->planes->valor,
                            'tipo_plan' => $planActivo->planes->tipo_plan
                        ] : null
                    ]
                ], 200);
            } else {
                return response()->json([
                    'success' => true,
                    'has_active_plan' => false,
                    'message' => 'No hay planes activos en el rango de fechas especificado'
                ], 200);
            }

        } catch (\Exception $e) {
            // Step 5: Handle unexpected errors
            Log::error('Error al verificar plan activo', [
                'documento' => $request->documento ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor al procesar la solicitud'
            ], 500);
        }
    }

    /**
     * Get all visible plans with their details
     *
     * Retrieves all plans marked as visible for public display on the gym
     * website. Uses eager loading to prevent N+1 query problems and includes
     * all plan details (features, pricing, duration, etc.).
     *
     * @return \Illuminate\Http\JsonResponse JSON response with visible plans
     *
     * @response 200 {
     *   "success": true,
     *   "data": [
     *     {
     *       "id": 1,
     *       "nombre_plan": "Plan Básico",
     *       "numero_clases": 8,
     *       "numero_dias": 30,
     *       "valor": 150000,
     *       "precio_final": 135000,
     *       "descuento": 10,
     *       "tiene_descuento": true,
     *       "ahorro": 15000,
     *       "tipo_plan": "prepago",
     *       "descripcion_corta": "Acceso básico al gimnasio",
     *       "visible_web": true,
     *       "orden": 1,
     *       "ciudad": {
     *         "id": 1,
     *         "nombre": "Bogotá",
     *         "codigo": "BOG"
     *       },
     *       "sede": {
     *         "id": 1,
     *         "nombre_sede": "Sede Norte",
     *         "direccion": "Calle 123 #45-67",
     *         "telefono": "3001234567"
     *       },
     *       "detalles": [
     *         {
     *           "id": 1,
     *           "plan_id": 1,
     *           "titulo": "Acceso a área de pesas",
     *           "descripcion": "Uso completo del área de pesas",
     *           "icono": "fas fa-dumbbell",
     *           "orden": 1,
     *           "tipo": "beneficio"
     *         }
     *       ]
     *     }
     *   ]
     * }
     */
    public function getPlanesVisibles(): JsonResponse
    {
        try {
            // Use eager loading to avoid N+1 queries
            $planes = Plan::with([
                'detalles' => function ($query) {
                    $query->orderBy('orden');
                },
                'ciudad:id,nombre,codigo',
                'sede:id,nombre_sede,direccion,telefono,persona_cargo'
            ])
            ->where('visible_web', 1)
            ->where('status', 1)
            ->orderBy('orden', 'asc')
            ->orderBy('precio_final', 'asc')
            ->get()
            ->map(function ($plan) {
                return [
                    'id' => $plan->id,
                    'nombre_plan' => $plan->nombre_plan,
                    'numero_clases' => $plan->numero_clases,
                    'numero_dias' => $plan->numero_dias,
                    'valor' => $plan->valor,
                    'precio_final' => $plan->precio_final,
                    'descuento' => $plan->descuento,
                    'tiene_descuento' => $plan->tiene_descuento,
                    'ahorro' => $plan->ahorro,
                    'tipo_plan' => $plan->tipo_plan,
                    'descripcion_corta' => $plan->descripcion_corta,
                    'visible_web' => $plan->visible_web,
                    'orden' => $plan->orden,
                    'ciudad' => $plan->ciudad ? [
                        'id' => $plan->ciudad->id,
                        'nombre' => $plan->ciudad->nombre,
                        'codigo' => $plan->ciudad->codigo
                    ] : null,
                    'sede' => $plan->sede ? [
                        'id' => $plan->sede->id,
                        'nombre_sede' => $plan->sede->nombre_sede,
                        'direccion' => $plan->sede->direccion,
                        'telefono' => $plan->sede->telefono,
                        'persona_cargo' => $plan->sede->persona_cargo
                    ] : null,
                    'detalles' => $plan->detalles->map(function ($detalle) {
                        return [
                            'id' => $detalle->id,
                            'plan_id' => $detalle->plan_id,
                            'titulo' => $detalle->titulo,
                            'descripcion' => $detalle->descripcion,
                            'icono' => $detalle->icono,
                            'orden' => $detalle->orden,
                            'tipo' => $detalle->tipo
                        ];
                    })
                ];
            });

            if ($planes->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'message' => 'No hay planes disponibles en este momento',
                    'data' => []
                ], 200);
            }

            return response()->json([
                'success' => true,
                'data' => $planes
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error al obtener planes visibles', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al cargar los planes disponibles'
            ], 500);
        }
    }
}
