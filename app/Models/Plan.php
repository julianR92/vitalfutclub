<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Plan extends Model
{
    use HasFactory;

    protected $table="planes";

      protected $fillable = [
        'nombre_plan',
        'numero_clases',
        'numero_dias',
        'valor',
        'sede_id',
        'ciudad_id',
        'descripcion_corta',
        'visible_web',
        'orden',
        'descuento',
        'tipo_plan'
    ];

     protected $casts = [
        'numero_clases' => 'integer',
        'numero_dias' => 'integer',
        'valor' => 'integer',
        'visible_web' => 'boolean',
        'orden' => 'integer',
        'descuento' => 'decimal:2',
    ];

    protected $appends = [
        'precio_final',
        'tiene_descuento',
        'ahorro',
    ];

    public function sede(): BelongsTo
    {
        return $this->belongsTo(Sede::class, 'sede_id');
    }

    public function perPlanes(): HasMany
    {
        return $this->hasMany(PerPlanes::class);
    }


    /**
     * Relación: Un plan pertenece a una ciudad
     */
    public function ciudad(): BelongsTo
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id');
    }

    /**
     * Relación: Un plan tiene muchos detalles
     */
    public function detalles(): HasMany
    {
        return $this->hasMany(PlanDetalle::class, 'plan_id')->orderBy('orden');
    }

      /**
     * Accessor: Precio final con descuento aplicado
     */
    public function getPrecioFinalAttribute()
    {
        if ($this->descuento > 0) {
            $descuentoAplicado = $this->valor * ($this->descuento / 100);
            return $this->valor - $descuentoAplicado;
        }
        return $this->valor;
    }

    /**
     * Accessor: Verifica si tiene descuento activo
     */
    public function getTieneDescuentoAttribute()
    {
        return $this->descuento > 0;
    }

    /**
     * Accessor: Monto ahorrado por descuento
     */
    public function getAhorroAttribute()
    {
        if ($this->descuento > 0) {
            return $this->valor * ($this->descuento / 100);
        }
        return 0;
    }

    /**
     * Scope: Planes visibles en web
     */
    public function scopeVisiblesWeb($query)
    {
        return $query->where('visible_web', 1)->orderBy('orden');
    }

    /**
     * Scope: Planes por ciudad
     */
    public function scopePorCiudad($query, int $ciudadId)
    {
        return $query->where('ciudad_id', $ciudadId);
    }

    /**
     * Get the route key name for Laravel route model binding.
     */
    public function getRouteKeyName()
    {
        return 'id';
    }

}
