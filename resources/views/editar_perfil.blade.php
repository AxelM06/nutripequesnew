@extends('layouts.app')

@section('title', 'Editar Registro - Nutripeques')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700;800&display=swap');

    :root {
        /* Colores Admin */
        --primary-purple: #7b7fd4;
        --accent-blue: #e2eaf4;
        /* Colores Usuario */
        --primary-cyan: #43cea2;
        --secondary-blue: #185a9d;
        --soft-cyan-bg: #dff0f6;
        
        --bg-main: #f0f4f9;
        --card-bg: #ffffff;
        --text-dark: #4a4a4a;
        --sidebar-width: 280px;
    }

    body {
        background-color: var(--bg-main);
        font-family: 'Quicksand', sans-serif;
        color: var(--text-dark);
        margin: 0;
    }

    /* --- SIDEBAR DINÁMICO --- */
    .sidebar {
        width: var(--sidebar-width);
        height: 100vh;
        position: fixed;
        left: 0; top: 0;
        background: var(--card-bg);
        padding: 20px;
        box-shadow: 10px 0 30px rgba(0,0,0,0.02);
        z-index: 1100;
        display: flex;
        flex-direction: column;
    }

    .nav-menu { margin-top: 20px; flex-grow: 1; display: flex; flex-direction: column; gap: 5px; }

    .nav-item {
        display: flex; align-items: center;
        padding: 12px 18px; margin-bottom: 4px;
        color: #7d8492; text-decoration: none;
        border-radius: 16px; transition: 0.3s;
        font-weight: 600;
    }

    /* Estilo cuando es Admin */
    .admin-nav.active, .admin-nav:hover {
        background: var(--accent-blue);
        color: var(--primary-purple);
    }

    /* Estilo cuando es Usuario */
    .user-nav.active, .user-nav:hover {
        background: var(--soft-cyan-bg);
        color: var(--secondary-blue);
    }

    .nav-item i { margin-right: 12px; font-size: 1.1rem; }

    /* --- CONTENIDO --- */
    .main-wrapper {
        margin-left: var(--sidebar-width);
        padding: 40px;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .edit-card {
        background: white;
        border-radius: 35px;
        padding: 40px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.05);
        max-width: 550px;
        width: 100%;
        border: 8px solid white;
    }

    .badge-type {
        background: #f8f9fa;
        color: #636e72;
        padding: 6px 15px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        margin-bottom: 10px;
        display: inline-block;
    }

    .form-control {
        border-radius: 15px;
        padding: 12px;
        border: 2px solid #f0f2f5;
    }

    /* Botón dinámico según rol */
    .btn-update {
        background: {{ session('rol') == 'admin' ? 'var(--primary-purple)' : 'var(--primary-cyan)' }};
        color: white;
        border-radius: 18px;
        padding: 15px;
        font-weight: 700;
        border: none;
        transition: 0.3s;
    }

    .btn-logout-sidebar {
        background: #fff0f0; color: #ff5e5e; border: none; padding: 12px;
        border-radius: 15px; width: 100%; font-weight: 700; margin-top: auto;
    }

    @media (max-width: 992px) {
        .sidebar { transform: translateX(-100%); }
        .main-wrapper { margin-left: 0; padding: 20px; }
    }
</style>

<nav class="sidebar">
    <div class="text-center mb-3">
        <span style="font-weight: 800; font-size: 20px;">Nutri<span style="color: var(--logo-red);">P</span>eques</span>
    </div>

    <div class="nav-menu">
        @if(session('rol') == 'admin')
            <a href="{{ route('home') }}" class="nav-item admin-nav">
                <i class="bi bi-house-door"></i> Inicio
            </a>
            <a href="{{ route('ver.ninos') }}" class="nav-item admin-nav">
                <i class="bi bi-file-earmark-medical"></i> Niños
            </a>
            <a href="{{ route('ver.usuarios') }}" class="nav-item admin-nav">
                <i class="bi bi-people"></i> Usuarios
            </a>
            <a href="{{ route('perfil') }}" class="nav-item admin-nav active">
                <i class="bi bi-gear"></i> Mi Perfil
            </a>
        @else
            <a href="{{ route('perfil') }}" class="nav-item user-nav active">
                <i class="bi bi-person-circle"></i> Mi Perfil
            </a>
            <a href="{{ route('panel.usuario') }}" class="nav-item user-nav">
                <i class="bi bi-grid-1x2-fill"></i> Inicio
            </a>
            <a href="{{ route('hijos.registrados') }}" class="nav-item user-nav">
                <i class="bi bi-people-fill"></i> Mis Hijos
            </a>
            <a href="{{ url('/crear_contacto') }}" class="nav-item user-nav">
                <i class="bi bi-envelope-paper-heart-fill"></i> Consulta
            </a>
        @endif
    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn-logout-sidebar">
            <i class="bi bi-box-arrow-right"></i> Salir
        </button>
    </form>
</nav>

<div class="main-wrapper">
    <div class="edit-card">
        <div class="text-center mb-4">
            <span class="badge-type">Configuración de {{ ucfirst($documento['coleccion']) }}</span>
            <h2 class="fw-bold">Editar Perfil</h2>
        </div>

        <form action="{{ url('/actualizar-firebase/'.$documento['coleccion'].'/'.$documento['id']) }}" method="POST">
            @csrf
            @method('PATCH')

            @foreach($documento as $campo => $valor)
                @if(!in_array($campo, ['id', 'coleccion', 'created_at', 'updated_at', 'createTime', 'updateTime', 'rol']))
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase" style="color: #a0a0a0;">
                            {{ str_replace('_', ' ', $campo) }}
                        </label>
                        <input type="{{ in_array(strtolower($campo), ['password', 'contraseña']) ? 'password' : 'text' }}" 
                               name="{{ $campo }}" class="form-control" value="{{ $valor }}" required>
                    </div>
                @endif
            @endforeach

            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-update">
                    <i class="bi bi-cloud-arrow-up-fill me-2"></i> Actualizar Ahora
                </button>
                <a href="{{ route('perfil') }}" class="btn btn-link text-muted text-decoration-none small fw-bold">
                    <i class="bi bi-arrow-left"></i> Cancelar y volver al perfil
                </a>
            </div>
        </form>
    </div>
</div>
@endsection