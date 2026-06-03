<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Panel Admin</title>

    <!-- BOOTSTRAP -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- ICONOS -->

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

</head>

<body style="background:#f5f7fb;">

<div class="d-flex">

    <!-- SIDEBAR -->

    <div
        class="bg-white border-end"
        style="
            width:250px;
            min-height:100vh;
        "
    >

        <div class="p-4">

            <h2 class="fw-bold text-primary">
                Gestión Empresarial
            </h2>

        </div>

        <ul class="nav flex-column p-3">

            <li class="nav-item mb-2">

                <a
                    href="{{ url('admin/validacion-formularios') }}"
                    class="nav-link text-dark"
                >
                    <i class="bi bi-file-earmark-check"></i>

                    Validación de Formularios de Bolsa de Trabajo
                </a>

            </li>

            <li class="nav-item mb-2">

                <a
                    href="{{ url('admin/rechazados') }}"
                    class="nav-link text-dark"
                >
                    <i class="bi bi-file-earmark-x"></i>

                    Rechazados Bolsa de Trabajo
                </a>

            </li>

            <li class="nav-item mb-2">

                <a
                    href="{{ url('admin/bolsa-trabajo') }}"
                    class="nav-link text-dark"
                >
                    <i class="bi bi-briefcase"></i>

                    Bolsa de Trabajo
                </a>

            </li>

            <li class="nav-item mb-2">

                <a
                    href="#"
                    class="nav-link text-dark"
                >
                    <i class="bi bi-box-seam"></i>

                    Productos
                </a>

            </li>

            <li class="nav-item mb-2">

                <a
                    href="#"
                    class="nav-link text-dark"
                >
                    <i class="bi bi-tools"></i>

                    Servicios
                </a>

            </li>

        </ul>

    </div>

    <li class="nav-item mb-2">

    <a
        href="{{ url('admin/postulantes') }}"
        class="nav-link text-white"
    >

        👥 Postulantes

    </a>

    </li>


    <!-- CONTENIDO -->

    <div class="flex-grow-1 p-4">

        @yield('content')

    </div>

</div>


<!-- BOOTSTRAP JS -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>