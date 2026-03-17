<?php
// app/Models/MedidaSesion.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MedidaSesion extends Model
{
    protected $table = 'medida_sesiones';

    protected $fillable = [
        'user_id',
        'sede_id',
        'fecha',
        'nota',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sede(): BelongsTo
    {
        return $this->belongsTo(Sede::class);
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(MedidaDetalle::class, 'medida_sesion_id')
                    ->orderBy('orden');
    }

    public static function crearConPersonas(int $userId, int $sedeId, string $fecha, array $personasIds): self
    {
        $sesion = static::create([
            'user_id' => $userId,
            'sede_id' => $sedeId,
            'fecha'   => $fecha,
        ]);

        $detalles = collect($personasIds)->map(fn($id, $index) => [
            'medida_sesion_id' => $sesion->id,
            'persona_id'       => $id,
            'orden'            => $index + 1,
            'created_at'       => now(),
            'updated_at'       => now(),
        ])->all();

        MedidaDetalle::insert($detalles);

        return $sesion->load('detalles.persona');
    }
}
