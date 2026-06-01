<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">

    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>

        body{
            background:linear-gradient(135deg,#2563eb,#38bdf8);
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .login-card{
            width:450px;
            border-radius:25px;
            border:none;
        }

    </style>

</head>
<body>

<div class="card login-card shadow-lg">

    <div class="card-body p-5">

        <div class="text-center mb-4">

            <h1 class="fw-bold text-primary">
                Gestión Empresarial
            </h1>

            <p class="text-muted">
                Ingrese sus credenciales
            </p>

        </div>

        @if(session('error'))

            <div class="alert alert-danger">

                {{ session('error') }}

            </div>

        @endif

        <form action="{{ url('validar-login') }}"
              method="POST">

            @csrf

            <div class="mb-4">

                <label class="form-label">
                    Correo Electrónico
                </label>

                <input type="email"
                       name="correo"
                       class="form-control form-control-lg"
                       required>

            </div>

            <div class="mb-4">

                <label class="form-label">
                    Contraseña
                </label>

                <input type="password"
                       name="password"
                       class="form-control form-control-lg"
                       required>

            </div>

            <button class="btn btn-primary btn-lg w-100">

                Iniciar Sesión

            </button>

        </form>

        <hr class="my-4">

        

    </div>

</div>

</body>
</html>