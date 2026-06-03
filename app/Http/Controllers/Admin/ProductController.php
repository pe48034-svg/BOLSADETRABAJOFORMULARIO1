<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProductController extends Controller
{
    // ===================================
    // FORMULARIOS PENDIENTES
    // ===================================
    public function formulariosProductos()
    {
        $productos = DB::table('registro_empresa_producto as e')
            ->join('productos_empresa as p', 'e.id_empresa_producto', '=', 'p.id_empresa_producto')
            ->select(
                'e.*',
                'p.id_producto',
                'p.nombre_producto',
                'p.descripcion',
                'p.categoria',
                'p.ubicacion_ciudad',
                'p.telefono_contacto',
                'p.redes_sociales',
                'p.correo_contacto',
                'p.direccion_atencion',
                'p.imagen_producto',
                'p.estado as estado_producto',
                'p.fecha_inicio',
                'p.fecha_fin'
            )
            ->get();

        return view('admin.formularios-productos', compact('productos'));
    }

    // ===================================
    // PRODUCTOS APROBADOS
    // ===================================
    public function productos()
    {
        $query = DB::table('empresas_producto_aprobadas');

        // Filtro por búsqueda (empresa o producto)
        if (request('buscar')) {
            $buscar = request('buscar');
            $query->where(function($q) use ($buscar) {
                $q->where('nombre_empresa', 'like', '%' . $buscar . '%')
                  ->orWhere('nombre_producto', 'like', '%' . $buscar . '%');
            });
        }

        // Filtro por estado
        if (request('estado') && request('estado') !== 'todos') {
            $query->where('estado', request('estado'));
        }

        // Filtro por rango de fechas
        if (request('fecha_inicio')) {
            $query->whereDate('fecha_inicio', '>=', request('fecha_inicio'));
        }
        if (request('fecha_fin')) {
            $query->whereDate('fecha_fin', '<=', request('fecha_fin'));
        }

        $productos = $query->orderBy('fecha_aprobacion', 'desc')->get();

        // Para el dropdown de empresas
        $empresas = DB::table('empresas_producto_aprobadas')
            ->select('nombre_empresa')
            ->distinct()
            ->orderBy('nombre_empresa')
            ->pluck('nombre_empresa');

        // Para el dropdown de estados (solo Publicado y Desactivado)
        $estados = ['Publicado', 'Desactivado'];

        return view('admin.productos', compact('productos', 'empresas', 'estados'));
    }

    // ===================================
    // PRODUCTOS RECHAZADOS
    // ===================================
    public function rechazados()
    {
        if (Schema::hasTable('empresas_producto_rechazadas')) {
            $productos = DB::table('empresas_producto_rechazadas')->orderBy('fecha_rechazo', 'desc')->get();
        } elseif (Schema::hasTable('empresas_bolsadetrabajo_rechazadas')) {
            $productos = DB::table('empresas_bolsadetrabajo_rechazadas')
                ->select(
                    'id_rechazado',
                    'nombre_empresa',
                    'ruc',
                    'titulo_puesto as nombre_producto',
                    'categoria',
                    'ubicacion as ubicacion_ciudad',
                    'documento_validacion',
                    'fecha_rechazo'
                )
                ->orderBy('fecha_rechazo', 'desc')
                ->get();
        } else {
            $productos = DB::table('registro_empresa_producto as e')
                ->join('productos_empresa as p', 'e.id_empresa_producto', '=', 'p.id_empresa_producto')
                ->where('p.estado', 'Rechazado')
                ->select('e.*', 'p.*')
                ->get();
        }

        return view('admin.productos-rechazados', compact('productos'));
    }

    // ===================================
    // VER PRODUCTO PENDIENTE
    // ===================================
    public function verProducto($id)
    {
        $producto = DB::table('registro_empresa_producto as e')
            ->join('productos_empresa as p', 'e.id_empresa_producto', '=', 'p.id_empresa_producto')
            ->where('e.id_empresa_producto', $id)
            ->select(
                'e.*',
                'p.id_producto',
                'p.nombre_producto',
                'p.descripcion',
                'p.categoria',
                'p.ubicacion_ciudad',
                'p.telefono_contacto',
                'p.redes_sociales',
                'p.correo_contacto',
                'p.direccion_atencion',
                'p.imagen_producto',
                'p.estado as estado_producto',
                'p.fecha_inicio',
                'p.fecha_fin'
            )
            ->first();

        if (!$producto) {
            return redirect('/admin/formularios-productos')->with('error', 'Producto no encontrado');
        }

        return view('admin.ver-producto', compact('producto'));
    }

    // ===================================
    // VER PRODUCTO APROBADO
    // ===================================
    public function verProductoAprobado($id)
    {
        $producto = DB::table('empresas_producto_aprobadas')->where('id_aprobado', $id)->first();
        return view('admin.ver-producto-aprobado', compact('producto'));
    }

    // ===================================
    // APROBAR PRODUCTO
    // ===================================
    public function aprobarProducto(Request $request, $id)
    {
        $producto = DB::table('registro_empresa_producto as e')
            ->join('productos_empresa as p', 'e.id_empresa_producto', '=', 'p.id_empresa_producto')
            ->where('e.id_empresa_producto', $id)
            ->select(
                'e.*',
                'p.id_producto',
                'p.nombre_producto',
                'p.descripcion',
                'p.categoria',
                'p.ubicacion_ciudad',
                'p.telefono_contacto',
                'p.redes_sociales',
                'p.correo_contacto',
                'p.direccion_atencion',
                'p.imagen_producto',
                'p.estado as estado_producto',
                'p.fecha_inicio',
                'p.fecha_fin'
            )
            ->first();

        $documentoSubgerencia = '';

        if ($request->hasFile('documento_validacion_subgerencia')) {
            $archivo = $request->file('documento_validacion_subgerencia');
            $nombreArchivo = time().'_'.$archivo->getClientOriginalName();

            $rutaSubgerencia = public_path('Productos/documentosProductosAprobadosSubgerencia');

            if (!file_exists($rutaSubgerencia)) {
                mkdir($rutaSubgerencia, 0777, true);
            }

            $archivo->move($rutaSubgerencia, $nombreArchivo);

            $documentoSubgerencia = 'Productos/documentosProductosAprobadosSubgerencia/'.$nombreArchivo;
        }

        $rutaDocumentosAprobados = public_path('Productos/documentosProductosAprobados');

        if (!file_exists($rutaDocumentosAprobados)) {
            mkdir($rutaDocumentosAprobados, 0777, true);
        }

        $rutaDocumentoOriginal = public_path($producto->documento_validacion);
        $nuevoDocumento = 'Productos/documentosProductosAprobados/'.basename($producto->documento_validacion);

        if (file_exists($rutaDocumentoOriginal)) {
            copy($rutaDocumentoOriginal, public_path($nuevoDocumento));
        }

        $rutaImagenOriginal = public_path($producto->imagen_producto);
        $nuevaImagen = $producto->imagen_producto ?: '';

        if (!empty($producto->imagen_producto) && file_exists($rutaImagenOriginal) && is_file($rutaImagenOriginal)) {
            $ext = strtolower(pathinfo($rutaImagenOriginal, PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];

            if (in_array($ext, $allowed)) {
                $destDir = public_path('Productos/imagenesProductosAprobados');
                if (!file_exists($destDir)) {
                    mkdir($destDir, 0777, true);
                }

                $nuevaImagen = 'Productos/imagenesProductosAprobados/'.basename($producto->imagen_producto);

                try {
                    copy($rutaImagenOriginal, public_path($nuevaImagen));
                } catch (\Exception $e) {
                    $nuevaImagen = $producto->imagen_producto ?: '';
                }
            }
        }

        $insertData = [
            'id_empresa_original' => $producto->id_empresa_producto,
            'id_producto_original' => $producto->id_producto,
            'id_usuario_aprobador' => 1,
            'nombre_empresa' => $producto->nombre_empresa,
            'ruc' => $producto->ruc,
            'correo_electronico' => $producto->correo_electronico,
            'telefono' => $producto->telefono,
            'responsable_representante' => $producto->responsable_representante,
            'direccion' => $producto->direccion,
            'documento_validacion' => $nuevoDocumento,
            'documento_aprobacion_pdf' => $documentoSubgerencia ?: '',
            'nombre_producto' => $producto->nombre_producto,
            'descripcion' => $producto->descripcion,
            'categoria' => $producto->categoria,
            'ubicacion_ciudad' => $producto->ubicacion_ciudad,
            'telefono_contacto' => $producto->telefono_contacto,
            'redes_sociales' => $producto->redes_sociales,
            'correo_contacto' => $producto->correo_contacto,
            'direccion_atencion' => $producto->direccion_atencion,
            'imagen_producto' => $nuevaImagen,
            'fecha_inicio' => $producto->fecha_inicio,
            'fecha_fin' => $producto->fecha_fin,
        ];

        if (Schema::hasColumn('empresas_producto_aprobadas', 'created_at')) {
            $insertData['created_at'] = now();
        }

        if (Schema::hasColumn('empresas_producto_aprobadas', 'updated_at')) {
            $insertData['updated_at'] = now();
        }

        $idAprobado = DB::table('empresas_producto_aprobadas')->insertGetId($insertData);

        DB::table('productos_publicos')->insert([
            'id_aprobado' => $idAprobado,
            'nombre_empresa' => $producto->nombre_empresa,
            'nombre_producto' => $producto->nombre_producto,
            'descripcion' => $producto->descripcion,
            'categoria' => $producto->categoria,
            'ubicacion_ciudad' => $producto->ubicacion_ciudad,
            'telefono_contacto' => $producto->telefono_contacto,
            'redes_sociales' => $producto->redes_sociales,
            'correo_contacto' => $producto->correo_contacto,
            'direccion_atencion' => $producto->direccion_atencion,
            'imagen_producto' => $nuevaImagen,
            'estado' => 'Publicado',
            'fecha_inicio' => $producto->fecha_inicio,
            'fecha_fin' => $producto->fecha_fin,
        ]);

        DB::table('productos_empresa')->where('id_empresa_producto', $id)->delete();
        DB::table('registro_empresa_producto')->where('id_empresa_producto', $id)->delete();

        return back()->with('success', 'Producto aprobado correctamente');
    }

    // ===================================
    // RECHAZAR PRODUCTO
    // ===================================
    public function rechazarProducto($id)
    {
        $producto = DB::table('registro_empresa_producto as e')
            ->join('productos_empresa as p', 'e.id_empresa_producto', '=', 'p.id_empresa_producto')
            ->where('e.id_empresa_producto', $id)
            ->select(
                'e.*',
                'p.id_producto',
                'p.nombre_producto',
                'p.descripcion',
                'p.categoria',
                'p.ubicacion_ciudad',
                'p.telefono_contacto',
                'p.redes_sociales',
                'p.correo_contacto',
                'p.direccion_atencion',
                'p.imagen_producto',
                'p.estado as estado_producto',
                'p.fecha_inicio',
                'p.fecha_fin'
            )
            ->first();

        if (!$producto) {
            return back();
        }

        if (Schema::hasTable('empresas_producto_rechazadas')) {
            $rechazadoData = [
                'id_empresa_original' => $producto->id_empresa_producto,
                'id_producto_original' => $producto->id_producto,
                'nombre_empresa' => $producto->nombre_empresa,
                'ruc' => $producto->ruc,
                'correo_electronico' => $producto->correo_electronico,
                'telefono' => $producto->telefono,
                'responsable_representante' => $producto->responsable_representante,
                'direccion' => $producto->direccion,
                'documento_validacion' => $producto->documento_validacion,
                'nombre_producto' => $producto->nombre_producto,
                'descripcion' => $producto->descripcion,
                'categoria' => $producto->categoria,
                'ubicacion_ciudad' => $producto->ubicacion_ciudad,
                'telefono_contacto' => $producto->telefono_contacto,
                'redes_sociales' => $producto->redes_sociales,
                'correo_contacto' => $producto->correo_contacto,
                'direccion_atencion' => $producto->direccion_atencion,
                'imagen_producto' => $producto->imagen_producto,
                'fecha_inicio' => $producto->fecha_inicio,
                'fecha_fin' => $producto->fecha_fin,
            ];

            if (Schema::hasColumn('empresas_producto_rechazadas', 'id_usuario_rechazo')) {
                $rechazadoData['id_usuario_rechazo'] = 1;
            }

            if (Schema::hasColumn('empresas_producto_rechazadas', 'motivo_rechazo')) {
                $rechazadoData['motivo_rechazo'] = '';
            }

            if (Schema::hasColumn('empresas_producto_rechazadas', 'created_at')) {
                $rechazadoData['created_at'] = now();
            }

            if (Schema::hasColumn('empresas_producto_rechazadas', 'updated_at')) {
                $rechazadoData['updated_at'] = now();
            }

            DB::table('empresas_producto_rechazadas')->insert($rechazadoData);
        } elseif (Schema::hasTable('empresas_bolsadetrabajo_rechazadas')) {
            $rechazadoData = [
                'id_empresa_original' => $producto->id_empresa_producto,
                'id_publicacion_original' => $producto->id_producto,
                'id_usuario_rechazador' => 1,
                'nombre_empresa' => $producto->nombre_empresa,
                'ruc' => $producto->ruc,
                'correo_electronico' => $producto->correo_electronico,
                'telefono' => $producto->telefono,
                'responsable_representante' => $producto->responsable_representante,
                'direccion' => $producto->direccion,
                'documento_validacion' => $producto->documento_validacion,
                'titulo_puesto' => $producto->nombre_producto,
                'descripcion_puesto' => $producto->descripcion,
                'requisitos' => null,
                'imagen_trabajo' => $producto->imagen_producto,
                'modalidad' => 'Producto',
                'categoria' => $producto->categoria,
                'salario_minimo' => null,
                'salario_maximo' => null,
                'ubicacion' => $producto->ubicacion_ciudad,
                'fecha_inicio_convocatoria' => $producto->fecha_inicio,
                'fecha_limite_postulacion' => $producto->fecha_fin,
                'veces_restaurado' => 0,
            ];

            if (Schema::hasColumn('empresas_bolsadetrabajo_rechazadas', 'created_at')) {
                $rechazadoData['created_at'] = now();
            }

            if (Schema::hasColumn('empresas_bolsadetrabajo_rechazadas', 'updated_at')) {
                $rechazadoData['updated_at'] = now();
            }

            DB::table('empresas_bolsadetrabajo_rechazadas')->insert($rechazadoData);
        }

        DB::table('productos_empresa')->where('id_empresa_producto', $id)->delete();
        DB::table('registro_empresa_producto')->where('id_empresa_producto', $id)->delete();

        return back()->with('success', 'Producto rechazado correctamente');
    }

    // ===================================
    // RESTAURAR PRODUCTO RECHAZADO
    // ===================================
    public function restaurar($id)
    {
        if (Schema::hasTable('empresas_producto_rechazadas')) {
            $producto = DB::table('empresas_producto_rechazadas')->where('id_rechazado', $id)->first();

            if (!$producto) {
                return back()->with('error', 'No se encontró el producto para restaurar.');
            }

            $insertData = [
                'id_empresa_producto' => null,
                'nombre_empresa' => $producto->nombre_empresa,
                'ruc' => $producto->ruc,
                'correo_electronico' => $producto->correo_electronico,
                'telefono' => $producto->telefono,
                'responsable_representante' => $producto->responsable_representante,
                'direccion' => $producto->direccion,
                'documento_validacion' => $producto->documento_validacion,
            ];

            $idEmpresa = DB::table('registro_empresa_producto')->insertGetId($insertData);

            $productoData = [
                'id_empresa_producto' => $idEmpresa,
                'nombre_producto' => $producto->nombre_producto,
                'descripcion' => $producto->descripcion,
                'categoria' => $producto->categoria,
                'ubicacion_ciudad' => $producto->ubicacion_ciudad,
                'telefono_contacto' => $producto->telefono_contacto,
                'redes_sociales' => $producto->redes_sociales,
                'correo_contacto' => $producto->correo_contacto,
                'direccion_atencion' => $producto->direccion_atencion,
                'imagen_producto' => $producto->imagen_producto,
                'estado' => 'Pendiente',
                'fecha_inicio' => $producto->fecha_inicio,
                'fecha_fin' => $producto->fecha_fin,
            ];

            if (Schema::hasColumn('productos_empresa', 'created_at')) {
                $productoData['created_at'] = now();
            }

            if (Schema::hasColumn('productos_empresa', 'updated_at')) {
                $productoData['updated_at'] = now();
            }

            DB::table('productos_empresa')->insert($productoData);

            DB::table('empresas_producto_rechazadas')->where('id_rechazado', $id)->delete();

            return back()->with('success', 'Producto restaurado correctamente');
        }

        if (Schema::hasTable('empresas_bolsadetrabajo_rechazadas')) {
            $producto = DB::table('empresas_bolsadetrabajo_rechazadas')->where('id_rechazado', $id)->first();

            if (!$producto) {
                return back()->with('error', 'No se encontró el producto para restaurar.');
            }

            $insertData = [
                'id_empresa_producto' => null,
                'nombre_empresa' => $producto->nombre_empresa,
                'ruc' => $producto->ruc,
                'correo_electronico' => $producto->correo_electronico,
                'telefono' => $producto->telefono,
                'responsable_representante' => $producto->responsable_representante,
                'direccion' => $producto->direccion,
                'documento_validacion' => $producto->documento_validacion,
            ];

            $idEmpresa = DB::table('registro_empresa_producto')->insertGetId($insertData);

            $productoData = [
                'id_empresa_producto' => $idEmpresa,
                'nombre_producto' => $producto->titulo_puesto,
                'descripcion' => $producto->descripcion_puesto,
                'categoria' => $producto->categoria,
                'ubicacion_ciudad' => $producto->ubicacion,
                'telefono_contacto' => $producto->telefono,
                'redes_sociales' => null,
                'correo_contacto' => $producto->correo_electronico,
                'direccion_atencion' => $producto->direccion,
                'imagen_producto' => $producto->imagen_trabajo,
                'estado' => 'Pendiente',
                'fecha_inicio' => $producto->fecha_inicio_convocatoria,
                'fecha_fin' => $producto->fecha_limite_postulacion,
            ];

            if (Schema::hasColumn('productos_empresa', 'created_at')) {
                $productoData['created_at'] = now();
            }

            if (Schema::hasColumn('productos_empresa', 'updated_at')) {
                $productoData['updated_at'] = now();
            }

            DB::table('productos_empresa')->insert($productoData);

            DB::table('empresas_bolsadetrabajo_rechazadas')->where('id_rechazado', $id)->delete();

            return back()->with('success', 'Producto restaurado correctamente');
        }

        return back()->with('error', 'No se puede restaurar este producto.');
    }

    // ===================================
    // ELIMINAR PUBLICACIÓN
    // ===================================
    public function eliminarProducto($id)
    {
        $producto = DB::table('empresas_producto_aprobadas')
            ->where('id_aprobado', $id)
            ->first();

        if (!$producto) {
            return back()->with('error', 'Publicación no encontrada');
        }

        // Marcar como desactivado en lugar de eliminar (mejor para auditoría)
        DB::table('empresas_producto_aprobadas')
            ->where('id_aprobado', $id)
            ->update(['estado' => 'Desactivado']);

        // También desactivar en la tabla de públicos
        DB::table('productos_publicos')
            ->where('estado', 'Publicado')
            ->whereRaw(
                'LOWER(nombre_producto) = LOWER(?) AND LOWER(nombre_empresa) = LOWER(?)',
                [$producto->nombre_producto, $producto->nombre_empresa ?? '']
            )
            ->update(['estado' => 'Desactivado']);

        return redirect('/admin/productos')
            ->with('success', 'Publicación desactivada correctamente');
    }

    // ===================================
    // BORRAR PUBLICACIÓN PERMANENTEMENTE
    // ===================================
    public function borrarProducto($id)
    {
        $producto = DB::table('empresas_producto_aprobadas')
            ->where('id_aprobado', $id)
            ->first();

        if (!$producto) {
            return back()->with('error', 'Publicación no encontrada');
        }

        DB::table('productos_publicos')
            ->whereRaw('LOWER(nombre_producto) = LOWER(?) AND LOWER(nombre_empresa) = LOWER(?)', [
                $producto->nombre_producto,
                $producto->nombre_empresa ?? ''
            ])
            ->delete();

        DB::table('empresas_producto_aprobadas')
            ->where('id_aprobado', $id)
            ->delete();

        return redirect('/admin/productos')
            ->with('success', 'Publicación eliminada correctamente');
    }

    // ===================================
    // REACTIVAR PUBLICACIÓN
    // ===================================
    public function reactivarProducto($id)
    {
        $producto = DB::table('empresas_producto_aprobadas')
            ->where('id_aprobado', $id)
            ->first();

        if (!$producto) {
            return back()->with('error', 'Publicación no encontrada');
        }

        // Marcar como publicado en lugar de desactivado
        DB::table('empresas_producto_aprobadas')
            ->where('id_aprobado', $id)
            ->update(['estado' => 'Publicado']);

        // También reactivar en la tabla de públicos
        DB::table('productos_publicos')
            ->whereRaw(
                'LOWER(nombre_producto) = LOWER(?) AND LOWER(nombre_empresa) = LOWER(?)',
                [$producto->nombre_producto, $producto->nombre_empresa ?? '']
            )
            ->update(['estado' => 'Publicado']);

        return redirect('/admin/productos')
            ->with('success', 'Publicación reactivada correctamente');
    }

    // ===================================
    // DESACTIVAR PRODUCTOS VENCIDOS
    // ===================================
    public function desactivarVencidos()
    {
        $hoy = \Carbon\Carbon::now()->startOfDay();

        // Desactivar en empresas_producto_aprobadas
        DB::table('empresas_producto_aprobadas')
            ->where('fecha_fin', '<', $hoy)
            ->where('estado', '!=', 'Desactivado')
            ->update(['estado' => 'Desactivado']);

        // Desactivar en productos_publicos
        DB::table('productos_publicos')
            ->where('fecha_fin', '<', $hoy)
            ->where('estado', '!=', 'Desactivado')
            ->update(['estado' => 'Desactivado']);

        return response()->json(['message' => 'Productos vencidos desactivados']);
    }

}
