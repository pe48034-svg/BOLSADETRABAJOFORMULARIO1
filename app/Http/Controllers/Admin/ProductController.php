<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\UseCases\Admin\AdminProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProductController extends Controller
{
    public function __construct(private AdminProductService $adminProductService)
    {
    }

    // ===================================
    // FORMULARIOS PENDIENTES
    // ===================================
    public function formulariosProductos()
    {
        $productos = $this->adminProductService->listPendingProducts();

        return view('admin.formularios-productos', compact('productos'));
    }

    // ===================================
    // PRODUCTOS APROBADOS
    // ===================================
    public function productos()
    {
        $filtros = [
            'buscar' => request('buscar'),
            'estado' => request('estado'),
            'fecha_inicio' => request('fecha_inicio'),
            'fecha_fin' => request('fecha_fin'),
        ];

        $productos = $this->adminProductService->listApprovedProducts($filtros);
        $empresas = DB::table('empresas_producto_aprobadas')
            ->select('nombre_empresa')
            ->distinct()
            ->orderBy('nombre_empresa')
            ->pluck('nombre_empresa');
        $estados = ['Publicado', 'Desactivado'];

        return view('admin.productos', compact('productos', 'empresas', 'estados'));
    }

    // ===================================
    // PRODUCTOS RECHAZADOS
    // ===================================
    public function rechazados()
    {
        $productos = $this->adminProductService->listRejectedProducts();

        return view('admin.productos-rechazados', compact('productos'));
    }

    // ===================================
    // VER PRODUCTO PENDIENTE
    // ===================================
    public function verProducto($id)
    {
        $producto = $this->adminProductService->getPendingProduct($id);

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
        $this->adminProductService->approveProduct(
            $id,
            $request->file('documento_validacion_subgerencia')
        );

        return back()->with('success', 'Solicitud aprobada correctamente');
    }

    // ===================================
    // RECHAZAR PRODUCTO
    // ===================================
    public function rechazarProducto($id)
    {
        $this->adminProductService->rejectProduct($id);

        return back()->with('warning', 'Solicitud rechazada correctamente');
    }

    // ===================================
    // RESTAURAR PRODUCTO RECHAZADO
    // ===================================
    public function restaurar($id)
    {
        try {
            $this->adminProductService->restoreProduct($id);
            return back()->with('success', 'Registro restaurado correctamente');
        } catch (\RuntimeException $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    // ===================================
    // ELIMINAR PUBLICACIÓN
    // ===================================
    public function eliminarProducto($id)
    {
        try {
            $this->adminProductService->deactivateProduct($id);
            return redirect('/admin/productos')->with('success', 'Publicación desactivada correctamente');
        } catch (\RuntimeException $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    // ===================================
    // BORRAR PUBLICACIÓN PERMANENTEMENTE
    // ===================================
    public function borrarProducto($id)
    {
        try {
            $this->adminProductService->deleteProduct($id);
            return redirect('/admin/productos')->with('success', 'Publicación eliminada correctamente');
        } catch (\RuntimeException $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    // ===================================
    // REACTIVAR PUBLICACIÓN
    // ===================================
    public function reactivarProducto($id)
    {
        try {
            $this->adminProductService->reactivateProduct($id);
            return redirect('/admin/productos')->with('success', 'Publicación reactivada correctamente');
        } catch (\RuntimeException $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    // ===================================
    // DESACTIVAR PRODUCTOS VENCIDOS
    // ===================================
    public function desactivarVencidos()
    {
        $this->adminProductService->deactivateExpired();

        return response()->json(['message' => 'Productos vencidos desactivados']);
    }

}
