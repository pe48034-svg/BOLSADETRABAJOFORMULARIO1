<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ZipArchive;

class PostulanteController extends Controller
{
    public function postulantes()
    {
        $ofertas = DB::table('publicaciones_publicas as p')
            ->leftJoin('postulaciones as po', 'p.id_publica', '=', 'po.id_publica')
            ->select('p.id_publica', 'p.nombre_empresa', 'p.titulo_puesto', DB::raw('COUNT(po.id_postulacion) as total_postulados'))
            ->groupBy('p.id_publica', 'p.nombre_empresa', 'p.titulo_puesto')
            ->get();

        return view('admin.postulantes', compact('ofertas'));
    }

    public function verPostulantes($id)
    {
        $postulantes = DB::table('postulaciones as po')
            ->join('postulantes as p', 'po.id_postulante', '=', 'p.id_postulante')
            ->where('po.id_publica', $id)
            ->select('p.*', 'po.id_postulacion', 'po.curriculum_pdf')
            ->get();

        return view('admin.ver-postulantes', compact('postulantes'));
    }

    public function verCV($id)
    {
        $cv = DB::table('postulaciones')->where('id_postulacion', $id)->first();

        if (!$cv || !file_exists(public_path($cv->curriculum_pdf))) {
            abort(404, 'Currículum no encontrado');
        }

        return response()->file(public_path($cv->curriculum_pdf), ['Content-Disposition' => 'inline']);
    }

    public function visualizarCV($id)
    {
        $cv = DB::table('postulaciones')->where('id_postulacion', $id)->first();

        if (!$cv || !file_exists(public_path($cv->curriculum_pdf))) {
            abort(404, 'Currículum no encontrado');
        }

        return view('admin.visualizar-cv', compact('cv'));
    }

    public function descargarCV($id)
    {
        $cv = DB::table('postulaciones')->where('id_postulacion', $id)->first();
        return response()->download(public_path($cv->curriculum_pdf));
    }

    public function descargarTodosCV($id)
    {
        $postulaciones = DB::table('postulaciones')->where('id_publica', $id)->get();

        $zip = new ZipArchive;
        $nombreZip = 'CV_Postulantes_'.$id.'.zip';
        $rutaZip = public_path($nombreZip);

        if ($zip->open($rutaZip, ZipArchive::CREATE) === TRUE) {
            foreach ($postulaciones as $postulacion) {
                $rutaArchivo = public_path($postulacion->curriculum_pdf);
                if (file_exists($rutaArchivo)) {
                    $zip->addFile($rutaArchivo, basename($rutaArchivo));
                }
            }
            $zip->close();
        }

        return response()->download($rutaZip);
    }

}
