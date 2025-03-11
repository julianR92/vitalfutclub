<?php

namespace App\Http\Livewire\Empresa;

use Livewire\Component;
use App\Models\Empresa;

class Index extends Component
{
    protected $listeners = [
        'render',
    ];

    public function render()
    {
        $empresa = Empresa::get();
        return view('livewire.empresa.index', ['empresa' => $empresa[0]]);
    }

    public function abrirModal()
    {
        $this->emit('abrirModal');
    }
}
