<div class="d-flex align-items-center justify-content-between mb-5">

    {{-- PASO 1 --}}
    <div class="text-center">

        <div class="
            rounded-circle d-flex align-items-center justify-content-center fw-bold
            {{ $paso >= 1 ? 'bg-success text-white' : 'bg-light border' }}
        "
        style="width:45px;height:45px;">

            @if($paso > 1)
                ✓
            @else
                1
            @endif

        </div>

        <small class="
            {{ $paso >= 1 ? 'text-success' : 'text-muted' }}
        ">
            Tipo Publicación
        </small>

    </div>


    <div class="flex-grow-1 border-top mx-3"></div>


    {{-- PASO 2 --}}
    <div class="text-center">

        <div class="
            rounded-circle d-flex align-items-center justify-content-center fw-bold
            {{ $paso == 2 ? 'bg-primary text-white' : '' }}
            {{ $paso > 2 ? 'bg-success text-white' : '' }}
            {{ $paso < 2 ? 'bg-light border' : '' }}
        "
        style="width:45px;height:45px;">

            @if($paso > 2)
                ✓
            @else
                2
            @endif

        </div>

        <small class="
            {{ $paso >= 2 ? 'text-primary' : 'text-muted' }}
        ">
            Información Empresa
        </small>

    </div>


    <div class="flex-grow-1 border-top mx-3"></div>


    {{-- PASO 3 --}}
    <div class="text-center">

        <div class="
            rounded-circle d-flex align-items-center justify-content-center fw-bold
            {{ $paso == 3 ? 'bg-primary text-white' : '' }}
            {{ $paso < 3 ? 'bg-light border' : '' }}
        "
        style="width:45px;height:45px;">

            3

        </div>

        <small class="
            {{ $paso == 3 ? 'text-primary' : 'text-muted' }}
        ">
            Detalles Publicación
        </small>

    </div>

</div>