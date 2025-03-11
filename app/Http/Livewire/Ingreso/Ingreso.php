<?php

namespace App\Http\Livewire\Ingreso;

use Livewire\Component;
use App\Models\Persona;
use App\Models\PerPLanes;
use App\Models\Ingreso as Ingresos;
use Carbon\Carbon;


class Ingreso extends Component
{
    public $numero_documento  = "";
    public $hoy = "";
    public $ocultar_busqueda = "";
    public $ocultar_div = 'hidden';
    public $nombre= "";
    public $plan = "";
    public $fecha_inicio = "";
    public $fecha_final = "";
    public $dias = "";
    public $clases = "";
    public $fecha = "";
    public $per_planes = "";
    public $sede = "";

    public function render()
    {
        
        return view('livewire.ingreso.ingreso');
    }

    /*public function sumar($numero){
        if(strlen($this->numero_documento) >= 12){
            $this->numero_documento = $this->numero_documento;
        }else{
       $this->numero_documento = $this->numero_documento.$numero;
        }
    }*/

    public function mount(){
        date_default_timezone_set("America/Bogota");
        $this->hoy = strftime("%A %d de %B de %Y");	

    }
    
   
    public function borrar(){
        if(strlen($this->numero_documento) == 0){
            $this->numero_documento = "";
        }else{
        $this->numero_documento =substr($this->numero_documento, 0, -1);
        }
      
    }

    public function ingreso(){
        //dd($this->numero_documento);
       if(strlen($this->numero_documento) < 5){
        $this->emit('alert', ['title' => 'Atencion!', 'text' => 'El numero de identificacion no puede ser menor a 5 Digitos','icon'=>'warning']);
        $this->numero_documento = '';
        return;
       }
       $datos = Persona::leftJoin('per_planes', 'per_planes.persona_id', '=', 'personas.id')->leftJoin('planes', 'planes.id', '=', 'per_planes.plan_id')->leftJoin('sedes', 'sedes.id', '=', 'per_planes.sede_id')->where('per_planes.estado',1)->where('personas.documento',$this->numero_documento)->select('per_planes.id as id_perplanes', 'planes.id as id_planes', 'planes.nombre_plan', 'planes.numero_clases', 'planes.numero_clases', 'planes.numero_dias', 'planes.valor', 'per_planes.persona_id', 'per_planes.fecha_inicio', 'per_planes.fecha_fin', 'per_planes.numero_clase', 'per_planes.cantidad_plan', 'per_planes.total_plan','personas.nombres', 'personas.apellidos', 'sedes.nombre_sede', 'sedes.direccion')->get();
       if($datos->count()>0){
       $this->ocultar_busqueda="hidden";
       $this->ocultar_div = "";
       $this->nombre = $datos[0]->nombres.' '.$datos[0]->apellidos;
       $this->plan = $datos[0]->nombre_plan; 
       $this->fecha_final = $datos[0]->fecha_fin;
       $this->fecha_inicio = $datos[0]->fecha_inicio;
       $date = Carbon::parse($this->fecha_final);
       $now = Carbon::now();
       $this->fecha = Carbon::now()->format('Y-m-d H:i:s');
       $this->dias = $date->diffInDays($now);
       $this->clases =$datos[0]->numero_clase - Ingresos::where('per_plan_id', $datos[0]->id_perplanes)->count();      
       $this->per_planes =$datos[0]->id_perplanes;
       $this->sede =$datos[0]->nombre_sede .' | '. $datos[0]->direccion ;
       }else{
        $this->emit('alert', ['title' => 'Atencion!', 'text' => 'El numero de identificacion: '.$this->numero_documento.' no tiene planes activos actualmente','icon'=>'warning']);
        $this->numero_documento = '';
        
       }   
      
    }

    public function ingresoClase(){

        $ingreso = new Ingresos;
        $ingreso->per_plan_id = $this->per_planes;
        $ingreso->fecha_ingreso = Carbon::now()->format('Y-m-d H:i:s');
        $ingreso->user_id = auth()->id();
        $ingreso->save();
        $this->emit('alert', ['title' => 'Proceso exitoso!', 'text' => 'Registro exitoso','icon'=>'success']);
        $this->numero_documento = '';
        $this->redirectRoute('ingreso.index'); 
        
    }

    public function cancelar(){
        $this->ocultar_busqueda="";
        $this->ocultar_div = "hidden";
        $this->numero_documento = '';

    }

}

