<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BolsaTrabajoController extends Controller
{

    public function guardar(Request $request)
    {

        $request->validate([
            'nombre_empresa' => 'required',
            'ruc' => 'required|unique:registro_bolsadetrabajo_empresa,ruc',
            'correo_electronico' => 'required|email',
            'telefono' => 'required',
            'responsable_representante' => 'required',
            'direccion' => 'required',
            'documento_validacion' => 'required|mimes:pdf|max:10240',
            'titulo_puesto' => 'required',
            'categoria' => 'required',
            'modalidad' => 'required',
            'ubicacion' => 'required',
            'salario_minimo' => 'required|numeric',
            'salario_maximo' => 'required|numeric',
            'fecha_inicio_convocatoria' => 'required|date',
            'fecha_limite_postulacion' => 'required|date|after_or_equal:fecha_inicio_convocatoria',
            'descripcion_puesto' => 'required',
            'requisitos' => 'required',
            'imagen_trabajo' => 'required|image|max:5120',
        ]);

        // =========================================
        // SUBIR DOCUMENTO VALIDACION
        // =========================================

        $documento = time() . '_' . $request->documento_validacion->getClientOriginalName();
        $rutaDocumento = public_path('BolsaTrabajo/documentos');

        if (!file_exists($rutaDocumento)) {
            mkdir($rutaDocumento, 0777, true);
        }

        $request->documento_validacion->move($rutaDocumento, $documento);


        // =========================================
        // INSERTAR EMPRESA
        // =========================================

        try {
            $idEmpresa = DB::table('registro_bolsadetrabajo_empresa')
                ->insertGetId([
                    'nombre_empresa' => $request->nombre_empresa,
                    'ruc' => $request->ruc,
                    'correo_electronico' => $request->correo_electronico,
                    'telefono' => $request->telefono,
                    'responsable_representante' => $request->responsable_representante,
                    'direccion' => $request->direccion,
                    'documento_validacion' => 'BolsaTrabajo/documentos/'.$documento
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            $code = $e->errorInfo[1] ?? null;
            if ($code == 1062) {
                return back()->withInput()->withErrors(['ruc' => 'El RUC ya está registrado.'])->with('error', 'Error al guardar: datos duplicados.');
            }
            return back()->withInput()->withErrors(['database' => 'Error al guardar la empresa.'])->with('error', 'Error al guardar la publicación.');
        }


        // =========================================
        // SUBIR IMAGEN TRABAJO
        // =========================================

        $imagen = time() . '_' . $request->imagen_trabajo->getClientOriginalName();

        $request->imagen_trabajo->move(public_path('BolsaTrabajo/imagenes'), $imagen);


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

            'imagen_trabajo' => 'BolsaTrabajo/imagenes/'.$imagen,

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
            'Publicación registrada correctamente. La aprobación puede demorar 1-2 días hábiles.'
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

    // =====================================================
    // FILTRO CATEGORÍA
    // =====================================================

    if ($request->categoria) {

        $query->where(

            'categoria',

            $request->categoria

        );

    }


    $ofertas = $query

    ->orderBy(
        'fecha_publicacion_publica',
        'desc'
    )

    ->get();


    $categorias = DB::table('publicaciones_publicas')
        ->distinct()
        ->orderBy('categoria')
        ->pluck('categoria');

    return view(

        'bolsa-trabajo.index',

        compact('ofertas', 'categorias')

    );

}

public function publicidadBolsaTrabajo()
{
    $hoy = \Carbon\Carbon::now()->startOfDay();
    
    $ofertas = DB::table('publicaciones_publicas')
        ->where('fecha_limite_postulacion', '>=', $hoy)
        ->orderBy('fecha_publicacion_publica', 'desc')
        ->get();

    return view('publicidad.bolsa-trabajo', compact('ofertas'));
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

    $file = $request->file('curriculum_pdf');
    $nombreOriginal = pathinfo(
        $file->getClientOriginalName(),
        PATHINFO_FILENAME
    );
    $extension = $file->getClientOriginalExtension();
    
    $archivo = time().'_'.$nombreOriginal.'.'.$extension;

    $ruta = public_path('curriculums');

    if (!file_exists($ruta)) {

        mkdir($ruta, 0777, true);

    }

    $file->move($ruta, $archivo);


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

        'curriculums/'.$archivo

    ]);


    return redirect('/')

    ->with(
        'success',
        'Postulación enviada correctamente'
    );

}

    

}