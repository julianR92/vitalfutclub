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
use App\Models\Sede;
use App\Models\Sorteo;
use App\Models\SorteoEquipo;
use App\Models\SorteoEquipoJugador;
use App\Models\SorteoJugador;
use Exception;
use Illuminate\Validation\Rule;

class SorteoController extends Controller
{
    public function index()
    {
        $sedes = Sede::orderBy('nombre_sede', 'ASC')->get();
        return view('livewire/sorteo.index', compact('sedes'));
    }

    public function getData()
    {

        $sorteos = Sorteo::with('sede')->where('status', 1)
            ->get();
        return response()->json(['data' => $sorteos]);
    }

    public function getDataClientes($sorteo_id)
    {
        $personas = Persona::join('users', 'users.persona_id', '=', 'personas.id')
            ->leftJoin('sorteo_jugadores', function ($join) use ($sorteo_id) {
                $join->on('sorteo_jugadores.jugador_id', '=', 'personas.id')
                    ->where('sorteo_jugadores.sorteo_id', $sorteo_id);
            })
            ->whereNull('sorteo_jugadores.id') // Filtra los que NO están en sorteo_jugadores
            ->where('users.rol', 'cliente')
            ->where('users.estado', 1)
            ->select('personas.id', 'personas.nombres', 'personas.apellidos', 'personas.documento')
            ->orderBy('personas.apellidos', 'ASC')
            ->orderBy('personas.nombres', 'ASC')
            ->get();

        return response()->json(['data' => $personas]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'sede_id' => 'required',
            'descripcion' => 'required|max:100',


        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        }

        DB::beginTransaction();

        try {

            $sorteo_id =  DB::table('sorteo')->insertGetId([
                'sede_id' => $request->sede_id,
                'descripcion' => $request->descripcion,
                'numero_equipos' => 0,
                'jugadores_completos' => 0,
                'clasificacion_validada' => 0,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),


            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Sorteo Creado Exitosamente']);
            // all good
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return response()->json(['success' => false, 'errors' => [$e->getMessage()]]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'errors' => [$e->getMessage()]]);
        }
    }

