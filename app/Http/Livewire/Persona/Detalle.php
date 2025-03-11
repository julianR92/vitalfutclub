<?php

namespace App\Http\Livewire\Persona;

use Livewire\Component;
use App\Models\Persona;
use App\Models\Plan;
use App\Models\PerPLanes;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class Detalle extends Component
{
    public Persona $persona;

    public $mostrarModa = 'hidden';
    public $titulo = 'Asignar plan';
    public $persona_id = '';
    public $plan_id = '';
    public $fecha_inicio = '';
    public $fecha_fin = '';
    public $numero_clase = '';
    public $cantidad_plan = 1;
    public $estado = 1;
    public $observacion = '';
    
    protected $listeners = ['downloadQr' => 'downloadQr'];



    protected function rules()
    {
        return [
            'persona_id' => 'required',
            'plan_id' => 'required',
            'fecha_inicio' => 'required',
        ];
    }

    protected $messages = [
        'persona_id.required' => 'Este campo es obligatorio',
        'plan_id.required' => 'Este campo es obligatorio',
        'fecha_inicio.required' => 'Este campo es obligatorio',
    ];

    public function mount(Persona $persona)
    {
        $this->persona = $persona;
    }

    public function render()
    {
        return view('livewire.persona.detalle', ['personas' => $this->persona,
        'planes' => PerPlanes::join('planes', 'planes.id', '=', 'per_planes.plan_id')
         ->where('per_planes.persona_id', $this->persona->id)
         ->leftjoin('ingreso', 'ingreso.per_plan_id', '=', 'per_planes.id')
         ->leftjoin('sedes', 'sedes.id', '=', 'per_planes.sede_id')
         ->select('per_planes.id as id_perplanes', 'planes.id as id_planes', 'planes.nombre_plan', 'planes.numero_clases', 'planes.numero_clases', 'planes.numero_dias', 'planes.valor', 'sedes.nombre_sede','per_planes.persona_id', 'per_planes.fecha_inicio', 'per_planes.fecha_fin', 'per_planes.numero_clase', 'per_planes.cantidad_plan', 'per_planes.total_plan', 'per_planes.estado','ingreso.per_plan_id as ingreso',DB::raw('count(ingreso.id) as count_ingreso'))->groupBy('per_planes.id', 'planes.id', 'planes.nombre_plan', 'planes.numero_clases', 'planes.numero_clases', 'planes.numero_dias', 'planes.valor', 'per_planes.persona_id', 'per_planes.fecha_inicio', 'per_planes.fecha_fin', 'per_planes.numero_clase', 'per_planes.cantidad_plan', 'per_planes.total_plan', 'per_planes.estado','ingreso.per_plan_id', 'sedes.nombre_sede')->orderBy('per_planes.id', 'desc')->get()]);
    }

    public function abrirModal(Persona $personas)
    {
        $this->persona = $personas;
        $this->persona_id = $this->persona->id;
        $planes = Plan::get();
        //actualizar registro
        // $this->tipo_doc = $personas->tipo_doc;
        // $this->documento = $personas->documento;
        // $this->nombres = $personas->nombres;
        // $this->apellidos = $personas->apellidos;
        // $this->direccion = $personas->direccion;
        // $this->telefono = $personas->telefono;
        // $this->correo = $personas->correo;
        // $this->estado = $personas->users->estado;
        $this->mostrarModal = '';
    }
    
    public function downloadQr($id){
        $plan = Perplanes::select('per_planes.id', 'personas.nombres', 'personas.apellidos', 'personas.documento', 'per_planes.fecha_inicio', 'per_planes.fecha_fin')
                ->join('personas', 'personas.id', '=', 'per_planes.persona_id')
                ->where('per_planes.id', $id)->get()->first();
         $data = [
                'documento' => $plan->documento,
                'numero_factura' => $id
            ];
        $nombres = $plan->nombres. ' '. $plan->apellidos;
        $encodedData = json_encode($data);
        $qrCodeImage = QrCode::format('png')->size(300)->generate($encodedData);
        $qrCodeDataUri = 'data:image/png;base64,' . base64_encode($qrCodeImage);
        $pdfHtml = view('factura.qr-code', ['qrCodeDataUri' => $qrCodeDataUri, 'nombres'=>$nombres, 'documento'=>$plan->documento, 'plan'=>$plan])->render();
        $dompdf = \PDF::loadHTML($pdfHtml)->setPaper('a4');
        $dompdf->render();

        // Return the PDF as a downloadable response
        return response()->streamDownload(function () use ($dompdf) {
            echo $dompdf->output();
        }, $plan->documento.'-'.$id.'.pdf');
        
      

    }


}
