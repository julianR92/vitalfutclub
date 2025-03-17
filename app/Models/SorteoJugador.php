<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SorteoJugador extends Model
{
    use HasFactory;
    protected $table = 'sorteo_jugadores';
    protected $primaryKey = 'id';

    public function sorteo()
    {
        return $this->belongsTo(Sorteo::class);
    }

    public function jugador()
    {
        return $this->belongsTo(Persona::class, 'jugador_id');
    }
}
