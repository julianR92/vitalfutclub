<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TorneoJugador extends Model
{
    use HasFactory;
    protected $table = 'torneo_jugadores';
    protected $primaryKey = 'id';

    public function torneo(){
        return $this->belongsTo(Torneo::class, 'torneo_id');
    }
}
