<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Panel Administrativo - PORVENIR PRODUCE</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom-theme.css') }}">

    <style>
        :root {
            --color-primary: #004a99;
            --color-secondary: #f4f7f6;
            --color-accent: #d4af37;
            --color-text: #333333;
        }

        body {
            background: var(--color-secondary);
        }

        .sidebar {
            width: 280px;
            min-height: 100vh;
            background: linear-gradient(135deg, #ffffff 0%, var(--color-secondary) 100%);
            border-right: 3px solid var(--color-primary);
            padding: 2rem 1.5rem;
            box-shadow: 2px 0 8px rgba(0, 74, 153, 0.1);
        }

        .sidebar h2 {
            color: var(--color-primary);
            font-size: 1.4rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sidebar h2::before {
            content: '';
            width: 4px;
            height: 24px;
            background: linear-gradient(180deg, var(--color-accent), var(--color-primary));
            border-radius: 2px;
        }

        .sidebar hr {
            border-color: var(--color-accent);
            border-width: 2px;
            margin: 1rem 0;
        }

        .sidebar-section {
            margin-bottom: 1.5rem;
        }

        .sidebar-section-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--color-primary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--color-accent);
        }

        .section-links {}

        .sidebar-section.collapsed .section-links {
            display: none;
        }

        .toggle-section-btn {
            font-size: 0.85rem;
            padding: 0.15rem 0.45rem;
            line-height: 1;
        }

        .sidebar-link {
            display: block;
            margin-bottom: 0.8rem;
            padding: 0.6rem 0.8rem;
            text-decoration: none;
            color: var(--color-text);
            border-radius: 6px;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            margin-left: 0.5rem;
        }

        .sidebar-link:hover {
            background-color: rgba(0, 74, 153, 0.08);
            border-left-color: var(--color-accent);
            color: var(--color-primary);
            transform: translateX(5px);
        }

        .content-wrapper {
            flex: 1;
            padding: 2rem;
            background: var(--color-secondary);
        }

        .page-header {
            margin-bottom: 2rem;
        }
    </style>

</head>

<body>

<div class="d-flex align-items-start">

    <!-- SIDEBAR -->
    <div class="sidebar">

        <h2>
            🚀 PORVENIR PRODUCE
        </h2>

        <hr>

        <div class="sidebar-section" id="indicatorsSection">
            <div class="d-flex align-items-center justify-content-between sidebar-section-title">
                <div>📊 Indicadores</div>
                <button type="button" data-target="indicatorLinks" class="btn btn-sm btn-outline-secondary toggle-section-btn" aria-expanded="true" aria-controls="indicatorLinks">▾</button>
            </div>
            <div id="indicatorLinks" class="section-links">
                <a href="{{ url('admin/indicadores-bolsa') }}" class="sidebar-link">📈 Indicadores Bolsa de Trabajo</a>
                <a href="{{ url('admin/indicadores-productos') }}" class="sidebar-link">📊 Indicadores Productos</a>
                <a href="{{ url('admin/indicadores-servicios') }}" class="sidebar-link">🛠 Indicadores Servicios</a>
            </div>
        </div>
        <div class="sidebar-section" id="bolsaSection">
            <div class="d-flex align-items-center justify-content-between sidebar-section-title">
                <div>💼 Bolsa de Trabajo</div>
                <button type="button" data-target="bolsaLinks" class="btn btn-sm btn-outline-secondary toggle-section-btn" aria-expanded="true" aria-controls="bolsaLinks">▾</button>
            </div>
            <div id="bolsaLinks" class="section-links">
                <a href="{{ url('admin/validacion-formularios') }}" class="sidebar-link">📄 Validación Formularios</a>
                <a href="{{ url('admin/rechazados') }}" class="sidebar-link">❌ Rechazados</a>
                <a href="{{ url('admin/bolsa-trabajo') }}" class="sidebar-link">💼 Publicaciones</a>
                <a href="{{ url('admin/postulantes') }}" class="sidebar-link">👥 Postulantes</a>
            </div>
        </div>

        <!-- PRODUCTOS -->

        <div class="sidebar-section mb-4" id="productosSection">
            <div class="d-flex align-items-center justify-content-between sidebar-section-title">
                <div>🛍 Productos</div>
                <button type="button" data-target="productosLinks" class="btn btn-sm btn-outline-secondary toggle-section-btn" aria-expanded="true" aria-controls="productosLinks">▾</button>
            </div>
            <div id="productosLinks" class="section-links ps-3">
                <a href="{{ url('admin/formularios-productos') }}" class="d-block mb-3 text-decoration-none text-dark sidebar-link">📦 Formularios Productos</a>
                <a href="{{ url('admin/productos') }}" class="d-block mb-3 text-decoration-none text-dark sidebar-link">📰 Publicaciones</a>
                <a href="{{ url('admin/productos-rechazados') }}" class="d-block mb-3 text-decoration-none text-dark sidebar-link">❌ Productos Rechazados</a>
            </div>
        </div>

        <!-- SERVICIOS -->

        <div class="sidebar-section mb-4" id="serviciosSection">
            <div class="d-flex align-items-center justify-content-between sidebar-section-title">
                <div>🛠 Servicios</div>
                <button type="button" data-target="serviciosLinks" class="btn btn-sm btn-outline-secondary toggle-section-btn" aria-expanded="true" aria-controls="serviciosLinks">▾</button>
            </div>
            <div id="serviciosLinks" class="section-links ps-3">
                <a href="{{ url('admin/formularios-servicios') }}" class="d-block mb-3 text-decoration-none text-dark sidebar-link">📄 Formularios Servicios</a>
                <a href="{{ url('admin/publicaciones-servicios') }}" class="d-block mb-3 text-decoration-none text-dark sidebar-link">📰 Publicaciones Servicios</a>
                <a href="{{ url('admin/servicios-rechazados') }}" class="d-block mb-3 text-decoration-none text-dark sidebar-link">❌ Servicios Rechazados</a>
            </div>
        </div>

    </div>


    <!-- CONTENIDO -->

    <div class="content-wrapper">

        @yield('content')

    </div>

</div>

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    (function() {
        var buttons = document.querySelectorAll('.toggle-section-btn');
        var storageKey = 'adminSidebarSectionState';

        function loadState() {
            try {
                return JSON.parse(localStorage.getItem(storageKey) || '{}');
            } catch (e) {
                return {};
            }
        }

        function saveState(state) {
            try {
                localStorage.setItem(storageKey, JSON.stringify(state));
            } catch (e) {
                // ignore storage errors
            }
        }

        var state = loadState();

        buttons.forEach(function(btn) {
            var section = btn.closest('.sidebar-section');
            var sectionId = section ? section.id : null;

            function updateButton(collapsed) {
                btn.setAttribute('aria-expanded', (!collapsed).toString());
                btn.textContent = collapsed ? '▸' : '▾';
            }

            if (sectionId && state[sectionId]) {
                section.classList.add('collapsed');
                updateButton(true);
            }

            btn.addEventListener('click', function(event) {
                event.stopPropagation();
                if (!section || !sectionId) {
                    return;
                }

                var collapsed = section.classList.toggle('collapsed');
                state[sectionId] = collapsed;
                saveState(state);
                updateButton(collapsed);
            });
        });
    })();
</script>

</html>