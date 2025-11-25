@extends('layouts.config')

@section('content')
<a href="{{ route('cafemap.config.index') }}" class="back-btn-modern">
    ← Volver a Configuración
</a>
<h2 class="settings-title-modern">Bunaster Box</h2>

<p class="subtitle-modern">
    Elegí un plan y recibí una experiencia cafetera mensual ☕📦
</p>

<div class="plans-grid-modern">

    <!-- PLAN STARTER -->
    <div class="plan-modern">
        <div class="plan-header-modern starter">
            <h3>Starter</h3>
            <p>Ideal para iniciarte en el café de especialidad</p>
        </div>

        <div class="plan-content-modern">
            <div class="price-modern">AR$ 8.900 <span>/mes</span></div>

            <ul class="modern-features">
                <li>☕ 250g café seleccionado del mes</li>
                <li>🌱 Notas de cata y origen</li>
                <li>📬 Envío estándar</li>
            </ul>

            <button class="modern-btn">Elegir este plan</button>
        </div>
    </div>

    <!-- PLAN BARISTA (RECOMMENDED) -->
    <div class="plan-modern recommended">
        <div class="recommended-label">★ Recomendado</div>

        <div class="plan-header-modern barista">
            <h3>Barista</h3>
            <p>Experiencia completa cada mes</p>
        </div>

        <div class="plan-content-modern">
            <div class="price-modern">AR$ 14.900 <span>/mes</span></div>

            <ul class="modern-features">
                <li>☕ 500g café premium</li>
                <li>🍪 Snack gourmet</li>
                <li>🧰 Accesorio sorpresa</li>
                <li>📬 Envío prioritario</li>
            </ul>

            <button class="modern-btn featured">Elegir este plan</button>
        </div>
    </div>

    <!-- PLAN MASTER BREWER -->
    <div class="plan-modern">
        <div class="plan-header-modern master">
            <h3>Master Brewer</h3>
            <p>Para los que viven el café como ritual</p>
        </div>

        <div class="plan-content-modern">
            <div class="price-modern">AR$ 22.900 <span>/mes</span></div>

            <ul class="modern-features">
                <li>☕ Selección doble de café premium</li>
                <li>🎁 Accesorio barista mensual</li>
                <li>📚 Mini revista Bunaster</li>
                <li>📬 Envío ultra prioritario</li>
            </ul>

            <button class="modern-btn">Elegir este plan</button>
        </div>
    </div>

</div>

@endsection