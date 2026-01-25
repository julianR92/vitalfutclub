<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Factura;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PerPLanes extends Model
{
    const ESTADO_ACTIVO = 1;    // Plan activo

    use HasFactory;
    protected $table = 'per_planes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
       'persona_id',
       'plan_id',
       'sede_id',
       'fecha_inicio',
       'fecha_fin',
       'numero_clase',
       'cantidad_plan',
       'total_plan',
       'estado',
       'observacion'

    ];

    public function persona(){
        return $this->belongsTo(Persona::class);
    }

    public function planes(){
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function factura(){
        return $this->hasOne(Factura::class);
    }

    public function ingreso(){
        return $this->hasOne(Ingreso::class);
    }

     public function sede(): BelongsTo
    {
        return $this->belongsTo(Sede::class, 'sede_id');
    }

    public function transacciones(): HasMany
    {
        return $this->hasMany(TransaccionPago::class, 'per_plan_id');
    }

    public function scopeActivos($query)
    {
        return $query->where('estado', 1);
    }

    public function scopeInactivos($query)
    {
        return $query->where('estado', 0);
    }

    public function scopeVencenHoy($query)
    {
        return $query->where('estado', 1)
            ->whereDate('fecha_fin', today());
    }
       /**
     * Scope: Planes vigentes (activos y no vencidos por fecha)
     */
    public function scopeVigentes($query)
    {
        return $query->where('estado', self::ESTADO_ACTIVO)
            ->where('fecha_fin', '>=', today());
    }

    /**
     * Scope: Planes de una sede específica
     */
    public function scopeDeSede($query, int $sedeId)
    {
        return $query->where('sede_id', $sedeId);
    }

      /**
     * Scope: Planes de una persona específica
     */
    public function scopeDePersona($query, int $personaId)
    {
        return $query->where('persona_id', $personaId);
    }

    /**
     * Verificar si el plan está activo
     */
    public function isActivo(): bool
    {
        return $this->estado === self::ESTADO_ACTIVO;
    }

    /**
     * Verificar si el plan está vencido por fecha
     */
    public function isVencidoPorFecha(): bool
    {
        return $this->fecha_fin < today();
    }

    /**
     * Verificar si el plan está vigente (activo y no vencido)
     */
    public function isVigente(): bool
    {
        return $this->isActivo() && !$this->isVencidoPorFecha();
    }

    /**
     * Obtener días restantes del plan
     */
    public function getDiasRestantesAttribute(): int
    {
        if (!$this->isActivo()) {
            return 0;
        }

        $dias = today()->diffInDays($this->fecha_fin, false);
        return $dias > 0 ? $dias : 0;
    }

    /**
     * Obtener clases restantes
     */
    public function getClasesRestantesAttribute(): int
    {
        $plan = $this->plan;
        if (!$plan) {
            return 0;
        }

        $clasesUsadas = $this->numero_clase;
        $clasesTotales = $plan->numero_clases;

        return max(0, $clasesTotales - $clasesUsadas);
    }
}
