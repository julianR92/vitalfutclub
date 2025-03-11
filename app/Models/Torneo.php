<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Torneo extends Model
{
    use HasFactory;
    protected $table = 'torneo';
    protected $primaryKey = 'id';

    public function jugadores(){
        return $this->hasMany(TorneoJugador::class, 'torneo_id');
    }
}
