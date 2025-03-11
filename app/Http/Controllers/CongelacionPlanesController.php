<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\CongelacionPlanes;
use App\Models\PerPLanes;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CongelacionPlanesController extends Controller
{
	public function getData()
	{
		$personas = Persona::select(['personas.*', 'users.estado'])
			->join('users', 'users.persona_id', '=', 'personas.id')
			->where('users.rol', 'cliente')
			->orderby('personas.id', 'desc')
			->get();

		return response()->json(['data' => $personas]);
	}

	public function index()
	{
		$datos = CongelacionPlanes::join('personas', 'personas.id', '=', 'congelacion_planes.persona_id')->get();

		$personas = Persona::leftJoin('per_planes', 'per_planes.persona_id', '=', 'personas.id')->where('per_planes.estado', 1)->get();
		return view('livewire/congelacion_planes.index', compact('datos', 'personas'));
	}

	public function store(Request $request)
	{

		if ($request->tipo == 'M') {
			try {
				DB::transaction(
					function () use ($request) {
						$planes_activos = PerPlanes::where('estado', 1)->get();
						foreach ($planes_activos as $plan) {
							$fecha_fin = Carbon::parse($plan->fecha_fin);
							$fecha_fin = $fecha_fin->addDays($request->diferencia);
							$plan->fecha_fin = $fecha_fin;
							$plan->save();

							$congelacion = new CongelacionPlanes();
							$congelacion->persona_id = $plan->persona_id;
							$congelacion->tipo = $request->tipo;
							$congelacion->fecha_inicio = $request->fecha_inicio;
							$congelacion->fecha_fin = $request->fecha_fin;
							$congelacion->dif_dias = $request->diferencia;
							$congelacion->observacion = $request->observacion;
							$congelacion->user_id = auth()->id();
							$congelacion->save();
						}
					}
				);
				return response()->json(['success' => true, 'message' => 'Operación realizada con éxito']);
			} catch (\Exception $e) {
				// Respuesta de error
				return response()->json(['success' => false, 'message' => 'Error en la operación: ' . $e->getMessage()], 500);
			}
		} else {
			try {
				DB::transaction(
					function () use ($request) {
						$planes_activos = PerPlanes::where('estado', 1)->where('id', $request->plan_id)->get();
						foreach ($planes_activos as $plan) {
							$fecha_fin = Carbon::parse($plan->fecha_fin);
							$fecha_fin = $fecha_fin->addDays($request->diferencia);
							$plan->fecha_fin = $fecha_fin;
							$plan->save();

							$congelacion = new CongelacionPlanes();
							$congelacion->persona_id = $plan->persona_id;
							$congelacion->tipo = $request->tipo;
							$congelacion->fecha_inicio = $request->fecha_inicio;
							$congelacion->fecha_fin = $request->fecha_fin;
							$congelacion->dif_dias = $request->diferencia;
							$congelacion->observacion = $request->observacion;
							$congelacion->user_id = auth()->id();
							$congelacion->save();
						}
					}
				);
				return response()->json(['success' => true, 'message' => 'Operación realizada con éxito']);
			} catch (\Exception $e) {
				// Respuesta de error
				return response()->json(['success' => false, 'message' => 'Error en la operación: ' . $e->getMessage()], 500);
			}
		}
	}
}
