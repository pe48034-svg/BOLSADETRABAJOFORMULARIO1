<?php

namespace App\Http\Controllers\Analista;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class IndicatorsController extends Controller
{
    public function bolsa()
    {
        $postulacionesPorEmpresa = DB::table('publicaciones_publicas as p')
            ->leftJoin('postulaciones as po', 'p.id_publica', '=', 'po.id_publica')
            ->select(
                DB::raw("COALESCE(NULLIF(TRIM(p.nombre_empresa), ''), 'Sin Empresa') as nombre_empresa"),
                DB::raw('COUNT(po.id_postulacion) as total_postulados')
            )
            ->groupBy('p.nombre_empresa')
            ->orderByDesc('total_postulados')
            ->get();

        return view('admin.indicadores-bolsa', compact('postulacionesPorEmpresa'));
    }

    public function productos()
    {
        return view('admin.indicadores-productos');
    }

    public function servicios()
    {
        return view('admin.indicadores-servicios');
    }
}
