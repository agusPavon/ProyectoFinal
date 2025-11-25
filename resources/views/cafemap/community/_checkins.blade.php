 @if ($post['type'] === 'checkin')
        <article class="checkin-compact-card bg-marron-tostado-light {{ $isMine ? 'post-mine' : '' }}">
           


            <div class="user-info flex items-center gap-2">
                <img src="https://www.pngall.com/wp-content/uploads/5/Profile-Avatar-PNG.png"
                     alt="Avatar" class="user-avatar-compact">

                <div class="checkin-details">
                    <p class="Font-poppins post-user text-texto-principal">
                        {{ $post['user'] }} hizo un Check-in en {{ $post['cafe'] }}
                    </p>

                    <span class="post-time-compact text-texto-secundario">
                        {{ $post['time'] }}
                    </span>
                </div>
            </div>

            {{-- Foto opcional --}}
            @if(!empty($post['image']))
              <img src="{{ Storage::url($post['image']) }}" alt="foto ckeck-in" class="rounded-lg mt-2 w-full">

            @endif

            {{-- Comentario opcional --}}
            @if (!empty($post['comment']))
                <p class="text-texto-secundario mt-2">{{ $post['comment'] }}</p>
            @endif

        </article>
    @endif