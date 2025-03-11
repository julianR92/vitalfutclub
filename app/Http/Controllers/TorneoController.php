<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Torneo;
use App\Models\TorneoJugador;
use App\Models\Persona;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\Notificaciones;
use Exception;
use Illuminate\Validation\Rule;

class TorneoController extends Controller
{
    public function index()
    {
        return view('livewire/torneo.index');
    }

    public function getData()
    {

        $torneos = Torneo::where('status', 1)
            ->get();
        return response()->json(['data' => $torneos]);
    }

    public function addTorneo()
    {
        return view('livewire/torneo.add');
    }
    public function getDataClientes()
    {
        $personas = Persona::join('users', 'users.persona_id', '=', 'personas.id')
            ->select('personas.id', 'personas.nombres', 'personas.apellidos', 'personas.documento')
            ->where('users.rol', 'cliente')
            ->where('users.estado', 1)
            ->orderBy('personas.apellidos', 'ASC')
            ->orderBy('personas.nombres', 'ASC')
            ->get();

        return response()->json(['data' => $personas]);
    }

    public function store(Request $request)
    {
        $jugadores = json_decode($request->input('jugadores'), true);

        $validator = Validator::make($request->all(), [
            'año' => 'required',
            'numero' => [
                'required',
                Rule::unique('torneo', 'numero')->where(function ($query) use ($request) {
                    return $query->where('ciudad', $request->ciudad)->where('año', $request->año)->where('status', 1);
                }),
            ],

        ], ['numero.unique' => 'Ya existe un torneo con el mismo numero en la misma ciudad en el mismo año actualmente activo']);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        }
        if (!is_array($jugadores) || count($jugadores) < 10) {
            return  response()->json(['success' => false, 'errors' => ['Debes seleccionar como minimo 10 jugadores']]);
        }

        DB::beginTransaction();

        try {

            $torneo_id =  DB::table('torneo')->insertGetId([
                'nombre' => 'Torneo VitalFut',
                'ciudad' => $request->ciudad,
                'año' => $request->año,
                'ciudad' => $request->ciudad,
                'numero' => $request->numero,
                'status' => 1,                
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),


            ]);
            $contador = 0;
            foreach($jugadores as $jugadorId){
                DB::table('torneo_jugadores')->insert([
                    'torneo_id' => $torneo_id,
                    'jugador_id' => $jugadorId,
                    'status' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                $contador++;

            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Torneo Creado Exitosamente', 'addMessage' => "$contador Jugadores al torneo"]);
            // all good
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return response()->json(['success' => false, 'errors' => [$e->getMessage()]]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'errors' => [$e->getMessage()]]);
        }
    }

    public function torneoData($id)
    {   
        $datos =  $this->getDataClientes()->getData(true);       
        $personas = $datos['data'];
        $torneo = Torneo::findOrFail($id);
        return view('livewire/torneo.torneo', compact('personas', 'torneo'));
    }
    public function loadDataActiveTorneo($id)
    {   
        $dataActive = $dataActive = TorneoJugador::select(
            'personas.nombres',
            'personas.apellidos',
            'personas.documento',
            'per_planes.fecha_fin',   // Puede ser null si no hay plan activo
            'planes.nombre_plan',      // Puede ser null si no hay plan activo
            'torneo_jugadores.torneo_id',
            'torneo_jugadores.id'
        )
        ->leftJoin('personas', 'personas.id', '=', 'torneo_jugadores.jugador_id')
        ->leftJoin('per_planes', function($join) {
            $join->on('per_planes.persona_id', '=', 'torneo_jugadores.jugador_id')
                 ->where('per_planes.estado', 1); // Solo trae los planes activos
        })
        ->leftJoin('planes', 'planes.id', '=', 'per_planes.plan_id')
        ->where('torneo_jugadores.torneo_id', $id)
        ->where('torneo_jugadores.status', 1)
        ->orderBy('per_planes.fecha_fin', 'ASC')
        ->orderBy('personas.apellidos')
        ->get();
        return response()->json(['data' => $dataActive]);
      }
    public function jugadorDelete($id)
    {   
        $jugador = TorneoJugador::findOrFail($id);
        $jugador->status = 0;
        $jugador->save();
        return response()->json(['success' => true, 'message' => 'Jugador Eliminado']);

      }
    public function torneoDelete($id)
    {   
        $torneo = Torneo::findOrFail($id);
        $torneo->status = 0;
        $torneo->save();
        return response()->json(['success' => true, 'message' => 'Torneo Eliminado']);

    }

    public function storeJugador(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'torneo_id' => 'required',
            'jugador_id' => [
                'required',
                Rule::unique('torneo_jugadores', 'jugador_id')->where(function ($query) use ($request) {
                    return $query->where('torneo_id', $request->torneo_id)->where('status', 1);
                }),
            ],

        ], ['jugador_id.unique' => 'Este jugador ya se encuentra activo en este torneo']);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        }
        
        DB::beginTransaction();

        try {
          
                DB::table('torneo_jugadores')->insert([
                    'torneo_id' => $request->torneo_id,
                    'jugador_id' => $request->jugador_id,
                    'status' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);            

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Jugador Incluido Exitosamente', 'addMessage' => "Ya podras gestionar a este jugador en este torneo"]);
            // all good
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return response()->json(['success' => false, 'errors' => [$e->getMessage()]]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'errors' => [$e->getMessage()]]);
        }
    }
}
