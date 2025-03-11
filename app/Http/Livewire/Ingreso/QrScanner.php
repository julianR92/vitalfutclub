<?php

namespace App\Http\Livewire\Ingreso;

use Livewire\Component;
use App\Models\Persona;
use App\Models\PerPLanes;
use App\Models\Ingreso as Ingresos;
use Carbon\Carbon;


class QrScanner extends Component
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
    protected $listeners = ['validateQr' => 'validateQr'];

    public function render()
    {
        return view('livewire.ingreso.qr-scanner');
    }
    
    public function validateQr($documento){
       $datos = Persona::leftJoin('per_planes', 'per_planes.persona_id', '=', 'personas.id')->leftJoin('planes', 'planes.id', '=', 'per_planes.plan_id')->leftJoin('sedes', 'sedes.id', '=', 'per_planes.sede_id')->where('per_planes.estado',1)->where('personas.documento',$documento)->select('per_planes.id as id_perplanes', 'planes.id as id_planes', 'planes.nombre_plan', 'planes.numero_clases', 'planes.numero_clases', 'planes.numero_dias', 'planes.valor', 'per_planes.persona_id', 'per_planes.fecha_inicio', 'per_planes.fecha_fin', 'per_planes.numero_clase', 'per_planes.cantidad_plan', 'per_planes.total_plan','personas.nombres', 'personas.apellidos','sedes.nombre_sede', 'sedes.direccion')->get();
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
       $this->sede =$datos[0]->nombre_sede .' | '. $datos[0]->direccion;
       }else{
        $this->emit('alert', ['title' => 'Atencion!', 'text' => 'El numero de identificacion: '.$documento.' no tiene planes activos actualmente','icon'=>'warning']);
        $this->dispatchBrowserEvent('reset-qr');

       }  
    }
     public function ingresoClaseQr(){

        $ingreso = new Ingresos;
        $ingreso->per_plan_id = $this->per_planes;
        $ingreso->fecha_ingreso = Carbon::now()->format('Y-m-d H:i:s');
        $ingreso->user_id = auth()->id();
        $ingreso->save();
        $this->emit('alert', ['title' => 'Proceso exitoso!', 'text' => 'Registro exitoso','icon'=>'success']);
        $this->numero_documento = '';
        $this->redirectRoute('ingreso.scanner'); 
        
    }
    
     public function cancelar(){
        $this->ocultar_busqueda="";
        $this->ocultar_div = "hidden";
        $this->redirectRoute('ingreso.scanner'); 
        

    }
}
