<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BolsaTrabajoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductoController;

Route::get(
    '/',
    [BolsaTrabajoController::class, 'inicio']
);
Route::get(
    '/registro-empresa',
    function () {

        return view(
            'registroempresa.seleccion-publicacion'
        );

    }
);

/*
|--------------------------------------------------------------------------
| VISTA DE FORMULARIOS
|--------------------------------------------------------------------------
*/


// PRODUCTOS
Route::get('/registro/productos', function () {
    return view('registroempresa.registro-empresa-productos');
});


// SERVICIOS
Route::get('/registro/servicios', function () {
    return view('registroempresa.registro-empresa-servicios');
});


// BOLSA TRABAJO
Route::get('/registro/bolsa-trabajo', function () {
    return view('registroempresa.registro-bolsa-trabajo');
});


// GUARDAR BOLSA TRABAJO
Route::post(
    '/guardar-bolsa-trabajo',
    [BolsaTrabajoController::class, 'guardar']
);

// GUARDAR SERVICIO
Route::post(
    '/guardar-servicio',
    [ProductoController::class, 'guardarServicio']
);
// LOGIN
Route::get('/login', [AuthController::class, 'login']);

Route::post(
    '/validar-login',
    [AuthController::class, 'validar']
);


/*
|--------------------------------------------------------------------------
| PANEL ADMIN
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/validacion-formularios',
    [AdminController::class, 'validacion']
);

Route::get(
    '/admin/bolsa-trabajo',
    [AdminController::class, 'bolsaTrabajo']
);

/*
|--------------------------------------------------------------------------
| VER DETALLE
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/ver/{id}',
    [AdminController::class, 'ver']
);

/*
|--------------------------------------------------------------------------
| APROBAR
|--------------------------------------------------------------------------
*/

Route::post(
    '/admin/aprobar/{id}',
    [AdminController::class, 'aprobar']
);

/*
|--------------------------------------------------------------------------
| RECHAZAR
|--------------------------------------------------------------------------
*/

Route::post(
    '/admin/rechazar/{id}',
    [AdminController::class, 'rechazar']
    
);

Route::post(
    '/admin/subir-documento/{id}',
    [AdminController::class, 'subirDocumento']
);

// =====================================================
// BOLSA DE TRABAJO PUBLICA
// =====================================================

Route::get(
    '/',
    [BolsaTrabajoController::class, 'inicio']
);

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

Route::get(

    '/admin/postulantes',

    [AdminController::class,
    'postulantes']

);


Route::get(

    '/admin/postulantes/ver/{id}',

    [AdminController::class,
    'verPostulantes']

);


Route::get(

    '/admin/postulante/cv/{id}',

    [AdminController::class,
    'verCV']

);

Route::get(

    '/admin/postulante/visualizar/{id}',

    [AdminController::class,
    'visualizarCV']

);

Route::get(

    '/admin/postulante/descargar/{id}',

    [AdminController::class,
    'descargarCV']

);

Route::post(

    '/admin/eliminar-documento/{id}',

    [AdminController::class,
    'eliminarDocumento']

);


Route::get(

    '/admin/postulantes/descargar-todos/{id}',

    [AdminController::class,
    'descargarTodosCV']

);

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


// =====================================================
// GUARDAR PRODUCTO
// =====================================================

Route::post(

    '/guardar-producto',

    [ProductoController::class,
    'guardar']

);


// =====================================================
// FORMULARIOS PRODUCTOS ADMIN
// =====================================================

Route::get(

    '/admin/formularios-productos',

    [AdminController::class,
    'formulariosProductos']

);


// =====================================================
// VER PRODUCTO PENDIENTE
// =====================================================

Route::get(

    '/admin/ver-producto/{id}',

    [AdminController::class,
    'verProducto']

);


// =====================================================
// APROBAR PRODUCTO
// =====================================================

Route::post(

    '/admin/aprobar-producto/{id}',

    [AdminController::class,
    'aprobarProducto']

);


// =====================================================
// RECHAZAR PRODUCTO
// =====================================================

Route::post(

    '/admin/rechazar-producto/{id}',

    [AdminController::class,
    'rechazarProducto']

);


// =====================================================
// PRODUCTOS APROBADOS
// =====================================================

Route::get(

    '/admin/productos',

    [AdminController::class,
    'productos']

);