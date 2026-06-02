@extends('layouts.app')

@section('content')

<h1 class="fw-bold mb-4">

    Registro Productos

</h1>

@include('components.stepper', ['paso' => 2])

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-5">

        <form

            action="{{ url('guardar-producto') }}"

            method="POST"

            enctype="multipart/form-data"

        >

            @csrf


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

                        <input

                            type="text"

                            name="nombre_empresa"

                            class="form-control"

                            required

                        >

                    </div>


                    <div class="col-md-6 mb-4">

                        <label class="form-label">

                            RUC

                        </label>

                        <input

                            type="text"

                            name="ruc"

                            class="form-control"

                            maxlength="11"

                            pattern="\d{11}"

                            title="Ingrese 11 dígitos de RUC"

                            required

                        >

                    </div>


                    <div class="col-md-6 mb-4">

                        <label class="form-label">

                            Correo

                        </label>

                        <input

                            type="email"

                            name="correo_electronico"

                            class="form-control"

                            required

                        >

                    </div>


                    <div class="col-md-6 mb-4">

                        <label class="form-label">

                            Teléfono

                        </label>

                        <input

                            type="text"

                            name="telefono"

                            class="form-control"

                            required

                        >

                    </div>


                    <div class="col-md-6 mb-4">

                        <label class="form-label">

                            Responsable Representante

                        </label>

                        <input

                            type="text"

                            name="responsable_representante"

                            class="form-control"

                            required

                        >

                    </div>


                    <div class="col-md-6 mb-4">

                        <label class="form-label">

                            Dirección

                        </label>

                        <input

                            type="text"

                            name="direccion"

                            class="form-control"

                            required

                        >

                    </div>


                    <div class="col-12 mb-4">

                        <label class="form-label">

                            Documento Validación PDF

                        </label>

                        <input

                            type="file"

                            name="documento_validacion"

                            class="form-control"

                            accept=".pdf"

                            required

                        >

                    </div>

                </div>


                <button

                    type="button"

                    class="btn btn-primary"

                    onclick="mostrarProducto()"

                >

                    Continuar

                </button>

            </div>



            <!-- ================================= -->
            <!-- INFORMACION PRODUCTO -->
            <!-- ================================= -->

            <div id="formProducto" style="display:none;">

                <h4 class="mb-4">

                    Información Producto

                </h4>

                <div class="row">

                    <div class="col-md-6 mb-4">

                        <label class="form-label">

                            Nombre Producto

                        </label>

                        <input

                            type="text"

                            name="nombre_producto"

                            class="form-control"

                            required

                        >

                    </div>


                    <div class="col-md-6 mb-4">

                        <label class="form-label">

                            Categoría

                        </label>

                        <input

                            type="text"

                            name="categoria"

                            class="form-control"

                            required

                        >

                    </div>


                    <div class="col-12 mb-4">

                        <label class="form-label">

                            Descripción

                        </label>

                        <textarea

                            name="descripcion"

                            class="form-control"

                            rows="4"

                            required

                        ></textarea>

                    </div>

                    <div class="col-12 mb-4">

                        <label class="form-label">

                            Requisitos

                        </label>

                        <textarea

                            name="requisitos"

                            class="form-control"

                            rows="3"

                        ></textarea>

                        <small class="text-muted">Ej: años de experiencia, títulos, conocimientos o certificaciones requeridas.</small>

                    </div>


                    <div class="col-md-6 mb-4">

                        <label class="form-label">

                            Ciudad

                        </label>

                        <input

                            type="text"

                            name="ubicacion_ciudad"

                            class="form-control"

                            required

                        >

                    </div>


                    <div class="col-md-6 mb-4">

                        <label class="form-label">

                            Teléfono Contacto

                        </label>

                        <input

                            type="text"

                            name="telefono_contacto"

                            class="form-control"

                            required

                        >

                    </div>


                    <div class="col-md-6 mb-4">

                        <label class="form-label">

                            Redes Sociales

                        </label>

                        <input

                            type="text"

                            name="redes_sociales"

                            class="form-control"

                        >

                    </div>


                    <div class="col-md-6 mb-4">

                        <label class="form-label">

                            Correo Contacto

                        </label>

                        <input

                            type="email"

                            name="correo_contacto"

                            class="form-control"

                            required

                        >

                    </div>


                    <div class="col-12 mb-4">

                        <label class="form-label">

                            Dirección Atención

                        </label>

                        <input

                            type="text"

                            name="direccion_atencion"

                            class="form-control"

                            required

                        >

                    </div>


                    <div class="col-md-6 mb-4">

                        <label class="form-label">

                            Imagen Producto

                        </label>

                        <input

                            type="file"

                            name="imagen_producto"

                            class="form-control"

                            required

                        >

                    </div>


                    <div class="col-md-3 mb-4">

                        <label class="form-label">

                            Fecha Inicio

                        </label>

                        <input

                            type="date"

                            name="fecha_inicio"

                            class="form-control"

                            required

                        >

                    </div>


                    <div class="col-md-3 mb-4">

                        <label class="form-label">

                            Fecha Fin

                        </label>

                        <input

                            type="date"

                            name="fecha_fin"

                            class="form-control"

                            required

                        >

                    </div>

                </div>


                <button type="submit" class="btn btn-success">

                    Registrar Producto

                </button>

            </div>

        </form>

    </div>

</div>



<script>

    window.mostrarProducto = function () {
        const container = document.getElementById('formEmpresa');
        const controls = container.querySelectorAll('input, textarea, select');

        for (let i = 0; i < controls.length; i++) {
            const el = controls[i];
            if (!el.checkValidity()) {
                el.reportValidity();
                return;
            }
        }

        document.getElementById('formEmpresa').style.display = 'none';
        document.getElementById('formProducto').style.display = 'block';
    }

</script>

@endsection