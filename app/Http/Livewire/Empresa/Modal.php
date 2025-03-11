<?php

namespace App\Http\Livewire\Empresa;

use Livewire\Component;
use App\Models\Empresa;

class Modal extends Component
{
    public $mostrarModal = 'hidden';
    public $titulo = 'Actualizar registro';

    public $nit='';
    public $razon_social='';
    public $direccion='';
    public $representante='';
    public $telefono='';
    public $correo='';

    public Empresa $empresa;

    protected $listeners = [
        'abrirModal',
    ];

    protected function rules()
    {
        return [
            'nit' => 'required|max:20',
            'razon_social' => 'required|max:100',
            'direccion' => 'required|max:150',
            'representante' => 'required|max:50',
            'telefono' => 'required|max:50',
            'correo' => 'required|max:150',
        ];
    }

    protected $messages = [
        'nit.required' => 'Este campo es obligatorio',
        'razon_social.required' => 'Este campo es obligatorio',
        'direccion.required' => 'Este campo es obligatorio',
        'telefono.required' => 'Este campo es obligatorio',
        'representante.required' => 'Este campo es obligatorio',
        'correo.required' => 'Este campo es obligatorio',

        'nit.max' => 'Este campo supera el número de caracteres',
        'razon_social.max' => 'Este campo supera el número de caracteres',
        'direccion.max' => 'Este campo supera el número de caracteres',
        'telefono.max' => 'Este campo supera el número de caracteres',
        'representante.max' => 'Este campo supera el número de caracteres',
        'correo.max' => 'Este campo supera el número de caracteres',
    ];


    public function render()
    {
        return view('livewire.empresa.modal');
    }

    public function abrirModal(Empresa $empresa)
    {
        if ($empresa->exists) {
            $this->empresa = $empresa;
            //actualizar registro
            $this->nit = $empresa->nit;
            $this->razon_social = $empresa->razon_social;
            $this->direccion = $empresa->direccion;
            $this->telefono = $empresa->telefono;
            $this->representante = $empresa->representante;
            $this->correo = $empresa->correo;
            $this->titulo = "Actualizar registro";
        }
        $this->mostrarModal = '';
    }

    public function cerrarModal()
    {
        $this->resetExcept('empresa');
        $this->resetErrorBag();
        $this->resetValidation();
        $this->mostrarModal = 'hidden';
    }

    public function guardar()
    {
        $valores = $this->validate();
        $this->empresa->fill($valores);
        $this->empresa->save();

        $this->emit('alert', ['title' => 'Proceso exitoso!', 'text' => 'Empresa guardada correctamente','icon'=>'success']);
        $this->cerrarModal();
        $this->emitTo('empresa.index', 'render');
    }

    public function updated($campo)
    {
        $this->validateOnly($campo);
    }
}
