<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PerPLanes;
use App\Models\Ingreso as Registro;
use App\Models\Persona as Usuarios;
use App\Models\Plan as Planes;
use Illuminate\Support\Facades\Mail;
use App\Mail\Notificaciones;
use Carbon\Carbon;

class Revision extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'control:diario';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando se ejecuta para realizar la revision diaria de los planes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $perplanes = Perplanes::where('estado',1)->get();
            if($perplanes->count()>0){
            foreach ($perplanes as $perplan){
                $plan =Planes::findOrFail($perplan->plan_id);
                $persona = Usuarios::findOrFail($perplan->persona_id);            
                $count = Registro::where('per_plan_id',$perplan->id)->count(); 
                $resta = $perplan->numero_clase - $count; 
              
                if($perplan->fecha_fin == date('Y-m-d')){
                  
                    $detalleCorreo = [
                        'nombres' => $persona->nombres . ' ' . $persona->apellidos, 
                        'documento'=> $persona->documento,          
                        'Subject' => 'Notificacion VitaLFut',
                        'adjunto' => 'NO',           
                        'numero_factura'=> null,
                        'mensaje'=> $persona->nombres. ' Te recordamos que tienes el plan: '.strtoupper($plan->nombre_plan).' activo hasta el dia de '.$perplan->fecha_fin.' (hoy)  recomendamos actualizar tu plan para que sigas entrenando con nosotros',
            
                    ];
                    $destinatarios = ['sbecerrab_96@hotmail.com', $persona->correo];
                    Mail::to($destinatarios)->queue(new Notificaciones($detalleCorreo));

                }

                if($resta == 1){

                    $detalleCorreo = [
                        'nombres' => $persona->nombres . ' ' . $persona->apellidos, 
                        'documento'=> $persona->documento,          
                        'Subject' => 'Notificacion VitaLFut',
                        'adjunto' => 'NO',           
                        'numero_factura'=> null,
                        'mensaje'=> $persona->nombres. ' Te recordamos que tienes el plan: '.strtoupper($plan->nombre_plan).' en el cual ya has asistido ha : '.strtoupper($count).' clases de las '.strtoupper($perplan->numero_clase). ' que tenias disponibles, recomendamos actualizar tu plan para que sigas entrenando con nosotros',
            
                    ];
                    $destinatarios = ['sbecerrab_96@hotmail.com', $persona->correo];
                    Mail::to($destinatarios)->queue(new Notificaciones($detalleCorreo));

                }

                if(date('Y-m-d') > $perplan->fecha_fin){
                    $updatePer= Perplanes::FindOrFail($perplan->id);
                    $updatePer->estado = 0;
                    $updatePer->save();
                  
                }

                if($resta <= 0){
                    $updatePer= Perplanes::FindOrFail($perplan->id);
                    $updatePer->estado = 0;
                    $updatePer->save();

                }

            }
          }

           //   FUNCION DE CUMPLEAÑOS
        $hoy = date('d-m');
        $festejo = [];
        $clientes = Usuarios::all();
        foreach ($clientes as $cliente) {
            if ($cliente->fecha_nacimiento) {
                $fecha_format = Carbon::parse($cliente->fecha_nacimiento)->format('d-m');
                if ($hoy == $fecha_format) {
                    $edad = Carbon::parse($cliente->fecha_nacimiento)->age;
                    $festejo[] = [
                        'nombres' => $cliente->nombres . ' ' . $cliente->apellidos,
                        'edad' => $edad
                    ];
                }
            }
        }
        if ($festejo) {
            $detalleCorreo = [
                'nombres' => $festejo,
                'documento' => null,
                'Subject' => 'Cumpleaños VitaLFut',
                'adjunto' => 'NO',
                'numero_factura' => null,
                'mensaje' =>'BIRTHDAY',

            ];
            $destinatarios = ['sbecerrab_96@hotmail.com'];
            Mail::to($destinatarios)->queue(new Notificaciones($detalleCorreo));
            
        }


    }
}
