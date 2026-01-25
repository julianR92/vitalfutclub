<?php

namespace App\Http\Livewire\Persona;

use Livewire\Component;
use App\Models\Persona;
use App\Models\Plan;
use App\Models\PerPLanes;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;


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
         ->select('per_planes.id as id_perplanes', 'planes.id as id_planes', 'planes.nombre_plan', 'planes.numero_clases', 'planes.numero_clases', 'planes.numero_dias', 'planes.valor','planes.descuento', 'sedes.nombre_sede','per_planes.persona_id', 'per_planes.fecha_inicio', 'per_planes.fecha_fin', 'per_planes.numero_clase', 'per_planes.cantidad_plan', 'per_planes.total_plan', 'per_planes.estado','ingreso.per_plan_id as ingreso',DB::raw('count(ingreso.id) as count_ingreso'))->groupBy('per_planes.id', 'planes.id', 'planes.nombre_plan', 'planes.numero_clases', 'planes.numero_clases', 'planes.numero_dias', 'planes.valor', 'per_planes.persona_id', 'per_planes.fecha_inicio', 'per_planes.fecha_fin', 'per_planes.numero_clase', 'per_planes.cantidad_plan', 'per_planes.total_plan', 'per_planes.estado','ingreso.per_plan_id', 'sedes.nombre_sede')->orderBy('per_planes.id', 'desc')->get()]);
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
        $qrCodeImage = QrCode::format('svg')->size(300)->generate($encodedData);
        $qrCodeDataUri = 'data:image/svg+xml;base64,' . base64_encode($qrCodeImage);
        $pdfHtml = view('factura.qr-code', ['qrCodeDataUri' => $qrCodeDataUri, 'nombres'=>$nombres, 'documento'=>$plan->documento, 'plan'=>$plan])->render();
        $dompdf = \PDF::loadHTML($pdfHtml)->setPaper('a4');
        $dompdf->render();

        // Return the PDF as a downloadable response
        return response()->streamDownload(function () use ($dompdf) {
            echo $dompdf->output();
        }, $plan->documento.'-'.$id.'.pdf');
    }

    /**
     * Calcula los días faltantes para el próximo cumpleaños
     *
     * @return int|null Días faltantes o null si no hay fecha de nacimiento
     */
    public function getDiasFaltantesCumpleanos()
    {
        if (!$this->persona->fecha_nacimiento) {
            return null;
        }

        $fechaNacimiento = Carbon::parse($this->persona->fecha_nacimiento);
        $hoy = Carbon::now()->startOfDay();

        $proximoCumple = $fechaNacimiento->copy()->year($hoy->year)->startOfDay();

        if ($proximoCumple->lt($hoy)) {
            $proximoCumple->addYear();
        }

        return $hoy->diffInDays($proximoCumple);
    }

    /**
     * Verifica si el cumpleaños está cerca (5 días o menos)
     *
     * @return bool
     */
    public function getCumpleaniosCercaProperty()
    {
        $dias = $this->getDiasFaltantesCumpleanos();
        return $dias !== null && $dias >= 0 && $dias <= 5;
    }

    /**
     * Obtiene el mensaje del badge de cumpleaños
     *
     * @return string
     */
    public function getMensajeCumpleanosProperty()
    {
        $dias = $this->getDiasFaltantesCumpleanos();

        if ($dias === null || $dias < 0 || $dias > 5) {
            return '';
        }

        if ($dias == 0) {
            return '¡Hoy cumple años! 🎉';
        } elseif ($dias == 1) {
            return 'Cumple mañana 🎂';
        } else {
            return "{$dias} días 🎈";
        }
    }


}
