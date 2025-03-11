<?php

namespace App\Http\Livewire\Sede;

use Livewire\Component;
use App\Models\Sede;
use Illuminate\Validation\Rule;

class Modal extends Component
{
    public $mostrarModal = 'hidden';
    public $titulo = 'Nuevo registro';

    public $nombre_sede = '';
    public $direccion = '';
    public $telefono = '';
    public $persona_cargo = '';

    public Sede $sede;

    protected $listeners = [
        'abrirModal',
        'eliminar'
    ];

    protected function rules()
    {
        return [
            'nombre_sede'=> ['required', 'min:5',Rule::unique('sedes', 'nombre_sede')->ignore($this->sede)],
            'direccion' => ['required', 'max:100' ,'regex:/^[a-zA-Z0-9_\-.# ]*$/'],
            'telefono' => ['required', 'max:10' ,'min:7'],
             'persona_cargo'=>['required', 'regex:/^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ ]*$/', 'max:40']
        ];
    }

    public function render()
    {
        return view('livewire.sede.modal');
    }

    public function mount(Sede $sedes)
    {
        $this->sede = $sedes;
    }

    public function abrirModal(Sede $sedes)
    {
        if ($sedes->exists) {
            $this->sede = $sedes;
            //actualizar registro
            $this->nombre_sede = $sedes->nombre_sede;
            $this->direccion = $sedes->direccion;
            $this->telefono = $sedes->telefono;
            $this->persona_cargo = $sedes->persona_cargo;
            $this->titulo = "Actualizar registro";
        } else {
            //nuevo registro
            $this->sede = new Sede;
            $this->titulo = "Nuevo registro";
        }
        $this->mostrarModal = '';
    }

    public function cerrarModalSede()
    {
        $this->resetExcept('sede');
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emitTo('sede.tabla', 'limpiarFiltros');
        $this->mostrarModal = 'hidden';
    }


    public function guardar()
    {
        $valores = $this->validate();
        $this->sede->fill($valores);
        if ($this->sede->exists) {
        $this->sede->update(['nombre_sede' => $this->sede->nombre_sede,
                             'direccion' => $this->sede->direccion,
                             'telefono' => $this->sede->telefono,
                             'persona_cargo' => $this->sede->persona_cargo,

                            ]);
        } else {

            $this->sede->create([
                'nombre_sede' => $this->sede->nombre_sede,
                'direccion' => $this->sede->direccion,
                'telefono' => $this->sede->telefono,
                'persona_cargo' => $this->sede->persona_cargo,
            ]);
        }

        $this->emit('alert', ['title' => 'Proceso exitoso!', 'text' => 'Usuario guardado correctamente','icon'=>'success']);
        $this->cerrarModalSede();
        $this->emitTo('sede.tabla', 'render');
        $this->redirectRoute('sedes.index');
    }

    public function eliminar(Sede $sede)
    {
       $sede->delete();
       $this->emitTo('sede.tabla', 'render');
       $this->redirectRoute('sedes.index');
    }

    public function updated($campo)
    {
        $this->validateOnly($campo);
    }
}