    public function addPlayers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sorteo_id' => 'required',
            'jugadores'  => 'required|array|min:1',


        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        }

        DB::beginTransaction();

        try {

            $contador = 0;
            foreach ($request->jugadores as $jugadorId) {
                DB::table('sorteo_jugadores')->insert([
                    'sorteo_id' => $request->sorteo_id,
                    'jugador_id' => $jugadorId,
                    'clasificacion' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                $contador++;
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => "$contador Jugadores Agregados Exitosamente"]);
            // all good
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return response()->json(['success' => false, 'errors' => [$e->getMessage()]]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'errors' => [$e->getMessage()]]);
        }
    }
    public function updateClasificacion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'clasificacion' => 'required',
            'id'  => 'required',


        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        }

        DB::beginTransaction();

        try {
            DB::table('sorteo_jugadores')->where('id', $request->id)->update([
                'clasificacion' => $request->clasificacion,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => "Clasificación Actualizada Exitosamente"]);
            // all good
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return response()->json(['success' => false, 'errors' => [$e->getMessage()]]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'errors' => [$e->getMessage()]]);
        }
    }
    public function teamNumber(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numero_equipos' => 'required|integer|min:1|max:99',
            'id'  => 'required',


        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()->all()]);
        }
        $numeroEquipos = $request->numero_equipos;
        $sorteoId = $request->id;
        DB::beginTransaction();

        try {

            for ($i = 1; $i <= $numeroEquipos; $i++) {
                DB::table('sorteo_equipos')->insert([
                    'sorteo_id' => $sorteoId,
                    'nombre_equipo' => "Equipo-" . $i,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }

            DB::table('sorteo')->where('id', $sorteoId)->update([
                'numero_equipos' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => "Equipos creados Exitosamente"]);
            // all good
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return response()->json(['success' => false, 'errors' => [$e->getMessage()]]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'errors' => [$e->getMessage()]]);
        }
    }

    public function sorteoData($id)
    {
        $sorteo =  Sorteo::with('sede')->findOrFail($id);
        $equipos_jugadores = SorteoEquipo::where('sorteo_id', $id)->with(['jugadores.jugador'])->get();
        $count_equipos = SorteoEquipo::where('sorteo_id', $id)->count();
        $count_jugadores = SorteoJugador::where('sorteo_id', $id)->count();
        return view('livewire/sorteo.sorteo', compact('sorteo', 'equipos_jugadores', 'count_equipos', 'count_jugadores'));
    }
    public function getSorteoJugadores($id)
    {
        $datos = SorteoJugador::with('jugador')->where('sorteo_id', $id)->orderBy('clasificacion', 'ASC')->get();
        return response()->json(['data' => $datos]);
    }
    public function jugadorDelete($id)
    {
        $jugador = SorteoJugador::findOrFail($id);
        $jugador->delete();
        return response()->json(['success' => true, 'message' => 'Jugador Eliminado']);
    }

    public function sorteoDelete($id)
    {
        $torneo = Sorteo::findOrFail($id);
        $torneo->status = 0;
        $torneo->save();
        return response()->json(['success' => true, 'message' => 'Sorteo Eliminado']);
    }
    public function finishSelection($id)
    {
        $torneo = Sorteo::findOrFail($id);
        $torneo->jugadores_completos = 1;
        $torneo->save();
        return response()->json(['success' => true, 'message' => 'Selección Finalizada']);
    }

    public function endingSorteo(Request $request)
    {


        DB::beginTransaction();

        try {
           $equipos = $request->equipos;
            foreach ($equipos as $equipo) {
                $equipo_id = $equipo['equipo_id'];

                foreach ($equipo['jugadores'] as $jugador) {
                    DB::table('sorteo_equipo_jugador')->insert([
                        'equipo_id' => $equipo_id,
                        'jugador_id' => $jugador['jugador_id'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
            DB::table('sorteo')->where('id', $request->id)->update([
                'sorteo_finalizado' => 1,
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

    public function validateClasificacion($id)
    {
        $sorteo_id = $id;
        $sorteo = Sorteo::find($sorteo_id);

        if (!$sorteo) {
            return response()->json(['success' => false, 'message' => 'Sorteo no encontrado'], 200);
        }

        $num_equipos = SorteoEquipo::where('sorteo_id', $sorteo_id)->count();

        $jugadores = SorteoJugador::where('sorteo_id', $sorteo_id)->pluck('clasificacion');

        if ($jugadores->contains(0)) {
            return response()->json(['success' => false, 'message' => 'No puede haber jugadores con clasificación 0']);
        }

        // Contar cuántos jugadores hay en cada clasificación
        $conteo = $jugadores->countBy();

        // Validar que las clasificaciones 1, 2, 4 y 5 sean múltiplos de `num_equipos`
        $clasificaciones_restringidas = [1, 2, 4, 5];
        $errores = [];

        foreach ($clasificaciones_restringidas as $clasificacion) {
            if (isset($conteo[$clasificacion]) && $conteo[$clasificacion] % $num_equipos !== 0) {
                $errores[] = "El número de jugadores con clasificación {$clasificacion} debe ser múltiplo de {$num_equipos}.";
            }
        }

        // Si hay errores, devolver mensaje
        if (!empty($errores)) {
            return response()->json(['success' => false, 'message' => implode(" ", $errores)]);
        }
        $sorteo->clasificacion_validada = 1;
        $sorteo->save();
        return response()->json(['success' => true, 'message' => 'Validación exitosa']);
    }

    public function createSorteo($id)
    {

        try {
            $sorteo = Sorteo::with('equipos')->findOrFail($id);

            if (!$sorteo) {
                return response()->json(['success' => false, 'message' => 'Sorteo no encontrado'], 200);
            }

            $equipos = $sorteo->equipos->toArray();
            $numEquipos = count($equipos);

            if ($numEquipos == 0) {
                return response()->json(['sucesss' => false, 'message' => 'No hay equipos disponibles'], 200);
            }

            $jugadores = DB::table('sorteo_jugadores')
                ->join('personas', 'sorteo_jugadores.jugador_id', '=', 'personas.id')
                ->where('sorteo_jugadores.sorteo_id', $id)
                ->select('sorteo_jugadores.jugador_id', 'personas.nombres', 'personas.apellidos', 'sorteo_jugadores.clasificacion')
                ->get()
                ->toArray();

            if (count($jugadores) == 0) {
                return response()->json(['success' => false, 'message' => 'No hay jugadores registrados'], 200);
            }

            // Agrupar jugadores por clasificación
            $jugadoresPorClasificacion = [];
            foreach ($jugadores as $jugador) {
                $jugadoresPorClasificacion[$jugador->clasificacion][] = $jugador;
            }

            // Mezclar jugadores aleatoriamente dentro de cada clasificación
            foreach ($jugadoresPorClasificacion as &$grupo) {
                shuffle($grupo);
            }

            // Inicializar equipos
            $equiposDistribuidos = [];
            foreach ($equipos as $equipo) {
                $equiposDistribuidos[$equipo['id']] = [
                    'nombre_equipo' => $equipo['nombre_equipo'],
                    'equipo_id' => $equipo['id'],
                    'jugadores' => []
                ];
            }

            // 1️⃣ **Distribuir clasificaciones 1, 2, 4, 5 equitativamente**
            $clasificacionesFijas = [1, 2, 4, 5];

            foreach ($clasificacionesFijas as $clasificacion) {
                if (!isset($jugadoresPorClasificacion[$clasificacion])) {
                    continue;
                }

                $index = 0;
                $jugadoresRestantes = $jugadoresPorClasificacion[3]; // Copia de jugadores para evitar duplicados

                foreach ($jugadoresPorClasificacion[$clasificacion] as $key => $jugador) {
                    $equipoId = array_keys($equiposDistribuidos)[$index % $numEquipos];
                    $equiposDistribuidos[$equipoId]['jugadores'][] = [
                        'jugador_id' => $jugador->jugador_id,
                        'nombre' => $jugador->nombres . ' ' . $jugador->apellidos,
                        'clasificacion' => $jugador->clasificacion
                    ];
                    unset($jugadoresRestantes[$key]);
                    $index++;
                }
            }


            if (isset($jugadoresPorClasificacion[3])) {
                shuffle($jugadoresPorClasificacion[3]); // Mezclar antes de repartir

                $totalJugadores3 = count($jugadoresPorClasificacion[3]);
                $jugadoresPorEquipo = intdiv($totalJugadores3, $numEquipos); // Cantidad base por equipo
                $sobrantes = $totalJugadores3 % $numEquipos; // Cantidad extra a repartir

                $index = 0;
                $equiposConJugadores3 = array_fill_keys(array_keys($equiposDistribuidos), 0); // Contador por equipo

                // 1️⃣ Asignar jugadores #3 equitativamente
                foreach ($jugadoresPorClasificacion[3] as $key => $jugador) {
                    if ($index < $jugadoresPorEquipo * $numEquipos) {
                        $equipoId = array_keys($equiposDistribuidos)[$index % $numEquipos];
                        $equiposDistribuidos[$equipoId]['jugadores'][] = [
                            'jugador_id' => $jugador->jugador_id,
                            'nombre' => $jugador->nombres . ' ' . $jugador->apellidos,
                            'clasificacion' => 3
                        ];
                        $equiposConJugadores3[$equipoId]++; // Contamos cuántos tiene cada equipo
                        unset($jugadoresPorClasificacion[3][$key]); // Evitamos duplicados
                        $index++;
                    }
                }

                // 2️⃣ Repartir los sobrantes equitativamente a los equipos con menos jugadores #3
                $jugadoresRestantes = array_values($jugadoresPorClasificacion[3]); // Reindexamos el array
                while ($sobrantes > 0) {
                    // Buscar el equipo con menos jugadores #3 asignados
                    asort($equiposConJugadores3); // Ordena de menor a mayor cantidad de jugadores #3
                    $equipoMenosLleno = key($equiposConJugadores3); // Primer equipo en la lista

                    // Tomar un jugador restante y asignarlo
                    $jugador = array_shift($jugadoresRestantes); // Extrae el primer jugador
                    $equiposDistribuidos[$equipoMenosLleno]['jugadores'][] = [
                        'jugador_id' => $jugador->jugador_id,
                        'nombre' => $jugador->nombres . ' ' . $jugador->apellidos,
                        'clasificacion' => 3
                    ];
                    $equiposConJugadores3[$equipoMenosLleno]++; // Incrementa el contador en este equipo

                    $sobrantes--; // Disminuir el número de sobrantes
                }
            }
            DB::commit();
            return response()->json(['success' => true, 'message' => "Equipos Sorteados exitosamente", 'equipos' => $equiposDistribuidos]);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return response()->json(['success' => false, 'errors' => [$e->getMessage()]]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'errors' => [$e->getMessage()]]);
        }
    }
}
