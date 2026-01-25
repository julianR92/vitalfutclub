<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CiudadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('ciudades.index');
    }

    /**
     * Get data for DataTables
     */
    public function getData()
    {
        try {
            $ciudades = Ciudad::with(['sedes', 'sedes.perPlanesActivos'])
                ->orderBy('nombre', 'asc')
                ->get();

            return response()->json(['data' => $ciudades]);
        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'error' => 'Error al obtener las ciudades: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ciudades.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:255|unique:ciudades,nombre',
                'codigo' => 'required|string|max:50|unique:ciudades,codigo',
                'estado' => 'required|boolean',
            ], [
                'nombre.required' => 'El nombre de la ciudad es obligatorio.',
                'nombre.unique' => 'Ya existe una ciudad con este nombre.',
                'codigo.required' => 'El código es obligatorio.',
                'codigo.unique' => 'Ya existe una ciudad con este código.',
                'estado.required' => 'El estado es obligatorio.',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            Ciudad::create($request->all());

            return redirect()
                ->route('ciudades.index')
                ->with('success', 'Ciudad creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al crear la ciudad: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Ciudad $ciudad)
    {
        try {
            $ciudad->load(['sedes', 'planes']);

            // Obtener personas con planes activos en esta ciudad
            $planesActivos = \App\Models\PerPLanes::with(['persona', 'planes', 'sede'])
                ->whereHas('sede', function($query) use ($ciudad) {
                    $query->where('ciudad_id', $ciudad->id);
                })
                ->where('estado', 1)
                ->get();

            return view('ciudades.show', compact('ciudad', 'planesActivos'));
        } catch (\Exception $e) {
            return redirect()->route('ciudades.index')
                ->with('error', 'Error al cargar la ciudad: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ciudad $ciudad)
    {
        return view('ciudades.edit', compact('ciudad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ciudad $ciudad)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:255|unique:ciudades,nombre,' . $ciudad->id,
                'codigo' => 'required|string|max:50|unique:ciudades,codigo,' . $ciudad->id,
                'estado' => 'required|boolean',
            ], [
                'nombre.required' => 'El nombre de la ciudad es obligatorio.',
                'nombre.unique' => 'Ya existe una ciudad con este nombre.',
                'codigo.required' => 'El código es obligatorio.',
                'codigo.unique' => 'Ya existe una ciudad con este código.',
                'estado.required' => 'El estado es obligatorio.',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $ciudad->update($request->all());

            return redirect()
                ->route('ciudades.index')
                ->with('success', 'Ciudad actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al actualizar la ciudad: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ciudad $ciudad)
    {
        try {
            // Verificar si tiene sedes o planes asociados
            if ($ciudad->sedes()->count() > 0 || $ciudad->planes()->count() > 0) {
                return redirect()
                    ->route('ciudades.index')
                    ->with('error', 'No se puede eliminar la ciudad porque tiene sedes o planes asociados.');
            }

            $ciudad->delete();

            return redirect()
                ->route('ciudades.index')
                ->with('success', 'Ciudad eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->route('ciudades.index')
                ->with('error', 'Error al eliminar la ciudad: ' . $e->getMessage());
        }
    }
}
