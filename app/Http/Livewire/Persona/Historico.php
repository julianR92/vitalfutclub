<?php

namespace App\Http\Livewire\Persona;

use Livewire\Component;
use App\Models\Persona;
use Illuminate\Support\Facades\Auth;
use App\Models\PerPLanes;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Historico extends Component
{
    public Persona $persona;

    public $persona_id='';
    protected $listeners = ['downloadQr' => 'downloadQr'];

            public function mount()
        {
            $this->persona = Persona::find(Auth::user()->persona_id);
        }

        public function render()
        {
            return view('livewire.persona.historico', [
                'personas' => $this->persona,
                'planes' => PerPlanes::join('planes', 'planes.id', '=', 'per_planes.plan_id')
                ->where('per_planes.persona_id',Auth::user()->persona_id)
                ->join('factura','factura.per_plan_id','=','per_planes.id')
                ->leftjoin('ingreso', 'ingreso.per_plan_id', '=', 'per_planes.id')
                ->select('per_planes.id as id_perplanes', 'planes.id as id_planes', 'planes.nombre_plan', 'planes.numero_clases',
                'planes.numero_clases', 'planes.numero_dias', 'planes.valor', 'per_planes.persona_id', 'per_planes.fecha_inicio',
                'per_planes.fecha_fin', 'per_planes.numero_clase', 'per_planes.cantidad_plan', 'per_planes.total_plan', 'per_planes.estado',
                'ingreso.per_plan_id as ingreso',DB::raw('count(ingreso.id) as count_ingreso'),'factura.ruta_factura')
                ->groupBy('per_planes.id','factura.ruta_factura','planes.id','planes.nombre_plan', 'planes.numero_clases',
                'planes.numero_clases', 'planes.numero_dias', 'planes.valor', 'per_planes.persona_id', 'per_planes.fecha_inicio',
                'per_planes.fecha_fin', 'per_planes.numero_clase', 'per_planes.cantidad_plan', 'per_planes.total_plan', 'per_planes.estado','ingreso.per_plan_id')
                ->orderBy('per_planes.id', 'desc')
                ->get()]);
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
