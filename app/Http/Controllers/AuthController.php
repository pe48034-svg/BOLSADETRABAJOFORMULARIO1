<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    // =========================================
    // MOSTRAR LOGIN
    // =========================================

    public function login()
    {
        return view('auth.login');
    }


    // =========================================
    // VALIDAR LOGIN
    // =========================================

    public function validar(Request $request)
    {

        $usuario = DB::table('usuarios')
        ->where('correo', $request->correo)
        ->where('password', $request->password)
        ->first();

        if($usuario)
        {

            Session::put('usuario', $usuario);

            // SUPER ADMIN
            if($usuario->rol == 'Super_Administrador')
            {
            return redirect('/admin/validacion-formularios');
            }

            // ANALISTA
            if($usuario->rol == 'Analista')
            {
                return redirect('/analista');
            }

            // GESTOR
            if($usuario->rol == 'Gestor_Operativo')
            {
                return redirect('/gestor');
            }

        }

        return back()->with(
            'error',
            'Credenciales incorrectas'
        );

    }


    // =========================================
    // CERRAR SESION
    // =========================================

    public function logout()
    {

        Session::flush();

        return redirect('/login');

    }

}