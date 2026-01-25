# API Development Instructions for Gym Payment Gateway

## Project Context
Development of RESTful API endpoints for a gym's payment gateway frontend integration. The system manages client information, membership plans, and payment processing.

## Database Models Reference
- **Persona.php**: Client/user entity model
- **Perplanes.php**: Client-plan relationship model (links clients to their active plans)
- **Plan.php**: Membership plan model
- **PlanDetalle.php**: Plan details model (features, pricing, etc.)

---

## Required Endpoints

### 1. Get Client Information by Document
**Endpoint:** `GET /api/cliente/{documento}`

**Purpose:** Retrieve complete client information using their document ID.

**Requirements:**
- Accept document number as URL parameter
- Return full client details from `Persona` model
- Include related data if applicable
- Handle cases where client doesn't exist

**Response Structure:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "documento": "1234567890",
    "nombre": "John Doe",
    "email": "john@example.com"
  }
}
```

---

### 2. Verify Active Plan
**Endpoint:** `POST /api/verify-plan`

**Purpose:** Verify if a client has an active plan (status = 1) within specified date range.

**Request Body:**
```json
{
  "documento": "1234567890",
  "fecha_inicio": "2025-01-01",
  "fecha_fin": "2025-12-31"
}
```

**Business Logic:**
- Query `per_planes` table for the given client (documento)
- Check for plans with `estado = 1` (active status)
- Verify date overlap between requested dates and existing active plans
- Return conflict details if active plan exists

**Date Overlap Detection:**
The system must detect these overlap scenarios:
```
Existing Plan: |-------|
New Plan Cases:
  Overlap Start:     |-------|
  Overlap End:   |-------|
  Encompasses:   |-----------|
  Within:          |----|
```

**Response Structure:**
```json
{
  "success": true,
  "has_active_plan": true,
  "message": "Cliente tiene un plan activo en el rango de fechas especificado",
  "plan_details": {
    "id": 5,
    "plan_id": 2,
    "fecha_inicio": "2025-01-15",
    "fecha_fin": "2025-06-15",
    "estado": 1
  }
}
```

---

### 3. Get Visible Plans
**Endpoint:** `GET /api/planes/visibles`

**Purpose:** Retrieve all publicly visible plans with their details for display on the gym website.

**Requirements:**
- Fetch all visible/active plans from `Plan` model
- Include related `PlanDetalle` data (use Eloquent relationships)
- Return comprehensive plan information including features, pricing, duration
- Optimize query with eager loading to prevent N+1 queries

**Response Structure:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "nombre": "Plan Básico",
      "descripcion": "Acceso a gimnasio básico",
      "precio": 50000,
      "duracion_meses": 1,
      "visible": true,
      "detalles": [
        {
          "id": 1,
          "plan_id": 1,
          "caracteristica": "Acceso a área de pesas",
          "valor": true
        },
        {
          "id": 2,
          "plan_id": 1,
          "caracteristica": "Clases grupales",
          "valor": false
        }
      ]
    }
  ]
}
```

---

## Technical Requirements

### Code Quality Standards

#### 1. Documentation
- All methods MUST include PHPDoc comments
- Document purpose, parameters, return types, and thrown exceptions
- Include usage examples where appropriate

**Example:**
```php
/**
 * Retrieve client information by document number
 * 
 * This method searches for a client in the database using their
 * unique document identifier and returns their complete profile.
 * 
 * @param string $documento Client's document ID (e.g., "1234567890")
 * @return \Illuminate\Http\JsonResponse JSON response with client data or error
 * 
 * @throws \Illuminate\Validation\ValidationException When documento format is invalid
 * @throws \Exception When database error occurs
 * 
 * @example
 * GET /api/cliente/1234567890
 * Response: {"success": true, "data": {...}}
 */
public function getByDocumento(string $documento)
{
    // Implementation
}
```

#### 2. Error Handling
- Implement comprehensive `try-catch` blocks
- Return consistent error response format
- Log errors appropriately using Laravel's Log facade
- Use HTTP status codes correctly:
  - `200`: Success
  - `404`: Resource not found
  - `422`: Validation error
  - `500`: Server error

