@extends('layouts.app')

@section('title', 'Pacientes - Nutriólogo')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<nav class="sidebar" style="background: #f4f9f9; border-right: 2px solid #e0f2f1; width: 260px; height: 100vh; position: fixed;">
    <div class="p-4 text-center">
        <h4 class="fw-bold" style="color: #43cea2;">NutriPeques</h4>
        <small class="text-muted">Panel Nutricional</small>
    </div>
    <div class="nav-menu px-3">
        <a href="{{ route('panel.nutriologo') }}" class="nav-link p-3 mb-2 rounded-3 text-dark">
            <i class="bi bi-grid-fill me-2"></i> Inicio
        </a>
        <a href="{{ route('nutri.pacientes') }}" class="nav-link active p-3 mb-2 rounded-3 bg-primary text-white">
            <i class="bi bi-people-fill me-2"></i> Mis Pacientes
        </a>
        <a href="{{ route('perfil') }}" class="nav-link p-3 mb-2 rounded-3 text-dark">
            <i class="bi bi-person-circle me-2"></i> Mi Perfil
        </a>
    </div>
</nav>

<div class="main-content" style="margin-left: 260px; padding: 40px;">
    <div class="header mb-4">
        <h2 class="fw-bold">Listado de Niños</h2>
        <p class="text-muted">Información básica para prescripción de planes</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Nombre del Niño</th>
                        <th>Edad</th>
                        <th>Peso / Talla</th>
                        <th class="text-center">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ninos as $nino)
                    <tr>
                        <td class="ps-4 fw-bold">{{ $nino['nombre'] }}</td>
                        <td>{{ $nino['edad'] }} años</td>
                        <td>
                            <span class="badge bg-light text-dark">{{ $nino['peso'] }} kg</span>
                            <span class="badge bg-light text-dark">{{ $nino['talla'] }} m</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('nino.asignar_plan', $nino['id']) }}" class="btn btn-primary rounded-pill px-4">
                                <i class="bi bi-journal-plus me-1"></i> Asignar Plan
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection