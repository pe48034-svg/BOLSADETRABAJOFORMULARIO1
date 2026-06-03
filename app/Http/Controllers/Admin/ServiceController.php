<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    public function formulariosServicios()
    {
        return view('admin.formularios-servicios');
    }

    public function publicacionesServicios()
    {
        return view('admin.publicaciones-servicios');
    }

    public function rechazados()
    {
        return view('admin.servicios-rechazados');
    }
}
