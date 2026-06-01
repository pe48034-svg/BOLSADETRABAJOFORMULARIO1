<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{

    // =====================================================
    // GUARDAR PRODUCTO
    // =====================================================

    public function guardar(Request $request)
    {

        // =====================================================
        // VALIDAR
        // =====================================================

        $request->validate([

            'nombre_empresa' =>
            'required',

            'ruc' =>
            'required',

            'correo_electronico' =>
            'required',

            'telefono' =>
            'required',

            'responsable_representante' =>
            'required',

            'direccion' =>
            'required',

            'documento_validacion' =>
            'required|mimes:pdf',

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

            'requisitos' =>
            'nullable',

            'imagen_producto' =>
            'required|image'

        ]);


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


        $request->file(
            'imagen_producto'
        )->move(

            $rutaImagen,

            $imagen

        );


        // =====================================================
        // INSERTAR EMPRESA
        // =====================================================

        $idEmpresa = DB::table(
            'registro_empresa_producto'
        )->insertGetId([

            'nombre_empresa' =>
            $request->nombre_empresa,

            'ruc' =>
            $request->ruc,

            'correo_electronico' =>
            $request->correo_electronico,

            'telefono' =>
            $request->telefono,

            'responsable_representante' =>
            $request->responsable_representante,

            'direccion' =>
            $request->direccion,

            'documento_validacion' =>

            'Productos/documentosProductos/'.$pdf

        ]);


        // =====================================================
        // INSERTAR PRODUCTO
        // =====================================================

        DB::table(
            'productos_empresa'
        )->insert([

            'id_empresa_producto' =>
            $idEmpresa,

            'nombre_producto' =>
            $request->nombre_producto,

            'descripcion' =>
            $request->descripcion,

            'categoria' =>
            $request->categoria,

            'ubicacion_ciudad' =>
            $request->ubicacion_ciudad,

            'telefono_contacto' =>
            $request->telefono_contacto,

            'redes_sociales' =>
            $request->redes_sociales,

            'correo_contacto' =>
            $request->correo_contacto,

            'direccion_atencion' =>
            $request->direccion_atencion,

            'imagen_producto' =>

            'Productos/imagenesProductos/'.$imagen,

            'estado' =>
            'Pendiente',

            'fecha_inicio' =>
            $request->fecha_inicio,

            'fecha_fin' =>
            $request->fecha_fin

        ]);


        return redirect('/')

        ->with(
            'success',
            'Producto registrado correctamente'
        );

    }

    // =====================================================
    // GUARDAR SERVICIO
    // =====================================================

    public function guardarServicio(Request $request)
    {

        $request->validate([
            'nombre_empresa' => 'required',
            'ruc' => 'required',
            'correo_electronico' => 'required',
            'telefono' => 'required',
            'nombre_servicio' => 'required',
            'categoria' => 'required',
            'descripcion' => 'required',
            'requisitos' => 'nullable',
        ]);

        return redirect('/')
            ->with(
                'success',
                'Servicio registrado correctamente (próximamente en módulo completo)'
            );

    }

}