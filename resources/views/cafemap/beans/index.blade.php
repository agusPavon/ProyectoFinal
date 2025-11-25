@extends('layouts.beans')

@section('content')

<div class="beans-wrapper">

    <!-- =============================== -->
    <!--       CABECERA / NIVEL          -->
    <!-- =============================== -->

    <div class="level-card">
        <h2 class="section-title">Tu Nivel</h2>

        <div class="badge-section">
            <div class="badge-icon">{{ $currentBadge->icon }}</div>
            <h3 class="badge-name">{{ $currentBadge->name }}</h3>
            <p class="level-text">Nivel {{ $level }}</p>
        </div>

        <!-- Círculo de progreso -->
        <div class="circle-container">
            <svg class="progress-ring" width="160" height="160">
                <circle class="progress-ring-bg" cx="80" cy="80" r="68" />
                <circle class="progress-ring-fill" cx="80" cy="80" r="68"
                        data-progress="{{ round($progress * 100) }}" />
            </svg>
            <div class="circle-label">
                {{ round($progress * 100) }}%
            </div>
        </div>

        <!-- Texto de avance -->
        <p class="next-level-text">
            @if($nextBadge)
                Te faltan <strong>{{ $nextBadge->required_beans - $beans }}</strong> Beans para
                convertirte en <strong>{{ $nextBadge->name }}</strong> ✨
            @else
                ¡Alcanzaste el nivel máximo! 🌟 Eres un verdadero experto cafetero.
            @endif
        </p>
    </div>



    <!-- =============================== -->
    <!--       HISTORIAL DE BEANS        -->
    <!-- =============================== -->

    <h2 class="section-title mt-8">Historial de Beans</h2>

    <div class="timeline">

        @forelse ($history as $item)
            <div class="timeline-item">
                <div class="dot"></div>

                <div class="timeline-box">
                    <p class="beans-earned">+{{ $item->beans }} Beans</p>

                    <p class="history-desc">
                        {{ ucfirst($item->action) }} — {{ $item->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>
        @empty
            <p class="empty-history">Todavía no sumaste Beans. Explorá cafés y empezá a ganar ☕✨</p>
        @endforelse
    </div>


    <!-- =============================== -->
    <!--         INCENTIVO FINAL         -->
    <!-- =============================== -->

    <div class="cta-section">
        <h3 class="cta-title">¡Seguí explorando!</h3>
        <p class="cta-text">Visitá nuevas cafeterías, dejá reseñas y hacé check-ins para subir de nivel.</p>

        <a href="/mapa" class="cta-btn">Ir al mapa</a>
    </div>


</div>

<!-- =============================== -->
<!--   MODAL SUBISTE DE NIVEL        -->
<!-- =============================== -->

@if(session('leveled_up'))
<div id="level-up-modal" class="level-up-modal">
    <div class="level-up-content">
        <h2>🎉 ¡Subiste de nivel!</h2>

        <p class="modal-badge">{{ session('new_badge_icon') }} {{ session('new_badge') }}</p>

        <button id="close-level-modal" class="modal-btn">Continuar</button>
    </div>
</div>
@endif


@endsection





@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {

    // ====== Progreso del círculo ======
    const circle = document.querySelector('.progress-ring-fill');
    if (circle) {
        const radius = circle.r.baseVal.value;
        const circumference = radius * 2 * Math.PI;

        const progress = circle.dataset.progress;

        circle.style.strokeDasharray = `${circumference} ${circumference}`;
        circle.style.strokeDashoffset = circumference - (progress / 100) * circumference;
    }

    // ====== Modal Level Up ======
    const modal = document.getElementById('level-up-modal');
    if (modal) {
        document.getElementById('close-level-modal').onclick = () => {
            modal.style.display = 'none';
        };

        // Confetti efecto
        confetti();
    }
});
</script>

<!-- Librería confetti -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

@endpush