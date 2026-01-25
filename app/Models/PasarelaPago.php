<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PasarelaPago extends Model
{
    use HasFactory;

    protected $table = 'pasarelas_pago';

    protected $fillable = [
        'nombre',
        'codigo',
        'activo',
        'configuracion',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'configuracion' => 'array',
    ];

    public function transacciones(): HasMany
    {
        return $this->hasMany(TransaccionPago::class, 'pasarela_id');
    }

    public function scopeActivas($query)
    {
        return $query->where('activo', 1);
    }
}
