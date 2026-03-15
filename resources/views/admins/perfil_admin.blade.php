@extends('layouts.app')

@section('title', 'Mi Perfil - Nutripeques')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700;800&display=swap');

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
        left: 0; top: 0;
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
        background: linear-gradient(135deg, #7276d1 0%, #ff9a9e 100%);
    }

    .profile-info-main {
        padding: 0 40px 30px;
        margin-top: -70px;
        text-align: center;
        position: relative;
    }

    .profile-avatar {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        border: 6px solid white;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .badge-role {
        position: absolute;
        bottom: 10px;
        right: calc(50% - 70px);
        background: var(--primary-purple);
        color: white;
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 800;
        border: 4px solid white;
        text-transform: uppercase;
    }

    .user-name-title {
        font-weight: 800;
        font-size: 2.2rem;
        margin-top: 15px;
        color: #333;
    }

    /* Grid de Información */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 25px;
    }

    .info-card {
        background: var(--card-bg);
        padding: 35px;
        border-radius: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
    }

    .card-title {
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 25px;
        color: var(--primary-purple);
        display: flex;
        align-items: center;
    }

    .data-label {
        font-size: 0.8rem;
        font-weight: 700;
        color: #a0a0a0;
        text-transform: uppercase;
        margin-bottom: 5px;
        display: block;
    }

    .data-value {
        font-weight: 700;
        color: #333;
        font-size: 1.1rem;
        padding-bottom: 10px;
        border-bottom: 2px solid #f8f9fa;
        margin-bottom: 20px;
    }

    .btn-action {
        background: var(--primary-purple);
        color: white;
        border-radius: 18px;
        padding: 16px;
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
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(114, 118, 209, 0.3);
        color: white;
    }

    .btn-logout-alt {
        background: #fff0f0;
        color: #ff5e5e;
        border: none;
        padding: 14px;
        border-radius: 18px;
        width: 100%;
        font-weight: 700;
        margin-top: 15px;
        transition: 0.3s;
    }

    .btn-logout-alt:hover {
        background: #ff5e5e;
        color: white;
    }

    @media (max-width: 992px) {
        .sidebar { transform: translateX(-100%); }
        .main-wrapper { margin-left: 0; padding: 20px; }
    }
</style>

<nav class="sidebar">
    <div class="logo-container">
        <div class="logo-nutri">Nutri</div>
        <div class="logo-peques">
            <span>P</span><span>e</span><span>q</span><span>u</span><span>e</span><span>s</span>
        </div>
    </div>

    <div class="nav-menu">
        <a href="{{ url('/home') }}" class="nav-item">
            <i class="bi bi-house-door"></i> Inicio
        </a>
        <a href="{{ route('ver.ninos') }}" class="nav-item">
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
        <a href="{{ route('perfil') }}" class="nav-item active">
            <i class="bi bi-gear"></i> Perfil
        </a>
    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn-logout-alt">
            <i class="bi bi-box-arrow-right me-2"></i> Salir del Sistema
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
                <span class="badge-role">{{ session('rol') }}</span>
            </div>
            
            <h2 class="user-name-title">{{ session('usuario') }} {{ session('apellido') }}</h2>
            <p class="text-muted fw-600"><i class="far fa-envelope me-2"></i> {{ session('email_login') }}</p>
        </div>
    </div>

    <div class="info-grid">
        <div class="info-card">
            <h3 class="card-title"><i class="fas fa-id-card me-3"></i> Información Personal</h3>
            
            <span class="data-label">Nombre Completo</span>
            <div class="data-value">{{ session('usuario') }} {{ session('apellido') }}</div>

            <span class="data-label">Correo Electrónico</span>
            <div class="data-value">{{ session('email_login') }}</div>

            @if(session('especialidad'))
                <span class="data-label">Especialidad</span>
                <div class="data-value">{{ session('especialidad') }}</div>
            @endif
        </div>

        <div class="info-card">
            <h3 class="card-title"><i class="fas fa-user-shield me-3"></i> Gestión de Cuenta</h3>
            
            <p class="text-muted mb-4">
                Mantén tus datos actualizados para una mejor gestión de la plataforma. Puedes cambiar tu contraseña y datos de contacto aquí.
            </p>

            <a href="{{ url('editar-perfil/' . session('user_id')) }}" class="btn-action">
                <i class="fas fa-user-edit"></i> Editar mi información
            </a> 
            
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout-alt">
                    <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión Actual
                </button>
            </form>
        </div>
    </div>
</div>
@endsection