@extends('layouts.app')

@section('title', 'Panel Nutriólogo - Nutripeques')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700;800&display=swap');

    :root {
        --primary-nutri: #43cea2; /* Verde/Cian médico */
        --secondary-nutri: #185a9d;
        --soft-nutri-bg: #dff0f6;
        --bg-main: #f4f9f9;
        --card-bg: #ffffff;
        --text-dark: #2d3436;
        --logo-red: #ff786e;
        --logo-green: #aec982;
        --logo-pink: #ffadd1;
        --logo-yellow: #f4be5d;
        --logo-blue: #b3caff;
    }

    body { background-color: var(--bg-main); font-family: 'Quicksand', sans-serif; margin: 0; }

    /* --- SIDEBAR NUTRIÓLOGO --- */
    .sidebar {
        width: 280px; height: 100vh; position: fixed;
        left: 0; top: 0; background: var(--card-bg);
        padding: 30px 20px;
        box-shadow: 10px 0 40px rgba(0,0,0,0.03);
        z-index: 1000; display: flex; flex-direction: column;
    }

    .logo-container {
        text-align: center; 
        margin-bottom: 25px; 
        border-bottom: 1px solid #f0f0f0; 
        padding-bottom: 15px;
    }

    .nav-menu { flex-grow: 1; margin-top: 20px; }

    .nav-item {
        display: flex; align-items: center;
        padding: 14px 18px; margin-bottom: 8px;
        color: #636e72; text-decoration: none;
        border-radius: 20px; transition: 0.3s; font-weight: 600;
    }

    .nav-item:hover, .nav-item.active {
        background: var(--soft-nutri-bg);
        color: var(--secondary-nutri);
    }

    .nav-item i { margin-right: 12px; font-size: 1.2rem; }

    /* --- ÁREA CENTRAL --- */
    .main-wrapper {
        margin-left: 280px; padding: 40px; min-height: 100vh;
        display: flex; align-items: center; justify-content: center;
    }

    .hero-panel {
        background: white; border-radius: 60px;
        padding: 60px; border: 12px solid white;
        box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        width: 100%; max-width: 1000px;
        text-align: center;
    }

    .menu-grid {
        display: grid; grid-template-columns: repeat(2, 1fr);
        gap: 25px; margin-top: 40px;
    }

    .menu-card {
        background: #fdfdfd; border-radius: 35px; padding: 35px;
        display: flex; flex-direction: column; align-items: center;
        text-align: center; text-decoration: none; color: #444;
        transition: 0.3s ease;
        box-shadow: 0 10px 20px rgba(0,0,0,0.02);
    }

    .menu-card:hover {
        transform: translateY(-10px);
        background: var(--soft-nutri-bg);
        box-shadow: 0 15px 30px rgba(24, 90, 157, 0.1);
    }

    .icon-circle {
        width: 80px; height: 80px; border-radius: 25px;
        display: flex; align-items: center; justify-content: center;
        font-size: 2.2rem; margin-bottom: 20px;
        background: white;
        box-shadow: 0 8px 15px rgba(0,0,0,0.05);
    }

    .btn-logout-alt {
        background: #fff0f0; color: #ff5e5e; border: none; padding: 14px;
        border-radius: 18px; width: 100%; font-weight: 700; margin-top: auto;
    }
</style>

<nav class="sidebar">
    <div class="logo-container">
        <div style="display: inline-flex; align-items: baseline; gap: 4px;">
            <span style="font-weight: 800; font-size: 22px; color: #333;">Nutri</span>
            <div class="logo-peques" style="font-size: 20px; font-weight: 800; display: flex; gap: 1px;">
                <span style="color: var(--logo-red);">P</span><span style="color: var(--logo-green);">e</span>
                <span style="color: var(--logo-pink);">q</span><span style="color: var(--logo-yellow);">u</span>
                <span style="color: var(--logo-blue);">e</span><span style="color: var(--logo-red);">s</span>
            </div>
        </div>
    </div>

    <div class="nav-menu">
        <a href="{{ route('panel.nutriologo') }}" class="nav-item active">
            <i class="bi bi-grid-1x2-fill"></i> <span>Inicio</span>
        </a>
        <a href="{{ route('nutri.pacientes') }}" class="nav-item">
            <i class="bi bi-people-fill"></i> <span>Pacientes</span>
        </a>
        <a href="{{ route('perfil') }}" class="nav-item">
            <i class="bi bi-person-circle"></i> <span>Mi Perfil</span>
        </a>
    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn-logout-alt">
            <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
        </button>
    </form>
</nav>

<div class="main-wrapper">
    <div class="hero-panel">
        <div class="mb-2">
            <span class="badge rounded-pill px-4 py-2 bg-light text-primary fw-bold shadow-sm">PANEL PROFESIONAL</span>
        </div>
        <h1 class="fw-800" style="font-size: 2.8rem; color: var(--text-dark);">
            ¡Hola, Nut. {{ session('usuario') }}!
        </h1>
        <p class="text-muted fs-5">Gestiona el bienestar nutricional de los más pequeños.</p>

        <div class="menu-grid">
            <a href="{{ route('nutri.pacientes') }}" class="menu-card">
                <div class="icon-circle" style="color: var(--primary-nutri);"><i class="bi bi-person-vcard-fill"></i></div>
                <h4 class="fw-800 mb-1">Pacientes</h4>
                <p class="small text-muted mb-0">Ver expedientes y asignar planes</p>
            </a>

            <a href="{{ route('nutri.plan') }}" class="menu-card">
                <div class="icon-circle" style="color: #f39c12;"><i class="bi bi-apple"></i></div>
                <h4 class="fw-800 mb-1">Planes</h4>
                <p class="small text-muted mb-0">Diseñar menús saludables</p>
            </a>

            <a href="{{ route('nutri.progreso') }}" class="menu-card">
                <div class="icon-circle" style="color: #e74c3c;"><i class="bi bi-activity"></i></div>
                <h4 class="fw-800 mb-1">Seguimiento</h4>
                <p class="small text-muted mb-0">Evolución de peso y talla</p>
            </a>

            <a href="{{ route('perfil') }}" class="menu-card">
                <div class="icon-circle" style="color: var(--secondary-nutri);"><i class="bi bi-gear-fill"></i></div>
                <h4 class="fw-800 mb-1">Configuración</h4>
                <p class="small text-muted mb-0">Actualizar mis datos profesionales</p>
            </a>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
@endsection