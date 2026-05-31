<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>

        Postular

    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body style="background:#f4f6f9;">

<div class="container py-5">

    <div class="card border-0 shadow rounded-4">

        <div class="card-body p-5">

            <h2 class="fw-bold mb-4">

                Formulario de Postulación

            </h2>

            <div class="alert alert-primary">

                Postulando a:

                <strong>

                    {{ $oferta->titulo_puesto }}

                </strong>

            </div>

            <form

                action="{{ url('guardar-postulacion/'.$oferta->id_publica) }}"

                method="POST"

                enctype="multipart/form-data"

            >

                @csrf

                <div class="row g-4">

                    <!-- NOMBRES -->

                    <div class="col-md-6">

                        <label class="fw-bold">

                            Nombres

                        </label>

                        <input
                            type="text"
                            name="nombres"
                            class="form-control"
                            required
                        >

                    </div>


                    <!-- APELLIDOS -->

                    <div class="col-md-6">

                        <label class="fw-bold">

                            Apellidos

                        </label>

                        <input
                            type="text"
                            name="apellidos"
                            class="form-control"
                            required
                        >

                    </div>


                    <!-- DNI -->

                    <div class="col-md-6">

                        <label class="fw-bold">

                            DNI

                        </label>

                        <input
                            type="text"
                            name="dni"
                            class="form-control"
                            required
                        >

                    </div>


                    <!-- CORREO -->

                    <div class="col-md-6">

                        <label class="fw-bold">

                            Correo Electrónico

                        </label>

                        <input
                            type="email"
                            name="correo_electronico"
                            class="form-control"
                            required
                        >

                    </div>


                    <!-- TELEFONO -->

                    <div class="col-md-6">

                        <label class="fw-bold">

                            Teléfono

                        </label>

                        <input
                            type="text"
                            name="telefono"
                            class="form-control"
                            required
                        >

                    </div>


                    <!-- DIRECCION -->

                    <div class="col-md-6">

                        <label class="fw-bold">

                            Dirección

                        </label>

                        <input
                            type="text"
                            name="direccion"
                            class="form-control"
                            required
                        >

                    </div>


                    <!-- FECHA NACIMIENTO -->

                    <div class="col-md-6">

                        <label class="fw-bold">

                            Fecha Nacimiento

                        </label>

                        <input
                            type="date"
                            name="fecha_nacimiento"
                            class="form-control"
                            required
                        >

                    </div>


                    <!-- GENERO -->

                    <div class="col-md-6">

                        <label class="fw-bold">

                            Género

                        </label>

                        <select
                            name="genero"
                            class="form-select"
                            required
                        >

                            <option value="">

                                Seleccionar

                            </option>

                            <option value="Masculino">

                                Masculino

                            </option>

                            <option value="Femenino">

                                Femenino

                            </option>

                            <option value="Otro">

                                Otro

                            </option>

                        </select>

                    </div>


                    <!-- PASSWORD -->

                    <div class="col-md-6">

                        <label class="fw-bold">

                            Contraseña

                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            required
                        >

                    </div>


                    <!-- MENSAJE -->

                    <div class="col-12">

                        <label class="fw-bold">

                            Mensaje de Postulación

                        </label>

                        <textarea
                            name="mensaje_postulacion"
                            class="form-control"
                            rows="4"
                        ></textarea>

                    </div>


                    <!-- CURRICULUM -->

                    <div class="col-12">

                        <label class="fw-bold">

                            Curriculum PDF

                        </label>

                        <input
                            type="file"
                            name="curriculum_pdf"
                            class="form-control"
                            accept=".pdf"
                            required
                        >

                    </div>


                    <!-- BOTON -->

                    <div class="col-12">

                        <button class="btn btn-primary px-5">

                            Enviar Postulación

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

</body>
</html>