@extends('layouts.app')

@section('title', 'Pacientes - Nutripeques')

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

    /* --- SIDEBAR --- */
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
        background: white; border-radius: 35px;
        padding: 40px; box-shadow: 0 15px 35px rgba(0,0,0,0.05);
    }

    .btn-choose {
        background: var(--primary-purple); color: white;
        border-radius: 15px; padding: 10px 25px;
        font-weight: 700; text-decoration: none; transition: 0.3s;
        border: none; display: inline-flex; align-items: center; gap: 8px;
    }
    .btn-choose:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(114, 118, 209, 0.3); color: white; }
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
        <a href="{{ route('nutri.pacientes') }}" class="nav-item active">
            <i class="bi bi-people"></i> <span>Pacientes</span>
        </a>
        <a href="{{ route('nutri.mis_pacientes') }}" class="nav-item">
            <i class="bi bi-heart-pulse-fill"></i> <span>Mis Pacientes</span>
        </a>
        {{-- EL BOTÓN QUE ESTABA AQUÍ CAUSABA EL ERROR --}}
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
                <h2 class="fw-800 mb-1" style="color: #333;">Directorio de Niños</h2>
                <p class="text-muted fw-600 mb-0">Seleccione un paciente para abrir su expediente.</p>
            </div>
            <span class="badge rounded-pill px-4 py-2" style="background: var(--soft-purple-bg); color: var(--primary-purple); font-weight: 700;">
                {{ count($ninos) }} Disponibles
            </span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="border-radius: 20px 0 0 20px;">Nombre Completo</th>
                        <th>Edad</th>
                        <th>Peso / Talla</th>
                        <th class="text-center" style="border-radius: 0 20px 20px 0;">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ninos as $nino)
                    <tr>
                        <td class="ps-4 fw-700">{{ $nino['nombre'] }}</td>
                        <td class="fw-600">{{ $nino['edad'] }} años</td>
                        <td>
                            <span class="badge bg-light text-dark border px-3 py-2" style="border-radius: 12px;">
                                <i class="bi bi-droplet-fill text-primary me-1"></i>{{ $nino['peso'] }} kg
                            </span>
                            <span class="badge bg-light text-dark border px-3 py-2" style="border-radius: 12px;">
                                <i class="bi bi-ruler text-primary me-1"></i>{{ $nino['talla'] }} m
                            </span>
                        </td>
                        <td class="text-center">
                            {{-- EL BOTÓN DEBE IR AQUÍ, DENTRO DEL LOOP --}}
                            <a href="{{ route('nutri.elegir', $nino['id']) }}" class="btn-choose">
                                <i class="bi bi-check2-circle"></i> Elegir Niño
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