@extends('layouts.app')

@section('title', 'Alta de Administrador - Nutripeques')

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
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .auth-card {
        background: white;
        border-radius: 35px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.05);
        border: none;
        max-width: 550px;
        width: 100%;
        overflow: hidden;
    }

    .auth-header {
        background: linear-gradient(135deg, var(--primary-purple), #5a5eb1);
        color: white;
        padding: 25px;
        text-align: center;
        font-weight: 700;
        font-size: 1.4rem;
    }

    .auth-body { padding: 40px; }

    .form-label { font-weight: 700; color: #555; margin-bottom: 8px; }

    .form-control {
        border-radius: 12px;
        padding: 12px 15px;
        border: 2px solid #f0f2f5;
        margin-bottom: 20px;
    }

    .form-control:focus {
        border-color: var(--primary-purple);
        box-shadow: none;
    }

    .btn-admin {
        background: var(--primary-purple);
        color: white;
        border-radius: 18px;
        padding: 15px;
        font-weight: 700;
        border: none;
        transition: 0.3s;
        width: 100%;
        box-shadow: 0 8px 20px rgba(123, 127, 212, 0.2);
    }

    .btn-admin:hover {
        transform: translateY(-3px);
        background: #5a5eb1;
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
        <a href="{{ route('ver.ninos') }}" class="nav-item">
            <i class="bi bi-file-earmark-medical"></i>Niños registrados
        </a>
        <a href="{{ route('ver.usuarios') }}" class="nav-item">
            <i class="bi bi-people"></i> Usuarios
        </a>
        <a href="{{ route('admin.register_nutri') }}" class="nav-item">
            <i class="bi bi-shield-plus"></i> Nutriólogos
        </a>
        <a href="{{ route('admin.register') }}" class="nav-item active">
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
    <div class="auth-card">
        <div class="auth-header">
            <i class="bi bi-shield-lock-fill me-2"></i> Nuevo Administrador
        </div>
        <div class="auth-body">

            @if(session('error'))
                <div class="alert alert-danger rounded-4">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('guardar.admin') }}">
                @csrf
                <input type="hidden" name="rol" value="admin">

                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="name" class="form-control" placeholder="Ej. Juan" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Apellido</label>
                        <input type="text" name="last_name" class="form-control" placeholder="Ej. Perez" required>
                    </div>
                </div>

                <label class="form-label">Correo Electrónico</label>
                <input type="email" name="email" class="form-control" placeholder="admin@nutripeques.com" required>

                <label class="form-label">Contraseña de Acceso</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>

                <button type="submit" class="btn-admin mt-2">
                    Registrar Administrador
                </button>
            </form>
        </div>
    </div>
</div>
@endsection