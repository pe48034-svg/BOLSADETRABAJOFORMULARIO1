<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use App\Mail\PublicacionAprobada;

class DocumentController extends Controller
{
    public function aprobar(Request $request, $id)
    {
        $empresa = DB::table('registro_bolsadetrabajo_empresa as e')
            ->join('publicaciones_trabajo as p', 'e.id_empresa', '=', 'p.id_empresa')
            ->where('e.id_empresa', $id)
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
            ->first();

        $documentoSubgerencia = '';

        if ($request->hasFile('documento_validacion_subgerencia')) {
            $archivo = $request->file('documento_validacion_subgerencia');
            $nombreArchivo = time().'_'.$archivo->getClientOriginalName();

            $rutaSubgerencia = public_path('BolsaTrabajo/documentosAprobadosSubgerenciaEmpleo');

            if (!file_exists($rutaSubgerencia)) {
                mkdir($rutaSubgerencia, 0777, true);
            }

            $archivo->move($rutaSubgerencia, $nombreArchivo);

            $documentoSubgerencia = 'BolsaTrabajo/documentosAprobadosSubgerenciaEmpleo/'.$nombreArchivo;
        }

        $rutaDocumentosAprobados = public_path('BolsaTrabajo/documentosBolsaDeTrabajoAprobados');

        if (!file_exists($rutaDocumentosAprobados)) {
            mkdir($rutaDocumentosAprobados, 0777, true);
        }

        $rutaDocumentoOriginal = public_path($empresa->documento_validacion);

        $nuevoDocumento = 'BolsaTrabajo/documentosBolsaDeTrabajoAprobados/'.basename($empresa->documento_validacion);

        if (file_exists($rutaDocumentoOriginal)) {
            copy($rutaDocumentoOriginal, public_path($nuevoDocumento));
        }

        $rutaImagenOriginal = public_path($empresa->imagen_trabajo);

        $nuevaImagen = $empresa->imagen_trabajo ?: '';

        if (!empty($empresa->imagen_trabajo) && file_exists($rutaImagenOriginal) && is_file($rutaImagenOriginal)) {
            $ext = strtolower(pathinfo($rutaImagenOriginal, PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];

            if (in_array($ext, $allowed)) {
                $destDir = public_path('BolsaTrabajo/imagenesBolsaTrabajoAprobados');
                if (!file_exists($destDir)) {
                    mkdir($destDir, 0777, true);
                }

                $nuevaImagen = 'BolsaTrabajo/imagenesBolsaTrabajoAprobados/'.basename($empresa->imagen_trabajo);

                try {
                    copy($rutaImagenOriginal, public_path($nuevaImagen));
                } catch (\Exception $e) {
                    $nuevaImagen = $empresa->imagen_trabajo ?: '';
                }
            }
        }

        $insertData = [
            'id_empresa_original' => $empresa->id_empresa,
            'id_publicacion_original' => $empresa->id_publicacion,
            'id_usuario_aprobador' => 1,
            'nombre_empresa' => $empresa->nombre_empresa,
            'ruc' => $empresa->ruc,
            'correo_electronico' => $empresa->correo_electronico,
            'telefono' => $empresa->telefono,
            'responsable_representante' => $empresa->responsable_representante,
            'direccion' => $empresa->direccion,
            'documento_validacion' => $nuevoDocumento,
            'documento_aprobacion_pdf' => $documentoSubgerencia ?: '',
            'titulo_puesto' => $empresa->titulo_puesto,
            'descripcion_puesto' => $empresa->descripcion_puesto,
            'requisitos' => $empresa->requisitos,
            'imagen_trabajo' => $nuevaImagen,
            'modalidad' => $empresa->modalidad,
            'categoria' => $empresa->categoria,
            'salario_minimo' => $empresa->salario_minimo,
            'salario_maximo' => $empresa->salario_maximo,
            'ubicacion' => $empresa->ubicacion,
            'fecha_inicio_convocatoria' => $empresa->fecha_inicio_convocatoria,
            'fecha_limite_postulacion' => $empresa->fecha_limite_postulacion,
        ];

        if (Schema::hasColumn('empresas_bolsadetrabajo_aprobadas', 'created_at')) {
            $insertData['created_at'] = now();
        }

        if (Schema::hasColumn('empresas_bolsadetrabajo_aprobadas', 'updated_at')) {
            $insertData['updated_at'] = now();
        }

        $idAprobado = DB::table('empresas_bolsadetrabajo_aprobadas')->insertGetId($insertData);

        try {
            Mail::to($empresa->correo_electronico)->send(new PublicacionAprobada([
                'nombre_empresa' => $empresa->nombre_empresa,
                'titulo_puesto' => $empresa->titulo_puesto,
                'descripcion_puesto' => $empresa->descripcion_puesto,
                'url' => url('/'),
            ]));
        } catch (\Exception $e) {
            // Si el envío falla, continuamos con la aprobación.
        }

        DB::table('publicaciones_trabajo')->where('id_empresa', $id)->delete();
        DB::table('registro_bolsadetrabajo_empresa')->where('id_empresa', $id)->delete();

        return back();
    }

    public function rechazar($id)
    {
        $empresa = DB::table('registro_bolsadetrabajo_empresa as e')
            ->join('publicaciones_trabajo as p', 'e.id_empresa', '=', 'p.id_empresa')
            ->where('e.id_empresa', $id)
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
            ->first();

        if (!$empresa) {
            return back();
        }

        if (Schema::hasTable('empresas_bolsadetrabajo_rechazadas')) {
            $rechazadoData = [
                'id_empresa_original' => $empresa->id_empresa,
                'id_publicacion_original' => $empresa->id_publicacion,
                'nombre_empresa' => $empresa->nombre_empresa,
                'ruc' => $empresa->ruc,
                'correo_electronico' => $empresa->correo_electronico,
                'telefono' => $empresa->telefono,
                'responsable_representante' => $empresa->responsable_representante,
                'direccion' => $empresa->direccion,
                'documento_validacion' => $empresa->documento_validacion,
                'titulo_puesto' => $empresa->titulo_puesto,
                'descripcion_puesto' => $empresa->descripcion_puesto,
                'requisitos' => $empresa->requisitos,
                'imagen_trabajo' => $empresa->imagen_trabajo,
                'modalidad' => $empresa->modalidad,
                'categoria' => $empresa->categoria,
                'salario_minimo' => $empresa->salario_minimo,
                'salario_maximo' => $empresa->salario_maximo,
                'ubicacion' => $empresa->ubicacion,
                'fecha_inicio_convocatoria' => $empresa->fecha_inicio_convocatoria,
                'fecha_limite_postulacion' => $empresa->fecha_limite_postulacion,
            ];

            if (Schema::hasColumn('empresas_bolsadetrabajo_rechazadas', 'id_usuario_rechazo')) {
                $rechazadoData['id_usuario_rechazo'] = 1;
            }

            if (Schema::hasColumn('empresas_bolsadetrabajo_rechazadas', 'motivo_rechazo')) {
                $rechazadoData['motivo_rechazo'] = '';
            }

            if (Schema::hasColumn('empresas_bolsadetrabajo_rechazadas', 'veces_restaurado')) {
                $rechazadoData['veces_restaurado'] = 0;
            }

            if (Schema::hasColumn('empresas_bolsadetrabajo_rechazadas', 'created_at')) {
                $rechazadoData['created_at'] = now();
            }

            if (Schema::hasColumn('empresas_bolsadetrabajo_rechazadas', 'updated_at')) {
                $rechazadoData['updated_at'] = now();
            }

            DB::table('empresas_bolsadetrabajo_rechazadas')->insert($rechazadoData);

            DB::table('publicaciones_trabajo')->where('id_empresa', $id)->delete();
            DB::table('registro_bolsadetrabajo_empresa')->where('id_empresa', $id)->delete();

            return back();
        }

        if (!Schema::hasColumn('registro_bolsadetrabajo_empresa', 'estado')) {
            DB::table('registro_bolsadetrabajo_empresa')->where('id_empresa', $id)->delete();
            DB::table('publicaciones_trabajo')->where('id_empresa', $id)->delete();
            return back();
        }

        $updateData = ['estado' => 'RECHAZADO'];

        if (Schema::hasColumn('registro_bolsadetrabajo_empresa', 'veces_restaurado')) {
            $updateData['veces_restaurado'] = intval($empresa->veces_restaurado ?? 0);
        }

        DB::table('registro_bolsadetrabajo_empresa')->where('id_empresa', $id)->update($updateData);

        if (Schema::hasColumn('publicaciones_trabajo', 'estado')) {
            DB::table('publicaciones_trabajo')->where('id_empresa', $id)->update(['estado' => 'RECHAZADO']);
        }

        return back();
    }

    public function restaurar($id)
    {
        if (Schema::hasTable('empresas_bolsadetrabajo_rechazadas')) {
            $activa = DB::table('empresas_bolsadetrabajo_rechazadas')->where('id_rechazado', $id)->first();

            if (!$activa) {
                return back()->with('error', 'No se encontró la oferta para restaurar.');
            }

            $registroData = [
                'id_empresa' => $activa->id_empresa_original,
                'nombre_empresa' => $activa->nombre_empresa,
                'ruc' => $activa->ruc,
                'correo_electronico' => $activa->correo_electronico,
                'telefono' => $activa->telefono,
                'responsable_representante' => $activa->responsable_representante,
                'direccion' => $activa->direccion,
                'documento_validacion' => $activa->documento_validacion,
                'estado' => 'PENDIENTE',
            ];

            if (Schema::hasColumn('registro_bolsadetrabajo_empresa', 'created_at')) {
                $registroData['created_at'] = now();
            }
            if (Schema::hasColumn('registro_bolsadetrabajo_empresa', 'updated_at')) {
                $registroData['updated_at'] = now();
            }

            DB::table('registro_bolsadetrabajo_empresa')->insert($registroData);

            $publicacionData = [
                'id_publicacion' => $activa->id_publicacion_original,
                'id_empresa' => $activa->id_empresa_original,
                'titulo_puesto' => $activa->titulo_puesto,
                'descripcion_puesto' => $activa->descripcion_puesto,
                'requisitos' => $activa->requisitos,
                'imagen_trabajo' => $activa->imagen_trabajo,
                'modalidad' => $activa->modalidad,
                'categoria' => $activa->categoria,
                'salario_minimo' => $activa->salario_minimo,
                'salario_maximo' => $activa->salario_maximo,
                'ubicacion' => $activa->ubicacion,
                'fecha_inicio_convocatoria' => $activa->fecha_inicio_convocatoria,
                'fecha_limite_postulacion' => $activa->fecha_limite_postulacion,
                'estado' => 'PENDIENTE',
            ];

            if (Schema::hasColumn('publicaciones_trabajo', 'created_at')) {
                $publicacionData['created_at'] = now();
            }
            if (Schema::hasColumn('publicaciones_trabajo', 'updated_at')) {
                $publicacionData['updated_at'] = now();
            }

            DB::table('publicaciones_trabajo')->insert($publicacionData);

            if (Schema::hasColumn('empresas_bolsadetrabajo_rechazadas', 'veces_restaurado')) {
                DB::table('empresas_bolsadetrabajo_rechazadas')
                    ->where('id_rechazado', $id)
                    ->update(['veces_restaurado' => intval($activa->veces_restaurado ?? 0) + 1]);

                if (intval($activa->veces_restaurado ?? 0) + 1 >= 2) {
                    DB::table('empresas_bolsadetrabajo_rechazadas')->where('id_rechazado', $id)->delete();
                }
            }

            return back()->with('success', 'La oferta fue enviada nuevamente a validación.');
        }

        $empresa = DB::table('registro_bolsadetrabajo_empresa')->where('id_empresa', $id)->first();

        if (!$empresa) {
            return back()->with('error', 'No se encontró la oferta para restaurar.');
        }

        $veces = intval($empresa->veces_restaurado ?? 0);
        if ($veces >= 2) {
            return back()->with('error', 'Ya alcanzó el límite de restauraciones para esta oferta.');
        }

        $updateData = [
            'estado' => 'PENDIENTE',
            'veces_restaurado' => $veces + 1,
        ];

        DB::table('registro_bolsadetrabajo_empresa')->where('id_empresa', $id)->update($updateData);

        if (Schema::hasColumn('publicaciones_trabajo', 'estado')) {
            DB::table('publicaciones_trabajo')->where('id_empresa', $id)->update(['estado' => 'PENDIENTE']);
        }

        return back()->with('success', 'La oferta fue enviada nuevamente a validación.');
    }

    public function subirDocumento(Request $request, $id)
    {
        if (!$request->hasFile('documento_pdf')) {
            return back();
        }

        $pdf = $request->file('documento_pdf');
        $archivo = time().'_'.$pdf->getClientOriginalName();

        $ruta = public_path('BolsaTrabajo/documentosAprobadosSubgerenciaEmpleo');
        if (!file_exists($ruta)) {
            mkdir($ruta, 0777, true);
        }

        $pdf->move($ruta, $archivo);

        $empresaAprobada = DB::table('empresas_bolsadetrabajo_aprobadas')->where('id_aprobado', $id)->first();

        if ($empresaAprobada && !empty($empresaAprobada->documento_aprobacion_pdf) && file_exists(public_path($empresaAprobada->documento_aprobacion_pdf))) {
            unlink(public_path($empresaAprobada->documento_aprobacion_pdf));
        }

        DB::table('empresas_bolsadetrabajo_aprobadas')->where('id_aprobado', $id)->update([
            'documento_aprobacion_pdf' => 'BolsaTrabajo/documentosAprobadosSubgerenciaEmpleo/'.$archivo
        ]);

        $empresa = DB::table('empresas_bolsadetrabajo_aprobadas')->where('id_aprobado', $id)->first();

        DB::table('publicaciones_publicas')->insert([
            'id_aprobado' => $empresa->id_aprobado,
            'nombre_empresa' => $empresa->nombre_empresa,
            'titulo_puesto' => $empresa->titulo_puesto,
            'descripcion_puesto' => $empresa->descripcion_puesto,
            'requisitos' => $empresa->requisitos,
            'imagen_trabajo' => $empresa->imagen_trabajo,
            'modalidad' => $empresa->modalidad,
            'categoria' => $empresa->categoria,
            'salario_minimo' => $empresa->salario_minimo,
            'salario_maximo' => $empresa->salario_maximo,
            'ubicacion' => $empresa->ubicacion,
            'fecha_inicio_convocatoria' => $empresa->fecha_inicio_convocatoria,
            'fecha_limite_postulacion' => $empresa->fecha_limite_postulacion
        ]);

        return back();
    }

}
