<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PerPLanes;

class Factura extends Model
{
    use HasFactory;
    protected $table = 'factura';
    protected $primaryKey = 'id';

    public function per_planes(){
        return $this->belongsTo(PerPLanes::class, 'per_plan_id');
    }
}
