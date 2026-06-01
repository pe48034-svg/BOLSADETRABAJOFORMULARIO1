<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BolsaController extends Controller
{
    public function validacion()
    {
        $query = DB::table('registro_bolsadetrabajo_empresa as e')
            ->join('publicaciones_trabajo as p', 'e.id_empresa', '=', 'p.id_empresa')
            ->select(
                'e.*',
                'p.id_publicacion',
                'p.titulo_puesto',
                'p.descripcion_puesto',
                'p.requisitos',
                'p.imagen_trabajo',
                'p.modalidad',
                'p.categoria',
                'p.salario_minimo',
                'p.salario_maximo',
                'p.ubicacion',
                'p.fecha_inicio_convocatoria',
                'p.fecha_limite_postulacion'
            );

        if (Schema::hasColumn('registro_bolsadetrabajo_empresa', 'estado')) {
            $query->where('e.estado', 'PENDIENTE');
        }

        $empresas = $query->get();

        return view('admin.validacion-formularios', compact('empresas'));
    }

    public function bolsaTrabajo()
    {
        $empresas = DB::table('empresas_bolsadetrabajo_aprobadas')->get();
        return view('admin.bolsa-trabajo', compact('empresas'));
    }

    public function rechazados()
    {
        if (Schema::hasTable('empresas_bolsadetrabajo_rechazadas')) {
            $empresas = DB::table('empresas_bolsadetrabajo_rechazadas')->get();
        } else {
            $empresas = DB::table('registro_bolsadetrabajo_empresa as e')
                ->join('publicaciones_trabajo as p', 'e.id_empresa', '=', 'p.id_empresa')
                ->where('e.estado', 'RECHAZADO')
                ->select(
                    'e.*',
                    'p.id_publicacion',
                    'p.titulo_puesto',
                    'p.descripcion_puesto',
                    'p.requisitos',
                    'p.imagen_trabajo',
                    'p.modalidad',
                    'p.categoria',
                    'p.salario_minimo',
                    'p.salario_maximo',
                    'p.ubicacion',
                    'p.fecha_inicio_convocatoria',
                    'p.fecha_limite_postulacion'
                )
                ->get();
        }

        return view('admin.rechazados', compact('empresas'));
    }

    public function ver($id)
    {
        $empresa = DB::table('registro_bolsadetrabajo_empresa as e')
            ->join('publicaciones_trabajo as p', 'e.id_empresa', '=', 'p.id_empresa')
            ->where('e.id_empresa', $id)
            ->select('e.*', 'p.*')
            ->first();

        if ($empresa && !empty($empresa->documento_validacion)) {
            $originalPath = public_path($empresa->documento_validacion);
            if (!file_exists($originalPath)) {
                $fallback = public_path('documentos/' . basename($empresa->documento_validacion));
                if (file_exists($fallback)) {
                    $empresa->documento_validacion = 'documentos/' . basename($empresa->documento_validacion);
                }
            }
        }

        return view('admin.ver', compact('empresa'));
    }

    public function eliminarDocumento($id)
    {
        $empresa = DB::table('empresas_bolsadetrabajo_aprobadas')->where('id_aprobado', $id)->first();

        if ($empresa && !empty($empresa->documento_aprobacion_pdf)) {
            $ruta = public_path($empresa->documento_aprobacion_pdf);
            if (file_exists($ruta)) {
                unlink($ruta);
            }

            DB::table('empresas_bolsadetrabajo_aprobadas')->where('id_aprobado', $id)->update(['documento_aprobacion_pdf' => null]);
        }

        return back();
    }

    public function eliminarPublicacion($id)
    {
        $empresa = DB::table('empresas_bolsadetrabajo_aprobadas')->where('id_aprobado', $id)->first();

        if ($empresa) {
            if (!empty($empresa->documento_aprobacion_pdf) && file_exists(public_path($empresa->documento_aprobacion_pdf))) {
                unlink(public_path($empresa->documento_aprobacion_pdf));
            }

            if (!empty($empresa->imagen_trabajo) && file_exists(public_path($empresa->imagen_trabajo))) {
                unlink(public_path($empresa->imagen_trabajo));
            }

            DB::table('publicaciones_publicas')->where('id_aprobado', $id)->delete();
            DB::table('empresas_bolsadetrabajo_aprobadas')->where('id_aprobado', $id)->delete();
        }

        return back()->with('success', 'Publicación eliminada correctamente.');
    }

}
