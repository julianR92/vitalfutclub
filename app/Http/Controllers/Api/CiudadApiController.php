<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ciudad;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CiudadApiController extends Controller
{
    /**
     * Get all active cities
     *
     * Retrieves all cities marked as active (estado = 1) from the database.
     * This endpoint is used by the frontend to populate city selection dropdowns
     * and display available gym locations.
     *
     * @return \Illuminate\Http\JsonResponse JSON response with all active cities
     *
     * @throws \Exception When database errors occur
     *
     * @response 200 {
     *   "success": true,
     *   "data": [
     *     {
     *       "id": 1,
     *       "nombre": "Bogotá",
     *       "codigo": "BOG",
     *       "estado": true,
     *       "created_at": "2025-01-01T00:00:00.000000Z",
     *       "updated_at": "2025-01-01T00:00:00.000000Z"
     *     },
     *     {
     *       "id": 2,
     *       "nombre": "Medellín",
     *       "codigo": "MDE",
     *       "estado": true,
     *       "created_at": "2025-01-01T00:00:00.000000Z",
     *       "updated_at": "2025-01-01T00:00:00.000000Z"
     *     }
     *   ]
     * }
     *
     * @response 200 {
     *   "success": true,
     *   "message": "No hay ciudades disponibles en este momento",
     *   "data": []
     * }
     */
    public function getCiudades(): JsonResponse
    {
        try {
            // Get all active cities ordered by name
            $ciudades = Ciudad::activas()
                ->orderBy('nombre', 'asc')
                ->get()
                ->map(function ($ciudad) {
                    return [
                        'id' => $ciudad->id,
                        'nombre' => $ciudad->nombre,
                        'codigo' => $ciudad->codigo,
                        'estado' => $ciudad->estado,
                        'created_at' => $ciudad->created_at,
                        'updated_at' => $ciudad->updated_at
                    ];
                });

            if ($ciudades->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'message' => 'No hay ciudades disponibles en este momento',
                    'data' => []
                ], 200);
            }

            return response()->json([
                'success' => true,
                'data' => $ciudades
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error al obtener ciudades', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al cargar las ciudades disponibles'
            ], 500);
        }
    }

    /**
     * Get all visible plans by city
     *
     * Retrieves all plans marked as visible (visible_web = true) filtered
     * by city ID. Includes complete plan details, detalles, and sede information.
     * Uses eager loading to optimize database queries and prevent N+1 problems.
     *
     * @param int $ciudadId The ID of the city to filter plans
     * @return \Illuminate\Http\JsonResponse JSON response with plans for the specified city
     *
     * @throws \Exception When database errors occur
     *
     * @response 200 {
     *   "success": true,
     *   "ciudad": {
     *     "id": 1,
     *     "nombre": "Bogotá",
     *     "codigo": "BOG"
     *   },
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
     *       "sede": {
     *         "id": 1,
     *         "nombre_sede": "Sede Norte",
     *         "direccion": "Calle 123 #45-67",
     *         "telefono": "3001234567",
     *         "persona_cargo": "Juan Pérez"
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
     *
     * @response 404 {
     *   "success": false,
     *   "message": "Ciudad no encontrada"
     * }
     *
     * @response 200 {
     *   "success": true,
     *   "ciudad": {
     *     "id": 1,
     *     "nombre": "Bogotá",
     *     "codigo": "BOG"
     *   },
     *   "message": "No hay planes disponibles para esta ciudad",
     *   "data": []
     * }
     */
    public function getPlanesByCiudad(int $ciudadId): JsonResponse
    {
        try {
            // Step 1: Verify city exists
            $ciudad = Ciudad::find($ciudadId);

            if (!$ciudad) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ciudad no encontrada'
                ], 404);
            }

            // Step 2: Get visible plans for this city with eager loading
            $planes = $ciudad->planes()
                ->with([
                    'detalles' => function ($query) {
                        $query->orderBy('orden');
                    },
                    'sede:id,nombre_sede,direccion,telefono,persona_cargo'
                ])
                ->where('visible_web', true)
                ->orderBy('orden', 'asc')
                ->orderBy('valor', 'asc')
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

            // Step 3: Return response
            if ($planes->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'ciudad' => [
                        'id' => $ciudad->id,
                        'nombre' => $ciudad->nombre,
                        'codigo' => $ciudad->codigo
                    ],
                    'message' => 'No hay planes disponibles para esta ciudad',
                    'data' => []
                ], 200);
            }

            return response()->json([
                'success' => true,
                'ciudad' => [
                    'id' => $ciudad->id,
                    'nombre' => $ciudad->nombre,
                    'codigo' => $ciudad->codigo
                ],
                'data' => $planes
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error al obtener planes por ciudad', [
                'ciudad_id' => $ciudadId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al cargar los planes de la ciudad'
            ], 500);
        }
    }
}