**Standard Error Response Format:**
```json
{
  "success": false,
  "message": "Error descriptivo para el usuario",
  "errors": {
    "campo": ["Detalle del error de validación"]
  }
}
```

#### 3. Validation
- Validate all incoming request data
- Use Laravel Form Requests for complex validation
- Return clear validation error messages in Spanish
- Validate data types, formats, and business rules

**Example Form Request:**
```php
namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class VerifyPlanRequest extends FormRequest
{
    public function rules()
    {
        return [
            'documento' => 'required|string|max:20',
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after:fecha_inicio',
        ];
    }

    public function messages()
    {
        return [
            'documento.required' => 'El documento es obligatorio',
            'fecha_inicio.after_or_equal' => 'La fecha de inicio debe ser hoy o posterior',
            'fecha_fin.after' => 'La fecha de fin debe ser posterior a la fecha de inicio',
        ];
    }
}
```

#### 4. Response Format
- Maintain consistent JSON response structure across all endpoints
- Always include `success` boolean flag
- Include meaningful messages for both success and error cases
- Use proper HTTP status codes

---

### Authentication & Security

#### Middleware Configuration
- **Middleware:** All endpoints MUST use `auth:sanctum` middleware
- **Configuration:** Already implemented in `routes/api.php`
- **Token:** Expect Bearer token in Authorization header
- **Validation:** Verify token validity on each request

**Route Protection Example:**
```php
// routes/api.php
Route::middleware('auth:sanctum')->prefix('api')->group(function () {
    Route::get('/cliente/{documento}', [ClienteApiController::class, 'getByDocumento']);
    Route::post('/verify-plan', [PlanApiController::class, 'verifyPlan']);
    Route::get('/planes/visibles', [PlanApiController::class, 'getPlanesVisibles']);
});
```

#### Security Checklist
- [ ] Sanitize all inputs (Laravel does this automatically)
- [ ] Use parameterized queries (Eloquent handles this)
- [ ] Validate documento format and length
- [ ] Implement rate limiting on API endpoints
- [ ] Log sensitive operations (plan changes, client access)
- [ ] Never expose sensitive data in error messages
- [ ] Validate date ranges to prevent abuse

---

## Controller Architecture

