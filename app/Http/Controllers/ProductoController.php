<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\StoreServiceRequest;
use App\UseCases\Public\ProductoService;
use Carbon\Carbon;

class ProductoController extends Controller
{
    public function __construct(private ProductoService $productoService)
    {
    }

    // =====================================================
    // GUARDAR PRODUCTO
    // =====================================================

    public function guardar(StoreProductRequest $request)
    {
        if (!$request->hasFile('imagen_producto')) {
            return back()->withInput()->withErrors([
                'imagen_producto' => 'No se detectó la imagen. Asegúrate de seleccionar un archivo válido y que no supere el límite de subida en el servidor.',
            ]);
        }

        $fechaInicio = $request->filled('fecha_inicio')
            ? Carbon::parse($request->fecha_inicio)
            : Carbon::today();

        $fechaFin = $request->filled('fecha_fin')
            ? Carbon::parse($request->fecha_fin)
            : $fechaInicio->copy()->addMonth();

        $maxFin = $fechaInicio->copy()->addYear();

        if ($fechaFin->gt($maxFin)) {
            return back()->withInput()->withErrors(['fecha_fin' => 'La fecha de fin no puede ser mayor a un año desde la fecha de inicio.']);
        }

        try {
            $this->productoService->createProduct(
                $request->validated(),
                $request->file('documento_validacion'),
                $request->file('imagen_producto'),
                $fechaInicio,
                $fechaFin
            );
        } catch (\Illuminate\Database\QueryException $exception) {
            return back()->withInput()->withErrors(['database' => 'Error al guardar el producto.'])->with('error', 'Error en el servidor al guardar el producto.');
        }

        return redirect()->back()->with('success', 'Producto registrado correctamente');
    }

    // =====================================================
    // GUARDAR SERVICIO
    // =====================================================

    public function guardarServicio(StoreServiceRequest $request)
    {
        $fechaInicio = $request->filled('fecha_inicio')
            ? Carbon::parse($request->fecha_inicio)
            : Carbon::today();

        $fechaFin = $request->filled('fecha_fin')
            ? Carbon::parse($request->fecha_fin)
            : $fechaInicio->copy()->addMonth();

        $maxFin = $fechaInicio->copy()->addYear();
        if ($fechaFin->gt($maxFin)) {
            return back()->withInput()->withErrors(['fecha_fin' => 'La fecha de fin no puede ser mayor a un año desde la fecha de inicio.']);
        }

        try {
            $this->productoService->createService(
                $request->validated(),
                $request->file('documento_validacion'),
                $request->file('imagen_servicio'),
                $fechaInicio,
                $fechaFin
            );
        } catch (\Illuminate\Database\QueryException $exception) {
            return back()->withInput()->withErrors(['database' => 'Error al guardar el servicio.'])->with('error', 'Error en el servidor al guardar el servicio.');
        }

        return redirect()->back()->with('success', 'Servicio registrado correctamente');
    }

    // =====================================================
    // PUBLICIDAD PRODUCTOS
    // =====================================================

    public function publicidadProductos()
    {
        $productos = $this->productoService->listPublicProducts();

        return view('publicidad.productos', compact('productos'));
    }

    public function detalleProducto(int $id)
    {
        $producto = $this->productoService->getPublicProductById($id);

        if (!$producto) {
            abort(404);
        }

        return view('publicidad.producto-detalle', compact('producto'));
    }
}
