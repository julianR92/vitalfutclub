# Payment Gateway API - Postman Collection Examples

## Base URL
```
http://localhost/api
```

## Authentication
Todos los endpoints requieren autenticación con Laravel Sanctum.

**Header requerido:**
```
Authorization: Bearer {your_token_here}
```

---

## Endpoint 1: Get Client by Document

### Request
```http
GET /api/cliente/1234567890
Authorization: Bearer {token}
```

### Response Success (200 OK)
```json
{
  "success": true,
  "data": {
    "id": 1,
    "tipo_doc": "CC",
    "documento": "1234567890",
    "nombres": "John",
    "apellidos": "Doe",
    "fecha_nacimiento": "1990-01-01",
    "direccion": "Calle 123 #45-67",
    "telefono": "3001234567",
    "correo": "john@example.com",
    "created_at": "2025-01-01T00:00:00.000000Z",
    "updated_at": "2025-01-01T00:00:00.000000Z"
  }
}
```

### Response Not Found (404)
```json
{
  "success": false,
  "message": "Cliente no encontrado con el documento proporcionado"
}
```

### Response Validation Error (422)
```json
{
  "success": false,
  "message": "Datos de entrada inválidos",
  "errors": {
    "documento": [
      "El documento solo debe contener números"
    ]
  }
}
```

---

## Endpoint 2: Verify Active Plan

### Request
```http
POST /api/verify-plan
Authorization: Bearer {token}
Content-Type: application/json

{
  "documento": "1234567890",
  "fecha_inicio": "2025-01-01",
  "fecha_fin": "2025-12-31"
}
```

### Response - Plan Activo Encontrado (200 OK)
```json
{
  "success": true,
  "has_active_plan": true,
  "message": "Cliente tiene un plan activo en el rango de fechas especificado",
  "plan_details": {
    "id": 5,
    "persona_id": 1,
    "plan_id": 2,
    "fecha_inicio": "2025-01-15",
    "fecha_fin": "2025-06-15",
    "numero_clase": 12,
    "cantidad_plan": 1,
    "estado": 1,
    "observacion": null,
    "plan": {
      "id": 2,
      "nombre_plan": "Plan Premium",
      "numero_clases": 12,
      "numero_dias": 180,
      "valor": 500000,
      "tipo_plan": "prepago"
    }
  }
}
```

### Response - Sin Plan Activo (200 OK)
```json
{
  "success": true,
  "has_active_plan": false,
  "message": "No hay planes activos en el rango de fechas especificado"
}
```

### Response - Cliente No Encontrado (404)
```json
{
  "success": false,
  "message": "Cliente no encontrado con el documento proporcionado"
}
```

### Response - Validation Error (422)
```json
{
  "success": false,
  "message": "Datos de entrada inválidos",
  "errors": {
    "fecha_inicio": [
      "La fecha de inicio debe ser hoy o posterior"
    ],
    "fecha_fin": [
      "La fecha de fin debe ser posterior a la fecha de inicio"
    ]
  }
}
```

---

## Endpoint 3: Get Visible Plans

### Request
```http
GET /api/planes/visibles
Authorization: Bearer {token}
```

