@extends('layouts.app')

@section('content')

<h1 class="fw-bold mb-4">
    Registro Servicios
</h1>

@include('components.stepper', ['paso' => 2])

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-5">

        <form>

            <!-- ================================= -->
            <!-- INFORMACION EMPRESA -->
            <!-- ================================= -->

            <div id="formEmpresa">

                <h4 class="mb-4">
                    Información Empresa
                </h4>

                <div class="row">

                    <div class="col-md-6 mb-4">

                        <label class="form-label">
                            Nombre Empresa
                        </label>

                        <input type="text"
                               class="form-control">

                    </div>

                    <div class="col-md-6 mb-4">

                        <label class="form-label">
                            RUC
                        </label>

                        <input type="text"
                               class="form-control">

                    </div>

                    <div class="col-md-6 mb-4">

                        <label class="form-label">
                            Correo
                        </label>

                        <input type="email"
                               class="form-control">

                    </div>

                    <div class="col-md-6 mb-4">

                        <label class="form-label">
                            Teléfono
                        </label>

                        <input type="text"
                               class="form-control">

                    </div>

                </div>

                <button type="button"
                        class="btn btn-primary"
                        onclick="mostrarServicio()">

                    Continuar

                </button>

            </div>



            <!-- ================================= -->
            <!-- INFORMACION SERVICIO -->
            <!-- ================================= -->

            <div id="formServicio" style="display:none;">

                <h4 class="mb-4">
                    Información Servicio
                </h4>

                <div class="mb-4">

                    <label class="form-label">
                        Nombre Servicio
                    </label>

                    <input type="text"
                           class="form-control">

                </div>

                <div class="mb-4">

                    <label class="form-label">
                        Categoría
                    </label>

                    <input type="text"
                           class="form-control">

                </div>

                <div class="mb-4">

                    <label class="form-label">
                        Descripción
                    </label>

                    <textarea class="form-control"></textarea>

                </div>

                <button class="btn btn-success">
                    Registrar Servicio
                </button>

            </div>

        </form>

    </div>

</div>



<script>

    function mostrarServicio()
    {
        document.getElementById('formEmpresa').style.display = 'none';

        document.getElementById('formServicio').style.display = 'block';
    }

</script>

@endsection