@extends('layouts.app')

@section('content')

<style>
    .section-header {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        padding: 60px 20px;
        text-align: center;
        border-radius: 15px;
        margin-bottom: 40px;
        box-shadow: 0 10px 30px rgba(79, 172, 254, 0.2);
    }

    .section-header h1 {
        font-size: 2.5rem;
        font-weight: 900;
        margin: 0 0 15px 0;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }

    .section-header p {
        font-size: 1.1rem;
        opacity: 0.95;
        margin: 0;
    }

    .card-servicio {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .card-servicio:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(79, 172, 254, 0.15);
    }

    .card-servicio .card-header-color {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        min-height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
    }

    .card-servicio .card-body {
        display: flex;
        flex-direction: column;
        flex: 1;
        padding: 25px;
    }

    .card-servicio .titulo-servicio {
        font-size: 1.3rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 8px;
        line-height: 1.3;
    }

    .card-servicio .empresa-nombre {
        color: #4facfe;
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 12px;
    }

    .card-servicio .categoria-badge {
        display: inline-block;
        background: #e0f7ff;
        color: #0277bd;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .card-servicio .descripcion-servicio {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 15px;
        flex: 1;
    }

    .card-servicio .info-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 15px;
        border-top: 1px solid #e0e0e0;
        gap: 10px;
        flex-wrap: wrap;
    }

    .card-servicio .contact-info {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #666;
        font-size: 0.9rem;
    }

    .card-servicio .btn-custom {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 12px 20px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: block;
        text-align: center;
        margin-top: 15px;
    }

    .card-servicio .btn-custom:hover {
        transform: scale(1.02);
        box-shadow: 0 5px 15px rgba(79, 172, 254, 0.4);
        color: white;
    }

    .cta-section {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        border-radius: 15px;
        padding: 40px;
        text-align: center;
        margin-bottom: 40px;
        box-shadow: 0 10px 30px rgba(79, 172, 254, 0.2);
    }

    .cta-section h3 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .cta-section p {
        font-size: 1rem;
        margin-bottom: 20px;
        opacity: 0.95;
    }

    .btn-cta {
        background: white;
        color: #4facfe;
        border: none;
        border-radius: 10px;
        padding: 12px 35px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-cta:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        color: #4facfe;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #999;
    }

    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.5;
    }

    .empty-state h3 {
        color: #2c3e50;
        margin-bottom: 10px;
    }

    @media (max-width: 768px) {
        .section-header h1 {
            font-size: 1.8rem;
        }

        .section-header p {
            font-size: 1rem;
        }

        .cta-section {
            padding: 30px 20px;
        }

        .cta-section h3 {
            font-size: 1.2rem;
        }
    }
</style>

<div class="section-header">
    <h1>🔧 Servicios</h1>
    <p>Encuentra los mejores servicios profesionales en tu área</p>
</div>

<!-- CTA Section -->
<div class="cta-section">
    <h3>¿Eres proveedor de servicios?</h3>
    <p>Registra tu servicio y conecta con clientes que necesitan tus soluciones</p>
    <a href="{{ url('registro/servicios') }}" class="btn-cta">Registra tu Servicio Ahora →</a>
</div>

@if(isset($servicios) && !$servicios->isEmpty())
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4 mb-5">
        @foreach($servicios as $servicio)
            <div class="col">
                <div class="card card-servicio">
                    <div class="card-header-color">🔧</div>

                    <div class="card-body">
                        <h5 class="titulo-servicio">{{ $servicio->nombre_servicio }}</h5>
                        <p class="empresa-nombre">{{ $servicio->nombre_empresa ?? 'Empresa' }}</p>

                        <span class="categoria-badge">{{ $servicio->categoria }}</span>

                        <p class="descripcion-servicio">
                            {{ Str::limit($servicio->descripcion, 120) }}
                        </p>

                        <div class="info-footer">
                            <div class="contact-info">
                                📧 {{ Str::limit($servicio->correo_contacto ?? 'No disponible', 25) }}
                            </div>
                            <div class="contact-info">
                                ☎️ {{ $servicio->telefono_contacto ?? 'No disponible' }}
                            </div>
                        </div>

                        @if(!empty($servicio->requisitos))
                            <div style="margin-top: 12px; padding: 12px; background: #f0f8ff; border-radius: 8px; font-size: 0.9rem; color: #0277bd;">
                                <strong>ℹ️ Requisitos:</strong> {{ Str::limit($servicio->requisitos, 80) }}
                            </div>
                        @endif

                        <a href="#contact-{{ $servicio->id }}" class="btn-custom" onclick="scrollToContact('{{ $servicio->nombre_empresa }}', '{{ $servicio->telefono_contacto ?? 'No disponible' }}')">
                            Contactar →
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="empty-state">
        <div class="empty-state-icon">🌟</div>
        <h3>Sección en construcción</h3>
        <p>En este momento estamos preparando el catálogo de servicios. Pronto tendremos disponibles los mejores proveedores de servicios en tu área.</p>
    </div>
@endif

<script>
    function scrollToContact(empresa, telefono) {
        alert('Contacto:\n\nEmpresa: ' + empresa + '\nTeléfono: ' + telefono + '\n\nPuedes comunicarte directamente para más información.');
    }
</script>

@endsection
