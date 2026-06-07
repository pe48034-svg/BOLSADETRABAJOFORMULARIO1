<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function formulariosServicios()
    {
        $servicios = DB::table('registro_empresa_servicio as e')
            ->join('servicios_empresa as s', 'e.id_empresa_servicio', '=', 's.id_empresa_servicio')
            ->where('s.estado', 'Pendiente')
            ->select(
                'e.*',
                's.id_servicio',
                's.nombre_servicio',
                's.descripcion',
                's.categoria',
                's.ubicacion_ciudad',
                's.telefono_contacto',
                's.redes_sociales',
                's.correo_contacto',
                's.direccion_atencion',
                's.imagen_servicio',
                's.horario_atencion',
                's.estado as estado_servicio',
                's.fecha_inicio',
                's.fecha_fin'
            )
            ->get();

        return view('admin.formularios-servicios', compact('servicios'));
    }

    public function verServicio($id)
    {
        $servicio = DB::table('registro_empresa_servicio as e')
            ->join('servicios_empresa as s', 'e.id_empresa_servicio', '=', 's.id_empresa_servicio')
            ->where('s.id_servicio', $id)
            ->select(
                'e.*',
                's.id_servicio',
                's.nombre_servicio',
                's.descripcion',
                's.categoria',
                's.ubicacion_ciudad',
                's.telefono_contacto',
                's.redes_sociales',
                's.correo_contacto',
                's.direccion_atencion',
                's.imagen_servicio',
                's.horario_atencion',
                's.estado as estado_servicio',
                's.fecha_inicio',
                's.fecha_fin'
            )
            ->first();

        if (!$servicio) {
            return redirect('/admin/formularios-servicios')->with('error', 'Servicio no encontrado');
        }

        return view('admin.ver-servicio', compact('servicio'));
    }

    public function verServicioRechazado($id)
    {
        $servicio = DB::table('empresas_servicio_rechazadas')->where('id_rechazado', $id)->first();

        if (!$servicio) {
            return back()->with('error', 'Servicio rechazado no encontrado.');
        }

        return view('admin.ver-servicio-rechazado', compact('servicio'));
    }

    public function aprobarServicio(Request $request, $id)
    {
        $request->validate([
            'documento_validacion_subgerencia' => 'required|mimes:pdf|max:10240',
        ]);

        $servicio = DB::table('registro_empresa_servicio as e')
            ->join('servicios_empresa as s', 'e.id_empresa_servicio', '=', 's.id_empresa_servicio')
            ->where('s.id_servicio', $id)
            ->select('e.*', 's.*')
            ->first();

        if (!$servicio) {
            return redirect('/admin/formularios-servicios')->with('error', 'Servicio no encontrado');
        }

        $archivo = $request->file('documento_validacion_subgerencia');
        $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
        $rutaSubgerencia = public_path('Servicios/documentosServiciosAprobadosSubgerencia');
        if (!file_exists($rutaSubgerencia)) {
            mkdir($rutaSubgerencia, 0777, true);
        }
        $archivo->move($rutaSubgerencia, $nombreArchivo);

        $documentoSubgerencia = 'Servicios/documentosServiciosAprobadosSubgerencia/' . $nombreArchivo;
        $idUsuarioAprobador = auth()->id() ?? 1;

        DB::transaction(function () use ($servicio, $documentoSubgerencia, $idUsuarioAprobador) {
            $idAprobado = DB::table('empresas_servicio_aprobadas')->insertGetId([
                'id_empresa_original' => $servicio->id_empresa_servicio,
                'id_servicio_original' => $servicio->id_servicio,
                'id_usuario_aprobador' => $idUsuarioAprobador,
                'nombre_empresa' => $servicio->nombre_empresa,
                'ruc' => $servicio->ruc,
                'correo_electronico' => $servicio->correo_electronico,
                'telefono' => $servicio->telefono,
                'responsable_representante' => $servicio->responsable_representante,
                'direccion' => $servicio->direccion,
                'documento_validacion' => $servicio->documento_validacion,
                'nombre_servicio' => $servicio->nombre_servicio,
                'descripcion' => $servicio->descripcion,
                'categoria' => $servicio->categoria,
                'ubicacion_ciudad' => $servicio->ubicacion_ciudad,
                'telefono_contacto' => $servicio->telefono_contacto,
                'redes_sociales' => $servicio->redes_sociales,
                'correo_contacto' => $servicio->correo_contacto,
                'direccion_atencion' => $servicio->direccion_atencion,
                'imagen_servicio' => $servicio->imagen_servicio,
                'horario_atencion' => $servicio->horario_atencion,
                'estado' => 'Aprobado',
                'documento_aprobacion' => $documentoSubgerencia,
                'fecha_inicio' => $servicio->fecha_inicio,
                'fecha_fin' => $servicio->fecha_fin,
            ]);

            DB::table('servicios_publicos')->insert([
                'id_aprobado' => $idAprobado,
                'nombre_empresa' => $servicio->nombre_empresa,
                'nombre_servicio' => $servicio->nombre_servicio,
                'descripcion' => $servicio->descripcion,
                'categoria' => $servicio->categoria,
                'ubicacion_ciudad' => $servicio->ubicacion_ciudad,
                'telefono_contacto' => $servicio->telefono_contacto,
                'redes_sociales' => $servicio->redes_sociales,
                'correo_contacto' => $servicio->correo_contacto,
                'direccion_atencion' => $servicio->direccion_atencion,
                'imagen_servicio' => $servicio->imagen_servicio,
                'horario_atencion' => $servicio->horario_atencion,
                'estado' => 'Publicado',
                'fecha_inicio' => $servicio->fecha_inicio,
                'fecha_fin' => $servicio->fecha_fin,
            ]);

            DB::table('servicios_empresa')->where('id_servicio', $servicio->id_servicio)->update(['estado' => 'Publicado']);
            DB::table('registro_empresa_servicio')->where('id_empresa_servicio', $servicio->id_empresa_servicio)->update(['estado' => 'Publicado']);
        });

        return redirect('/admin/formularios-servicios')->with('success', 'Servicio aprobado y movido a publicaciones de servicios.');
    }

    public function rechazarServicio(Request $request, $id)
    {
        $servicio = DB::table('registro_empresa_servicio as e')
            ->join('servicios_empresa as s', 'e.id_empresa_servicio', '=', 's.id_empresa_servicio')
            ->where('s.id_servicio', $id)
            ->select('e.*', 's.*')
            ->first();

        if (!$servicio) {
            return redirect('/admin/formularios-servicios')->with('error', 'Servicio no encontrado');
        }

        if ($servicio->estado !== 'Pendiente') {
            return redirect('/admin/formularios-servicios')->with('error', 'Este servicio ya ha sido procesado.');
        }

        $motivoRechazo = $request->input('motivo_rechazo', '');
        $idUsuarioRechazo = auth()->id() ?? 1;

        $rechazoData = [
            'id_empresa_original' => $servicio->id_empresa_servicio,
            'id_servicio_original' => $servicio->id_servicio,
            'id_usuario_rechazo' => $idUsuarioRechazo,
            'nombre_empresa' => $servicio->nombre_empresa,
            'ruc' => $servicio->ruc,
            'correo_electronico' => $servicio->correo_electronico,
            'telefono' => $servicio->telefono,
            'responsable_representante' => $servicio->responsable_representante,
            'direccion' => $servicio->direccion,
            'documento_validacion' => $servicio->documento_validacion,
            'nombre_servicio' => $servicio->nombre_servicio,
            'descripcion' => $servicio->descripcion,
            'categoria' => $servicio->categoria,
            'ubicacion_ciudad' => $servicio->ubicacion_ciudad,
            'telefono_contacto' => $servicio->telefono_contacto,
            'redes_sociales' => $servicio->redes_sociales,
            'correo_contacto' => $servicio->correo_contacto,
            'direccion_atencion' => $servicio->direccion_atencion,
            'imagen_servicio' => $servicio->imagen_servicio,
            'horario_atencion' => $servicio->horario_atencion,
            'estado' => 'Rechazado',
            'motivo_rechazo' => $motivoRechazo,
            'fecha_inicio' => $servicio->fecha_inicio,
            'fecha_fin' => $servicio->fecha_fin,
        ];

        DB::transaction(function () use ($servicio, $rechazoData) {
            DB::table('empresas_servicio_rechazadas')->updateOrInsert(
                ['id_servicio_original' => $servicio->id_servicio],
                $rechazoData
            );

            DB::table('servicios_empresa')->where('id_servicio', $servicio->id_servicio)->update(['estado' => 'Rechazado']);
            DB::table('registro_empresa_servicio')->where('id_empresa_servicio', $servicio->id_empresa_servicio)->update(['estado' => 'Rechazado']);
        });

        return redirect('/admin/formularios-servicios')->with('success', 'Servicio rechazado y enviado a servicios rechazados.');
    }

    public function restaurarServicio($id)
    {
        $servicioRechazado = DB::table('empresas_servicio_rechazadas')->where('id_rechazado', $id)->first();

        if (!$servicioRechazado) {
            return back()->with('error', 'Servicio rechazado no encontrado.');
        }

        DB::transaction(function () use ($servicioRechazado) {
            DB::table('servicios_empresa')
                ->where('id_servicio', $servicioRechazado->id_servicio_original)
                ->update(['estado' => 'Pendiente']);

            DB::table('registro_empresa_servicio')
                ->where('id_empresa_servicio', $servicioRechazado->id_empresa_original)
                ->update(['estado' => 'Pendiente']);

            DB::table('empresas_servicio_rechazadas')
                ->where('id_rechazado', $servicioRechazado->id_rechazado)
                ->delete();
        });

        return back()->with('success', 'Servicio reactivado y devuelto a formularios de servicios.');
    }

    public function verPublicacionServicio($id)
    {
        $servicio = DB::table('servicios_publicos')->where('id_publico_servicio', $id)->first();

        if (!$servicio) {
            return back()->with('error', 'Publicación de servicio no encontrada.');
        }

        return view('admin.ver-publicacion-servicio', compact('servicio'));
    }

    public function desactivarPublicacionServicio($id)
    {
        $servicio = DB::table('servicios_publicos')->where('id_publico_servicio', $id)->first();

        if (!$servicio) {
            return back()->with('error', 'Publicación de servicio no encontrada.');
        }

        DB::table('servicios_publicos')
            ->where('id_publico_servicio', $id)
            ->update(['estado' => 'Desactivado']);

        return back()->with('success', 'Publicación desactivada correctamente.');
    }

    public function reactivarPublicacionServicio($id)
    {
        $servicio = DB::table('servicios_publicos')->where('id_publico_servicio', $id)->first();

        if (!$servicio) {
            return back()->with('error', 'Publicación de servicio no encontrada.');
        }

        DB::table('servicios_publicos')
            ->where('id_publico_servicio', $id)
            ->update(['estado' => 'Publicado']);

        return back()->with('success', 'Publicación reactivada correctamente.');
    }

    public function borrarPublicacionServicio($id)
    {
        $servicio = DB::table('servicios_publicos')->where('id_publico_servicio', $id)->first();

        if (!$servicio) {
            return back()->with('error', 'Publicación de servicio no encontrada.');
        }

        DB::transaction(function () use ($servicio) {
            DB::table('servicios_publicos')
                ->where('id_publico_servicio', $servicio->id_publico_servicio)
                ->delete();

            if (!empty($servicio->id_aprobado)) {
                DB::table('empresas_servicio_aprobadas')
                    ->where('id_aprobado', $servicio->id_aprobado)
                    ->delete();
            }
        });

        return back()->with('success', 'Publicación eliminada correctamente.');
    }

    public function publicacionesServicios(Request $request)
    {
        $query = DB::table('servicios_publicos')
            ->select('servicios_publicos.*', 'servicios_publicos.fecha_publicacion as fecha_registro');

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('nombre_empresa', 'like', '%' . $search . '%')
                    ->orWhere('nombre_servicio', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha_publicacion', '>=', $request->input('fecha_inicio'));
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha_publicacion', '<=', $request->input('fecha_fin'));
        }

        $servicios = $query->orderByDesc('fecha_publicacion')->get();

        $filters = [
            'search' => $request->input('search'),
            'estado' => $request->input('estado'),
            'fecha_inicio' => $request->input('fecha_inicio'),
            'fecha_fin' => $request->input('fecha_fin'),
        ];

        return view('admin.publicaciones-servicios', compact('servicios', 'filters'));
    }

    public function rechazados()
    {
        $servicios = DB::table('empresas_servicio_rechazadas')
            ->select('empresas_servicio_rechazadas.*', 'empresas_servicio_rechazadas.fecha_rechazo as fecha_registro')
            ->orderByDesc('fecha_rechazo')
            ->get();

        return view('admin.servicios-rechazados', compact('servicios'));
    }
}
