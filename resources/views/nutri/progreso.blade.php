@extends('layouts.app')
@section('content')
<div class="container py-4" style="max-width: 500px;">
    <a href="{{ route('panel.nutriologo') }}" class="text-dark fs-4"><i class="bi bi-arrow-left"></i></a>
    <h4 class="fw-bold mt-3 text-center">Progreso del Niño</h4>
    
    <div class="bg-white p-4 rounded-4 shadow-sm mt-4 text-center">
        <i class="bi bi-graph-up text-danger" style="font-size: 4rem;"></i>
        <p class="mt-3 fw-bold">Gráfica de Comidas Cumplidas</p>
        <hr>
        <div class="row text-center">
            <div class="col-6"><strong>Peso:</strong><br>25 kg</div>
            <div class="col-6"><strong>Estatura:</strong><br>1.20 m</div>
        </div>
    </div>
</div>
@endsection