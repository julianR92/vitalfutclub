<?php

namespace App\Http\Livewire\Persona;

use Livewire\Component;
use App\Models\PerPLanes;
use App\Models\User;


class Index extends Component
{

    public function render()
    {
        $usuarios = User::where('rol', 'cliente')->count();
        $planes_activos = PerPLanes::where('estado', 1)->count();
        return view('livewire.persona.index', compact('usuarios','planes_activos'));
    }

    public function abrirModal()
    {
        $this->emit('abrirModal');
    }
}
