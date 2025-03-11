<?php

namespace App\Http\Livewire\PerPlanes;

use Livewire\Component;
use App\Models\Plan;
use App\Models\Persona;
use App\Models\PerPLanes;
use App\Models\Empresa;
use App\Models\Factura;
use App\Models\Sede;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\Notificaciones;
// use Barryvdh\DomPDF\PDF;
use PDF;

class Modal extends Component
{
    public $mostrarModal = 'hidden';
    public $titulo = 'Asignar Plan';
    public $plan_id = '';
    public $fecha_inicio = '';
    public $cantidad_plan = 1;
    public $sede_id='';
    public Persona $persona;

    protected $listeners = [
        'abrirModal',
        
    ];

    protected function rules()
    {
        return [
            'plan_id' => 'required',            
            'fecha_inicio' => 'required|date',
            'cantidad_plan' => 'required|numeric|min:1|max:50',
            'sede_id'=>'required'
            
        ];
    }

    

    public function render()
    {
        return view('livewire.per-planes.modal',['planes' => Plan::all(),'sedes'=>Sede::all()]);
    }

    public function abrirModal(Persona $persona){

        $this->mostrarModal = '';
        $this->persona = $persona;

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
        $plan = Plan::findOrFail($this->plan_id);
        $calculo_dias = $this->cantidad_plan * $plan->numero_dias;
        $calculo_clases = $this->cantidad_plan * $plan->numero_clases;
        $total_plan = $this->cantidad_plan * $plan->valor;
        $fecha_fin = date("Y-m-d", strtotime($this->fecha_inicio . "+".$calculo_dias." day"));

        $planes = new PerPLanes;
        $planes->persona_id = $this->persona->id;
        $planes->plan_id = $this->plan_id;
        $planes->sede_id = $this->sede_id;
        $planes->fecha_inicio = $this->fecha_inicio;
        $planes->fecha_fin = $fecha_fin;
        $planes->numero_clase= $calculo_clases;
        $planes->cantidad_plan = $this->cantidad_plan;
        $planes->total_plan = $total_plan;
        $planes->estado = 1;
        $planes->observacion = 'Asignacion Inicial';
        $planes->save();
        $id = $planes->id;
        
        //generate pdf
        $empresa = Empresa::all();
        $plan_activo = PerPlanes::join('planes', 'planes.id', '=', 'per_planes.plan_id')->join('personas', 'personas.id', '=', 'per_planes.persona_id')->leftJoin('sedes','sedes.id', '=', 'per_planes.sede_id')->where('per_planes.persona_id', $this->persona->id)->where('per_planes.estado', 1)->get();       
        $hoy = date("Y-m-d");	     
        $pdf = PDF::loadView('factura.factura', compact('empresa','plan_activo', 'hoy', 'id'));
        Storage::disk('public')->put('facturas/'.$plan_activo[0]->documento.'/Factura-de-venta-'.$planes->id.'.pdf', $pdf->output());

        //save table factura
        $factura = new Factura;
        $factura->per_plan_id = $id;
        $factura->fecha_factura = $hoy;
        $factura->ruta_factura = 'storage/public/facturas/'.$plan_activo[0]->documento.'/Factura-de-venta-'.$planes->id.'.pdf';
        $factura->save();

        //send Mail
        $detalleCorreo = [
            'nombres' => $plan_activo[0]->nombres . ' ' . $plan_activo[0]->apellidos, 
            'documento'=> $plan_activo[0]->documento, 
            'sede'=> $plan_activo[0]->nombre_sede,    
            'plan'=> $plan_activo[0]->nombre_plan, 
            'Subject' => 'Facturacion VitalFut N°-'.$id,
            'adjunto' => 'SI',           
            'numero_factura'=> $id,
            'mensaje'=>null,

        ];

        $destinatarios = ['sbecerrab_96@hotmail.com', $plan_activo[0]->correo];
        Mail::to($destinatarios)->queue(new Notificaciones($detalleCorreo));

        $this->emit('alert', ['title' => 'Proceso exitoso!', 'text' => 'Plan Asignado Exitosamente','icon'=>'success']);
        $this->cerrarModal();
        $this->redirectRoute('persona.detalle', ['persona'=>$this->persona->id]);  

              
        
    }

    public function updated($campo)
    {
        $this->validateOnly($campo);

    }
}
