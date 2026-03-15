@extends('layouts.app')
@section('content')
<style>
    .comida-card { border: 3px solid #f8b133; border-radius: 20px; padding: 15px; margin-bottom: 15px; position: relative; }
    .btn-validar { position: absolute; bottom: 10px; right: 15px; background: #7276d1; color: white; border: none; border-radius: 12px; padding: 4px 12px; font-size: 0.8rem; }
</style>
<div class="container py-4" style="max-width: 500px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('panel.nutriologo') }}" class="text-dark fs-4"><i class="bi bi-arrow-left"></i></a>
        <h5 class="fw-bold m-0">Ajustar plan alimenticio</h5>
        <i class="bi bi-chat-dots fs-4"></i>
    </div>

    @foreach(['Desayuno', 'Colación', 'Comida', 'Cena'] as $comida)
    <div class="comida-card bg-white">
        <label class="fw-bold d-block mb-1">{{ $comida }}</label>
        <textarea class="form-control border-0 p-0 shadow-none" rows="2" style="resize:none;">Ejemplo de dieta para {{ $comida }}...</textarea>
        <button class="btn-validar">Validar</button>
    </div>
    @endforeach
</div>
@endsection