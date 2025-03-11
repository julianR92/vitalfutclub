<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'tipo_doc',
        'documento',
        'nombres',
        'apellidos',
        'fecha_nacimiento',
        'direccion',
        'telefono',
        'correo',
    ];

    public function users(){
        return $this->hasOne(User::class);
    }

    public function perPlanes(){
        return $this->hasMany(PerPlanes::class);
    }

    public function factura(){
        return $this->hasMany(Factura::class);
    }
}
