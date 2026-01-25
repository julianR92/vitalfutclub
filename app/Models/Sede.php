<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sede extends Model
{
    use HasFactory;

    protected $table = 'sedes';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre_sede',
        'user_id',
        'direccion',
        'telefono',
        'persona_cargo',
        'ciudad_id',

    ];

    /**
     * Get the route key name for Laravel route model binding
     */
    public function getRouteKeyName()
    {
        return 'id';
    }

      /**
     * Relación: Una sede tiene muchos planes
     */
    public function planes(): HasMany
    {
        return $this->hasMany(Plan::class, 'sede_id');
    }

    //  lo nuevo 30-09-24
    public function users()
    {
        return $this->belongsToMany(User::class, 'sede_user', 'sede_id', 'user_id');
    }

    public function ciudad(): BelongsTo
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id');
    }

    public function perPlanes(): HasMany
    {
        return $this->hasMany(PerPlanes::class, 'sede_id');
    }

     /**
     * Relación: Una sede pertenece a un profesor (usuario)
     */
    public function profesor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Alias de la relación profesor para mayor claridad
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope: Sedes con profesor asignado
     */
    public function scopeConProfesor($query)
    {
        return $query->whereNotNull('user_id');
    }

    /**
     * Scope: Sedes sin profesor asignado
     */
    public function scopeSinProfesor($query)
    {
        return $query->whereNull('user_id');
    }

    /**
     * Scope: Sedes de un profesor específico
     */
    public function scopeDeProfesor($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

     /**
     * Relación: Per planes activos de esta sede
     */
    public function perPlanesActivos(): HasMany
    {
        return $this->hasMany(PerPLanes::class, 'sede_id')
            ->where('estado', PerPLanes::ESTADO_ACTIVO);
    }




    //  lo nuevo 30-09-24
}
