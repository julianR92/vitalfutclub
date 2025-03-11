<?php

namespace App\Http\Livewire\Plan;

use App\Models\Plan;
use App\Models\Sede;
use Livewire\Component;

class Modal extends Component
{
    public $mostrarModal = 'hidden';
    public $titulo = 'Nuevo registro';

    public $nombre_plan='';
    public $numero_clases='';
    public $numero_dias='';
    public $valor='';
    public $sede_id='';

    public Plan $plan;

    protected $listeners = [
        'abrirModal',
        'eliminar'
    ];

    protected function rules()
    {
        return [
            'nombre_plan' => 'required|max:100',
            'numero_clases' => 'required|numeric',
            'numero_dias' => 'required|numeric',
            'valor' => 'required|numeric',
            'sede_id' => 'required',
        ];
    }

    protected $messages = [
        'nombre_plan.required' => 'Este campo es obligatorio',
        'nombre_plan.max' => 'Este campo supera el número de caracteres',
        'numero_clases.required' => 'Este campo es obligatorio',
        'numero_dias.required' => 'Este campo es obligatorio',
        'valor.required' => 'Este campo es obligatorio',
        'sede_id.required' => 'Este campo es obligatorio',
    ];

    public function mount(Plan $planes)
    {
        $this->plan = $planes;
    }

    public function render()
    {
        return view('livewire.plan.modal',[
            'sedes'=>Sede::pluck('nombre_sede','id')
        ]);
    }

    public function abrirModal(Plan $planes)
    {
        if ($planes->exists) {
            $this->plan = $planes;
            //actualizar registro
            $this->nombre_plan = $planes->nombre_plan;
            $this->numero_clases = $planes->numero_clases;
            $this->numero_dias = $planes->numero_dias;
            $this->valor = $planes->valor;
            $this->sede_id = $planes->sede_id;
            $this->titulo = "Actualizar registro";
        } else {
            //nuevo registro
            $this->plan = new Plan;
            $this->titulo = "Nuevo registro";
        }
        $this->mostrarModal = '';
    }

    public function cerrarModal()
    {
        $this->resetExcept('plan');
        $this->resetErrorBag();
        $this->resetValidation();
        $this->mostrarModal = 'hidden';
    }

    public function guardar()
    {
        $valores = $this->validate();
        $this->plan->fill($valores);
        $this->plan->save();

        $this->emit('alert', ['title' => 'Proceso exitoso!', 'text' => 'Plan guardado correctamente','icon'=>'success']);
        $this->cerrarModal();
        $this->emitTo('plan.tabla', 'render');
    }

    public function eliminar(Plan $planes)
    {
        $planes->delete();
        $this->emitTo('plan.tabla', 'render');
    }

    public function updated($campo)
    {
        $this->validateOnly($campo);
    }
}
