<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ZipArchive;

class AdminController extends Controller
{

    // =====================================================
    // VALIDACION DE FORMULARIOS
    // =====================================================

    public function validacion()
    {

        $empresas = DB::table(
            'registro_bolsadetrabajo_empresa as e'
        )

        ->join(
            'publicaciones_trabajo as p',
            'e.id_empresa',
            '=',
            'p.id_empresa'
        )

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

        return view(
            'admin.validacion-formularios',
            compact('empresas')
        );

    }


    // =====================================================
    // BOLSA DE TRABAJO
    // =====================================================

    public function bolsaTrabajo()
    {

        $empresas = DB::table(
            'empresas_bolsadetrabajo_aprobadas'
        )->get();

        return view(
            'admin.bolsa-trabajo',
            compact('empresas')
        );

    }


    // =====================================================
    // APROBAR EMPRESA
    // =====================================================

    public function aprobar(Request $request, $id)
    {

        $empresa = DB::table(
            'registro_bolsadetrabajo_empresa as e'
        )

        ->join(
            'publicaciones_trabajo as p',
            'e.id_empresa',
            '=',
            'p.id_empresa'
        )

        ->where(
            'e.id_empresa',
            $id
        )

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


        // =====================================================
        // DOCUMENTO SUBGERENCIA
        // =====================================================

        $documentoSubgerencia = '';

        if (
            $request->hasFile(
                'documento_validacion_subgerencia'
            )
        ) {

            $archivo = $request->file(
                'documento_validacion_subgerencia'
            );

            $nombreArchivo =
                time().'_'.
                $archivo->getClientOriginalName();


            $rutaSubgerencia = public_path(

                'BolsaTrabajo/documentosAprobadosSubgerenciaEmpleo'

            );


            if (!file_exists($rutaSubgerencia)) {

                mkdir(
                    $rutaSubgerencia,
                    0777,
                    true
                );

            }


            $archivo->move(

                $rutaSubgerencia,

                $nombreArchivo

            );


            $documentoSubgerencia =

                'BolsaTrabajo/documentosAprobadosSubgerenciaEmpleo/'.
                $nombreArchivo;

        }


        // =====================================================
        // CREAR CARPETA DOCUMENTOS APROBADOS
        // =====================================================

        $rutaDocumentosAprobados = public_path(

            'BolsaTrabajo/documentosBolsaDeTrabajoAprobados'

        );

        if (!file_exists($rutaDocumentosAprobados)) {

            mkdir(
                $rutaDocumentosAprobados,
                0777,
                true
            );

        }


        // =====================================================
        // CREAR CARPETA IMAGENES APROBADAS
        // =====================================================

        $rutaImagenesAprobadas = public_path(

            'BolsaTrabajo/imagenesBolsaTrabajoAprobados'
    
        );

        if (!file_exists($rutaImagenesAprobadas)) {

            mkdir(
                $rutaImagenesAprobadas,
                0777,
                true
            );

        }


        // =====================================================
        // COPIAR DOCUMENTO
        // =====================================================

        $rutaDocumentoOriginal =
            public_path(
                $empresa->documento_validacion
            );

        $nuevoDocumento =

            'BolsaTrabajo/documentosBolsaDeTrabajoAprobados/'.

            basename(
                $empresa->documento_validacion
            );


        if (
            file_exists(
                $rutaDocumentoOriginal
            )
        ) {

            copy(

                $rutaDocumentoOriginal,

                public_path(
                    $nuevoDocumento
                )

            );

        }


        // =====================================================
        // COPIAR IMAGEN
        // =====================================================

        $rutaImagenOriginal =
            public_path(
                $empresa->imagen_trabajo
            );

        $nuevaImagen =

            'BolsaTrabajo/imagenesBolsaDeTrabajoAprobados/'.

            basename(
                $empresa->imagen_trabajo
            );


        if (
            file_exists(
                $rutaImagenOriginal
            )
        ) {

            copy(

                $rutaImagenOriginal,

                public_path(
                    $nuevaImagen
                )

            );

        }


        // =====================================================
        // INSERTAR APROBADAS
        // =====================================================

        DB::table(
            'empresas_bolsadetrabajo_aprobadas'
        )->insert([

            'id_empresa_original' =>
            $empresa->id_empresa,

            'id_publicacion_original' =>
            $empresa->id_publicacion,

            'id_usuario_aprobador' =>
            1,

            'nombre_empresa' =>
            $empresa->nombre_empresa,

            'ruc' =>
            $empresa->ruc,

            'correo_electronico' =>
            $empresa->correo_electronico,

            'telefono' =>
            $empresa->telefono,

            'responsable_representante' =>
            $empresa->responsable_representante,

            'direccion' =>
            $empresa->direccion,

            'documento_validacion' =>
            $nuevoDocumento,

            'documento_aprobacion_pdf' =>
            $documentoSubgerencia,

            'titulo_puesto' =>
            $empresa->titulo_puesto,

            'descripcion_puesto' =>
            $empresa->descripcion_puesto,

            'requisitos' =>
            $empresa->requisitos,

            'imagen_trabajo' =>
            $nuevaImagen,

            'modalidad' =>
            $empresa->modalidad,

            'categoria' =>
            $empresa->categoria,

            'salario_minimo' =>
            $empresa->salario_minimo,

            'salario_maximo' =>
            $empresa->salario_maximo,

            'ubicacion' =>
            $empresa->ubicacion,

            'fecha_inicio_convocatoria' =>
            $empresa->fecha_inicio_convocatoria,

            'fecha_limite_postulacion' =>
            $empresa->fecha_limite_postulacion

        ]);


        // =====================================================
        // ELIMINAR PENDIENTES
        // =====================================================

        DB::table(
            'publicaciones_trabajo'
        )

        ->where(
            'id_empresa',
            $id
        )

        ->delete();


        DB::table(
            'registro_bolsadetrabajo_empresa'
        )

        ->where(
            'id_empresa',
            $id
        )

        ->delete();


        return back();

    }


