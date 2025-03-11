<?php

namespace App\Http\Livewire\Sede;

use Livewire\Component;
use App\Models\Sede;



class Tabla extends Component
{

    protected $listeners = [
        'render',
        'limpiarFiltros'    
    ];
   

    public function render()
    {
        $sedes = Sede::all();
        return view('livewire.sede.tabla', ['sedes' => $sedes]);
    }

    public function abrirModal(Sede $sedes)
    {
        $this->emitTo('sede.modal','abrirModal', $sedes);
    }

    public function limpiarFiltros()
    {
        //metodo livewire que resetea las variables publicas
        $this->reset();
    }

}
