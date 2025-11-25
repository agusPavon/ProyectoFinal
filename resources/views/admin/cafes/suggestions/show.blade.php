@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-lg border border-[#f3e4ce] overflow-hidden my-10">
  <div class="p-6">
    <h2 class="text-2xl font-trocchi text-[var(--marron-tostado)] mb-4">☕ {{ $suggestion->name }}</h2>

    <p class="mb-2"><strong>Dirección:</strong> {{ $suggestion->address }}</p>
    <p class="mb-2"><strong>Web:</strong> {{ $suggestion->website ?? '—' }}</p>
    <p class="mb-2"><strong>Tostado:</strong> {{ $suggestion->roasting_type ?? '—' }}</p>
    <p class="mb-4"><strong>Estado:</strong>
      <span class="capitalize">{{ $suggestion->status }}</span>
    </p>

    @if($suggestion->attributes)
    <h3 class="font-trocchi text-lg text-[var(--marron-tostado)] mb-2">Características</h3>
    <div class="flex flex-wrap gap-2 mb-4">
      @foreach(json_decode($suggestion->attributes, true) as $attr)
        <span class="bg-[#f6ecda] text-[var(--marron-tostado)] px-3 py-1 rounded-full text-sm">{{ ucfirst($attr) }}</span>
      @endforeach
    </div>
    @endif

    <div class="flex justify-end gap-3 mt-6">
      <form action="{{ route('admin.cafes.suggestions.approve', $suggestion->id) }}" method="POST">
        @csrf
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">Aprobar</button>
      </form>

      <form action="{{ route('admin.cafes.suggestions.reject', $suggestion->id) }}" method="POST">
        @csrf
        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">Rechazar</button>
      </form>
    </div>
  </div>
</div>
@endsection