### Response Success (200 OK)
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "nombre_plan": "Plan Básico",
      "numero_clases": 8,
      "numero_dias": 30,
      "valor": 150000,
      "precio_final": 135000,
      "descuento": 10,
      "tiene_descuento": true,
      "ahorro": 15000,
      "tipo_plan": "prepago",
      "descripcion_corta": "Acceso básico al gimnasio",
      "visible_web": true,
      "orden": 1,
      "ciudad": {
        "id": 1,
        "nombre": "Bogotá",
        "codigo": "BOG"
      },
      "sede": {
        "id": 1,
        "nombre_sede": "Sede Norte",
        "direccion": "Calle 123 #45-67",
        "telefono": "3001234567",
        "persona_cargo": "Juan Pérez"
      },
      "detalles": [
        {
          "id": 1,
          "plan_id": 1,
          "titulo": "Acceso a área de pesas",
          "descripcion": "Uso completo del área de pesas",
          "icono": "fas fa-dumbbell",
          "orden": 1,
          "tipo": "beneficio"
        },
        {
          "id": 2,
          "plan_id": 1,
          "titulo": "Clases grupales",
          "descripcion": "Acceso a clases de spinning y yoga",
          "icono": "fas fa-users",
          "orden": 2,
          "tipo": "beneficio"
        }
      ]
    },
    {
      "id": 2,
      "nombre_plan": "Plan Premium",
      "numero_clases": 12,
      "numero_dias": 180,
      "valor": 500000,
      "precio_final": 500000,
      "descuento": 0,
      "tiene_descuento": false,
      "ahorro": 0,
      "tipo_plan": "prepago",
      "descripcion_corta": "Acceso completo con entrenador personal",
      "visible_web": true,
      "orden": 2,
      "ciudad": {
        "id": 1,
        "nombre": "Bogotá",
        "codigo": "BOG"
      },
      "sede": {
        "id": 1,
        "nombre_sede": "Sede Norte",
        "direccion": "Calle 123 #45-67",
        "telefono": "3001234567",
        "persona_cargo": "Juan Pérez"
      },
      "detalles": [
        {
          "id": 3,
          "plan_id": 2,
          "titulo": "Entrenador Personal",
          "descripcion": "Sesiones individuales con entrenador certificado",
          "icono": "fas fa-user-shield",
          "orden": 1,
          "tipo": "premium"
        },
        {
          "id": 4,
          "plan_id": 2,
          "titulo": "Acceso Ilimitado",
          "descripcion": "Acceso 24/7 a todas las instalaciones",
          "icono": "fas fa-star",
          "orden": 2,
          "tipo": "premium"
        }
      ]
    }
  ]
}
```

### Response - No Plans Available (200 OK)
```json
{
  "success": true,
  "message": "No hay planes disponibles en este momento",
  "data": []
}
```

---

## Endpoint 4: Get All Cities

### Request
```http
GET /api/ciudades
Authorization: Bearer {token}
```

### Response Success (200 OK)
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "nombre": "Bogotá",
      "codigo": "BOG",
      "estado": true,
      "created_at": "2025-01-01T00:00:00.000000Z",
      "updated_at": "2025-01-01T00:00:00.000000Z"
    },
    {
      "id": 2,
      "nombre": "Medellín",
      "codigo": "MDE",
      "estado": true,
      "created_at": "2025-01-01T00:00:00.000000Z",
      "updated_at": "2025-01-01T00:00:00.000000Z"
    },
    {
      "id": 3,
      "nombre": "Cali",
      "codigo": "CAL",
      "estado": true,
      "created_at": "2025-01-01T00:00:00.000000Z",
      "updated_at": "2025-01-01T00:00:00.000000Z"
    }
  ]
}
```

### Response - No Cities Available (200 OK)
```json
{
  "success": true,
  "message": "No hay ciudades disponibles en este momento",
  "data": []
}
```

---

## Endpoint 5: Get Plans by City

### Request
```http
GET /api/ciudades/1/planes
Authorization: Bearer {token}
```

