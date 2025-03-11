<?php

namespace App\Http\Livewire\Plan;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.plan.index');
    }

    public function abrirModal()
    {
        $this->emit('abrirModal');
    }
}
