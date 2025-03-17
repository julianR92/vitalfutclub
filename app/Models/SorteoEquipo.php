<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SorteoEquipo extends Model
{
    use HasFactory;
    protected $table = 'sorteo_equipos';
    protected $primaryKey = 'id';

    public function sorteo()
    {
        return $this->belongsTo(Sorteo::class);
    }

    public function jugadores()
    {
        return $this->hasMany(SorteoEquipoJugador::class, 'equipo_id');
    }
}
