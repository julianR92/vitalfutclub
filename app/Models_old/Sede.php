<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    use HasFactory;

    protected $table = 'sedes';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre_sede',
        'direccion',
        'telefono',
        'persona_cargo',

    ];

    public function planes(){
        return $this->hasOne(Plan::class);
    }
}
