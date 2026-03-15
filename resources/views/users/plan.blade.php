@extends('layouts.app')

@section('title', 'Planes Nutricionales - Nutripeques')

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

    /* --- SIDEBAR --- */
    .sidebar {
        width: 280px;
        height: 100vh;
        position: fixed;
        left: 0; top: 0;
        background: white;
        padding: 20px;
        display: flex;
        flex-direction: column;
        z-index: 1000;
        box-shadow: 10px 0 40px rgba(0,0,0,0.03);
    }

    .logo-container {
        text-align: center;
        margin-bottom: 25px;
        border-bottom: 1px solid #f0f0f0;
        padding-bottom: 15px;
    }

    .logo-peques { font-size: 18px; font-weight: 800; display: flex; gap: 2px; justify-content: center; }
    .logo-peques span:nth-child(1) { color: var(--logo-red); }
    .logo-peques span:nth-child(2) { color: var(--logo-green); }
    .logo-peques span:nth-child(3) { color: var(--logo-pink); }
    .logo-peques span:nth-child(4) { color: var(--logo-yellow); }
    .logo-peques span:nth-child(5) { color: var(--logo-blue); }
    .logo-peques span:nth-child(6) { color: var(--logo-red); }

    .nav-menu { display: flex; flex-direction: column; gap: 5px; flex-grow: 1; }

    .nav-item {
        display: flex;
        align-items: center;
        padding: 12px 18px;
        color: #636e72;
        text-decoration: none;
        font-weight: 600;
        border-radius: 20px;
        transition: 0.3s;
    }

    .nav-item i { margin-right: 12px; font-size: 1.2rem; }

    .nav-item:hover, .nav-item.active {
        background: var(--soft-cyan-bg);
        color: var(--secondary-blue);
    }

    .btn-logout {
        background: #fff0f0;
        color: #ff5e5e;
        border: none;
        padding: 12px;
        border-radius: 15px;
        width: 100%;
        font-weight: 700;
        margin-top: auto;
    }

    /* --- CONTENIDO PRINCIPAL --- */
    .main-wrapper {
        margin-left: 280px;
        padding: 40px;
    }

    .plan-header-banner {
        background: white;
        padding: 30px;
        border-radius: 30px;
        margin-bottom: 40px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
    }

    .icon-circle {
        width: 60px; height: 60px;
        background: var(--soft-cyan-bg);
        color: var(--primary-cyan);
        border-radius: 20px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.8rem;
    }

    /* --- TARJETAS --- */
    .card-age-plan {
        background: white;
        border-radius: 25px;
        padding: 25px;
        display: flex;
        align-items: center;
        gap: 20px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 2px solid transparent;
        text-decoration: none !important;
    }

    .card-age-plan:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        border-color: var(--soft-cyan-bg);
    }

    .age-icon {
        width: 65px; height: 65px;
        border-radius: 22px;
        display: flex; align-items: center; justify-content: center;
        color: white; font-size: 1.6rem; flex-shrink: 0;
    }

    .arrow-go { color: #dee2e6; font-size: 1.5rem; margin-left: auto; }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .col-animate { animation: fadeInUp 0.5s ease backwards; }
</style>

<nav class="sidebar">
    <div class="logo-container">
        <div style="display: inline-flex; align-items: baseline; gap: 4px;">
            <span style="font-weight: 800; font-size: 18px; color: #333;">Nutri</span>
            <div class="logo-peques">
                <span>P</span><span>e</span><span>q</span><span>u</span><span>e</span><span>s</span>
            </div>
        </div>
    </div>

    <div class="nav-menu">
        <a href="{{ route('perfil') }}" class="nav-item {{ Request::is('perfil') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i> <span>Mi Perfil</span>
        </a>
        <a href="{{ route('panel.usuario') }}" class="nav-item {{ Request::is('panel-usuario') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i> <span>Inicio</span>
        </a>
        <a href="{{ url('/plan/15-18') }}" class="nav-item active">
            <i class="bi bi-egg-fried"></i> <span>Planes</span>
        </a>
        <a href="{{ route('hijos.registrados') }}" class="nav-item"><i class="bi bi-people-fill"></i> <span>Mis Hijos</span></a>
        <a href="{{ url('/agregar_hijo') }}" class="nav-item"><i class="bi bi-person-plus-fill"></i> <span>Agregar Hijo</span></a>
        <a href="{{ url('/actividades') }}" class="nav-item"><i class="bi bi-bicycle"></i> <span>Actividades</span></a>
        <a href="{{ url('/crear_contacto') }}" class="nav-item"><i class="bi bi-envelope-paper-heart-fill"></i> <span>Consulta</span></a>
        <a href="{{ url('/inicio') }}" class="nav-item"><i class="bi bi-house-heart-fill"></i> <span>Resumen Diario</span></a>
    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn-logout">
            <i class="bi bi-box-arrow-right"></i> Salir
        </button>
    </form>
</nav>

<div class="main-wrapper">
    <div class="plan-header-banner">
        <div class="icon-circle">
            <i class="bi bi-clipboard2-check-fill"></i>
        </div>
        <div>
            <h2 style="font-weight: 800; margin-bottom: 0; color: var(--text-dark);">Conoce nuestros planes alimenticios</h2>
            <p class="text-muted mb-0">Una vez que conozcas el IMC de tu hijo, un nutriologo te asignará uno de los siguientes 
                planes, además de algunas recomendaciones especiales.
            </p>
        </div>
    </div>

    <div class="row">
        @php
            $planes = [
                ['nivel' => 'Nivel 1', 'rango' => 'Menos de 15', 'color' => '#ff786e', 'icon' => 'bi-graph-down', 'file' => 'Nivel 1-Menos de 15.pdf', 'delay' => '0.1s'],
                ['nivel' => 'Nivel 2', 'rango' => '15.0 - 18.4', 'color' => '#f4be5d', 'icon' => 'bi-arrow-down-right-circle', 'file' => 'Nivel 2-15.0 - 18.4.pdf', 'delay' => '0.2s'],
                ['nivel' => 'Nivel 3', 'rango' => '18.5 - 24.9', 'color' => '#aec982', 'icon' => 'bi-check2-all', 'file' => 'Nivel 3-18.5 - 24.9.pdf', 'delay' => '0.3s'],
                ['nivel' => 'Nivel 4', 'rango' => '25.0 - 29.9', 'color' => '#ffadd1', 'icon' => 'bi-exclamation-lg', 'file' => 'Nivel 4-25.0 - 29.9.pdf', 'delay' => '0.4s'],
                ['nivel' => 'Nivel 5', 'rango' => '30.0 - 34.9', 'color' => '#b3caff', 'icon' => 'bi-reception-3', 'file' => 'Nivel 5-30.0 - 34.9.pdf', 'delay' => '0.5s'],
                ['nivel' => 'Nivel 6', 'rango' => 'Más de 35', 'color' => '#43cea2', 'icon' => 'bi-reception-4', 'file' => 'Nivel 6-Más de 35.pdf', 'delay' => '0.6s'],
            ];
        @endphp

        @foreach($planes as $p)
        <div class="col-md-6 mb-4 col-animate" style="animation-delay: {{ $p['delay'] }}">
            <a href="{{ asset('pdfs/' . $p['file']) }}" target="_blank" class="card-age-plan shadow-sm">
                <div class="age-icon" style="background-color: {{ $p['color'] }}">
                    <i class="bi {{ $p['icon'] }}"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1" style="color: #333; font-size: 1.2rem;">{{ $p['nivel'] }}</h5>
                    <span class="badge rounded-pill px-3 py-2" style="background: var(--bg-main); color: var(--text-dark); font-weight: 700;">
                        IMC: {{ $p['rango'] }}
                    </span>
                </div>
                <div class="arrow-go">
                    <i class="bi bi-file-earmark-pdf-fill text-danger"></i>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection