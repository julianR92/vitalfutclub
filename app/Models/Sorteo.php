<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sorteo extends Model
{
    use HasFactory;
    protected $table = 'sorteo';
    protected $primaryKey = 'id';

    public function equipos()
    {
        return $this->hasMany(SorteoEquipo::class, 'sorteo_id');
    }

    public function jugadores()
    {
        return $this->hasMany(SorteoJugador::class, 'sorteo_id');
    }
    public function sede()
    {
        return $this->belongsTo(Sede::class, 'sede_id');
    }
}
