<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaccionPago extends Model
{
    use HasFactory;

    protected $table = 'transacciones_pago';

    protected $fillable = [
        'referencia',
        'per_plan_id',
        'pasarela_id',
        'persona_id',
        'monto',
        'moneda',
        'estado',
        'tipo_transaccion',
        'metodo_pago',
        'request_data',
        'response_data',
        'referencia_externa',
        'fecha_aprobacion',
        'ip_address',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'request_data' => 'array',
        'response_data' => 'array',
        'fecha_aprobacion' => 'datetime',
    ];

    // Constantes para estados
    const ESTADO_PENDIENTE = 'pendiente';
    const ESTADO_APROBADO = 'aprobado';
    const ESTADO_RECHAZADO = 'rechazado';
    const ESTADO_CANCELADO = 'cancelado';
    const ESTADO_REEMBOLSADO = 'reembolsado';

    // Constantes para tipos
    const TIPO_COMPRA = 'compra';
    const TIPO_AUTORIZACION = 'autorizacion';
    const TIPO_REEMBOLSO = 'reembolso';
    const TIPO_ANULACION = 'anulacion';

    public function perPlan(): BelongsTo
    {
        return $this->belongsTo(PerPLanes::class, 'per_plan_id');
    }

    public function pasarela(): BelongsTo
    {
        return $this->belongsTo(PasarelaPago::class, 'pasarela_id');
    }

    public function persona(): BelongsTo
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    public function scopeAprobadas($query)
    {
        return $query->where('estado', self::ESTADO_APROBADO);
    }

    public function scopePendientes($query)
    {
        return $query->where('estado', self::ESTADO_PENDIENTE);
    }

    public function scopeEntreFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('created_at', [$fechaInicio, $fechaFin]);
    }

    /**
     * Verifica si la transacción está aprobada
     */
    public function isAprobada(): bool
    {
        return $this->estado === self::ESTADO_APROBADO;
    }

    /**
     * Verifica si la transacción está pendiente
     */
    public function isPendiente(): bool
    {
        return $this->estado === self::ESTADO_PENDIENTE;
    }
}
