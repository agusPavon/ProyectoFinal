
<section class="cafes-list-container">
  <h3 class="section-heading font-trocchi text-marron-tostado">Cafeterías cercanas</h3>
  <div class="cafes-list"> @foreach($cafes as $cafe)
    <div class="cafe-card bg-cremoso" data-id="{{ $cafe->id }}">
      <h3 class="text-marron-tostado font-trocchi">{{ $cafe->name }}</h3>
      <p>{{ $cafe->address }}</p>
      <p>⭐ {{ number_format($cafe->average_rating, 1) }}</p>
      @if($cafe->description)
        <p class="text-texto-secundario">{{ Str::limit($cafe->description, 80) }}</p>
      @endif
    </div>
  @endforeach</div>
</section>

