@extends('layouts.app')

@section('title', 'Detalles del Plan - Nutripeques')

@section('content')
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
    }

    body {
        background-color: var(--bg-main);
        font-family: 'Quicksand', sans-serif;
        margin: 0;
    }

    /* --- SIDEBAR REUTILIZADO --- */
    .sidebar {
        width: 280px; height: 100vh; position: fixed;
        left: 0; top: 0; background: var(--card-bg);
        padding: 30px 20px; box-shadow: 10px 0 40px rgba(0,0,0,0.03);
        z-index: 1000; display: flex; flex-direction: column;
    }

    .logo-nutri { font-weight: 800; font-size: 26px; color: #333; text-align: center; }
    .logo-peques { font-size: 22px; font-weight: 800; display: flex; justify-content: center; gap: 2px; margin-bottom: 30px; }
    .logo-peques span:nth-child(1) { color: var(--logo-red); }
    .logo-peques span:nth-child(2) { color: var(--logo-green); }
    .logo-peques span:nth-child(3) { color: var(--logo-pink); }
    .logo-peques span:nth-child(4) { color: var(--logo-yellow); }
    .logo-peques span:nth-child(5) { color: #b3caff; }
    .logo-peques span:nth-child(6) { color: var(--logo-red); }

    .nav-item {
        display: flex; align-items: center; padding: 14px 18px;
        margin-bottom: 8px; color: #636e72; text-decoration: none;
        border-radius: 20px; transition: 0.3s; font-weight: 600;
    }
    .nav-item:hover, .nav-item.active { background: var(--soft-cyan-bg); color: var(--secondary-blue); }
    .nav-item i { margin-right: 12px; font-size: 1.2rem; }

    /* --- ÁREA CENTRAL INTEGRADA --- */
    .main-wrapper {
        margin-left: 280px;
        padding: 40px;
        min-height: 100vh;
    }

    .hero-panel {
        background: var(--soft-cyan-bg);
        border-radius: 60px;
        padding: 50px 40px;
        border: 12px solid white;
        box-shadow: 0 20px 50px rgba(0,0,0,0.05);
    }

    .info-item {
        background: white;
        padding: 25px;
        border-radius: 30px;
        margin-bottom: 25px;
        border-left: 8px solid var(--primary-cyan);
        box-shadow: 0 10px 25px rgba(0,0,0,0.02);
    }

    .btn-download {
        background: linear-gradient(135deg, var(--primary-cyan), var(--secondary-blue));
        color: white;
        border-radius: 25px;
        padding: 20px;
        font-weight: 800;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        transition: 0.3s;
        border: none;
        font-size: 1.1rem;
        box-shadow: 0 10px 25px rgba(67, 206, 162, 0.3);
    }

    .btn-download:hover {
        transform: translateY(-5px);
        filter: brightness(1.1);
        color: white;
    }

    .btn-logout {
        background: #fff0f0; color: #ff5e5e; border: none; padding: 12px;
        border-radius: 15px; width: 100%; font-weight: 700; margin-top: auto;
    }
</style>

<nav class="sidebar" style="padding: 15px 15px;"> 
    <div class="logo-container" style="text-align: center; margin-bottom: 15px; border-bottom: 1px solid #f0f0f0; padding-bottom: 10px;">
        <div style="display: inline-flex; align-items: baseline; gap: 4px;">
            <span style="font-weight: 800; font-size: 18px; color: #333;">Nutri</span>
            <div class="logo-peques" style="font-size: 16px; font-weight: 800; display: flex; gap: 1px; margin-bottom: 0;">
                <span style="color: #ff786e;">P</span>
                <span style="color: #aec982;">e</span>
                <span style="color: #ffadd1;">q</span>
                <span style="color: #f4be5d;">u</span>
                <span style="color: #b3caff;">e</span>
                <span style="color: #ff786e;">s</span>
            </div>
        </div>
    </div>

    <div class="nav-menu" style="gap: 5px;"> 
        <a href="{{ route('perfil') }}" class="nav-item {{ Request::is('perfil') ? 'active' : '' }}" style="padding: 10px 15px; margin-bottom: 4px;">
            <i class="bi bi-person-circle" style="font-size: 1.1rem;"></i> <span>Mi Perfil</span>
        </a>
        <a href="{{ route('panel.usuario') }}" class="nav-item {{ Request::is('panel-usuario') ? 'active' : '' }}" style="padding: 10px 15px; margin-bottom: 4px;">
            <i class="bi bi-grid-1x2-fill" style="font-size: 1.1rem;"></i> <span>Inicio</span>
        </a>
        <a href="{{ url('/plan/15-18') }}" class="nav-item {{ Request::is('plan*') ? 'active' : '' }}" style="padding: 10px 15px; margin-bottom: 4px;">
            <i class="bi bi-egg-fried" style="font-size: 1.1rem;"></i> <span>Planes</span>
        </a>
        <a href="{{ route('hijos.registrados') }}" class="nav-item" style="padding: 10px 15px; margin-bottom: 4px;"><i class="bi bi-people-fill"></i> <span>Mis Hijos</span></a>
        <a href="{{ url('/agregar_hijo') }}" class="nav-item" style="padding: 10px 15px; margin-bottom: 4px;"><i class="bi bi-person-plus-fill"></i> <span>Agregar Hijo</span></a>
        <a href="{{ url('/actividades') }}" class="nav-item" style="padding: 10px 15px; margin-bottom: 4px;"><i class="bi bi-bicycle"></i> <span>Actividades</span></a>
        <a href="{{ url('/crear_contacto') }}" class="nav-item" style="padding: 10px 15px; margin-bottom: 4px;"><i class="bi bi-envelope-paper-heart-fill"></i> <span>Consulta</span></a>
        <a href="{{ url('/inicio') }}" class="nav-item active" style="padding: 10px 15px; margin-bottom: 4px;"><i class="bi bi-house-heart-fill"></i> <span>Resumen Diario</span></a>
    </div>

    <form action="{{ route('logout') }}" method="POST" style="margin-top: auto; padding-top: 10px;">
        @csrf
        <button type="submit" class="btn-logout" style="padding: 8px; font-size: 13px; border-radius: 12px;">
            <i class="bi bi-box-arrow-right"></i> Salir
        </button>
    </form>
</nav>

<div class="main-wrapper">
    <div class="hero-panel text-start">
        <div class="d-flex align-items-center mb-5">
            <div>
                <span class="badge rounded-pill bg-white text-info px-4 py-2 shadow-sm fw-bold border mb-1 text-uppercase">Consulta Nutricional</span>
                <h1 class="fw-800 mb-0">Detalles del Plan</h1>
            </div>
        </div>

        @if($miPlan)
            <div class="row">
                <div class="col-lg-7">
                    <div class="info-item shadow-sm">
                        <h5 class="fw-800" style="color: var(--secondary-blue)"><i class="bi bi-bookmark-star-fill me-2"></i>Título del Plan</h5>
                        <p class="mb-0 fs-5 fw-600">{{ $miPlan['titulo'] }}</p>
                    </div>

                    <div class="info-item shadow-sm">
                        <h5 class="fw-800" style="color: var(--secondary-blue)"><i class="bi bi-card-text me-2"></i>Indicaciones Especiales</h5>
                        <p class="mb-0 text-muted fw-600">{{ $miPlan['detalle'] }}</p>
                    </div>
                </div>

                <div class="col-lg-5">
                    @if($miPlan['archivo'] && $miPlan['archivo'] != 'sin_archivo')
                        <div class="bg-white p-4 rounded-5 shadow-sm text-center border">
                            <i class="bi bi-file-earmark-pdf text-danger" style="font-size: 4rem;"></i>
                            <h4 class="fw-800 mt-3">Documento PDF</h4>
                            <p class="small text-muted mb-4">El plan incluye un archivo descargable con el menú completo y horarios.</p>
                            
                            <a href="{{ asset($miPlan['archivo']) }}" class="btn-download" download>
                                <i class="bi bi-cloud-arrow-down-fill" style="font-size: 1.5rem;"></i>
                                <span>DESCARGAR PLAN</span>
                            </a>
                        </div>
                    @else
                        <div class="bg-white p-5 rounded-5 shadow-sm text-center border opacity-75">
                            <i class="bi bi-clock-history text-warning" style="font-size: 3rem;"></i>
                            <h5 class="fw-800 mt-3">Sin archivo adjunto</h5>
                            <p class="small text-muted mb-0">El especialista aún no ha subido el documento PDF para este plan.</p>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <div class="bg-white d-inline-block p-5 rounded-circle mb-4 shadow-sm">
                    <i class="bi bi-clipboard-x text-muted" style="font-size: 4rem;"></i>
                </div>
                <h3 class="text-muted fw-800">No se encontró información</h3>
                <p class="text-muted">Aún no hay un plan nutricional registrado para este perfil.</p>
            </div>
        @endif
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
@endsection