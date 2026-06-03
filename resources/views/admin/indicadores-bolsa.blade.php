@extends('admin.layout')

@section('content')

<style>
    .indicator-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        padding: 24px;
        min-height: 180px;
    }

    .indicator-title {
        font-weight: 700;
        margin-bottom: 12px;
        color: #004a99;
    }

    .indicator-value {
        font-size: 2.5rem;
        font-weight: 800;
        color: #1a3d7c;
        margin-bottom: 10px;
    }

    .indicator-meta {
        color: #586775;
        font-size: 0.95rem;
    }

    .chart-card {
        background: white;
        border-radius: 18px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        padding: 24px;
    }

    .chart-header {
        margin-bottom: 18px;
    }

    .chart-header h3 {
        margin: 0;
        color: #004a99;
        font-weight: 800;
    }

    .chart-header p {
        margin: 4px 0 0;
        color: #586775;
    }
</style>

<div class="page-header">
    <h2>Indicadores - Bolsa de Trabajo</h2>
    <p class="text-muted">Métricas específicas de la bolsa de trabajo.</p>
</div>

<div class="row gy-4">
    <div class="col-md-6">
        <div class="indicator-card">
            <div class="indicator-title">Publicaciones activas</div>
            <div class="indicator-value">--</div>
            <div class="indicator-meta">Total de publicaciones actualmente activas</div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="indicator-card">
            <div class="indicator-title">Postulantes hoy</div>
            <div class="indicator-value">--</div>
            <div class="indicator-meta">Postulaciones recibidas en las últimas 24 horas</div>
        </div>
    </div>

    <div class="col-12">
        <div class="chart-card">
            <div class="chart-header">
                <h3>Postulaciones por empresa</h3>
                <p>Cuántas postulaciones tiene cada empresa en las ofertas laborales.</p>
            </div>
            <canvas id="postulacionesEmpresaChart" style="max-height: 420px;"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const labels = @json($postulacionesPorEmpresa->pluck('nombre_empresa'));
        const data = @json($postulacionesPorEmpresa->pluck('total_postulados'));

        const ctx = document.getElementById('postulacionesEmpresaChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Postulaciones',
                    data: data,
                    backgroundColor: 'rgba(0, 74, 153, 0.8)',
                    borderColor: 'rgba(0, 74, 153, 1)',
                    borderWidth: 1,
                    borderRadius: 10,
                    maxBarThickness: 44
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: { label: function(context) { return context.parsed.y + ' postulaciones'; } } }
                },
                scales: {
                    x: {
                        ticks: { color: '#33475b' },
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { color: '#33475b', precision: 0 },
                        grid: { color: 'rgba(0, 74, 153, 0.08)' }
                    }
                }
            }
        });
    });
</script>

@endsection
