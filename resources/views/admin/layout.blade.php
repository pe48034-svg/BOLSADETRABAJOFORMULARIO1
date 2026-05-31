<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>

        Panel Administrativo

    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body style="background:#f4f6fb;">

<div class="d-flex">

    <!-- SIDEBAR -->

    <div style="
        width:260px;
        min-height:100vh;
        background:white;
        border-right:1px solid #ddd;
        padding:30px;
    ">

        <h2 class="fw-bold text-primary">

            Gestión Empresarial

        </h2>

        <hr>


        <!-- VALIDACION FORMULARIOS -->

        <a
            href="{{ url('admin/validacion-formularios') }}"
            class="d-block mb-4 text-decoration-none text-dark"
        >

            📄 Validación Formularios

        </a>


        <!-- BOLSA TRABAJO -->

        <a
            href="{{ url('admin/bolsa-trabajo') }}"
            class="d-block mb-4 text-decoration-none text-dark"
        >

            💼 Bolsa de Trabajo

        </a>


        <!-- POSTULANTES -->

        <a
            href="{{ url('admin/postulantes') }}"
            class="d-block mb-4 text-decoration-none text-dark"
        >

            👥 Postulantes

        </a>


        <!-- FORMULARIOS PRODUCTOS -->

        <a
            href="{{ url('admin/formularios-productos') }}"
            class="d-block mb-4 text-decoration-none text-dark"
        >

            📦 Formularios Productos

        </a>


        <!-- PRODUCTOS APROBADOS -->

        <a
            href="{{ url('admin/productos') }}"
            class="d-block mb-4 text-decoration-none text-dark"
        >

            🛍 Productos

        </a>


        <!-- SERVICIOS -->

        <a
            href="#"
            class="d-block mb-4 text-decoration-none text-dark"
        >

            🛠 Servicios

        </a>

    </div>


    <!-- CONTENIDO -->

    <div class="flex-grow-1 p-4">

        @yield('content')

    </div>

</div>

</body>

</html>