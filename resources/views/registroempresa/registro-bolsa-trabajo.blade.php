@extends('layouts.app')

@section('content')

<style>
    .registration-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 40px 20px;
    }

    .registration-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        overflow: hidden;
    }

    .registration-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px 30px;
        text-align: center;
    }

    .registration-header h1 {
        font-size: 2.5rem;
        font-weight: 900;
        margin: 0;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }

    .registration-header p {
        margin: 10px 0 0 0;
        font-size: 1.1rem;
        opacity: 0.95;
    }

    .registration-body {
        padding: 40px 30px;
    }

    .form-section {
        animation: fadeIn 0.5s ease-in-out;
    }

    .section-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .section-title::before {
        content: '';
        display: inline-block;
        width: 5px;
        height: 30px;
        background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
        border-radius: 3px;
    }

    .section-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: #667eea;
        color: white;
        border-radius: 50%;
        font-weight: 700;
        font-size: 1.2rem;
    }

    .form-group-custom {
        margin-bottom: 25px;
    }

    .form-label-custom {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 10px;
        display: block;
        font-size: 1rem;
    }

    .form-control-custom {
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        padding: 12px 15px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control-custom:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }

    .input-group-custom {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .input-group-icon {
        color: #667eea;
        font-size: 1.3rem;
    }

    .textarea-custom {
        resize: vertical;
        min-height: 100px;
        font-family: inherit;
    }

    .row-custom {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
    }

    .row-full {
        grid-column: 1 / -1;
    }

    .button-group {
        display: flex;
        gap: 15px;
        margin-top: 35px;
        flex-wrap: wrap;
    }

    .btn-custom {
        padding: 14px 35px;
        font-size: 1.05rem;
        font-weight: 600;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        text-align: center;
        min-width: 180px;
    }

    .btn-continue {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }

    .btn-continue:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-submit {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
        box-shadow: 0 8px 20px rgba(17, 153, 142, 0.3);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(17, 153, 142, 0.4);
        color: white;
    }

    .btn-back {
        background: #f0f0f0;
        color: #2c3e50;
        border: 2px solid #e0e0e0;
    }

    .btn-back:hover {
        background: #e0e0e0;
        color: #2c3e50;
    }

    .alert-custom {
        border-radius: 10px;
        padding: 15px 20px;
        margin-bottom: 25px;
        border: none;
        font-weight: 500;
    }

    .alert-success-custom {
        background: #d4edda;
        color: #155724;
    }

    .alert-danger-custom {
        background: #f8d7da;
        color: #721c24;
    }

    .helper-text {
        font-size: 0.9rem;
        color: #7f8c8d;
        margin-top: 8px;
    }

    .step-indicator {
        display: flex;
        justify-content: space-between;
        margin-bottom: 40px;
        padding: 0 20px;
    }

    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        flex: 1;
    }

    .step-circle {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 1.1rem;
        background: #e0e0e0;
        color: #999;
        transition: all 0.3s ease;
    }

    .step.active .step-circle {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .step-label {
        font-size: 0.85rem;
        color: #999;
        text-align: center;
    }

    .step.active .step-label {
        color: #667eea;
        font-weight: 600;
    }

    .divider {
        height: 3px;
        background: #e0e0e0;
        border-radius: 2px;
        flex: 1;
        margin: 0 10px;
        align-self: flex-start;
        margin-top: 20px;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .registration-header h1 {
            font-size: 1.8rem;
        }

        .registration-body {
            padding: 25px 15px;
        }

        .row-custom {
            grid-template-columns: 1fr;
        }

        .button-group {
            flex-direction: column;
        }

        .btn-custom {
            min-width: auto;
            width: 100%;
        }

        .step-indicator {
            display: none;
        }
    }
</style>

<div class="registration-container">
    <div class="container-fluid" style="max-width: 900px;">
        <div class="registration-card">
            <!-- Header -->
            <div class="registration-header">
                <h1>💼 Registra tu Oferta de Trabajo</h1>
                <p>Completa el formulario para publicar tu oferta de empleo</p>
            </div>

            <!-- Body -->
            <div class="registration-body">
                <!-- Step Indicator -->
                <div class="step-indicator">
                    <div class="step active" id="step1-indicator">
                        <div class="step-circle">1</div>
                        <div class="step-label">Empresa</div>
                    </div>
                    <div class="divider"></div>
                    <div class="step" id="step2-indicator">
                        <div class="step-circle">2</div>
                        <div class="step-label">Publicación</div>
                    </div>
                </div>

                <form action="{{ url('guardar-bolsa-trabajo') }}" method="POST" enctype="multipart/form-data" id="mainForm">
                    @csrf

                    @if(session('success'))
                        <div class="alert alert-custom alert-success-custom">
                            ✓ {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-custom alert-danger-custom">
                            <strong>⚠️ Errores en el formulario:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- STEP 1: INFORMACIÓN EMPRESA -->
                    <div id="formEmpresa" class="form-section">
                        <div class="section-title">
                            <span class="section-number">1</span>
                            Información de la Empresa
                        </div>

                        <div class="row-custom">
                            <div class="form-group-custom">
                                <label class="form-label-custom">🏢 Nombre Empresa <span style="color: #e74c3c;">*</span></label>
                                <input type="text" name="nombre_empresa" class="form-control-custom" style="width: 100%;" required placeholder="Ej: Empresa ABC S.A.">
                            </div>

                            <div class="form-group-custom">
                                <label class="form-label-custom">📋 RUC <span style="color: #e74c3c;">*</span></label>
                                <input type="text" name="ruc" class="form-control-custom" style="width: 100%;" maxlength="11" required placeholder="Ej: 12345678901">
                                <div class="helper-text">11 dígitos sin guiones</div>
                            </div>

                            <div class="form-group-custom">
                                <label class="form-label-custom">📧 Correo Electrónico <span style="color: #e74c3c;">*</span></label>
                                <input type="email" name="correo_electronico" class="form-control-custom" style="width: 100%;" required placeholder="empresa@ejemplo.com">
                            </div>

                            <div class="form-group-custom">
                                <label class="form-label-custom">☎️ Teléfono <span style="color: #e74c3c;">*</span></label>
                                <input type="text" name="telefono" class="form-control-custom" style="width: 100%;" required placeholder="Ej: 044 123456">
                            </div>

                            <div class="form-group-custom">
                                <label class="form-label-custom">👤 Representante Responsable <span style="color: #e74c3c;">*</span></label>
                                <input type="text" name="responsable_representante" class="form-control-custom" style="width: 100%;" required placeholder="Nombre completo">
                            </div>

                            <div class="form-group-custom">
                                <label class="form-label-custom">📄 Documento de Validación <span style="color: #e74c3c;">*</span></label>
                                <input type="file" name="documento_validacion" class="form-control-custom" style="width: 100%; padding: 8px 12px;" required>
                                <div class="helper-text">Formato: PDF, JPG, PNG. Máx: 5MB</div>
                            </div>

                            <div class="form-group-custom row-full">
                                <label class="form-label-custom">🗺️ Dirección <span style="color: #e74c3c;">*</span></label>
                                <textarea name="direccion" class="form-control-custom textarea-custom" style="width: 100%;" required placeholder="Calle, número, distrito, provincia..."></textarea>
                            </div>
                        </div>

                        <div class="button-group">
                            <button type="button" class="btn-custom btn-continue" onclick="mostrarBolsaTrabajo()">
                                ▶ Continuar →
                            </button>
                        </div>
                    </div>

                    <!-- STEP 2: INFORMACIÓN PUBLICACIÓN -->
                    <div id="formBolsaTrabajo" style="display:none;" class="form-section">
                        <div class="section-title">
                            <span class="section-number">2</span>
                            Detalles de la Oferta de Trabajo
                        </div>

                        <div class="row-custom">
                            <div class="form-group-custom">
                                <label class="form-label-custom">💼 Título del Puesto <span style="color: #e74c3c;">*</span></label>
                                <input type="text" name="titulo_puesto" class="form-control-custom" style="width: 100%;" required placeholder="Ej: Ingeniero de Software">
                            </div>

                            <div class="form-group-custom">
                                <label class="form-label-custom">🏷️ Categoría <span style="color: #e74c3c;">*</span></label>
                                <input type="text" name="categoria" class="form-control-custom" style="width: 100%;" required placeholder="Ej: Tecnología, Administrativo">
                            </div>

                            <div class="form-group-custom">
                                <label class="form-label-custom">📍 Modalidad <span style="color: #e74c3c;">*</span></label>
                                <select name="modalidad" class="form-control-custom" style="width: 100%;" required>
                                    <option value="">Seleccionar modalidad...</option>
                                    <option value="Presencial">🏢 Presencial</option>
                                    <option value="Virtual">💻 Virtual</option>
                                    <option value="Hibrido">🔄 Híbrido</option>
                                </select>
                            </div>

                            <div class="form-group-custom">
                                <label class="form-label-custom">📌 Ubicación <span style="color: #e74c3c;">*</span></label>
                                <select name="ubicacion" class="form-control-custom" style="width: 100%;" required>
                                    <option value="">Seleccionar ciudad...</option>
                                    <option>🏙️ Trujillo Centro</option>
                                    <option>🌳 La Esperanza</option>
                                    <option>🏛️ El Porvenir</option>
                                    <option>🌺 Florencia de Mora</option>
                                    <option>🏖️ Huanchaco</option>
                                    <option>🏘️ Laredo</option>
                                    <option>🏞️ Moche</option>
                                    <option>⛱️ Salaverry</option>
                                    <option>🏡 Victor Larco</option>
                                    <option>🏗️ Alto Trujillo</option>
                                </select>
                            </div>

                            <div class="form-group-custom">
                                <label class="form-label-custom">💵 Salario Mínimo (S/) <span style="color: #e74c3c;">*</span></label>
                                <input type="number" step="0.01" name="salario_minimo" class="form-control-custom" style="width: 100%;" required placeholder="0.00">
                            </div>

                            <div class="form-group-custom">
                                <label class="form-label-custom">💰 Salario Máximo (S/) <span style="color: #e74c3c;">*</span></label>
                                <input type="number" step="0.01" name="salario_maximo" class="form-control-custom" style="width: 100%;" required placeholder="0.00">
                            </div>

                            <div class="form-group-custom">
                                <label class="form-label-custom">📅 Fecha Inicio <span style="color: #e74c3c;">*</span></label>
                                <input type="date" name="fecha_inicio_convocatoria" class="form-control-custom" style="width: 100%;" value="{{ old('fecha_inicio_convocatoria', \Carbon\Carbon::now()->addDay()->format('Y-m-d')) }}" readonly required>
                            </div>

                            <div class="form-group-custom">
                                <label class="form-label-custom">⏰ Fecha Límite <span style="color: #e74c3c;">*</span></label>
                                <input type="date" name="fecha_limite_postulacion" class="form-control-custom" style="width: 100%;" value="{{ old('fecha_limite_postulacion', \Carbon\Carbon::now()->addMonth()->format('Y-m-d')) }}" readonly required>
                            </div>

                            <div class="form-group-custom row-full">
                                <label class="form-label-custom">📝 Descripción del Puesto <span style="color: #e74c3c;">*</span></label>
                                <textarea name="descripcion_puesto" class="form-control-custom textarea-custom" style="width: 100%;" required placeholder="Describe las funciones principales, responsabilidades y tareas del puesto..."></textarea>
                                <div class="helper-text">Sé detallado para atraer candidatos calificados</div>
                            </div>

                            <div class="form-group-custom row-full">
                                <label class="form-label-custom">✅ Requisitos <span style="color: #e74c3c;">*</span></label>
                                <textarea name="requisitos" class="form-control-custom textarea-custom" style="width: 100%;" required placeholder="Experiencia, estudios, certificaciones, habilidades requeridas..."></textarea>
                                <div class="helper-text">Ejemplo: 2 años de experiencia en ventas, título técnico, conocimiento de Excel avanzado</div>
                            </div>

                            <div class="form-group-custom row-full">
                                <label class="form-label-custom">🖼️ Imagen de la Oferta <span style="color: #e74c3c;">*</span></label>
                                <input type="file" name="imagen_trabajo" class="form-control-custom" style="width: 100%; padding: 8px 12px;" required>
                                <div class="helper-text">Formato: JPG, PNG, WebP. Tamaño recomendado: 400x300px. Máx: 5MB</div>
                            </div>
                        </div>

                        <div class="button-group">
                            <button type="button" class="btn-custom btn-back" onclick="volverAlPaso1()">
                                ← Atrás
                            </button>
                            <button type="submit" class="btn-custom btn-submit">
                                ✓ Registrar Publicación
                            </button>
                        </div>
                        <div class="helper-text" style="margin-top: 20px; text-align: center;">
                            ℹ️ La publicación será revisada por nuestro equipo. La aprobación puede demorar 1-2 días hábiles.
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function mostrarBolsaTrabajo() {
        const container = document.getElementById('formEmpresa');
        const controls = container.querySelectorAll('input, textarea, select');

        let isValid = true;
        for (let i = 0; i < controls.length; i++) {
            const el = controls[i];
            if (!el.checkValidity()) {
                el.reportValidity();
                isValid = false;
                break;
            }
        }

        if (isValid) {
            document.getElementById('formEmpresa').style.display = 'none';
            document.getElementById('formBolsaTrabajo').style.display = 'block';
            document.getElementById('step1-indicator').classList.remove('active');
            document.getElementById('step2-indicator').classList.add('active');
            window.scrollTo(0, 0);
        }
    }

    function volverAlPaso1() {
        document.getElementById('formBolsaTrabajo').style.display = 'none';
        document.getElementById('formEmpresa').style.display = 'block';
        document.getElementById('step1-indicator').classList.add('active');
        document.getElementById('step2-indicator').classList.remove('active');
        window.scrollTo(0, 0);
    }
</script>

@endsection