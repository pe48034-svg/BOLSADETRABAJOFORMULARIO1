<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductoController extends Controller
{

    // =====================================================
    // GUARDAR PRODUCTO
    // =====================================================

    public function guardar(Request $request)
    {

        // Detectar si el archivo no fue enviado (posible límite de PHP)
        if (!$request->hasFile('imagen_producto')) {
            // si no hay archivos en la petición, informar posible causa
            return back()
                ->withInput()
                ->withErrors([
                    'imagen_producto' => 'No se detectó la imagen. Asegúrate de seleccionar un archivo válido y que no supere el límite de subida en el servidor.'
                ]);
        }


        // =====================================================
        // VALIDAR
        // =====================================================

        $request->validate([

            'nombre_empresa' =>
            'required',

            'ruc' =>
            'required|digits:11',

            'correo_electronico' =>
            'required',

            'telefono' =>
            'required',

            'responsable_representante' =>
            'required',

            'direccion' =>
            'required',

            'documento_validacion' =>
            'required|mimes:pdf|max:10240',

            'nombre_producto' =>
            'required',

            'descripcion' =>
            'required',

            'categoria' =>
            'required',

            'ubicacion_ciudad' =>
            'required',

            'telefono_contacto' =>
            'required',

            'correo_contacto' =>
            'required',

            'direccion_atencion' =>
            'required',

            'imagen_producto' =>
            'required|image|max:5120',

            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio'

        ]);

        $fechaInicio = $request->filled('fecha_inicio')
            ? Carbon::parse($request->fecha_inicio)
            : Carbon::today();

        $fechaFin = $request->filled('fecha_fin')
            ? Carbon::parse($request->fecha_fin)
            : $fechaInicio->copy()->addMonth();

        $maxFin = $fechaInicio->copy()->addYear();

        if ($fechaFin->gt($maxFin)) {
            return back()
                ->withInput()
                ->withErrors(['fecha_fin' => 'La fecha de fin no puede ser mayor a un año desde la fecha de inicio.']);
        }


        // =====================================================
        // SUBIR PDF
        // =====================================================

        $pdf = time().'_'.
        $request->file(
            'documento_validacion'
        )->getClientOriginalName();


        $rutaPDF = public_path(
            'Productos/documentosProductos'
        );


        if (!file_exists($rutaPDF)) {

            mkdir($rutaPDF, 0777, true);

        }


        $request->file(
            'documento_validacion'
        )->move(

            $rutaPDF,

            $pdf

        );


        // =====================================================
        // SUBIR IMAGEN
        // =====================================================

        $imagen = time().'_'.
        $request->file(
            'imagen_producto'
        )->getClientOriginalName();


        $rutaImagen = public_path(
            'Productos/imagenesProductos'
        );


        if (!file_exists($rutaImagen)) {
            mkdir($rutaImagen, 0777, true);
        }

        $request->file('imagen_producto')->move($rutaImagen, $imagen);

        // =====================================================
        // INSERTAR O ACTUALIZAR EMPRESA (TRANSACCIÓN)
        // =====================================================
        return DB::transaction(function () use ($request, $pdf, $imagen, $fechaInicio, $fechaFin) {
            $empresaData = [
                'nombre_empresa' => $request->nombre_empresa,
                'ruc' => $request->ruc,
                'correo_electronico' => $request->correo_electronico,
                'telefono' => $request->telefono,
                'responsable_representante' => $request->responsable_representante,
                'direccion' => $request->direccion,
                'documento_validacion' => 'Productos/documentosProductos/'.$pdf,
            ];

            $empresaExistente = DB::table('registro_empresa_producto')
                ->where('ruc', $request->ruc)
                ->orWhere('correo_electronico', $request->correo_electronico)
                ->first();

            if ($empresaExistente) {
                $idEmpresa = $empresaExistente->id_empresa_producto;
                DB::table('registro_empresa_producto')
                    ->where('id_empresa_producto', $idEmpresa)
                    ->update($empresaData);
            } else {
                $idEmpresa = DB::table('registro_empresa_producto')->insertGetId($empresaData);
            }

            DB::table('productos_empresa')->insert([
                'id_empresa_producto' => $idEmpresa,
                'nombre_producto' => $request->nombre_producto,
                'descripcion' => $request->descripcion,
                'categoria' => $request->categoria,
                'ubicacion_ciudad' => $request->ubicacion_ciudad,
                'telefono_contacto' => $request->telefono_contacto,
                'redes_sociales' => $request->redes_sociales,
                'correo_contacto' => $request->correo_contacto,
                'direccion_atencion' => $request->direccion_atencion,
                'imagen_producto' => 'Productos/imagenesProductos/'.$imagen,
                'estado' => 'Pendiente',
                'fecha_inicio' => $fechaInicio->format('Y-m-d'),
                'fecha_fin' => $fechaFin->format('Y-m-d'),
            ]);

            return redirect()->back()->with('success', 'Producto registrado correctamente');
        });




    }

    // =====================================================
    // GUARDAR SERVICIO
    // =====================================================

    public function guardarServicio(Request $request)
    {

        $request->validate([
            'nombre_empresa' => 'required',
            'ruc' => 'required|digits:11',
            'correo_electronico' => 'required|email',
            'telefono' => 'required',
            'responsable_representante' => 'nullable',
            'direccion' => 'nullable',
            'documento_validacion' => 'required|mimes:pdf|max:10240',
            'nombre_servicio' => 'required',
            'categoria' => 'required',
            'descripcion' => 'required',
            'ubicacion_ciudad' => 'nullable',
            'telefono_contacto' => 'nullable',
            'redes_sociales' => 'nullable',
            'correo_contacto' => 'nullable|email',
            'direccion_atencion' => 'nullable',
            'imagen_servicio' => 'nullable|image|max:5120',
            'horario_atencion' => 'nullable',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        // Manejar subida de archivos si existen
        $rutaPDF = null;
        if ($request->hasFile('documento_validacion')) {
            $pdf = time() . '_' . $request->file('documento_validacion')->getClientOriginalName();
            $rutaPDFDir = public_path('Servicios/documentosServicios');
            if (!file_exists($rutaPDFDir)) {
                mkdir($rutaPDFDir, 0777, true);
            }
            $request->file('documento_validacion')->move($rutaPDFDir, $pdf);
            $rutaPDF = 'Servicios/documentosServicios/' . $pdf;
        }

        $rutaImagen = null;
        if ($request->hasFile('imagen_servicio')) {
            $imagen = time() . '_' . $request->file('imagen_servicio')->getClientOriginalName();
            $rutaImagenDir = public_path('Servicios/imagenesServicios');
            if (!file_exists($rutaImagenDir)) {
                mkdir($rutaImagenDir, 0777, true);
            }
            $request->file('imagen_servicio')->move($rutaImagenDir, $imagen);
            $rutaImagen = 'Servicios/imagenesServicios/' . $imagen;
        }

        $fechaInicio = $request->filled('fecha_inicio')
            ? Carbon::parse($request->fecha_inicio)
            : Carbon::today();

        $fechaFin = $request->filled('fecha_fin')
            ? Carbon::parse($request->fecha_fin)
            : $fechaInicio->copy()->addMonth();

        $maxFin = $fechaInicio->copy()->addYear();

        if ($fechaFin->gt($maxFin)) {
            return back()
                ->withInput()
                ->withErrors(['fecha_fin' => 'La fecha de fin no puede ser mayor a un año desde la fecha de inicio.']);
        }

        return DB::transaction(function () use ($request, $rutaPDF, $rutaImagen, $fechaInicio, $fechaFin) {

            $empresaData = [
                'nombre_empresa' => $request->nombre_empresa,
                'ruc' => $request->ruc,
                'correo_electronico' => $request->correo_electronico,
                'telefono' => $request->telefono,
                'responsable_representante' => $request->input('responsable_representante'),
                'direccion' => $request->input('direccion'),
                'documento_validacion' => $rutaPDF,
                'estado' => 'Pendiente',
                'fecha_registro' => Carbon::now()->format('Y-m-d'),
            ];

            $empresaExistente = DB::table('registro_empresa_servicio')
                ->where('ruc', $request->ruc)
                ->orWhere('correo_electronico', $request->correo_electronico)
                ->first();

            if ($empresaExistente) {
                $idEmpresa = $empresaExistente->id_empresa_servicio ?? $empresaExistente->id;
                DB::table('registro_empresa_servicio')
                    ->where('id_empresa_servicio', $idEmpresa)
                    ->update($empresaData);
            } else {
                $idEmpresa = DB::table('registro_empresa_servicio')->insertGetId($empresaData);
            }

            DB::table('servicios_empresa')->insert([
                'id_empresa_servicio' => $idEmpresa,
                'nombre_servicio' => $request->nombre_servicio,
                'descripcion' => $request->descripcion,
                'categoria' => $request->categoria,
                'ubicacion_ciudad' => $request->input('ubicacion_ciudad'),
                'telefono_contacto' => $request->input('telefono_contacto'),
                'redes_sociales' => $request->input('redes_sociales'),
                'correo_contacto' => $request->input('correo_contacto'),
                'direccion_atencion' => $request->input('direccion_atencion'),
                'imagen_servicio' => $rutaImagen,
                'horario_atencion' => $request->input('horario_atencion'),
                'estado' => 'Pendiente',
                'fecha_inicio' => $fechaInicio->format('Y-m-d'),
                'fecha_fin' => $fechaFin->format('Y-m-d'),
                'fecha_registro' => Carbon::now()->format('Y-m-d'),
            ]);

            return redirect()->back()->with('success', 'Servicio registrado correctamente');

        });

    }

    // =====================================================
    // PUBLICIDAD PRODUCTOS
    // =====================================================

    public function publicidadProductos()
    {
        $hoy = \Carbon\Carbon::now()->startOfDay();

        $productos = DB::table('productos_publicos')
            ->where('estado', 'Publicado')
            ->where('fecha_fin', '>=', $hoy)
            ->orderBy('fecha_publicacion', 'desc')
            ->get();

        return view('publicidad.productos', compact('productos'));
    }

    public function detalleProducto($id)
    {
        $hoy = \Carbon\Carbon::now()->startOfDay();

        $producto = DB::table('productos_publicos')
            ->where('id_publico_producto', $id)
            ->where('estado', 'Publicado')
            ->where('fecha_fin', '>=', $hoy)
            ->first();

        if (!$producto) {
            abort(404);
        }

        return view('publicidad.producto-detalle', compact('producto'));
    }

}
