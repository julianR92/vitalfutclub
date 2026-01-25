<?php

namespace App\Http\Controllers;

use App\Models\Sede;
use App\Models\Ciudad;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SedeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sedes.index');
    }

    /**
     * Get data for DataTables
     */
    public function getData()
    {
        try {
            $sedes = Sede::with(['ciudad', 'profesor', 'planes'])
                ->orderBy('nombre_sede', 'asc')
                ->get();

            return response()->json(['data' => $sedes]);
        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'error' => 'Error al obtener las sedes: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ciudades = Ciudad::where('estado', 1)->orderBy('nombre', 'asc')->get();
        $profesores = User::where('rol', 'profesor')->orderBy('name', 'asc')->get();

        return view('sedes.create', compact('ciudades', 'profesores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre_sede' => 'required|string|max:255',
                'ciudad_id' => 'required|exists:ciudades,id',
                'user_id' => 'nullable|exists:users,id',
                'direccion' => 'nullable|string|max:255',
                'telefono' => 'nullable|string|max:50',
                'persona_cargo' => 'nullable|string|max:255',
            ], [
                'nombre_sede.required' => 'El nombre de la sede es obligatorio.',
                'ciudad_id.required' => 'La ciudad es obligatoria.',
                'ciudad_id.exists' => 'La ciudad seleccionada no existe.',
                'user_id.exists' => 'El profesor seleccionado no existe.',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            Sede::create($request->all());

            return redirect()
                ->route('sedes.index')
                ->with('success', 'Sede creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al crear la sede: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sede $sede)
    {
        try {
            $sede->load(['ciudad', 'profesor', 'planes']);

            // Obtener personas con planes activos en esta sede
            $planesActivos = \App\Models\PerPLanes::with(['persona', 'planes'])
                ->where('sede_id', $sede->id)
                ->where('estado', 1) // estado = 1 para planes activos
                ->get();

            return view('sedes.show', compact('sede', 'planesActivos'));
        } catch (\Exception $e) {
            return redirect()->route('sedes.index')
                ->with('error', 'Error al cargar la sede: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sede $sede)
    {
        $ciudades = Ciudad::where('estado', 1)->orderBy('nombre', 'asc')->get();
        $profesores = User::where('rol', 'profesor')->orderBy('name', 'asc')->get();

        return view('sedes.edit', compact('sede', 'ciudades', 'profesores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sede $sede)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre_sede' => 'required|string|max:255',
                'ciudad_id' => 'required|exists:ciudades,id',
                'user_id' => 'nullable|exists:users,id',
                'direccion' => 'nullable|string|max:255',
                'telefono' => 'nullable|string|max:50',
                'persona_cargo' => 'nullable|string|max:255',
            ], [
                'nombre_sede.required' => 'El nombre de la sede es obligatorio.',
                'ciudad_id.required' => 'La ciudad es obligatoria.',
                'ciudad_id.exists' => 'La ciudad seleccionada no existe.',
                'user_id.exists' => 'El profesor seleccionado no existe.',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $sede->update($request->all());

            return redirect()
                ->route('sedes.index')
                ->with('success', 'Sede actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al actualizar la sede: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sede $sede)
    {
        try {
            // Verificar si tiene planes o per_planes asociados
            if ($sede->planes()->count() > 0 || $sede->perPlanes()->count() > 0) {
                return redirect()
                    ->route('sedes.index')
                    ->with('error', 'No se puede eliminar la sede porque tiene planes asociados.');
            }

            $sede->delete();

            return redirect()
                ->route('sedes.index')
                ->with('success', 'Sede eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->route('sedes.index')
                ->with('error', 'Error al eliminar la sede: ' . $e->getMessage());
        }
    }
}