### Option 1: Dedicated API Controller (✅ Recommended)
Create a dedicated `Api\` namespace for API-specific controllers:

```
app/Http/Controllers/Api/
├── ClienteApiController.php
├── PlanApiController.php
```

**Benefits:**
- Clear separation of concerns
- API-specific logic isolated from web controllers
- Easier to version (v1, v2) in the future
- Better maintainability and scalability
- Follows RESTful best practices

**Implementation:**
```php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ClienteApiController extends Controller
{
    // API methods here
}
```

### Option 2: Extend Existing Controllers
Add API methods to existing controllers if they already exist.

**Use when:**
- Existing controllers are lightweight
- Logic is closely related to existing web methods
- Team prefers consolidated controllers
- Project is small-scale

---

## Implementation Guidelines

### Complete Method Template

```php
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
 *     "documento": "1234567890",
 *     "nombre": "John Doe",
 *     "email": "john@example.com"
 *   }
 * }
 * 
 * @response 404 {
 *   "success": false,
 *   "message": "Cliente no encontrado"
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
        $cliente = Persona::where('documento', $documento)->first();

        // Step 3: Handle not found
        if (!$cliente) {
            return response()->json([
                'success' => false,
                'message' => 'Cliente no encontrado con el documento proporcionado'
            ], 404);
        }

        // Step 4: Return success response
        return response()->json([
            'success' => true,
            'data' => $cliente
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
```

### Date Overlap Validation Logic

```php
/**
 * Check if there's a date overlap between two date ranges
 * 
 * @param string $start1 Start date of first range
 * @param string $end1 End date of first range
 * @param string $start2 Start date of second range
 * @param string $end2 End date of second range
 * @return bool True if ranges overlap, false otherwise
 */
private function datesOverlap($start1, $end1, $start2, $end2): bool
{
    return ($start1 <= $end2) && ($end1 >= $start2);
}
```

### Query Optimization for Endpoint 3

```php
/**
 * Get all visible plans with their details
 * 
 * Retrieves all plans marked as visible for public display on the gym
 * website. Uses eager loading to prevent N+1 query problems and includes
 * all plan details (features, pricing, duration, etc.).
 * 
 * @return \Illuminate\Http\JsonResponse
 */
public function getPlanesVisibles(): JsonResponse
{
    try {
        // Use eager loading to avoid N+1 queries
        $planes = Plan::with('detalles')
            ->where('visible', true)
            ->orderBy('precio', 'asc')
            ->get();

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
```

---

## Database Optimization

### Required Indexes
Add these indexes to improve query performance:

```php
// In migration file
Schema::table('personas', function (Blueprint $table) {
    $table->index('documento');
});

Schema::table('per_planes', function (Blueprint $table) {
    $table->index(['documento', 'estado']);
    $table->index(['fecha_inicio', 'fecha_fin']);
});

Schema::table('planes', function (Blueprint $table) {
    $table->index('visible');
});
```

---

## Implementation Checklist

### Phase 1: Setup
- [ ] Create `App\Http\Controllers\Api` directory
- [ ] Create `ClienteApiController.php`
- [ ] Create `PlanApiController.php`
- [ ] Create Form Request classes if needed
- [ ] Set up routes in `routes/api.php` with `auth:sanctum`

### Phase 2: Endpoint 1 - Get Client by Document
- [ ] Implement `getByDocumento()` method
- [ ] Add comprehensive PHPDoc comments
- [ ] Implement try-catch error handling
- [ ] Add input validation for documento
- [ ] Test with existing client
- [ ] Test with non-existent client
- [ ] Test with invalid documento format

### Phase 3: Endpoint 2 - Verify Active Plan
- [ ] Implement `verifyPlan()` method
- [ ] Add comprehensive PHPDoc comments
- [ ] Implement date overlap logic
- [ ] Add validation for dates and documento
- [ ] Implement try-catch error handling
- [ ] Test with no active plans
- [ ] Test with overlapping active plan
- [ ] Test with non-overlapping active plan
- [ ] Test edge cases (same start/end dates)

### Phase 4: Endpoint 3 - Get Visible Plans
- [ ] Implement `getPlanesVisibles()` method
- [ ] Add comprehensive PHPDoc comments
- [ ] Implement eager loading for detalles
- [ ] Implement try-catch error handling
- [ ] Test with visible plans
- [ ] Test with no visible plans
- [ ] Verify N+1 query prevention

### Phase 5: Testing & Documentation
- [ ] Create Postman/Insomnia collection
- [ ] Test all success scenarios
- [ ] Test all error scenarios
- [ ] Test authentication failures
- [ ] Verify response formats
- [ ] Test with invalid tokens
- [ ] Document API in README or Swagger

### Phase 6: Performance & Security
- [ ] Add database indexes
- [ ] Implement rate limiting
- [ ] Add API logging
- [ ] Review security vulnerabilities
- [ ] Test under load (if applicable)

---

## Testing Scenarios

### Endpoint 1: Get Client by Document

**Test Case 1: Successful retrieval**
```
GET /api/cliente/1234567890
Authorization: Bearer {token}

Expected: 200 OK with client data
```

**Test Case 2: Client not found**
```
GET /api/cliente/9999999999
Authorization: Bearer {token}

Expected: 404 Not Found
```

**Test Case 3: Invalid documento format**
```
GET /api/cliente/ABC123
Authorization: Bearer {token}

Expected: 422 Unprocessable Entity
```

**Test Case 4: Unauthorized access**
```
GET /api/cliente/1234567890
(No Authorization header)

Expected: 401 Unauthorized
```

### Endpoint 2: Verify Active Plan

**Test Case 1: No active plan**
```
POST /api/verify-plan
Authorization: Bearer {token}
Content-Type: application/json

{
  "documento": "1234567890",
  "fecha_inicio": "2025-06-01",
  "fecha_fin": "2025-12-01"
}

Expected: 200 OK, has_active_plan: false
```

**Test Case 2: Active plan exists (overlap)**
```
POST /api/verify-plan
Authorization: Bearer {token}
Content-Type: application/json

{
  "documento": "1234567890",
  "fecha_inicio": "2025-01-01",
  "fecha_fin": "2025-06-01"
}

Expected: 200 OK, has_active_plan: true with plan details
```

**Test Case 3: Invalid date range**
```
POST /api/verify-plan
Authorization: Bearer {token}
Content-Type: application/json

{
  "documento": "1234567890",
  "fecha_inicio": "2025-12-01",
  "fecha_fin": "2025-01-01"
}

Expected: 422 Unprocessable Entity
```

### Endpoint 3: Get Visible Plans

**Test Case 1: Plans exist**
```
GET /api/planes/visibles
Authorization: Bearer {token}

Expected: 200 OK with array of plans and details
```

**Test Case 2: No visible plans**
```
GET /api/planes/visibles
Authorization: Bearer {token}

Expected: 200 OK with empty array and message
```

---

## Best Practices Summary

### Code Organization
✅ Use dependency injection for services  
✅ Follow PSR-12 coding standards  
✅ Keep controllers thin (delegate complex business logic to services)  
✅ Use Eloquent relationships efficiently  
✅ Group related functionality in dedicated controllers  

### Performance
✅ Implement eager loading for relationships (`->with()`)  
✅ Add database indexes on frequently queried fields  
✅ Consider caching for visible plans endpoint  
✅ Use pagination for large datasets  
✅ Minimize database queries in loops  

### Security
✅ Use Laravel Sanctum authentication  
✅ Validate and sanitize all inputs  
✅ Use parameterized queries (Eloquent handles this)  
✅ Implement rate limiting  
✅ Log sensitive operations without exposing data  
✅ Never return sensitive data in error messages  

### Error Handling
✅ Use try-catch blocks consistently  
✅ Log errors with context  
✅ Return user-friendly error messages  
✅ Use appropriate HTTP status codes  
✅ Handle edge cases explicitly  

### Documentation
✅ Add PHPDoc comments to all public methods  
✅ Document request/response formats  
✅ Include usage examples  
✅ Document validation rules  
✅ Maintain API documentation (Postman/Swagger)  

---

## API Versioning (Future Consideration)

Consider implementing API versioning from the start:

```php
// routes/api.php
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::get('/cliente/{documento}', [ClienteApiController::class, 'getByDocumento']);
    Route::post('/verify-plan', [PlanApiController::class, 'verifyPlan']);
    Route::get('/planes/visibles', [PlanApiController::class, 'getPlanesVisibles']);
});
```

URLs would become:
- `/api/v1/cliente/{documento}`
- `/api/v1/verify-plan`
- `/api/v1/planes/visibles`

---

## Deliverables

1. ✅ Fully functional API endpoints meeting all specifications
2. ✅ PHPDoc comments on all methods with examples
3. ✅ Comprehensive error handling with try-catch blocks
4. ✅ Request validation implementation (Form Requests or inline)
5. ✅ Routes configured with `auth:sanctum` middleware
6. ✅ Postman collection or API documentation for testing
7. ✅ Database indexes for optimized queries
8. ✅ Test results for all scenarios
9. ✅ Code following PSR-12 standards

---

## Support Resources

- **Laravel Documentation**: https://laravel.com/docs
- **Laravel Sanctum**: https://laravel.com/docs/sanctum
- **API Best Practices**: RESTful API design principles
- **PSR-12 Coding Standards**: https://www.php-fig.org/psr/psr-12/

---

## Notes

- All responses must be in Spanish for user-facing messages
- Error messages should be clear and actionable
- The payment gateway frontend depends on consistent response formats
- Security is paramount - never expose sensitive data
- Performance matters - optimize queries from the start
- Document everything - future developers will thank you

---

**Last Updated:** December 2025  
**Version:** 1.0  
**Maintainer:** Development Team
