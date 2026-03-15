@extends('layouts.app')

@section('title', 'Mi Perfil - Nutripeques')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700;800&display=swap');

    :root {
        --primary-cyan: #43cea2;
        --secondary-blue: #185a9d;
        --soft-cyan-bg: #dff0f6;
        --bg-main: #f4f9f9;
        --card-bg: #ffffff;
        --text-dark: #2d3436;
        --logo-red: #ff786e;
        --logo-green: #aec982;
        --logo-pink: #ffadd1;
        --logo-yellow: #f4be5d;
        --logo-blue: #b3caff;
        --sidebar-width: 280px;
    }

    body {
        background-color: var(--bg-main);
        font-family: 'Quicksand', sans-serif;
        color: var(--text-dark);
        margin: 0;
    }

    /* --- SIDEBAR USUARIO --- */
    .sidebar {
        width: var(--sidebar-width);
        height: 100vh;
        position: fixed;
        left: 0; top: 0;
        background: var(--card-bg);
        padding: 15px 15px;
        box-shadow: 10px 0 40px rgba(0,0,0,0.03);
        z-index: 1100;
        display: flex;
        flex-direction: column;
    }

    .logo-container {
        text-align: center;
        margin-bottom: 15px;
        border-bottom: 1px solid #f0f0f0;
        padding-bottom: 10px;
    }

    .nav-menu { flex-grow: 1; display: flex; flex-direction: column; gap: 5px; }

    .nav-item {
        display: flex;
        align-items: center;
        padding: 10px 15px;
        margin-bottom: 4px;
        color: #636e72;
        text-decoration: none;
        border-radius: 20px;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .nav-item:hover, .nav-item.active {
        background: var(--soft-cyan-bg);
        color: var(--secondary-blue);
    }

    .nav-item i { margin-right: 12px; font-size: 1.1rem; }

    /* --- CONTENIDO PERFIL --- */
    .main-wrapper {
        margin-left: var(--sidebar-width);
        padding: 40px;
        min-height: 100vh;
    }

    .profile-header-card {
        background: var(--card-bg);
        border-radius: 35px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        position: relative;
        margin-bottom: 30px;
        border: 8px solid white;
    }

    .profile-banner {
        height: 140px;
        background: linear-gradient(135deg, var(--primary-cyan) 0%, var(--secondary-blue) 100%);
    }

    .profile-info-main {
        padding: 0 40px 30px;
        margin-top: -60px;
        text-align: center;
        position: relative;
    }

    .profile-avatar {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        border: 6px solid white;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .badge-role {
        position: absolute;
        bottom: 10px;
        right: calc(50% - 65px);
        background: var(--secondary-blue);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        border: 3px solid white;
        text-transform: uppercase;
    }

    .user-name-title {
        font-weight: 800;
        font-size: 2rem;
        margin-top: 15px;
        color: var(--text-dark);
    }

    /* Grid de Información */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 25px;
    }

    .info-card {
        background: var(--card-bg);
        padding: 30px;
        border-radius: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        border: 5px solid white;
    }

    .card-title {
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 25px;
        color: var(--secondary-blue);
        display: flex;
        align-items: center;
    }

    .data-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: #b2bec3;
        text-transform: uppercase;
        margin-bottom: 5px;
        display: block;
    }

    .data-value {
        font-weight: 700;
        color: var(--text-dark);
        font-size: 1.05rem;
        padding-bottom: 8px;
        border-bottom: 2px solid #f1f2f6;
        margin-bottom: 15px;
    }

    .btn-action {
        background: var(--primary-cyan);
        color: white;
        border-radius: 15px;
        padding: 14px;
        font-weight: 700;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
        transition: 0.3s;
        border: none;
    }

    .btn-action:hover {
        background: var(--secondary-blue);
        transform: translateY(-2px);
        color: white;
    }

    .btn-logout-sidebar {
        background: #fff0f0;
        color: #ff5e5e;
        border: none;
        padding: 10px;
        border-radius: 12px;
        width: 100%;
        font-weight: 700;
        font-size: 13px;
        margin-top: auto;
    }

    @media (max-width: 992px) {
        .sidebar { transform: translateX(-100%); }
        .main-wrapper { margin-left: 0; padding: 20px; }
    }
</style>

