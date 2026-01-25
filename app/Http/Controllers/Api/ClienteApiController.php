<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ClienteApiController extends Controller
{
    /**
     * Retrieve client information by document number
     *
     * Searches the Persona table for a client matching the provided document
     * number and returns their complete profile information. This endpoint
     * is used by the frontend payment gateway to verify client identity.
     *
     * @param string $documento Client's unique document identifier
     * @return \Illuminate\Http\JsonResponse JSON response containing client data
     *
     * @throws \Illuminate\Validation\ValidationException When documento is invalid
     * @throws \Exception When database connection fails
     *
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "id": 1,
     *     "tipo_doc": "CC",
     *     "documento": "1234567890",
     *     "nombres": "John",
     *     "apellidos": "Doe",
     *     "fecha_nacimiento": "1990-01-01",
     *     "direccion": "Calle 123 #45-67",
     *     "telefono": "3001234567",
     *     "correo": "john@example.com",
     *     "created_at": "2025-01-01T00:00:00.000000Z",
     *     "updated_at": "2025-01-01T00:00:00.000000Z"
     *   }
     * }
     *
     * @response 404 {
     *   "success": false,
     *   "message": "Cliente no encontrado con el documento proporcionado"
     * }
     *
     * @response 422 {
     *   "success": false,
     *   "message": "Datos de entrada inválidos",
     *   "errors": {
     *     "documento": ["El documento solo debe contener números"]
     *   }
     * }
     */
    public function getByDocumento(string $documento): JsonResponse
    {
        try {
            // Step 1: Validate input
            $validator = Validator::make(
                ['documento' => $documento],
                [
                    'documento' => 'required|string|max:20|regex:/^[0-9]+$/'
                ],
                [
                    'documento.required' => 'El documento es obligatorio',
                    'documento.max' => 'El documento no puede exceder 20 caracteres',
                    'documento.regex' => 'El documento solo debe contener números'
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos de entrada inválidos',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Step 2: Query database
            $cliente = Persona::where('documento', $documento)
                ->select('personas.id', 'personas.tipo_doc', 'personas.documento', 'personas.nombres', 'personas.apellidos', 'personas.fecha_nacimiento', 'personas.direccion', 'personas.telefono', 'personas.correo', 'personas.created_at', 'personas.updated_at')
                ->join('users', 'users.persona_id', '=', 'personas.id')
                ->where('users.rol', 'cliente')
                ->first();

            // Step 3: Handle not found
            if (!$cliente) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cliente no encontrado con el documento proporcionado'
                ], 404);
            }

            // Step 4: Return success response with all client data
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $cliente->id,
                    'tipo_doc' => $cliente->tipo_doc,
                    'documento' => $cliente->documento,
                    'nombres' => $cliente->nombres,
                    'apellidos' => $cliente->apellidos,
                    'fecha_nacimiento' => $cliente->fecha_nacimiento,
                    'direccion' => $cliente->direccion,
                    'telefono' => $cliente->telefono,
                    'correo' => $cliente->correo,
                    'created_at' => $cliente->created_at,
                    'updated_at' => $cliente->updated_at
                ]
            ], 200);

        } catch (\Exception $e) {
            // Step 5: Handle unexpected errors
            Log::error('Error al obtener cliente por documento', [
                'documento' => $documento,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor al procesar la solicitud'
            ], 500);
        }
    }
}
