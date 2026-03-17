<?php

namespace App\Http\Controllers;

use App\Models\MedidaDetalle;
use App\Models\MedidaSesion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MisMedidasController extends Controller
{
    /**
     * Dashboard principal: última sesión + resumen para la vista.
     */
    public function index(): View
    {
        $user    = auth()->user();
        $persona = $user->people;

        abort_unless($persona, 404, 'No se encontró el perfil de persona asociado a este usuario.');

        // Todas las sesiones donde este cliente tiene detalles activos (status null o 1, excluye 0 = eliminados)
        $sesiones = MedidaSesion::with('sede')
            ->whereHas('detalles', function ($q) use ($persona) {
                $q->where('persona_id', $persona->id)->where('completado', 1)

                  ->where(function ($q2) {
                      $q2->whereNull('status')->orWhere('status', 1);
                  });
            })
            ->orderBy('fecha')
            ->get();

        // Último registro de medidas
        $ultima = MedidaDetalle::where('persona_id', $persona->id)
            ->where(function ($q) {
                $q->whereNull('status')->orWhere('status', 1);
            })
            ->whereNotNull('peso_kg')
            ->orderByDesc('created_at')
            ->first();

        return view('mis-medidas.dashboard', compact('persona', 'sesiones', 'ultima'));
    }

    /**
     * AJAX: todos los detalles de este cliente en orden cronológico.
     * Devuelve arrays para Chart.js.
     */
    public function datos(): JsonResponse
    {
        $persona = auth()->user()->people;

        abort_unless($persona, 404);

        $detalles = MedidaDetalle::where('persona_id', $persona->id)
            ->where(function ($q) {
                $q->whereNull('status')->orWhere('status', 1);
            })
            ->whereNotNull('peso_kg')
            ->with('sesion.sede')
            ->orderBy('created_at')
            ->get();

        $labels = $detalles->map(fn($d) => optional($d->sesion)->fecha
            ? $d->sesion->fecha->format('d/m/Y')
            : $d->created_at->format('d/m/Y')
        );

        return response()->json([
            'labels'            => $labels,
            'peso'              => $detalles->pluck('peso_kg'),
            'imc'               => $detalles->pluck('imc'),
            'porcentaje_grasa'  => $detalles->pluck('porcentaje_grasa'),
            'porcentaje_musculo'=> $detalles->pluck('porcentaje_musculo'),
            'grasa_visceral'    => $detalles->pluck('grasa_visceral'),
            'sentadillas'       => $detalles->pluck('sentadillas'),
            'abdominales'       => $detalles->pluck('abdominales'),
            'flexiones'         => $detalles->pluck('flexiones'),
            'elasticidad'       => $detalles->pluck('elasticidad'),
            // tabla completa
            'tabla' => $detalles->map(fn($d) => [
                'fecha'              => optional($d->sesion)->fecha
                                            ? $d->sesion->fecha->format('d/m/Y')
                                            : $d->created_at->format('d/m/Y'),
                'sede' => data_get($d, 'sesion.sede.nombre_sede', '—'),
                'altura_cm'          => $d->altura_cm,
                'peso_kg'            => $d->peso_kg,
                'imc'                => $d->imc,
                'edad'               => $d->edad_al_momento,
                'tmb'                => $d->metabolismo_basal,
                'grasa'              => $d->porcentaje_grasa,
                'musculo'            => $d->porcentaje_musculo,
                'grasa_visceral'     => $d->grasa_visceral,
                'sentadillas'        => $d->sentadillas,
                'abdominales'        => $d->abdominales,
                'flexiones'          => $d->flexiones,
                'elasticidad'        => $d->elasticidad,
            ]),
        ]);
    }
}
