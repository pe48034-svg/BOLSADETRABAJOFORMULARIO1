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
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
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
        background: linear-gradient(180deg, #4facfe 0%, #00f2fe 100%);
        border-radius: 3px;
    }

    .section-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: #4facfe;
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
        width: 100%;
    }

    .form-control-custom:focus {
        border-color: #4facfe;
        box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1);
        outline: none;
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
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        box-shadow: 0 8px 20px rgba(79, 172, 254, 0.3);
    }

    .btn-continue:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(79, 172, 254, 0.4);
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
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        box-shadow: 0 5px 15px rgba(79, 172, 254, 0.4);
    }

    .step-label {
        font-size: 0.85rem;
        color: #999;
        text-align: center;
    }

    .step.active .step-label {
        color: #00f2fe;
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
            <div class="registration-header">
                <h1>🔧 Registra tu Servicio</h1>
                <p>Completa el formulario para publicar tu servicio en el directorio</p>
            </div>

            <div class="registration-body">
                <div class="step-indicator">
                    <div class="step active" id="step1-indicator">
                        <div class="step-circle">1</div>
                        <div class="step-label">Empresa</div>
                    </div>
                    <div class="divider"></div>
                    <div class="step" id="step2-indicator">
                        <div class="step-circle">2</div>
                        <div class="step-label">Servicio</div>
                    </div>
                </div>

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

                @php
                    $fechaHoy = \Carbon\Carbon::today();
                    $fechaFinDefault = $fechaHoy->copy()->addMonth();
                    $fechaFinMax = $fechaHoy->copy()->addYear();
                @endphp

                <form action="{{ url('guardar-servicio') }}" method="POST" enctype="multipart/form-data" id="mainForm">
                    @csrf

                    <div id="formEmpresa" class="form-section">
                        <div class="section-title">
                            <span class="section-number">1</span>
                            Información de la Empresa
                        </div>

                        <div class="row-custom">
                            <div class="form-group-custom">
                                <label class="form-label-custom">🏢 Nombre Empresa <span style="color: #e74c3c;">*</span></label>
                                <input type="text" name="nombre_empresa" class="form-control-custom" required placeholder="Ej: Empresa ABC S.A.">
                            </div>

                            <div class="form-group-custom">
                                <label class="form-label-custom">📋 RUC <span style="color: #e74c3c;">*</span></label>
                                <input type="text" name="ruc" class="form-control-custom" maxlength="11" pattern="\d{11}" title="Ingrese 11 dígitos de RUC" required placeholder="Ej: 12345678901">
                                <div class="helper-text">11 dígitos sin guiones</div>
                            </div>

                            <div class="form-group-custom">
                                <label class="form-label-custom">📧 Correo <span style="color: #e74c3c;">*</span></label>
                                <input type="email" name="correo_electronico" class="form-control-custom" required placeholder="empresa@ejemplo.com">
                            </div>

                            <div class="form-group-custom">
                                <label class="form-label-custom">☎️ Teléfono <span style="color: #e74c3c;">*</span></label>
                                <input type="text" name="telefono" class="form-control-custom" required placeholder="Ej: 044 123456">
                            </div>

                            <div class="form-group-custom">
                                <label class="form-label-custom">👤 Responsable / Representante</label>
                                <input type="text" name="responsable_representante" class="form-control-custom" placeholder="Nombre del responsable">
                            </div>

                            <div class="form-group-custom row-full">
                                <label class="form-label-custom">📍 Dirección</label>
                                <input type="text" name="direccion" class="form-control-custom" placeholder="Dirección de la empresa">
                            </div>

                            <div class="form-group-custom row-full">
                                <label class="form-label-custom">📄 Documento de Validación (PDF) <span style="color: #e74c3c;">*</span></label>
                                <input type="file" name="documento_validacion" class="form-control-custom" accept="application/pdf" required>
                                <div class="helper-text">Requerido. PDF máximo 10MB.</div>
                            </div>
                        </div>

                        <div class="button-group">
                            <button type="button" class="btn-custom btn-continue" onclick="mostrarServicio()">
                                ▶ Continuar →
                            </button>
                        </div>
                    </div>

                    <div id="formServicio" style="display:none;" class="form-section">
                        <div class="section-title">
                            <span class="section-number">2</span>
                            Información del Servicio
                        </div>

                        <div class="row-custom">
                            <div class="form-group-custom">
                                <label class="form-label-custom">🔧 Nombre del Servicio <span style="color: #e74c3c;">*</span></label>
                                <input type="text" name="nombre_servicio" class="form-control-custom" required placeholder="Ej: Reparación de computadoras">
                            </div>

                            <div class="form-group-custom">
                                <label class="form-label-custom">🏷️ Categoría <span style="color: #e74c3c;">*</span></label>
                                <input type="text" name="categoria" class="form-control-custom" required placeholder="Ej: Tecnología, Limpieza, etc.">
                            </div>

                            <div class="form-group-custom row-full">
                                <label class="form-label-custom">📝 Descripción <span style="color: #e74c3c;">*</span></label>
                                <textarea name="descripcion" class="form-control-custom textarea-custom" required placeholder="Describe detalladamente tu servicio, qué incluye, en qué zonas atiende, horarios..."></textarea>
                                <div class="helper-text">Sé específico para atraer más clientes interesados en tus servicios</div>
                            </div>

                            <div class="form-group-custom">
                                <label class="form-label-custom">📌 Ubicación / Ciudad</label>
                                <input type="text" name="ubicacion_ciudad" class="form-control-custom" placeholder="Ej: Lima">
                            </div>

                            <div class="form-group-custom">
                                <label class="form-label-custom">☎️ Teléfono de Contacto</label>
                                <input type="text" name="telefono_contacto" class="form-control-custom" placeholder="Teléfono de contacto">
                            </div>

                            <div class="form-group-custom">
                                <label class="form-label-custom">🌐 Redes Sociales</label>
                                <input type="text" name="redes_sociales" class="form-control-custom" placeholder="URLs o redes sociales">
                            </div>

                            <div class="form-group-custom">
                                <label class="form-label-custom">📧 Correo de Contacto</label>
                                <input type="email" name="correo_contacto" class="form-control-custom" placeholder="correo@contacto.com">
                            </div>

                            <div class="form-group-custom row-full">
                                <label class="form-label-custom">📍 Dirección de Atención</label>
                                <input type="text" name="direccion_atencion" class="form-control-custom" placeholder="Dirección donde se presta el servicio">
                            </div>

                            <div class="form-group-custom">
                                <label class="form-label-custom">🖼️ Imagen del Servicio</label>
                                <input type="file" name="imagen_servicio" class="form-control-custom" accept="image/*">
                                <div class="helper-text">Opcional. Imagen representativa del servicio (max 5MB).</div>
                            </div>

                            <div class="form-group-custom">
                                <label class="form-label-custom">⏰ Horario de Atención</label>
                                <input type="text" name="horario_atencion" class="form-control-custom" placeholder="Ej: Lun-Vie 9:00-18:00">
                            </div>

                            <input type="hidden" name="fecha_inicio" value="{{ $fechaHoy->format('Y-m-d') }}">
                            <div class="form-group-custom row-full">
                                <div class="helper-text" style="margin-bottom: 20px; font-weight: 600;">Fecha de inicio automática: {{ $fechaHoy->format('d/m/Y') }}</div>
                            </div>

                            <div class="form-group-custom">
                                <label class="form-label-custom">📅 Fecha Fin</label>
                                <input type="date" name="fecha_fin" class="form-control-custom" value="{{ old('fecha_fin', $fechaFinDefault->format('Y-m-d')) }}" min="{{ $fechaHoy->format('Y-m-d') }}" max="{{ $fechaFinMax->format('Y-m-d') }}">
                                <div class="helper-text">La fecha fin será dentro de 1 mes por defecto y como máximo hasta {{ $fechaFinMax->format('d/m/Y') }}.</div>
                            </div>
                        </div>

                        <div class="button-group">
                            <button type="button" class="btn-custom btn-back" onclick="volverAlPaso1()">
                                ← Atrás
                            </button>
                            <button type="submit" class="btn-custom btn-submit">
                                ✓ Registrar Servicio
                            </button>
                        </div>
                        <div class="helper-text" style="margin-top: 20px; text-align: center;">
                            ℹ️ Tu servicio será revisado por nuestro equipo. La aprobación puede demorar 1-2 días hábiles.
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function mostrarServicio() {
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
            document.getElementById('formServicio').style.display = 'block';
            document.getElementById('step1-indicator').classList.remove('active');
            document.getElementById('step2-indicator').classList.add('active');
            window.scrollTo(0, 0);
        }
    }

    function volverAlPaso1() {
        document.getElementById('formServicio').style.display = 'none';
        document.getElementById('formEmpresa').style.display = 'block';
        document.getElementById('step1-indicator').classList.add('active');
        document.getElementById('step2-indicator').classList.remove('active');
        window.scrollTo(0, 0);
    }
</script>

@endsection
