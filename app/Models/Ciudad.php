<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ciudad extends Model
{
    use HasFactory;

    protected $table = 'ciudades';

    protected $fillable = [
        'nombre',
        'codigo',
        'estado',
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];

    /**
     * Get the route key name for Laravel route model binding
     */
    public function getRouteKeyName()
    {
        return 'id';
    }

    /**
     * Relación: Una ciudad tiene muchas sedes
     */
    public function sedes(): HasMany
    {
        return $this->hasMany(Sede::class, 'ciudad_id');
    }

    /**
     * Relación: Una ciudad tiene muchos planes
     */
    public function planes(): HasMany
    {
        return $this->hasMany(Plan::class, 'ciudad_id');
    }

    /**
     * Scope: Ciudades activas
     */
    public function scopeActivas($query)
    {
        return $query->where('estado', 1);
    }
}
