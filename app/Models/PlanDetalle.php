<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanDetalle extends Model
{
    use HasFactory;

    protected $table = 'planes_detalles';

    protected $fillable = [
        'plan_id',
        'titulo',
        'descripcion',
        'icono',
        'orden',
        'tipo',
    ];

    protected $casts = [
        'orden' => 'integer',
    ];

    /**
     * Relación: Un detalle pertenece a un plan
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    /**
     * Scope: Ordenar por campo orden
     */
    public function scopeOrdenado($query)
    {
        return $query->orderBy('orden');
    }

    /**
     * Scope: Filtrar por tipo
     */
    public function scopePorTipo($query, string $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    /**
     * Get the route key name for Laravel route model binding.
     */
    public function getRouteKeyName()
    {
        return 'id';
    }
}
