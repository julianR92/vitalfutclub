<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Persona;

class CongelacionPlanes extends Model
{
    
    use HasFactory;
    protected $table = 'congelacion_planes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
       'persona_id',
       'tipo',
       'fecha_inicio',
       'fecha_fin',
       'dif_dias',
       'observacion',
       'user_id'

    ];

    public function persona(){
        return $this->belongsTo(Persona::class);
    }

}
