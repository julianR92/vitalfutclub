<?php

namespace App\Http\Livewire\Sede;

use Livewire\Component;


class Sede extends Component
{
    public function render()
    {
        return view('livewire.sede.sede');
    }

    public function abrirModal()
    {
        $this->emit('abrirModal');
    }
}