    // =====================================================
    // RECHAZAR
    // =====================================================

    public function rechazar($id)
    {

        DB::table(
            'registro_bolsadetrabajo_empresa'
        )

        ->where(
            'id_empresa',
            $id
        )

        ->delete();


        DB::table(
            'publicaciones_trabajo'
        )

        ->where(
            'id_empresa',
            $id
        )

        ->delete();


        return back();

    }


    // =====================================================
    // VER
    // =====================================================

    public function ver($id)
    {

        $empresa = DB::table(
            'registro_bolsadetrabajo_empresa as e'
        )

        ->join(
            'publicaciones_trabajo as p',
            'e.id_empresa',
            '=',
            'p.id_empresa'
        )

        ->where(
            'e.id_empresa',
            $id
        )

        ->select(

            'e.*',

            'p.*'

        )

        ->first();


        return view(
            'admin.ver',
            compact('empresa')
        );

    }


    // =====================================================
    // SUBIR DOCUMENTO
    // =====================================================

    public function subirDocumento(Request $request, $id)
    {

        if (
            !$request->hasFile(
                'documento_pdf'
            )
        ) {

            return back();

        }


        $pdf = $request->file(
            'documento_pdf'
        );


        $archivo =
            time().'_'.
            $pdf->getClientOriginalName();


        $ruta = public_path(

            'BolsaTrabajo/documentosAprobadosSubgerenciaEmpleo'

        );


        if (!file_exists($ruta)) {

            mkdir(
                $ruta,
                0777,
                true
            );

        }


        $pdf->move(
            $ruta,
            $archivo
        );

        $empresaAprobada = DB::table(
            'empresas_bolsadetrabajo_aprobadas'
        )
        ->where(
            'id_aprobado',
            $id
        )
        ->first();

        if (
            $empresaAprobada &&
            !empty($empresaAprobada->documento_aprobacion_pdf) &&
            file_exists(public_path($empresaAprobada->documento_aprobacion_pdf))
        ) {
            unlink(public_path($empresaAprobada->documento_aprobacion_pdf));
        }

        DB::table(
            'empresas_bolsadetrabajo_aprobadas'
        )

        ->where(
            'id_aprobado',
            $id
        )

        ->update([

            'documento_aprobacion_pdf' =>

            'BolsaTrabajo/documentosAprobadosSubgerenciaEmpleo/'.
            $archivo

        ]);


        $empresa = DB::table(
            'empresas_bolsadetrabajo_aprobadas'
        )

        ->where(
            'id_aprobado',
            $id
        )

        ->first();


        DB::table(
            'publicaciones_publicas'
        )->insert([

            'id_aprobado' =>
            $empresa->id_aprobado,

            'nombre_empresa' =>
            $empresa->nombre_empresa,

            'titulo_puesto' =>
            $empresa->titulo_puesto,

            'descripcion_puesto' =>
            $empresa->descripcion_puesto,

            'requisitos' =>
            $empresa->requisitos,

            'imagen_trabajo' =>
            $empresa->imagen_trabajo,

            'modalidad' =>
            $empresa->modalidad,

            'categoria' =>
            $empresa->categoria,

            'salario_minimo' =>
            $empresa->salario_minimo,

            'salario_maximo' =>
            $empresa->salario_maximo,

            'ubicacion' =>
            $empresa->ubicacion,

            'fecha_inicio_convocatoria' =>
            $empresa->fecha_inicio_convocatoria,

            'fecha_limite_postulacion' =>
            $empresa->fecha_limite_postulacion

        ]);


        return back();

    }



// =====================================================
// TABLA POSTULANTES
// =====================================================

public function postulantes()
{

    $ofertas = DB::table(
        'publicaciones_publicas as p'
    )

    ->leftJoin(
        'postulaciones as po',
        'p.id_publica',
        '=',
        'po.id_publica'
    )

    ->select(

        'p.id_publica',

        'p.nombre_empresa',

        'p.titulo_puesto',

        DB::raw(
            'COUNT(po.id_postulacion)
            as total_postulados'
        )

    )

    ->groupBy(

        'p.id_publica',

        'p.nombre_empresa',

        'p.titulo_puesto'

    )

    ->get();


    return view(
        'admin.postulantes',
        compact('ofertas')
    );

}


// =====================================================
// VER POSTULANTES
// =====================================================

public function verPostulantes($id)
{

    $postulantes = DB::table(
        'postulaciones as po'
    )

    ->join(
        'postulantes as p',
        'po.id_postulante',
        '=',
        'p.id_postulante'
    )

    ->where(
        'po.id_publica',
        $id
    )

    ->select(

    'p.*',

    'po.id_postulacion',

    'po.curriculum_pdf'

    )

    ->get();


    return view(
        'admin.ver-postulantes',
        compact('postulantes')
    );

}


// =====================================================
// VER CV
// =====================================================

public function verCV($id)
{

    $cv = DB::table(
        'postulaciones'
    )

    ->where(
        'id_postulacion',
        $id
    )

    ->first();

    if (!$cv || !file_exists(public_path($cv->curriculum_pdf))) {
        abort(404, 'Currículum no encontrado');
    }

    return response()->file(
        public_path(
            $cv->curriculum_pdf
        ),
        ['Content-Disposition' => 'inline']
    );

}

public function visualizarCV($id)
{
    $cv = DB::table(
        'postulaciones'
    )
    ->where(
        'id_postulacion',
        $id
    )
    ->first();

    if (!$cv || !file_exists(public_path($cv->curriculum_pdf))) {
        abort(404, 'Currículum no encontrado');
    }

    return view('admin.visualizar-cv', compact('cv'));
}

public function eliminarDocumento($id)
{
    $empresa = DB::table(
        'empresas_bolsadetrabajo_aprobadas'
    )
    ->where(
        'id_aprobado',
        $id
    )
    ->first();

    if ($empresa && !empty($empresa->documento_aprobacion_pdf)) {
        $ruta = public_path($empresa->documento_aprobacion_pdf);
        if (file_exists($ruta)) {
            unlink($ruta);
        }

        DB::table(
            'empresas_bolsadetrabajo_aprobadas'
        )
        ->where(
            'id_aprobado',
            $id
        )
        ->update([
            'documento_aprobacion_pdf' => null
        ]);
    }

    return back();
}


// =====================================================
// DESCARGAR CV
// =====================================================

public function descargarCV($id)
{

    $cv = DB::table(
        'postulaciones'
    )

    ->where(
        'id_postulacion',
        $id
    )

    ->first();


    return response()->download(

        public_path(
            $cv->curriculum_pdf
        )

    );

}


// =====================================================
// DESCARGAR TODOS LOS CVS
// =====================================================

public function descargarTodosCV($id)
{

    $postulaciones = DB::table(
        'postulaciones'
    )

    ->where(
        'id_publica',
        $id
    )

    ->get();


    $zip = new ZipArchive;

    $nombreZip =
    'CV_Postulantes_'.$id.'.zip';


    $rutaZip = public_path(
        $nombreZip
    );


    if (

        $zip->open(
            $rutaZip,
            ZipArchive::CREATE
        ) === TRUE

    ) {

        foreach (
            $postulaciones as $postulacion
        ) {

            $rutaArchivo = public_path(
                $postulacion->curriculum_pdf
            );

            if (
                file_exists($rutaArchivo)
            ) {

                $zip->addFile(

                    $rutaArchivo,

                    basename($rutaArchivo)

                );

            }

        }

        $zip->close();

    }


    return response()->download(
        $rutaZip
    );

}




// =====================================================
// FORMULARIOS PRODUCTOS
// =====================================================

public function formulariosProductos()
{

    $productos = DB::table(
        'registro_empresa_producto as e'
    )

    ->join(
        'productos_empresa as p',
        'e.id_empresa_producto',
        '=',
        'p.id_empresa_producto'
    )

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


    return view(
        'admin.formularios-productos',
        compact('productos')
    );

}


// =====================================================
// PRODUCTOS APROBADOS
// =====================================================

public function productos()
{

    $productos = DB::table(
        'empresas_producto_aprobadas'
    )

    ->orderBy(
        'fecha_aprobacion',
        'desc'
    )

    ->get();


    return view(
        'admin.productos',
        compact('productos')
    );

}


// =====================================================
// VER PRODUCTO PENDIENTE
// =====================================================

public function verProducto($id)
{

    $producto = DB::table(
        'registro_empresa_producto as e'
    )

    ->join(
        'productos_empresa as p',
        'e.id_empresa_producto',
        '=',
        'p.id_empresa_producto'
    )

    ->where(
        'e.id_empresa_producto',
        $id
    )

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


    return view(
        'admin.ver-producto',
        compact('producto')
    );

}


// =====================================================
// APROBAR PRODUCTO
// =====================================================

public function aprobarProducto(Request $request, $id)
{

    // =====================================================
    // OBTENER PRODUCTO
    // =====================================================

    $producto = DB::table(
        'registro_empresa_producto as e'
    )

    ->join(
        'productos_empresa as p',
        'e.id_empresa_producto',
        '=',
        'p.id_empresa_producto'
    )

    ->where(
        'e.id_empresa_producto',
        $id
    )

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


    // =====================================================
    // DOCUMENTO SUBGERENCIA
    // =====================================================

    $documentoSubgerencia = '';

    if(
        $request->hasFile(
            'documento_validacion_subgerencia'
        )
    ){

        $archivo = $request->file(
            'documento_validacion_subgerencia'
        );

        $nombreArchivo =
        time().'_'.$archivo->getClientOriginalName();


        $archivo->move(

            public_path(
                'Productos/documentosProductosAprobadosSubgerencia'
            ),

            $nombreArchivo

        );


        $documentoSubgerencia =

        'Productos/documentosProductosAprobadosSubgerencia/'.
        $nombreArchivo;

    }


    // =====================================================
    // MOVER DOCUMENTO ORIGINAL
    // =====================================================

    $rutaDocumentoOriginal =

    public_path(
        $producto->documento_validacion
    );


    $nuevoDocumento =

    'Productos/documentosProductos/'.
    basename(
        $producto->documento_validacion
    );


    if(file_exists($rutaDocumentoOriginal))
    {

        rename(

            $rutaDocumentoOriginal,

            public_path($nuevoDocumento)

        );

    }


    // =====================================================
    // MOVER IMAGEN
    // =====================================================

    $rutaImagenOriginal =

    public_path(
        $producto->imagen_producto
    );


    $nuevaImagen =

    'Productos/imagenesProductos/'.
    basename(
        $producto->imagen_producto
    );


    if(file_exists($rutaImagenOriginal))
    {

        rename(

            $rutaImagenOriginal,

            public_path($nuevaImagen)

        );

    }


    // =====================================================
// INSERTAR APROBADOS
// =====================================================

$idAprobado = DB::table(
    'empresas_producto_aprobadas'
)->insertGetId([

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

    // =====================================================
// INSERTAR PRODUCTOS PUBLICOS
// =====================================================

DB::table(
    'productos_publicos'
)->insert([

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

    // =====================================================
    // ELIMINAR PENDIENTES
    // =====================================================

    DB::table(
        'productos_empresa'
    )

    ->where(
        'id_empresa_producto',
        $id
    )

    ->delete();


    DB::table(
        'registro_empresa_producto'
    )

    ->where(
        'id_empresa_producto',
        $id
    )

    ->delete();


    return redirect('admin/formularios-productos')
->with(
    'success',
    'Producto aprobado correctamente'
);

}

// =====================================================
// RECHAZAR PRODUCTO
// =====================================================

public function rechazarProducto($id)
{

    DB::table(
        'productos_empresa'
    )

    ->where(
        'id_empresa_producto',
        $id
    )

    ->delete();


    DB::table(
        'registro_empresa_producto'
    )

    ->where(
        'id_empresa_producto',
        $id
    )

    ->delete();

}

// =====================================================
// VER PRODUCTO APROBADO
// =====================================================

public function verProductoAprobado($id)
{

    $producto = DB::table(
        'empresas_producto_aprobadas'
    )

    ->where(
        'id_aprobado',
        $id
    )

    ->first();


    return view(
        'admin.ver-producto-aprobado',
        compact('producto')
    );

}

}