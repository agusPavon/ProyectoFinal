@extends('layouts.admin')

@section('content')
     <!-- 🔙 BOTÓN VOLVER -->
        <a href="{{ route('admin.cafes.index') }}"
           class="px-4 py-2 rounded-lg text-sm font-semibold bg-[var(--marron-tostado)] text-white hover:bg-[#6b3e1f] transition shadow">
            ← Volver al Panel
        </a>

<div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-lg border border-[#f3e4ce] overflow-hidden my-10">
  <div class="flex justify-between items-center bg-gradient-to-r from-[#FEF8E0] to-[#FFFDF8] px-6 py-5 border-b border-[#f1e0c5]">
    <h2 class="text-2xl font-trocchi text-[var(--marron-tostado)]">📬 Sugerencias de Cafeterías</h2>
  </div>

  <table class="w-full border-collapse text-left">
    <thead class="bg-[#fff9ee] text-[var(--marron-tostado)]">
      <tr>
        <th class="p-3 border-b">Nombre</th>
        <th class="p-3 border-b">Dirección</th>
        <th class="p-3 border-b">Estado</th>
        <th class="p-3 border-b">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach($suggestions as $s)
      <tr class="hover:bg-[#fff3e0] transition">
        <td class="p-3 border-b">{{ $s->name }}</td>
        <td class="p-3 border-b">{{ $s->address }}</td>
        <td class="p-3 border-b">
          @if($s->status == 'pendiente')
            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-sm">Pendiente</span>
          @elseif($s->status == 'aprobada')
            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm">Aprobada</span>
          @else
            <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-sm">Rechazada</span>
          @endif
        </td>
        <td class="p-3 border-b">
          <a href="{{ route('admin.cafes.suggestions.show', $s->id) }}" class="text-[var(--marron-tostado)] hover:underline">Ver</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
