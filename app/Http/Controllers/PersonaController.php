<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    public function getData()
    {
        $personas = Persona::select(['personas.*', 'users.estado'])
            ->join('users', 'users.persona_id', '=', 'personas.id')
            ->where('users.rol', 'cliente')
            ->orderby('personas.id', 'desc')
            ->get();

        return response()->json(['data' => $personas]);
    }
}
