<?php
// app/Models/MedidaDetalle.php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedidaDetalle extends Model
{
    protected $table = 'medida_detalles';

    protected $fillable = [
        'medida_sesion_id',
        'persona_id',
        'altura_cm',
        'peso_kg',
        'circunferencia_brazo',
        'circunferencia_cintura',
        'circunferencia_muslo',
        'porcentaje_grasa',
        'porcentaje_musculo',
        'grasa_visceral',
        'imc',
        'metabolismo_basal',
        'edad_al_momento',
        'sentadillas',
        'abdominales',
        'flexiones',
        'elasticidad',
        'test_resistencia',
        'orden',
        'completado',
        'status',
        'notas',
    ];

    protected $casts = [
        'completado'         => 'boolean',
        'altura_cm'          => 'decimal:2',
        'peso_kg'            => 'decimal:2',
        'imc'                => 'decimal:2',
        'porcentaje_grasa'   => 'decimal:2',
        'porcentaje_musculo' => 'decimal:2',
         'sentadillas'        => 'integer',
        'abdominales'        => 'integer',
        'flexiones'          => 'integer',
        'elasticidad'        => 'decimal:1',
        'test_resistencia'   => 'decimal:1',
        'status'             => 'boolean',

    ];

    // ─── Relaciones ────────────────────────────────────────────────────

    public function sesion(): BelongsTo
    {
        return $this->belongsTo(MedidaSesion::class, 'medida_sesion_id');
    }

    public function persona(): BelongsTo
    {
        return $this->belongsTo(Persona::class);
    }

    // ─── Hook saving ───────────────────────────────────────────────────

    protected static function booted(): void
    {
        static::saving(function (MedidaDetalle $detalle) {
            // Fórmulas desactivadas — los campos imc, metabolismo_basal y edad_al_momento
            // se ingresan manualmente desde la vista de edición.
            // if ($detalle->isDirty(['peso_kg', 'altura_cm', 'persona_id', 'medida_sesion_id'])) {
            //     $detalle->recalcularCampos();
            // }
        });
    }

    // ─── Cálculos ──────────────────────────────────────────────────────

    public function recalcularCampos(): void
    {
        $this->edad_al_momento   = $this->calcularEdad();
        $this->imc               = $this->calcularImc();
        $this->metabolismo_basal = $this->calcularTmb();
    }

    private function calcularEdad(): ?int
    {
        $persona = $this->relationLoaded('persona')
            ? $this->persona
            : Persona::find($this->persona_id);

        if (!$persona || empty($persona->fecha_nacimiento)) {
            return null;
        }

        $sesion = $this->relationLoaded('sesion')
            ? $this->sesion
            : MedidaSesion::find($this->medida_sesion_id);

        $fechaReferencia = $sesion && $sesion->fecha ? $sesion->fecha : now();

        return Carbon::parse($persona->fecha_nacimiento)
            ->diffInYears($fechaReferencia);
    }

    private function calcularImc(): ?float
    {
        if (!$this->peso_kg || !$this->altura_cm || $this->altura_cm <= 0) {
            return null;
        }

        $alturaMetros = $this->altura_cm / 100;

        return round($this->peso_kg / ($alturaMetros ** 2), 2);
    }

    private function calcularTmb(): ?int
    {
        if (!$this->peso_kg || !$this->altura_cm || !$this->edad_al_momento) {
            return null;
        }

        $tmb = 88.362
            + (13.397 * $this->peso_kg)
            + (4.799  * $this->altura_cm)
            - (5.677  * $this->edad_al_momento);

        return (int) round($tmb);
    }
}