### Response Success (200 OK)
```json
{
  "success": true,
  "ciudad": {
    "id": 1,
    "nombre": "Bogotá",
    "codigo": "BOG"
  },
  "data": [
    {
      "id": 1,
      "nombre_plan": "Plan Básico",
      "numero_clases": 8,
      "numero_dias": 30,
      "valor": 150000,
      "precio_final": 135000,
      "descuento": 10,
      "tiene_descuento": true,
      "ahorro": 15000,
      "tipo_plan": "prepago",
      "descripcion_corta": "Acceso básico al gimnasio",
      "visible_web": true,
      "orden": 1,
      "sede": {
        "id": 1,
        "nombre_sede": "Sede Norte",
        "direccion": "Calle 123 #45-67",
        "telefono": "3001234567",
        "persona_cargo": "Juan Pérez"
      },
      "detalles": [
        {
          "id": 1,
          "plan_id": 1,
          "titulo": "Acceso a área de pesas",
          "descripcion": "Uso completo del área de pesas",
          "icono": "fas fa-dumbbell",
          "orden": 1,
          "tipo": "beneficio"
        },
        {
          "id": 2,
          "plan_id": 1,
          "titulo": "Clases grupales",
          "descripcion": "Acceso a clases de spinning y yoga",
          "icono": "fas fa-users",
          "orden": 2,
          "tipo": "beneficio"
        }
      ]
    },
    {
      "id": 3,
      "nombre_plan": "Plan Fitness",
      "numero_clases": 16,
      "numero_dias": 60,
      "valor": 280000,
      "precio_final": 252000,
      "descuento": 10,
      "tiene_descuento": true,
      "ahorro": 28000,
      "tipo_plan": "prepago",
      "descripcion_corta": "Plan intermedio con más clases",
      "visible_web": true,
      "orden": 2,
      "sede": {
        "id": 2,
        "nombre_sede": "Sede Sur",
        "direccion": "Carrera 45 #23-11",
        "telefono": "3009876543",
        "persona_cargo": "María López"
      },
      "detalles": [
        {
          "id": 5,
          "plan_id": 3,
          "titulo": "Nutricionista",
          "descripcion": "Consulta mensual con nutricionista",
          "icono": "fas fa-heartbeat",
          "orden": 1,
          "tipo": "premium"
        }
      ]
    }
  ]
}
```

### Response - City Not Found (404)
```json
{
  "success": false,
  "message": "Ciudad no encontrada"
}
```

### Response - No Plans for City (200 OK)
```json
{
  "success": true,
  "ciudad": {
    "id": 1,
    "nombre": "Bogotá",
    "codigo": "BOG"
  },
  "message": "No hay planes disponibles para esta ciudad",
  "data": []
}
```

---

## Error Responses

### Unauthorized (401)
```json
{
  "message": "Unauthenticated."
}
```

### Server Error (500)
```json
{
  "success": false,
  "message": "Error interno del servidor al procesar la solicitud"
}
```

---

## Testing with cURL

### Endpoint 1: Get Client
```bash
curl -X GET "http://localhost/api/cliente/1234567890" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

### Endpoint 2: Verify Plan
```bash
curl -X POST "http://localhost/api/verify-plan" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "documento": "1234567890",
    "fecha_inicio": "2025-01-01",
    "fecha_fin": "2025-12-31"
  }'
```

### Endpoint 3: Get Visible Plans
```bash
curl -X GET "http://localhost/api/planes/visibles" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

### Endpoint 4: Get All Cities
```bash
curl -X GET "http://localhost/api/ciudades" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

### Endpoint 5: Get Plans by City
```bash
curl -X GET "http://localhost/api/ciudades/1/planes" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

---

## Rate Limiting

Todos los endpoints están sujetos a rate limiting. Por defecto Laravel Sanctum aplica:
- 60 requests por minuto para rutas autenticadas

Si excedes el límite recibirás un error 429 (Too Many Requests).

---

## CORS Configuration

Si vas a consumir esta API desde un frontend en otro dominio, asegúrate de configurar CORS en `config/cors.php`.

---

## Notes

1. Todos los endpoints requieren token de autenticación válido
2. Las fechas deben estar en formato ISO 8601 (YYYY-MM-DD)
3. Los valores monetarios están en pesos colombianos (COP)
4. El campo `estado` en per_planes: 1 = activo, 0 = inactivo
5. La detección de solapamiento de fechas funciona con la lógica: (start1 <= end2) AND (end1 >= start2)
