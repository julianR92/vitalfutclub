<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SedeUser extends Model
{   

    use HasFactory;
    public $timestamps = true; 
    protected $table = 'sede_user';
    protected $primaryKey = 'id';
}
