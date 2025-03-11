<?php

namespace App\Http\Livewire\Plan;

use App\Models\Plan;
use Livewire\Component;

class Tabla extends Component
{
    protected $listeners = [
        'render',
    ];

    public function render()
    {
        $planes = Plan::select(['planes.*', 'sedes.nombre_sede'])
            ->join('sedes', 'planes.sede_id', '=', 'sedes.id')->get();
        return view('livewire.plan.tabla', ['planes' => $planes]);
    }

    public function abrirModal(Plan $planes)
    {
        $this->emitTo('plan.modal', 'abrirModal', $planes);
    }
}
