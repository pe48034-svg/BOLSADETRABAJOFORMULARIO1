<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BolsaTrabajoController;
use App\Http\Controllers\Admin\BolsaController;
use App\Http\Controllers\Admin\PostulanteController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\ProductoController;

// RUTA TEMPORAL PARA REPARAR COLUMNA ESTADO
Route::get('/admin/repair-database', function () {
    try {
        DB::statement('ALTER TABLE `empresas_producto_aprobadas` MODIFY COLUMN `estado` VARCHAR(50) NOT NULL');
        DB::statement('ALTER TABLE `productos_publicos` MODIFY COLUMN `estado` VARCHAR(50) NOT NULL');
        return response()->json([
            'success' => true,
            'message' => 'Base de datos reparada correctamente. Puedes desactivar publicaciones ahora.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
});

Route::get(
    '/',
    function () {
        return view('publicidad.porvenir-produce');
    }
);

Route::get(
    '/publicidad',
    function () {
        return redirect('/publicidad/bolsa-trabajo');
    }
);

Route::get(
    '/publicidad/bolsa-trabajo',
    [BolsaTrabajoController::class, 'publicidadBolsaTrabajo']
);

Route::get(
    '/publicidad/productos',
    [ProductoController::class, 'publicidadProductos']
);

Route::get(
    '/publicidad/productos/{id}',
    [ProductoController::class, 'detalleProducto']
);

Route::get(
    '/publicidad/servicios',
    function () {
        return view('publicidad.servicios');
    }
);

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/validar-login', [AuthController::class, 'validar']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::get(
    '/registro-empresa',
    function () {

        return view(
            'registroempresa.seleccion-publicacion'
        );

    }
);

Route::get('/registro/bolsa-trabajo', function () {
    return view('registroempresa.registro-bolsa-trabajo');
});

Route::get('/registro/bolsa-trabajos', function () {
    return redirect('/registro/bolsa-trabajo');
});

Route::post('/guardar-bolsa-trabajo', [BolsaTrabajoController::class, 'guardar']);

Route::get('/admin/postulantes', [PostulanteController::class, 'postulantes']);
Route::get('/admin/postulantes/ver/{id}', [PostulanteController::class, 'verPostulantes']);
Route::get('/admin/postulante/cv/{id}', [PostulanteController::class, 'verCV']);
Route::get('/admin/postulante/visualizar/{id}', [PostulanteController::class, 'visualizarCV']);
Route::get('/admin/postulante/descargar/{id}', [PostulanteController::class, 'descargarCV']);
Route::post('/admin/eliminar-documento/{id}', [BolsaController::class, 'eliminarDocumento']);
Route::post('/admin/eliminar-publicacion/{id}', [BolsaController::class, 'eliminarPublicacion']);
Route::get('/admin/postulantes/descargar-todos/{id}', [PostulanteController::class, 'descargarTodosCV']);

Route::get('/admin/ver/{id}', [BolsaController::class, 'ver']);
Route::get('/admin/validacion-formularios', [BolsaController::class, 'validacion']);
Route::get('/admin/rechazados', [BolsaController::class, 'rechazados']);
Route::get('/admin/bolsa-trabajo', [BolsaController::class, 'bolsaTrabajo']);
Route::get('/admin/indicadores-bolsa', function () {
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
});

Route::get('/admin/indicadores-productos', function () {
    return view('admin.indicadores-productos');
});

Route::get('/admin/indicadores-servicios', function () {
    return view('admin.indicadores-servicios');
});
/*
|--------------------------------------------------------------------------
| APROBAR
|--------------------------------------------------------------------------
*/

Route::post(
    '/admin/aprobar/{id}',
    [\App\Http\Controllers\Admin\DocumentController::class, 'aprobar']
);

/*
|--------------------------------------------------------------------------
| RECHAZAR
|--------------------------------------------------------------------------
*/

Route::post(
    '/admin/rechazar/{id}',
    [\App\Http\Controllers\Admin\DocumentController::class, 'rechazar']
);

Route::post(
    '/admin/restaurar/{id}',
    [\App\Http\Controllers\Admin\DocumentController::class, 'restaurar']
);

Route::post('/admin/subir-documento/{id}', [\App\Http\Controllers\Admin\DocumentController::class, 'subirDocumento']);

// =====================================================
// BOLSA DE TRABAJO PUBLICA
// =====================================================

Route::get(
    '/detalle-oferta/{id}',
    [BolsaTrabajoController::class, 'detalle']
);

Route::get(
    '/postular/{id}',
    [BolsaTrabajoController::class, 'postular']
);

Route::post(

    '/guardar-postulacion/{id}',

    [BolsaTrabajoController::class,
    'guardarPostulacion']

);

// =====================================================
// POSTULANTES ADMIN
// =====================================================

Route::get('/admin/postulantes', [PostulanteController::class, 'postulantes']);
Route::get('/admin/postulantes/ver/{id}', [PostulanteController::class, 'verPostulantes']);
Route::get('/admin/postulante/cv/{id}', [PostulanteController::class, 'verCV']);
Route::get('/admin/postulante/visualizar/{id}', [PostulanteController::class, 'visualizarCV']);
Route::get('/admin/postulante/descargar/{id}', [PostulanteController::class, 'descargarCV']);
Route::post('/admin/eliminar-documento/{id}', [BolsaController::class, 'eliminarDocumento']);
Route::get('/admin/postulantes/descargar-todos/{id}', [PostulanteController::class, 'descargarTodosCV']);

// =====================================================
// PRODUCTOS
// =====================================================


// =====================================================
// FORMULARIO PRODUCTOS
// =====================================================

Route::get(

    '/registro/productos',

    function () {

        return view(
            'registroempresa.registro-empresa-productos'
        );

    }

);

Route::get(

    '/registro/servicios',

    function () {

        return view(
            'registroempresa.registro-empresa-servicios'
        );

    }

);


// =====================================================
// GUARDAR PRODUCTO
// =====================================================

Route::post(

    '/guardar-producto',

    [ProductoController::class,
    'guardar']

);

Route::post(

    '/guardar-servicio',

    [ProductoController::class,
    'guardarServicio']

);


// =====================================================
// FORMULARIOS PRODUCTOS ADMIN
// =====================================================

Route::get('/admin/formularios-productos', [ProductController::class, 'formulariosProductos']);


// =====================================================
// VER PRODUCTO PENDIENTE
// =====================================================

Route::get('/admin/ver-producto/{id}', [ProductController::class, 'verProducto']);

// =====================================================
// PRODUCTOS APROBADOS
// =====================================================

Route::get('/admin/productos', [ProductController::class, 'productos']);

Route::get('/admin/ver-producto-aprobado/{id}', [ProductController::class, 'verProductoAprobado']);

Route::post('/admin/productos/reactivar/{id}', [ProductController::class, 'reactivarProducto']);

// =====================================================
// PRODUCTOS RECHAZADOS
// =====================================================

Route::get('/admin/productos-rechazados', [ProductController::class, 'rechazados']);

Route::post('/admin/productos/restaurar/{id}', [ProductController::class, 'restaurar']);


// =====================================================
// SERVICIOS ADMIN
// =====================================================

Route::get('/admin/formularios-servicios', [ServiceController::class, 'formulariosServicios']);
Route::get('/admin/publicaciones-servicios', [ServiceController::class, 'publicacionesServicios']);
Route::get('/admin/servicios-rechazados', [ServiceController::class, 'rechazados']);


// =====================================================
// APROBAR PRODUCTO
// =====================================================

Route::post(

    '/admin/aprobar-producto/{id}',

    [\App\Http\Controllers\Admin\ProductController::class, 'aprobarProducto']

);


// =====================================================
// RECHAZAR PRODUCTO
// =====================================================

Route::post(

    '/admin/rechazar-producto/{id}',

    [\App\Http\Controllers\Admin\ProductController::class, 'rechazarProducto']

);

// =====================================================
// ELIMINAR PUBLICACIÓN
// =====================================================

Route::delete(

    '/admin/eliminar-producto/{id}',

    [\App\Http\Controllers\Admin\ProductController::class, 'eliminarProducto']

);

Route::delete(

    '/admin/borrar-producto/{id}',

    [\App\Http\Controllers\Admin\ProductController::class, 'borrarProducto']

);

// =====================================================
// DESACTIVAR PRODUCTOS VENCIDOS
// =====================================================

Route::get(

    '/admin/desactivar-vencidos',

    [\App\Http\Controllers\Admin\ProductController::class, 'desactivarVencidos']

);

