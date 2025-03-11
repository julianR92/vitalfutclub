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
        'direccion',
        'telefono',
        'correo',
    ];

    public function users(){
        return $this->hasOne(User::class);
    }
}
