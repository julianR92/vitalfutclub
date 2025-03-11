<?php

namespace App\Http\Livewire\Reportes;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\PerPLanes;
use App\Models\Empresa;
use App\Models\Factura;
use App\Models\Sede;
use App\Models\Plan;
use App\Models\Persona;

class Index extends Component
{
   public $fecha_inicio = '';
   public $fecha_fin = '';
   public $reporte_planes = '';
   public $reporte_clases = '';
   public $reporte_planes2 = '';
   public $hidden='hidden';
   public $reporte='nada';
   public $buscar=false;

   protected function rules()
   {
      return [
         'fecha_inicio' => ['required'],
         'fecha_fin' => ['required', 'after_or_equal:' . $this->fecha_inicio],
      ];
   }

   protected $messages = [
      'fecha_inicio.required' => 'Este campo es obligatorio',
      'fecha_fin.required' => 'Este campo es obligatorio',
      'fecha_fin.after_or_equal' => 'La fecha fin no puede superar la fecha de inicio',
   ];

   public function updated($campo)
   {
      $this->buscar=false;
      $this->validateOnly($campo);
   }

   public function render()
   {
      $planes_sedes = PerPLanes::select('sedes.nombre_sede',DB::raw('count(per_planes.id) as numero_planes'))
      ->leftJoin('sedes', 'sedes.id', '=', 'per_planes.sede_id')
      ->where('per_planes.estado',1)
      ->groupBy('sedes.nombre_sede')
      ->get();
       

      return view('livewire.reportes.index',compact('planes_sedes'));
   }

   public function generarReportePlanes()
   {
      $this->buscar=true;
      $valores = $this->validate();

      $sql = "SELECT CONCAT(nombres,' ' ,apellidos) AS cliente,fecha_inicio,nombre_plan,total_plan,per_planes.created_at FROM per_planes
        INNER JOIN personas ON per_planes.`persona_id`=personas.`id`
        INNER JOIN planes ON per_planes.`plan_id`=planes.id
        WHERE DATE(per_planes.created_at) BETWEEN '{$this->fecha_inicio}' AND '{$this->fecha_fin}' ORDER BY per_planes.created_at DESC";
      $query = DB::select($sql);

      $this->reporte_planes = $query;
      $this->reporte_planes2='';
      $this->reporte_clases='';
      $this->reporte='reporte_planes';
      $this->hidden='';
      return $this->reporte_planes;
   }

   public function generarReporteClases()
   {
      $this->buscar=true;
      $valores = $this->validate();

      $sql = "SELECT documento,CONCAT(nombres,' ',apellidos) AS cliente,fecha_ingreso
      FROM ingreso
      INNER JOIN per_planes AS perplan ON ingreso.per_plan_id=perplan.id
      INNER JOIN personas ON perplan.persona_id=personas.id
      WHERE DATE(fecha_ingreso) BETWEEN '{$this->fecha_inicio}' AND '{$this->fecha_fin}'
      ORDER BY fecha_ingreso ASC";
      $query = DB::select($sql);
      $this->reporte_planes='';
      $this->reporte_planes2='';
      $this->hidden='';
      $this->reporte='reporte_clases';
      $this->reporte_clases = $query;
      return $this->reporte_clases;
   }
   
   public function generarReportePlanes2()
   {
      $this->buscar=true;
      $valores = $this->validate();

      $sql = "SELECT documento,nombres,apellidos,fecha_inicio,total_plan,sedes.nombre_sede,per_planes.created_at FROM per_planes
        INNER JOIN personas ON per_planes.`persona_id`=personas.`id`
        INNER JOIN planes ON per_planes.`plan_id`=planes.id
        INNER JOIN sedes on planes.sede_id=sedes.id
        WHERE DATE(per_planes.created_at) BETWEEN '{$this->fecha_inicio}' AND '{$this->fecha_fin}' ORDER BY per_planes.created_at DESC";
      $query = DB::select($sql);

      $this->reporte_planes2 = $query;
      $this->reporte_clases='';
      $this->reporte_planes = '';
      $this->reporte='reporte_planes2';
      $this->hidden='';
      return $this->reporte_planes2;
   }

   /*
        SELECT CONCAT(nombres,' ' ,apellidos) AS cliente,fecha_inicio,nombre_plan,total_plan,per_planes.created_at FROM per_planes
        INNER JOIN personas ON per_planes.`persona_id`=personas.`id`
        INNER JOIN planes ON per_planes.`plan_id`=planes.id
        WHERE DATE(per_planes.created_at) BETWEEN '2022-03-22' AND '2022-03-22'

    */
}
