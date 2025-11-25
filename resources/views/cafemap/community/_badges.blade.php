<div class="flex gap-2 mt-2">
    @foreach($user->badges as $badge)
        <span class="text-xl">{{ $badge->icon }}</span>
    @endforeach
</div>