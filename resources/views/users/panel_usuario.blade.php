@extends('layouts.app')

@section('title', 'Panel Usuario - Nutripeques')

@section('content')
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
    }

    body {
        background-color: var(--bg-main);
        font-family: 'Quicksand', sans-serif;
        margin: 0;
    }

    /* --- SIDEBAR AJUSTADO --- */
    .sidebar {
        width: 280px; 
        height: 100vh; 
        position: fixed;
        left: 0; 
        top: 0; 
        background: var(--card-bg);
        padding: 15px 15px; 
        box-shadow: 10px 0 40px rgba(0,0,0,0.03);
        z-index: 1000; 
        display: flex; 
        flex-direction: column;
    }

    .logo-container {
        text-align: center; 
        margin-bottom: 15px; 
        border-bottom: 1px solid #f0f0f0; 
        padding-bottom: 10px;
    }

    .nav-menu { display: flex; flex-direction: column; gap: 5px; flex-grow: 1; }

    .nav-item {
        display: flex; align-items: center; padding: 10px 15px;
        margin-bottom: 4px; color: #636e72; text-decoration: none;
        border-radius: 20px; transition: 0.3s; font-weight: 600;
    }
    .nav-item:hover, .nav-item.active { background: var(--soft-cyan-bg); color: var(--secondary-blue); }
    .nav-item i { margin-right: 12px; font-size: 1.1rem; }

    .btn-logout {
        background: #fff0f0; color: #ff5e5e; border: none; padding: 8px;
        border-radius: 12px; width: 100%; font-weight: 700; font-size: 13px; margin-top: auto;
    }

    /* --- CONTENIDO PRINCIPAL --- */
    .main-wrapper {
        margin-left: 280px; /* Ancho exacto del sidebar */
        padding: 40px;
        min-height: 100vh;
    }

    /* --- ANIMACIONES Y TARJETAS --- */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .welcome-banner {
        background: white;
        padding: 40px;
        border-radius: 30px;
        margin-bottom: 30px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        animation: fadeInUp 0.8s ease-out;
    }

    .tip-box {
        padding: 25px;
        border-radius: 25px;
        background: white;
        border: 1px solid #f0f0f0;
        transition: 0.3s;
        height: 100%;
    }

    .tip-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.05);
    }

    .badge-welcome {
        background: var(--soft-cyan-bg);
        color: var(--secondary-blue);
        padding: 8px 20px;
        border-radius: 50px;
        font-weight: 700;
        display: inline-block;
        margin-bottom: 15px;
    }

    .search-card {
        background: white;
        border-radius: 25px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
    }
</style>

<nav class="sidebar"> 
    <div class="logo-container">
        <div style="display: inline-flex; align-items: baseline; gap: 4px;">
            <span style="font-weight: 800; font-size: 18px; color: #333;">Nutri</span>
            <div style="font-size: 16px; font-weight: 800; display: flex; gap: 1px;">
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
        <a href="{{ route('perfil') }}" class="nav-item"><i class="bi bi-person-circle"></i> <span>Mi Perfil</span></a>
        <a href="{{ route('panel.usuario') }}" class="nav-item active"><i class="bi bi-grid-1x2-fill"></i> <span>Inicio</span></a>
        <a href="{{ url('/plan/15-18') }}" class="nav-item"><i class="bi bi-egg-fried"></i> <span>Planes</span></a>
        <a href="{{ route('hijos.registrados') }}" class="nav-item"><i class="bi bi-people-fill"></i> <span>Mis Hijos</span></a>
        <a href="{{ url('/agregar_hijo') }}" class="nav-item"><i class="bi bi-person-plus-fill"></i> <span>Agregar Hijo</span></a>
        <a href="{{ url('/actividades') }}" class="nav-item"><i class="bi bi-bicycle"></i> <span>Actividades</span></a>
        <a href="{{ url('/crear_contacto') }}" class="nav-item"><i class="bi bi-envelope-paper-heart-fill"></i> <span>Consulta</span></a>
        <a href="{{ route('mis_consultas') }}" class="nav-item"><i class="bi bi-chat-left-text-fill"></i> <span>Respuestas</span></a>
        <a href="{{ url('/inicio') }}" class="nav-item"><i class="bi bi-house-heart-fill"></i> <span>Resumen Diario</span></a>
    </div>

    <form action="{{ route('logout') }}" method="POST" style="margin-top: auto; padding-top: 10px;">
        @csrf
        <button type="submit" class="btn-logout">
            <i class="bi bi-box-arrow-right"></i> Salir
        </button>
    </form>
</nav>

<div class="main-wrapper">
    
    <div class="search-card">
        <h5 class="fw-bold mb-3"><i ></i> Buscador Nutricional </h5>
        <form action="{{ route('alimento.buscar') }}" method="POST" class="d-flex gap-2">
            @csrf
            <input type="text" name="alimento" class="form-control form-control-lg" placeholder="Ej: Cereales, Yogurt, Galletas..." required style="border-radius: 15px;">
            <button type="submit" class="btn btn-primary px-4 fw-bold" style="border-radius: 15px; background: var(--primary-cyan); border: none;">Consultar</button>
        </form>

        @if(session('resultado_busqueda'))
            <div class="alert {{ session('color_alerta') }} mt-3 mb-0 shadow-sm" style="border-radius: 15px;">
                {!! session('resultado_busqueda') !!}
            </div>
        @endif
    </div>

    <div class="welcome-banner">
        <div class="badge-welcome">BIENVENIDO, {{ session('usuario') ?? session('user_name') ?? 'USUARIO' }}</div>
        <h1 class="display-4 fw-bold mb-3" style="color: var(--text-dark);">La mejor página para mejorar la salud de tus pequeños</h1>
        <p class="lead text-muted mb-4">Gestiona, aprende y crece junto a nosotros.</p>
        
        <div class="row g-4 mt-2">
            <div class="col-md-6">
                <div class="tip-box">
                    <h5 class="fw-bold" style="color: var(--primary-cyan);">¿SABÍAS QUE?</h5>
                    <p class="text-muted mb-0">El calcio es fundamental para fortalecer los huesos de los niños en crecimiento.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="tip-box">
                    <h5 class="fw-bold" style="color: var(--logo-green);">TIP DE HOY</h5>
                    <p class="text-muted mb-0">Evita jugos procesados; prefiere siempre la fruta entera para mantener la fibra.</p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection