<?php

namespace App\Models;

use Faker\Provider\ar_EG\Person;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SorteoEquipoJugador extends Model
{
    use HasFactory;
    protected $table = 'sorteo_equipo_jugador';
    protected $primaryKey = 'id';

    public function equipo()
    {
        return $this->belongsTo(SorteoEquipo::class, 'equipo_id');
    }

    public function jugador()
    {
        return $this->belongsTo(Persona::class, 'jugador_id');
    }
}
