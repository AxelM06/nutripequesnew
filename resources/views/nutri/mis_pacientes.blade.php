@extends('layouts.app')

@section('title', 'Mis Pacientes Activos - Nutripeques')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700;800&display=swap');

    :root {
        --primary-purple: #7276d1;
        --soft-purple-bg: #f0f2ff;
        --bg-main: #f4f9f9;
        --card-bg: #ffffff;
        --text-dark: #2d3436;
        --sidebar-width: 280px;
    }

    body {
        background-color: var(--bg-main);
        font-family: 'Quicksand', sans-serif;
        color: var(--text-dark);
        margin: 0;
    }

    /* --- SIDEBAR MAESTRO (CALCO DEL PERFIL) --- */
    .sidebar {
        width: 280px; height: 100vh; position: fixed;
        left: 0; top: 0; background: var(--card-bg);
        padding: 30px 15px 15px 15px; 
        box-shadow: 10px 0 40px rgba(0,0,0,0.03);
        z-index: 1000; display: flex; flex-direction: column;
    }

    .logo-container {
        text-align: center; 
        margin-bottom: 25px; 
        border-bottom: 1px solid #f0f0f0; 
        padding-bottom: 15px;
    }

    .nav-menu { flex-grow: 1; }

    .nav-item {
        display: flex; align-items: center;
        padding: 12px 15px; margin-bottom: 5px;
        color: #636e72; text-decoration: none;
        border-radius: 20px; transition: 0.3s; font-weight: 600;
    }

    .nav-item:hover, .nav-item.active {
        background: var(--soft-purple-bg);
        color: var(--primary-purple);
    }

    .nav-item i { margin-right: 12px; font-size: 1.1rem; }

    .btn-logout-sidebar {
        background: #fff0f0; color: #ff5e5e; border: none; padding: 10px;
        border-radius: 12px; width: 100%; font-weight: 700; font-size: 13px;
        transition: 0.3s;
    }
    .btn-logout-sidebar:hover { background: #ff5e5e; color: white; }

    /* --- CONTENIDO --- */
    .main-wrapper {
        margin-left: var(--sidebar-width);
        padding: 40px;
    }

    .table-card {
        background: white; 
        border-radius: 35px; 
        padding: 40px; 
        box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        border: 8px solid white;
    }

    .status-badge {
        padding: 8px 15px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.85rem;
    }
</style>

<nav class="sidebar">
    <div class="logo-container">
        <div style="display: inline-flex; align-items: baseline; gap: 4px;">
            <span style="font-weight: 800; font-size: 18px; color: #333;">Nutri</span>
            <div style="font-size: 16px; font-weight: 800; display: flex; gap: 1px;">
                <span style="color: #ff786e;">P</span><span style="color: #aec982;">e</span>
                <span style="color: #ffadd1;">q</span><span style="color: #f4be5d;">u</span>
                <span style="color: #b3caff;">e</span><span style="color: #ff786e;">s</span>
            </div>
        </div>
    </div>

    <div class="nav-menu">
        <a href="{{ route('perfil') }}" class="nav-item">
            <i class="bi bi-person-circle"></i> <span>Mi Perfil</span>
        </a>
        <a href="{{ route('panel.nutriologo') }}" class="nav-item">
            <i class="bi bi-grid-1x2-fill"></i> <span>Panel Control</span>
        </a>
        <a href="{{ route('nutri.pacientes') }}" class="nav-item">
            <i class="bi bi-people"></i> <span>Pacientes</span>
        </a>
        <a href="{{ route('nutri.mis_pacientes') }}" class="nav-item active">
            <i class="bi bi-heart-pulse-fill"></i> <span>Mis Pacientes</span>
        </a>
        <a href="{{ route('nutri.mensajes') }}" class="nav-item">
            <i class="bi bi-chat-dots-fill"></i> <span>Mensajería</span>
        </a>
    </div>

    <form action="{{ route('logout') }}" method="POST" style="margin-top: auto;">
        @csrf
        <button type="submit" class="btn-logout-sidebar">
            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
        </button>
    </form>
</nav>

<div class="main-wrapper">
    <div class="table-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-800" style="color: #333; margin-bottom: 5px;">Mis Pacientes en Seguimiento</h2>
                <p class="text-muted fw-600 mb-0">Niños vinculados a tu consulta profesional.</p>
            </div>
            <div class="text-end">
                <span class="badge rounded-pill px-4 py-2" style="background: var(--soft-purple-bg); color: var(--primary-purple); font-weight: 800;">
                    {{ count($misPacientes) }} Pacientes Activos
                </span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="border-radius: 20px 0 0 20px;">Nombre del Paciente</th>
                        <th>Último Peso Registrado</th>
                        <th>Estado Nutricional (IMC)</th>
                        <th class="text-center" style="border-radius: 0 20px 20px 0;">Estatus</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($misPacientes as $nino)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: #eeeffb; border-radius: 12px; color: var(--primary-purple);">
                                    <i class="bi bi-person-check-fill"></i>
                                </div>
                                <span class="fw-700 text-dark">{{ $nino['nombre'] }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="fw-600 text-dark">{{ $nino['peso'] }} kg</span>
                        </td>
                        <td>
                            @php
                                $imc = $nino['imc'];
                                $color = ($imc < 18.5) ? '#f59e0b' : (($imc > 24.9) ? '#ef4444' : '#10b981');
                                $bg = $color . '15';
                                $texto = ($imc < 18.5) ? 'Bajo Peso' : (($imc > 24.9) ? 'Sobrepeso' : 'Normal');
                            @endphp
                            <span class="status-badge" style="background-color: {{ $bg }}; color: {{ $color }}; border: 1px solid {{ $color }}40;">
                                <i class="bi bi-activity me-1"></i> {{ $imc }} ({{ $texto }})
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2 fw-bold" style="font-size: 0.75rem;">
                                <i class="bi bi-check-circle-fill me-1"></i> En seguimiento
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="mb-3">
                                <i class="bi bi-folder2-open display-4 text-muted opacity-25"></i>
                            </div>
                            <h5 class="text-muted fw-600">No hay pacientes asignados todavía</h5>
                            <p class="text-muted small">Ve a la pestaña "Pacientes" para elegir a un niño.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection