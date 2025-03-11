<?php

namespace App\Http\Livewire\Persona;

use Livewire\Component;
use App\Models\Persona;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class Modal extends Component
{
    public $mostrarModal = 'hidden';
    public $titulo = 'Nuevo registro';

    public $tipo_doc = '';
    public $documento = '';
    public $nombres = '';
    public $apellidos = '';
    public $fecha_nacimiento ='';
    public $direccion = '';
    public $telefono = '';
    public $correo = '';
    public $estado = '';

    public Persona $persona;

    protected $listeners = [
        'abrirModal',
        'eliminar'
    ];

    protected function rules()
    {
        return [
            'tipo_doc' => 'required',
            'documento' => ['required', 'max:20', Rule::unique('personas', 'documento')->ignore($this->persona)],
            'nombres' => 'required|max:25',
            'apellidos' => 'required|max:25',
            'fecha_nacimiento'=>'required|date|before:10 years ago',
            'direccion' => 'max:150',
            'telefono' => 'required|max:20',
            'correo' => ['required', 'email', 'max:150', Rule::unique('personas', 'correo')->ignore($this->persona)],
            'estado' => 'required',
        ];
    }

    protected $messages = [
        'tipo_doc.required' => 'Este campo es obligatorio',
        'documento.required' => 'Este campo es obligatorio',
        'documento.max' => 'Este campo supera el número de caracteres',
        'documento.unique' => 'Este registro ya se encuentra almacenado en la base de datos',
        'nombres.required' => 'Este campo es obligatorio',
        'nombres.max' => 'Este campo supera el número de caracteres',
        'apellidos.required' => 'Este campo es obligatorio',
        'apellidos.max' => 'Este campo supera el número de caracteres',
        'telefono.required' => 'Este campo es obligatorio',
        'telefono.max' => 'Este campo supera el número de caracteres',
        'correo.required' => 'Este campo es obligatorio',
        'correo.email' => 'Este no es un correo valido',
        'correo.max' => 'Este campo supera el número de caracteres',
        'correo.unique' => 'Este registro ya se encuentra almacenado en la base de datos',
        'estado.required' => 'Este campo es obligatorio',
        'fecha_nacimiento.before' =>'El campo fecha nacimiento debe ser una fecha anterior a 10 años atras.'

    ];

    public function render()
    {
        return view('livewire.persona.modal');
    }

    public function mount(Persona $personas)
    {
        $this->persona = $personas;
    }

    public function abrirModal(Persona $personas)
    {
        if ($personas->exists) {
            $this->persona = $personas;
            //actualizar registro
            $this->tipo_doc = $personas->tipo_doc;
            $this->documento = $personas->documento;
            $this->nombres = $personas->nombres;
            $this->apellidos = $personas->apellidos;
            $this->fecha_nacimiento = $personas->fecha_nacimiento;
            $this->direccion = $personas->direccion;
            $this->telefono = $personas->telefono;
            $this->correo = $personas->correo;
            $this->estado = $personas->users->estado;
            $this->titulo = "Actualizar registro";
        } else {
            //nuevo registro
            $this->persona = new Persona;
            $this->estado = 1;
            $this->titulo = "Nuevo registro";
        }
        $this->mostrarModal = '';
    }

    public function cerrarModal()
    {
        $this->resetExcept('persona');
        $this->resetErrorBag();
        $this->resetValidation();
        $this->mostrarModal = 'hidden';
    }

    public function guardar()
    {
        $valores = $this->validate();
        $this->persona->fill($valores);
        if ($this->persona->exists) {
            $this->persona->save();
            $this->persona->users()->update(['name' => $this->persona->nombres, 'email' => $this->persona->correo, 'estado' => $this->estado]);
        } else {
            $this->persona->save();
            $this->persona->users()->create([
                'persona_id' => $this->persona->id,
                'name' => $this->persona->nombres,
                'email' => $this->persona->correo,
                'estado' => $this->estado,
                'rol' => 'cliente',
                'password' => Hash::make($this->persona->documento),
            ]);
        }

        $this->emit('alert', ['title' => 'Proceso exitoso!', 'text' => 'Usuario guardado correctamente','icon'=>'success']);
        $this->cerrarModal();
        // $this->emitTo('persona.tabla', 'render');
        $this->redirectRoute('persona.index');
    }

    public function eliminar(Persona $personas)
    {
        $personas->users()->delete();
        $personas->delete();
        // $this->emitTo('persona.tabla', 'render');
        $this->redirectRoute('persona.index');
    }

    public function updated($campo)
    {
        $this->validateOnly($campo);
    }
}
