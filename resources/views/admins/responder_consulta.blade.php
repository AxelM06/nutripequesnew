@extends('layouts.app')

@section('title', 'Responder Consulta - Nutripeques')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

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
        overflow-x: hidden;
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

    .nav-menu {
        margin-top: 40px;
        flex-grow: 1;
    }

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

    .nav-item i {
        margin-right: 12px;
        font-size: 1.2rem;
    }

    /* --- LOGO --- */
    .logo-container { text-align: center; user-select: none; }
    .logo-nutri { font-weight: 800; font-size: 28px; color: #000; display: block; line-height: 1; }
    .logo-peques { font-size: 24px; font-weight: 800; display: flex; justify-content: center; gap: 2px; }
    .logo-peques span:nth-child(1) { color: var(--logo-red); }
    .logo-peques span:nth-child(2) { color: var(--logo-green); }
    .logo-peques span:nth-child(3) { color: var(--logo-pink); }
    .logo-peques span:nth-child(4) { color: var(--logo-yellow); }
    .logo-peques span:nth-child(5) { color: var(--logo-blue); }
    .logo-peques span:nth-child(6) { color: var(--logo-red); }

    .btn-logout {
        background: #fff0f0;
        color: #ff5e5e;
        border: none;
        padding: 12px;
        border-radius: 15px;
        width: 100%;
        font-weight: 700;
        transition: 0.3s;
        margin-top: 20px;
    }

    .btn-logout:hover { background: #ff5e5e; color: white; }

    /* --- CONTENIDO PRINCIPAL --- */
    .main-wrapper {
        margin-left: var(--sidebar-width);
        padding: 40px;
        min-height: 100vh;
        position: relative;
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
            <i class="bi bi-file-earmark-medical"></i> Niños registrados
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
        <a href="{{ route('ver.contactos') }}" class="nav-item active">
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
    <div class="container-fluid py-2">
        <div class="card shadow-sm border-0 mx-auto" style="max-width: 850px; border-radius: 30px;">
            <div class="card-header bg-white border-0 pt-5 px-5">
                <h2 class="fw-bold" style="color: var(--primary-purple);">
                    <i class="bi bi-chat-dots-fill me-2"></i>Atender Consulta
                </h2>
                <p class="text-muted">Proporciona orientación y seguimiento a las dudas de las familias.</p>
                <hr class="opacity-10 mt-4">
            </div>
            
            <div class="card-body px-5 pb-5">
                <div class="p-4 mb-4" style="background-color: #f8f9ff; border-left: 6px solid var(--primary-purple); border-radius: 0 20px 20px 0;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-bold text-dark fs-5">
                            <i class="bi bi-person-circle me-2 text-muted"></i>{{ $consulta['nombre'] }}
                        </span>
                        <span class="badge bg-white text-primary shadow-sm border py-2 px-3 rounded-pill">
                            {{ $consulta['asunto'] }}
                        </span>
                    </div>
                    <p class="text-muted mb-0 fs-6" style="font-style: italic; line-height: 1.6;">
                        "{{ $consulta['mensaje'] }}"
                    </p>
                </div>

                <form action="{{ route('mensaje.guardar', $consulta['id']) }}" method="POST">
                    @csrf
                    <div class="mb-4 mt-5">
                        <label class="form-label fw-bold fs-5 mb-3" style="color: #5a5eb1;">
                            <i class="bi bi-pencil-square me-2"></i>Redacta tu respuesta y recomendaciones:
                        </label>
                        <textarea name="respuesta" 
                                  class="form-control" 
                                  rows="6" 
                                  style="border-radius: 20px; border: 2px solid #e2eaf4; padding: 20px; font-size: 1.05rem;" 
                                  placeholder="Hola {{ $consulta['nombre'] }}, respondiendo a tu consulta sobre {{ strtolower($consulta['asunto']) }} te recomiendo lo siguiente..." 
                                  required></textarea>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-md-8">
                            <button type="submit" class="btn w-100 p-3 text-white fw-bold shadow-sm" style="background: var(--primary-purple); border-radius: 15px; transition: 0.3s;">
                                ENVIAR RESPUESTA Y FINALIZAR <i class="bi bi-send-check-fill ms-2"></i>
                            </button>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('ver.contactos') }}" class="btn btn-light w-100 p-3 fw-bold text-muted border" style="border-radius: 15px; background: white;">
                                CANCELAR
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection