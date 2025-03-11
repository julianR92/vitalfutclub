<?php

namespace App\Http\Livewire\Reportes;

use Livewire\Component;
use App\Models\User;
use App\Models\Sede;
use Illuminate\Support\Facades\DB;

class ReportesSedes extends Component
{

    public $profesores;
    public $sedes = []; // Lista de sedes filtradas
    public $user_id = null; // Categoría seleccionada
    public $sede_id = null; // Sede seleccionada
    public $fecha_inicio = '';
    public $fecha_fin = '';
    public $clases = [];
    public $buscar = false;


    public function mount()
    {
        $this->profesores = User::where('rol', 'profesor')->where('estado',1)->orderBy('name', 'ASC')->get();
        $this->fecha_fin = date('Y-m-d');
        $this->fecha_inicio = date('Y-m-d');
    }

    public function render()
    {
        return view('livewire.reportes.reportes-sedes');
    }
    
    public function updatedUserId($user_id)
    {    
        $this->clases = [];
        $this->buscar = false;
        if ($user_id) {
            $user = User::find($user_id);
            // Cargar las sedes relacionadas con la categoría seleccionada
            $this->sedes = $user->sedes;
        } else {
            // Si no hay categoría seleccionada, reiniciar las sedes
            $this->sedes = [];
        }

        // Reiniciar la selección de sede
        $this->sede_id = '';
    }

    public function generarReporteClases()
    {   
       
        $this->validate([
            'user_id' => 'required',
            'sede_id' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $sql = "SELECT documento,CONCAT(nombres,' ',apellidos) AS cliente,fecha_ingreso,nombre_sede
        FROM ingreso
        INNER JOIN per_planes AS perplan ON ingreso.per_plan_id=perplan.id
        INNER JOIN sedes on perplan.sede_id=sedes.id
        INNER JOIN personas ON perplan.persona_id=personas.id
        WHERE DATE(fecha_ingreso) BETWEEN '{$this->fecha_inicio}' AND '{$this->fecha_fin}'
        AND ingreso.user_id = '{$this->user_id}'
        ORDER BY fecha_ingreso ASC";
        $query = DB::select($sql);
        if(!empty($query)){
            $this->buscar = true;
           $this->clases = $query;
        }else{
            $this->buscar = true;            
            $this->clases = [];
        }

        
    }
    public function limpiar(){
        $this->sedes = []; 
        $this->user_id = null; 
        $this->sede_id = null; 
        $this->fecha_inicio = date('Y-m-d');
        $this->fecha_fin = date('Y-m-d');
        $this->buscar = false;


    }
}
