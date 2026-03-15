@extends('layouts.app')

@section('title', 'Expedientes de Niños - Nutripeques')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap');

    :root {
        --primary-purple: #7b7fd4;
        --bg-main: #f0f4f9;
        --card-bg: #ffffff;
        --text-dark: #4a4a4a;
        --accent-blue: #e2eaf4;
        --logo-red: #ff786e;
        --logo-green: #aec982;
        --logo-pink: #ffadd1;
        --logo-yellow: #f4be5d;
        --logo-blue: #b3caff;
        --sidebar-width: 260px;
        
        /* Colores específicos de esta tabla */
        --imc-low: #f59e0b;
        --imc-good: #10b981;
        --imc-high: #ef4444;
    }

    body {
        background-color: var(--bg-main);
        font-family: 'Quicksand', sans-serif;
        color: var(--text-dark);
        margin: 0;
    }

    /* --- SIDEBAR --- */
    .sidebar {
        width: var(--sidebar-width);
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        background: var(--card-bg);
        padding: 30px 20px;
        box-shadow: 10px 0 30px rgba(0,0,0,0.02);
        z-index: 1100;
        display: flex;
        flex-direction: column;
    }

    .nav-menu { margin-top: 40px; flex-grow: 1; }

    .nav-item {
        display: flex;
        align-items: center;
        padding: 14px 18px;
        margin-bottom: 8px;
        color: #7d8492;
        text-decoration: none;
        border-radius: 16px;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .nav-item:hover, .nav-item.active {
        background: var(--accent-blue);
        color: var(--primary-purple);
    }

    .nav-item i { margin-right: 12px; font-size: 1.2rem; }

    /* --- LOGOS --- */
    .logo-container { text-align: center; }
    .logo-nutri { font-weight: 800; font-size: 28px; color: #000; display: block; line-height: 1; }
    .logo-peques { font-size: 24px; font-weight: 800; display: flex; justify-content: center; gap: 2px; }
    .logo-peques span:nth-child(1) { color: var(--logo-red); }
    .logo-peques span:nth-child(2) { color: var(--logo-green); }
    .logo-peques span:nth-child(3) { color: var(--logo-pink); }
    .logo-peques span:nth-child(4) { color: var(--logo-yellow); }
    .logo-peques span:nth-child(5) { color: var(--logo-blue); }
    .logo-peques span:nth-child(6) { color: var(--logo-red); }

    /* --- CONTENIDO --- */
    .main-wrapper {
        margin-left: var(--sidebar-width);
        padding: 40px;
        min-height: 100vh;
    }

    .page-header {
        background: white;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        margin-bottom: 30px;
    }

    .table-container {
        background: white;
        border-radius: 25px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .avatar-circle {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: white;
    }

    .imc-badge {
        padding: 8px 15px;
        border-radius: 12px;
        font-weight: 800;
        font-size: 1.1rem;
    }

    .btn-plan {
        background-color: #10b981;
        color: white;
        border: none;
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 700;
        transition: 0.3s;
    }

    .btn-plan:hover {
        background-color: #059669;
        transform: translateY(-2px);
        color: white;
    }

    .btn-logout {
        background: #fff0f0;
        color: #ff5e5e;
        border: none;
        padding: 12px;
        border-radius: 15px;
        width: 100%;
        font-weight: 700;
        margin-top: 20px;
    }

    .status-indicator {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
    }

    @media (max-width: 992px) {
        .sidebar { transform: translateX(-100%); }
        .main-wrapper { margin-left: 0; padding: 20px; }
    }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<nav class="sidebar">
    <div class="logo-container">
        <div class="logo-nutri">Nutri</div>
        <div class="logo-peques">
            <span>P</span><span>e</span><span>q</span><span>u</span><span>e</span><span>s</span>
        </div>
    </div>

    <div class="nav-menu">
        <a href="{{ url('/home') }}" class="nav-item">
            <i class="bi bi-house-door"></i>  Inicio
        </a>
        <a href="{{ route('ver.ninos') }}" class="nav-item active">
            <i class="bi bi-file-earmark-medical"></i>Niños registrados
        </a>
        <a href="{{ route('ver.usuarios') }}" class="nav-item">
            <i class="bi bi-people"></i> Usuarios
        </a>
        <a href="{{ route('admin.register_nutri') }}" class="nav-item">
            <i class="bi bi-shield-plus"></i> Nutriólogos
        </a>
        <a href="{{ route('admin.register') }}" class="nav-item">
            <i class="bi bi-person-gear"></i> Administradores
        </a>
        <a href="{{ route('ver.servicios') }}" class="nav-item">
            <i class="bi bi-apple"></i> Servicios
        </a>
        <a href="{{ route('ver.contactos') }}" class="nav-item">
            <i class="bi bi-chat-left-text"></i> Consultas
        </a>
        <a href="{{ route('perfil') }}" class="nav-item">
            <i class="bi bi-gear"></i> Perfil
        </a>
    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn-logout">
            <i class="bi bi-box-arrow-right"></i> Salir
        </button>
    </form>
</nav>

<div class="main-wrapper">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold mb-1 text-dark">Expedientes Nutricionales</h2>
            <p class="text-muted mb-0">Monitoreo global de niños y cálculo de IMC automático</p>
        </div>
        <div class="text-end">
            <span class="badge bg-light text-primary p-3 rounded-4 border">
                <i class="bi bi-people-fill me-2"></i> {{ count($ninos) }} Niños Registrados
            </span>
        </div>
    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Paciente</th>
                        <th>Tutor id</th>
                        <th>Edad</th>
                        <th>Medidas (P/T)</th>
                        <th>IMC Actual</th>
                        <th class="text-center">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ninos as $nino)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle me-3 bg-{{ $nino['genero'] ? 'info' : 'danger' }}">
                                    {{ substr($nino['nombre'], 0, 1) }}
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $nino['nombre'] }}</h6>
                                    <small class="text-muted">
                                        {{ $nino['genero'] ? 'Niño' : 'Niña' }}
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="text-dark small fw-bold">{{ $nino['correo'] }}</div>
                        </td>
                        <td>
                            <span class="fw-bold">{{ $nino['edad'] }} años</span>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="small"><i class="bi bi-geo-fill text-muted"></i> {{ $nino['peso'] }} kg</span>
                                <span class="small"><i class="bi bi-ruler text-muted"></i> {{ $nino['talla'] }} m</span>
                            </div>
                        </td>
                        <td>
                            @php
                                $statusColor = 'var(--imc-good)';
                                $statusText = 'Normal';
                                if($nino['imc'] < 18.5) { $statusColor = 'var(--imc-low)'; $statusText = 'Bajo Peso'; }
                                if($nino['imc'] > 24.9) { $statusColor = 'var(--imc-high)'; $statusText = 'Sobrepeso'; }
                            @endphp
                            <div class="d-flex align-items-center">
                                <span class="imc-badge me-2" style="color: {{ $statusColor }}; background: {{ $statusColor }}15;">
                                    {{ $nino['imc'] }}
                                </span>
                                <div class="small fw-bold d-none d-md-block" style="color: {{ $statusColor }};">
                                    <span class="status-indicator" style="background-color: {{ $statusColor }};"></span>
                                    {{ $statusText }}
                                </div>
                            </div>
                        </td>
                        <td class="text-center pe-4">
                            <a href="{{ route('nino.asignar_plan', $nino['id']) }}" class="btn btn-plan shadow-sm">
                                <i class="bi bi-journal-plus me-1"></i> Asignar Plan
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="bi bi-folder-x display-1 text-muted"></i>
                            <p class="mt-3 text-muted">No hay niños registrados en el sistema actualmente.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection