<?php

namespace App\Http\Livewire\Persona;

use Livewire\Component;
use App\Models\Persona;

class Tabla extends Component
{
    protected $listeners = [
        'render',
    ];

    public function render()
    {
        $personas = Persona::select(['personas.*', 'users.estado'])
            ->join('users', 'users.persona_id', '=', 'personas.id')->where('users.rol','cliente')->orderby('personas.id', 'desc')->get();

        return view('livewire.persona.tabla', ['personas' => $personas]);
    }

    public function abrirModal(Persona $personas)
    {
        $this->emitTo('persona.modal', 'abrirModal', $personas);
    }
}
