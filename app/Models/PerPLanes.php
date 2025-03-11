<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Factura;

class PerPLanes extends Model
{
    
    use HasFactory;
    protected $table = 'per_planes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
       'persona_id',
       'plan_id',
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
        return $this->belongsTo(Plan::class);
    }

    public function factura(){
        return $this->hasOne(Factura::class);
    }

    public function ingreso(){
        return $this->hasOne(Ingreso::class);
    }
}
