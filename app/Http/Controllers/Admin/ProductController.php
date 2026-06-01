<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
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

    public function productos()
    {
        $productos = DB::table('empresas_producto_aprobadas')->orderBy('fecha_aprobacion', 'desc')->get();
        return view('admin.productos', compact('productos'));
    }

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

        return view('admin.ver-producto', compact('producto'));
    }

    public function verProductoAprobado($id)
    {
        $producto = DB::table('empresas_producto_aprobadas')->where('id_aprobado', $id)->first();
        return view('admin.ver-producto-aprobado', compact('producto'));
    }

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

            $archivo->move(public_path('Productos/documentosProductosAprobadosSubgerencia'), $nombreArchivo);

            $documentoSubgerencia = 'Productos/documentosProductosAprobadosSubgerencia/'.$nombreArchivo;
        }

        $rutaDocumentoOriginal = public_path($producto->documento_validacion);
        $nuevoDocumento = 'Productos/documentosProductos/'.basename($producto->documento_validacion);

        if (file_exists($rutaDocumentoOriginal)) {
            rename($rutaDocumentoOriginal, public_path($nuevoDocumento));
        }

        $rutaImagenOriginal = public_path($producto->imagen_producto);
        $nuevaImagen = 'Productos/imagenesProductos/'.basename($producto->imagen_producto);

        if (file_exists($rutaImagenOriginal)) {
            rename($rutaImagenOriginal, public_path($nuevaImagen));
        }

        $idAprobado = DB::table('empresas_producto_aprobadas')->insertGetId([
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
            'nombre_producto' => $producto->nombre_producto,
            'descripcion' => $producto->descripcion,
            'categoria' => $producto->categoria,
            'ubicacion_ciudad' => $producto->ubicacion_ciudad,
            'telefono_contacto' => $producto->telefono_contacto,
            'redes_sociales' => $producto->redes_sociales,
            'correo_contacto' => $producto->correo_contacto,
            'direccion_atencion' => $producto->direccion_atencion,
            'imagen_producto' => $nuevaImagen,
            'estado' => 'APROBADO',
            'documento_aprobacion_pdf' => $documentoSubgerencia,
            'fecha_inicio' => $producto->fecha_inicio,
            'fecha_fin' => $producto->fecha_fin
        ]);

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
            'fecha_inicio' => $producto->fecha_inicio,
            'fecha_fin' => $producto->fecha_fin
        ]);

        DB::table('productos_empresa')->where('id_empresa_producto', $id)->delete();
        DB::table('registro_empresa_producto')->where('id_empresa_producto', $id)->delete();

        return redirect('admin/formularios-productos')->with('success', 'Producto aprobado correctamente');
    }

    public function rechazarProducto($id)
    {
        DB::table('productos_empresa')->where('id_empresa_producto', $id)->delete();
        DB::table('registro_empresa_producto')->where('id_empresa_producto', $id)->delete();
    }

}
