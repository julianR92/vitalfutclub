<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $table = 'planes';

    protected $fillable = [
        'nombre_plan',
        'numero_clases',
        'numero_dias',
        'valor',
        'sede_id'
    ];

    public function sedesx(){
        return $this->belongsTo(Sede::class);
    }
}
