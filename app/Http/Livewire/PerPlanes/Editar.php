<?php

namespace App\Http\Livewire\PerPlanes;

use Livewire\Component;
use App\Models\PerPLanes;
use App\Models\Ingreso;
use App\Models\Factura;

class Editar extends Component
{   
    public $titulo = 'Editar Plan';
    public $mostrarModal = 'hidden';
    public PerPLanes $perplanes;
    public $fecha_fin = '';
    public $numero_clase = '';
    public $observacion = '';

    protected $listeners = [
        'abrirModal', 
        'eliminar'       
    ];

    protected function rules()
    {
        return [
            'fecha_fin' => 'required|date|after:'.$this->perplanes->fecha_fin.'',           
            'numero_clase' => 'required|numeric|min:'.$this->perplanes->numero_clase.'',
            'observacion'=>'required'
            
        ];
    }

    
    public function updated($campo)
    {
        $this->validateOnly($campo);

    }

    public function render()
    {
        return view('livewire.per-planes.editar');
    }

    public function abrirModal(PerPLanes $perplanes){
      
         $this->mostrarModal = '';
         $this->perplanes = $perplanes;
         $this->fecha_fin = $this->perplanes->fecha_fin;
         $this->numero_clase = $this->perplanes->numero_clase;

    }

    public function cerrarModal()
    {           
        
        $this->resetExcept('perplanes');
        $this->resetErrorBag();
        $this->resetValidation();
        $this->mostrarModal = 'hidden';
    }

    public function actualizar()
    {
      $perplanes = PerPLanes::findOrFail($this->perplanes->id);
      $perplanes->fecha_fin =  $this->fecha_fin;
      $perplanes->numero_clase = $this->numero_clase;
      $perplanes->observacion =$this->observacion;
      $perplanes->save();
      $this->emit('alert', ['title' => 'Proceso exitoso!', 'text' => 'Plan Actalizado Exitosamente','icon'=>'success']);
      $this->cerrarModal();
      $this->redirectRoute('persona.detalle', ['persona'=>$this->perplanes->persona_id]);  

        
    }

    public function eliminar($id)
    {   
      
         $factura = Factura::where('per_plan_id', $id)->delete();         
         $ingreso = Ingreso::where('per_plan_id',$id)->delete();
         $perplanes = PerPLanes::findOrFail($id);
         $persona = $perplanes->persona_id;
         $perplanes->delete();
        
         $this->redirectRoute('persona.detalle', ['persona'=>$persona]);  

       
    }


}