<nav class="sidebar">
    <div class="logo-container">
        <div style="display: inline-flex; align-items: baseline; gap: 4px;">
            <span style="font-weight: 800; font-size: 18px; color: #333;">Nutri</span>
            <div class="logo-peques" style="font-size: 16px; font-weight: 800; display: flex; gap: 1px;">
                <span style="color: #ff786e;">P</span>
                <span style="color: #aec982;">e</span>
                <span style="color: #ffadd1;">q</span>
                <span style="color: #f4be5d;">u</span>
                <span style="color: #b3caff;">e</span>
                <span style="color: #ff786e;">s</span>
            </div>
        </div>
    </div>

    <div class="nav-menu">
        <a href="{{ route('perfil') }}" class="nav-item active">
            <i class="bi bi-person-circle"></i> <span>Mi Perfil</span>
        </a>
        <a href="{{ route('panel.usuario') }}" class="nav-item">
            <i class="bi bi-grid-1x2-fill"></i> <span>Inicio</span>
        </a>
        <a href="{{ url('/plan/15-18') }}" class="nav-item">
            <i class="bi bi-egg-fried"></i> <span>Planes</span>
        </a>
        <a href="{{ route('hijos.registrados') }}" class="nav-item"><i class="bi bi-people-fill"></i> <span>Mis Hijos</span></a>
        <a href="{{ url('/agregar_hijo') }}" class="nav-item"><i class="bi bi-person-plus-fill"></i> <span>Agregar Hijo</span></a>
        <a href="{{ url('/actividades') }}" class="nav-item"><i class="bi bi-bicycle"></i> <span>Actividades</span></a>
        <a href="{{ url('/crear_contacto') }}" class="nav-item"><i class="bi bi-envelope-paper-heart-fill"></i> <span>Consulta</span></a>
        <a href="{{ url('/inicio') }}" class="nav-item"><i class="bi bi-house-heart-fill"></i> <span>Resumen Diario</span></a>
    </div>

    <form action="{{ route('logout') }}" method="POST" style="margin-top: auto; padding-top: 10px;">
        @csrf
        <button type="submit" class="btn-logout-sidebar">
            <i class="bi bi-box-arrow-right"></i> Salir
        </button>
    </form>
</nav>

<div class="main-wrapper">
    <div class="profile-header-card">
        <div class="profile-banner"></div>
        <div class="profile-info-main">
            <div class="position-relative d-inline-block">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(session('usuario')) }}&background=43cea2&color=fff&size=130" 
                     class="profile-avatar" alt="Avatar">
                <span class="badge-role">Padre / Tutor</span>
            </div>
            
            <h2 class="user-name-title">{{ session('usuario') }} {{ session('apellido') }}</h2>
            <p class="text-muted fw-bold"><i class="bi bi-envelope-at me-2"></i> {{ session('email_login') }}</p>
        </div>
    </div>

    <div class="info-grid">
        <div class="info-card">
            <h3 class="card-title"><i class="bi bi-person-lines-fill me-3"></i> Mis Datos</h3>
            
            <span class="data-label">Nombre del Tutor</span>
            <div class="data-value">{{ session('usuario') }} {{ session('apellido') }}</div>

            <span class="data-label">Cuenta de Correo</span>
            <div class="data-value">{{ session('email_login') }}</div>

            <span class="data-label">Estatus de Cuenta</span>
            <div class="data-value"><span class="text-success"><i class="bi bi-patch-check-fill"></i> Activa</span></div>
        </div>

        <div class="info-card">
            <h3 class="card-title"><i class="bi bi-shield-lock-fill me-3"></i> Seguridad</h3>
            
            <p class="text-muted mb-4" style="font-size: 0.9rem;">
                Mantén tu información actualizada para recibir notificaciones sobre los planes nutricionales de tus hijos.
            </p>

            <a href="{{ url('editar-perfil/' . session('user_id')) }}" class="btn-action mb-3">
                <i class="bi bi-pencil-square"></i> Editar Perfil
            </a> 
            
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout-sidebar" style="background: #fff0f0; color: #ff5e5e; padding: 14px; border-radius: 15px; font-size: 1rem;">
                    <i class="bi bi-door-open-fill me-2"></i> Cerrar Sesión
                </button>
            </form>
        </div>
    </div>
</div>
@endsection