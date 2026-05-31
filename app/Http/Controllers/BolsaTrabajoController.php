<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BolsaTrabajoController extends Controller
{

    public function guardar(Request $request)
    {

        // =========================================
        // SUBIR DOCUMENTO VALIDACION
        // =========================================

        $documento = time() . '_' .
                      $request->documento_validacion->getClientOriginalName();

        $request->documento_validacion
                ->move(public_path('documentos'), $documento);


        // =========================================
        // INSERTAR EMPRESA
        // =========================================

        $idEmpresa = DB::table('registro_bolsadetrabajo_empresa')
        ->insertGetId([

            'nombre_empresa' => $request->nombre_empresa,

            'ruc' => $request->ruc,

            'correo_electronico' => $request->correo_electronico,

            'telefono' => $request->telefono,

            'responsable_representante'
                => $request->responsable_representante,

            'direccion' => $request->direccion,

            'documento_validacion'
                => 'BolsaTrabajo/documentos' . $documento

        ]);


        // =========================================
        // SUBIR IMAGEN TRABAJO
        // =========================================

        $imagen = time() . '_' .
                   $request->imagen_trabajo->getClientOriginalName();

        $request->imagen_trabajo
                ->move(public_path('BolsaTrabajo/imagenes'), $imagen);


        // =========================================
        // INSERTAR PUBLICACION
        // =========================================

        DB::table('publicaciones_trabajo')
        ->insert([

            'id_empresa' => $idEmpresa,

            'titulo_puesto' => $request->titulo_puesto,

            'descripcion_puesto'
                => $request->descripcion_puesto,

            'requisitos' => $request->requisitos,

            'imagen_trabajo'
                => 'BolsaTrabajo/imagenes' . $imagen,

            'modalidad' => $request->modalidad,

            'categoria' => $request->categoria,

            'salario_minimo'
                => $request->salario_minimo,

            'salario_maximo'
                => $request->salario_maximo,

            'ubicacion' => $request->ubicacion,

            'fecha_inicio_convocatoria'
                => $request->fecha_inicio_convocatoria,

            'fecha_limite_postulacion'
                => $request->fecha_limite_postulacion

        ]);


        return back()->with(
            'success',
            'Publicación registrada correctamente'
        );

    }

    // =====================================================
    // VISTA PRINCIPAL
    // =====================================================

    // =====================================================
// VISTA PRINCIPAL
// =====================================================

public function inicio(Request $request)
{

    $query = DB::table(
        'publicaciones_publicas'
    );


    // =====================================================
    // BUSCADOR
    // =====================================================

    if ($request->buscar) {

        $query->where(

            'titulo_puesto',

            'LIKE',

            '%'.$request->buscar.'%'

        );

    }


    // =====================================================
    // FILTRO MODALIDAD
    // =====================================================

    if ($request->modalidad) {

        $query->where(

            'modalidad',

            $request->modalidad

        );

    }


    $ofertas = $query

    ->orderBy(
        'fecha_publicacion_publica',
        'desc'
    )

    ->get();


    return view(

        'bolsa-trabajo.index',

        compact('ofertas')

    );

}


    // =====================================================
    // VER DETALLE
    // =====================================================

    public function detalle($id)
    {

        $oferta = DB::table(
            'publicaciones_publicas'
        )

        ->where(
            'id_aprobado',
            $id
        )

        ->first();

        return view(
            'bolsa-trabajo.detalle',
            compact('oferta')
        );

    }


    // =====================================================
    // FORMULARIO POSTULACION
    // =====================================================

    public function postular($id)
    {

        $oferta = DB::table(
            'publicaciones_publicas'
        )

        ->where(
            'id_aprobado',
            $id
        )

        ->first();

        return view(
            'bolsa-trabajo.postular',
            compact('oferta')
        );

    }

    // =====================================================
// GUARDAR POSTULACION
// =====================================================

public function guardarPostulacion(
    Request $request,
    $id
)
{

    $request->validate([

        'nombres' =>
        'required',

        'apellidos' =>
        'required',

        'dni' =>
        'required',

        'correo_electronico' =>
        'required',

        'telefono' =>
        'required',

        'direccion' =>
        'required',

        'fecha_nacimiento' =>
        'required',

        'genero' =>
        'required',

        'password' =>
        'required',

        'curriculum_pdf' =>
        'required|mimes:pdf|max:5000'

    ]);


    // =====================================================
    // GUARDAR PDF
    // =====================================================

    $archivo = time().'_'.
    $request->file(
        'curriculum_pdf'
    )->getClientOriginalName();


    $ruta = public_path(
        'curriculums'
    );


    if (!file_exists($ruta)) {

        mkdir($ruta, 0777, true);

    }


    $request->file(
        'curriculum_pdf'
    )->move(

        $ruta,

        $archivo

    );


    // =====================================================
    // INSERTAR POSTULANTE
    // =====================================================

    $idPostulante = DB::table(
        'postulantes'
    )->insertGetId([

        'nombres' =>
        $request->nombres,

        'apellidos' =>
        $request->apellidos,

        'dni' =>
        $request->dni,

        'correo_electronico' =>
        $request->correo_electronico,

        'telefono' =>
        $request->telefono,

        'direccion' =>
        $request->direccion,

        'fecha_nacimiento' =>
        $request->fecha_nacimiento,

        'genero' =>
        $request->genero,

        'password' =>
        bcrypt($request->password)

    ]);


    // =====================================================
    // INSERTAR POSTULACION
    // =====================================================

    DB::table(
        'postulaciones'
    )->insert([

        'id_publica' =>
        $id,

        'id_postulante' =>
        $idPostulante,

        'mensaje_postulacion' =>
        $request->mensaje_postulacion,

        'curriculum_pdf' =>

        'BolsaTrabajo/curriculums'.$archivo

    ]);


    return redirect('/')

    ->with(
        'success',
        'Postulación enviada correctamente'
    );

}

    

}