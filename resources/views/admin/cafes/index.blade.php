@extends('layouts.admin')

@section('content')

<div class="max-w-7xl mx-auto p-8">
  <div class="flex justify-between items-center mb-8">
    <h2 class="text-3xl font-trocchi text-[var(--marron-tostado)]">☕ Cafeterías registradas</h2>
     <a href="{{ route('admin.cafes.suggestions.index') }}" class="bg-[var(--marron-tostado)] text-white px-6 py-2.5 rounded-lg font-medium shadow hover:bg-[#6b3b10] transition">
Sugerencias
</a> 

    <a href="{{ route('admin.cafes.create') }}"
       class="bg-[var(--marron-tostado)] text-white px-6 py-2.5 rounded-lg font-medium shadow hover:bg-[#6b3b10] transition">
      + Nueva
    </a>
  </div>

  @if($cafes->isEmpty())
    <p class="text-center text-[var(--texto-secundario)] italic py-10">No hay cafeterías registradas todavía ☕</p>
  @else
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
    @foreach($cafes as $cafe)
    <div class="bg-white rounded-xl border border-[#f1e0c5] shadow-md hover:shadow-lg transition-all duration-200 p-4 flex flex-col justify-between">

      <!-- Nombre -->
      <div>
        <h3 class="font-trocchi text-[var(--marron-tostado)] text-lg mb-1">{{ $cafe->name }}</h3>
        <p class="text-[var(--texto-secundario)] text-sm leading-snug">{{ $cafe->address }}</p>
      </div>

      <!-- Rating -->
      <div class="mt-3 flex items-center gap-1 text-[#d28b0c]">
        <span>⭐</span>
        <span class="text-sm font-medium">{{ $cafe->average_rating ?? '—' }}</span>
      </div>

      <!-- Acciones -->
      <div class="mt-4 flex justify-end gap-3 text-[var(--marron-tostado)]">
        <a href="{{route('admin.cafes.edit', $cafe -> id)}}" title="Editar" class="hover:text-[#7a4d25] transition">
          <i class="fa-solid fa-pen"></i>
        </a>
        <a href="{{route('admin.cafes.show', $cafe -> id)}}" title="Ver detalles" class="hover:text-[#7a4d25] transition">
          <i class="fa-solid fa-eye"></i>
        </a>

    <form action="{{ route('admin.cafes.destroy', $cafe->id) }}"
          method="POST"
          onsubmit="return confirm('¿Estás seguro de que querés eliminar esta cafetería?')">
      @csrf
      @method('DELETE')
      <button type="submit" class="text-red-600 hover:underline"><i class="fa-solid fa-trash"></i></button>
    </form>
      </div>
    </div>
    @endforeach
  </div>
  @endif
</div>
@endsection

