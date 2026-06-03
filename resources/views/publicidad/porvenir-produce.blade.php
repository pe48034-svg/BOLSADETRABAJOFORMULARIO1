@extends('layouts.app')

@section('content')

<style>
    .porvenir-hero {
        min-height: 100vh;
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #7aa8d1 100%);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .porvenir-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><path d="M0,400 Q300,200 600,250 T1200,300 L1200,600 L0,600 Z" fill="rgba(255,255,255,0.1)"/><path d="M0,450 Q300,250 600,350 T1200,400 L1200,600 L0,600 Z" fill="rgba(255,255,255,0.05)"/></svg>');
        background-size: cover;
        background-repeat: no-repeat;
        opacity: 0.3;
    }

    .porvenir-content {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 900px;
        width: 100%;
        padding: 40px 20px;
    }

    .porvenir-title {
        font-size: 4rem;
        font-weight: 900;
        color: white;
        text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.3);
        margin-bottom: 20px;
        animation: fadeInDown 0.8s ease-out;
    }

    .porvenir-subtitle {
        font-size: 1.5rem;
        color: rgba(255, 255, 255, 0.95);
        margin-bottom: 60px;
        font-weight: 300;
        animation: fadeInUp 0.8s ease-out 0.2s both;
    }

    .porvenir-buttons {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
        animation: fadeInUp 0.8s ease-out 0.4s both;
    }

    .btn-porvenir {
        padding: 25px 40px;
        font-size: 1.2rem;
        font-weight: 600;
        border: none;
        border-radius: 15px;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        position: relative;
        overflow: hidden;
        display: inline-block;
        width: 100%;
    }

    .btn-porvenir::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.2);
        transition: left 0.3s ease;
        z-index: 1;
    }

    .btn-porvenir:hover::before {
        left: 100%;
    }

    .btn-porvenir span {
        position: relative;
        z-index: 2;
    }

    .btn-trabajo {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .btn-trabajo:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(102, 126, 234, 0.4);
    }

    .btn-productos {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .btn-productos:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(245, 87, 108, 0.4);
    }

    .btn-servicios {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .btn-servicios:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(79, 172, 254, 0.4);
    }

    .icon-button {
        font-size: 2.5rem;
        margin-bottom: 10px;
        display: block;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .porvenir-footer {
        position: relative;
        z-index: 2;
        margin-top: 40px;
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.95rem;
    }

    @media (max-width: 768px) {
        .porvenir-title {
            font-size: 2.5rem;
        }

        .porvenir-subtitle {
            font-size: 1.1rem;
            margin-bottom: 40px;
        }

        .porvenir-buttons {
            gap: 20px;
        }

        .btn-porvenir {
            padding: 20px 30px;
            font-size: 1rem;
        }

        .icon-button {
            font-size: 2rem;
        }
    }

    /* Efecto de partículas flotantes */
    .particle {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        pointer-events: none;
    }

    .particle-1 {
        width: 80px;
        height: 80px;
        top: 10%;
        left: 10%;
        animation: float 6s ease-in-out infinite;
    }

    .particle-2 {
        width: 60px;
        height: 60px;
        top: 60%;
        right: 10%;
        animation: float 8s ease-in-out infinite 1s;
    }

    .particle-3 {
        width: 100px;
        height: 100px;
        bottom: 10%;
        left: 50%;
        animation: float 7s ease-in-out infinite 2s;
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(30px);
        }
    }
</style>

<div class="porvenir-hero">
    <!-- Partículas de fondo -->
    <div class="particle particle-1"></div>
    <div class="particle particle-2"></div>
    <div class="particle particle-3"></div>

    <div class="porvenir-content">
        <h1 class="porvenir-title">🏛️ PORVENIR PRODUCE</h1>
        
        <p class="porvenir-subtitle">
            Conecta oportunidades de negocio, empleo y servicios en nuestra plataforma
        </p>

        <div class="porvenir-buttons">
            <!-- Botón Bolsa de Trabajo -->
            <a href="{{ url('/publicidad/bolsa-trabajo') }}" class="btn-porvenir btn-trabajo">
                <span class="icon-button">💼</span>
                <span>Bolsa de Trabajo</span>
            </a>

            <!-- Botón Productos -->
            <a href="{{ url('/publicidad/productos') }}" class="btn-porvenir btn-productos">
                <span class="icon-button">🏪</span>
                <span>Productos</span>
            </a>

            <!-- Botón Servicios -->
            <a href="{{ url('/publicidad/servicios') }}" class="btn-porvenir btn-servicios">
                <span class="icon-button">🔧</span>
                <span>Servicios</span>
            </a>
        </div>

        <div class="porvenir-footer">
            <p>
                <small>
                    Explora las mejores oportunidades de trabajo, productos y servicios disponibles en nuestra región.
                </small>
            </p>
        </div>
    </div>
</div>

@endsection
