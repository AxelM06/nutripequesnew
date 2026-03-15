@extends('layouts.app')

@section('title', 'Perfil Nutriólogo - Nutripeques')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700;800&display=swap');

    :root {
        /* Colores para el Nutriólogo */
        --primary-purple: #7276d1;
        --soft-purple-bg: #f0f2ff;
        --bg-main: #f4f9f9;
        --card-bg: #ffffff;
        --text-dark: #2d3436;
        
        /* Colores del Logo */
        --logo-red: #ff786e;
        --logo-green: #aec982;
        --logo-pink: #ffadd1;
        --logo-yellow: #f4be5d;
        --sidebar-width: 280px;
    }

    body {
        background-color: var(--bg-main);
        font-family: 'Quicksand', sans-serif;
        color: var(--text-dark);
        margin: 0;
    }

    /* --- SIDEBAR IDENTICA --- */
    .sidebar {
        width: 280px; height: 100vh; position: fixed;
        left: 0; top: 0; background: var(--card-bg);
        padding: 30px 15px 15px 15px; /* Espacio de 30px arriba corregido */
        box-shadow: 10px 0 40px rgba(0,0,0,0.03);
        z-index: 1000; display: flex; flex-direction: column;
    }

    .logo-container {
        text-align: center; 
        margin-bottom: 25px; 
        border-bottom: 1px solid #f0f0f0; 
        padding-bottom: 15px;
    }

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
    }

    .profile-banner {
        height: 160px;
        /* Gradiente más profesional para nutriólogo */
        background: linear-gradient(135deg, #7276d1 0%, #43cea2 100%);
    }

    .profile-info-main {
        padding: 0 40px 30px;
        margin-top: -70px;
        text-align: center;
        position: relative;
    }

    .profile-avatar {
        width: 140px; height: 140px; border-radius: 50%;
        border: 6px solid white; box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .badge-role {
        position: absolute; bottom: 10px; right: calc(50% - 70px);
        background: var(--primary-purple); color: white;
        padding: 6px 15px; border-radius: 20px; font-size: 12px;
        font-weight: 800; border: 4px solid white; text-transform: uppercase;
    }

    .user-name-title {
        font-weight: 800; font-size: 2.2rem; margin-top: 15px; color: #333;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 25px;
    }

    .info-card {
        background: var(--card-bg); padding: 35px;
        border-radius: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.03);
    }

    .card-title {
        font-weight: 700; font-size: 1.2rem; margin-bottom: 25px;
        color: var(--primary-purple); display: flex; align-items: center;
    }

    .data-label {
        font-size: 0.8rem; font-weight: 700; color: #a0a0a0;
        text-transform: uppercase; margin-bottom: 5px; display: block;
    }

    .data-value {
        font-weight: 700; color: #333; font-size: 1.1rem;
        padding-bottom: 10px; border-bottom: 2px solid #f8f9fa; margin-bottom: 20px;
    }

    .btn-action {
        background: var(--primary-purple); color: white; border-radius: 18px;
        padding: 16px; font-weight: 700; width: 100%;
        display: flex; align-items: center; justify-content: center;
        gap: 10px; text-decoration: none; transition: 0.3s; border: none;
    }

    .btn-action:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(114, 118, 209, 0.3);
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
                <span style="color: #ff786e;">P</span><span style="color: #aec982;">e</span>
                <span style="color: #ffadd1;">q</span><span style="color: #f4be5d;">u</span>
                <span style="color: #b3caff;">e</span><span style="color: #ff786e;">s</span>
            </div>
        </div>
    </div>

    <div class="nav-menu" style="flex-grow: 1;">
        <a href="{{ route('perfil.nutri') }}" class="nav-item active">
            <i class="bi bi-person-circle"></i> <span>Mi Perfil</span>
        </a>
        <a href="{{ route('panel.nutriologo') }}" class="nav-item">
            <i class="bi bi-grid-1x2-fill"></i> <span>Panel Control</span>
        </a>
        <a href="{{ route('nutri.pacientes') }}" class="nav-item">
            <i class="bi bi-people-fill"></i> <span>Mis Pacientes</span>
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
    <div class="profile-header-card">
        <div class="profile-banner"></div>
        <div class="profile-info-main">
            <div class="position-relative d-inline-block">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(session('usuario')) }}&background=7276d1&color=fff&size=140" 
                     class="profile-avatar" alt="Avatar">
                <span class="badge-role">NUTRIÓLOGO</span>
            </div>
            
            <h2 class="user-name-title">Nut. {{ session('usuario') }} {{ session('apellido') }}</h2>
            <p class="text-muted fw-600"><i class="far fa-envelope me-2"></i> {{ session('email_login') }}</p>
        </div>
    </div>

    <div class="info-grid">
        <div class="info-card">
            <h3 class="card-title"><i class="fas fa-user-md me-3"></i> Credenciales Médicas</h3>
            
            <span class="data-label">Nombre del Especialista</span>
            <div class="data-value">{{ session('usuario') }} {{ session('apellido') }}</div>

            <span class="data-label">Cédula / Especialidad</span>
            <div class="data-value">{{ session('especialidad', 'Nutrición Infantil') }}</div>

            <span class="data-label">Correo Institucional</span>
            <div class="data-value">{{ session('email_login') }}</div>
        </div>

        <div class="info-card">
            <h3 class="card-title"><i class="fas fa-cog me-3"></i> Opciones de Cuenta</h3>
            
            <p class="text-muted mb-4">
                Como especialista, asegúrate de mantener tu información de contacto actualizada para los padres de familia.
            </p>

            <a href="{{ url('editar-perfil/' . session('user_id')) }}" class="btn-action mb-3">
                <i class="fas fa-user-edit"></i> Actualizar Perfil Médico
            </a> 

            <a href="{{ route('panel.nutriologo') }}" class="btn-action" style="background: #f8f9fa; color: #333;">
                <i class="bi bi-arrow-left"></i> Volver al Panel
            </a>
        </div>
    </div>
</div>
@endsection