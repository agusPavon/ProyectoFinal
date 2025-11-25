@forelse ($posts as $post)

    @php
        $isMine = auth()->id() === ($post['user_id'] ?? null);
    @endphp

    {{-- 🔎 REVIEW --}}
    @if ($post['type'] === 'review')
        <article class="barista-card bg-cremoso {{ $isMine ? 'post-mine' : '' }}">

            <div class="barista-header flex items-center gap-2">
                <img src="https://www.pngall.com/wp-content/uploads/5/Profile-Avatar-PNG.png"
                     alt="Avatar" class="user-avatar-compact">
                <strong>{{ $post['user'] }}</strong>
            </div>

            <p class="text-texto-secundario">
                En <strong>{{ $post['cafe'] }}</strong>
                — ⭐{{ $post['rating'] ?? 'N/A' }}
            </p>

            @if (!empty($post['comment']))
                <p class="text-texto-secundario">{{ $post['comment'] }}</p>
            @endif

            <span class="post-time-compact text-texto-secundario">
                {{ $post['time'] }}
            </span>
        </article>
    @endif

    {{-- 📍 CHECK-IN --}}
    @include('cafemap.community._checkins', ['isMine' => $isMine])

@empty
    <p class="empty-state">No hay actividad reciente.</p>
@endforelse