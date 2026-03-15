@extends('layouts.app')

@section('title', 'Mis Hijos - Nutripeques')

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
        
        /* Colores del Logo para badges */
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

    /* TARJETAS DE LOS HIJOS */
    .child-card {
        background: white;
        border-radius: 35px;
        padding: 30px;
        border: none;
        transition: all 0.3s ease;
        box-shadow: 0 10px 25px rgba(0,0,0,0.02);
        position: relative;
        overflow: hidden;
    }

    .child-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(67, 206, 162, 0.15);
    }

    .child-card::before {
        content: ""; position: absolute; top: 0; left: 0; width: 10px; height: 100%;
        background: var(--primary-cyan);
    }

    .info-badge {
        background: var(--soft-cyan-bg);
        border-radius: 20px;
        padding: 10px 20px;
        text-align: center;
    }

    .imc-badge {
        font-weight: 800;
        padding: 8px 18px;
        border-radius: 25px;
        font-size: 0.85rem;
    }

    .btn-plan {
        background: linear-gradient(135deg, var(--primary-cyan), #38b2ac);
        color: white; border-radius: 20px; padding: 12px 25px;
        font-weight: 700; border: none; width: 100%;
        margin-top: 20px; transition: 0.3s;
    }

    .btn-plan:hover {
        transform: scale(1.03); color: white; filter: brightness(1.1);
    }

    .btn-logout {
        background: #fff0f0; color: #ff5e5e; border: none; padding: 12px;
        border-radius: 15px; width: 100%; font-weight: 700; margin-top: auto;
    }
</style>

<nav class="sidebar" style="padding: 15px 15px;"> <div class="logo-container" style="text-align: center; margin-bottom: 15px; border-bottom: 1px solid #f0f0f0; padding-bottom: 10px;">
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

    <div class="nav-menu" style="gap: 5px;"> <a href="{{ route('perfil') }}" class="nav-item {{ Request::is('perfil') ? 'active' : '' }}" style="padding: 10px 15px; margin-bottom: 4px;">
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
        <a href="{{ url('/inicio') }}" class="nav-item " style="padding: 10px 15px; margin-bottom: 4px;"><i class="bi bi-house-heart-fill"></i> <span>Resumen Diario</span></a>
    </div>

    <form action="{{ route('logout') }}" method="POST" style="margin-top: auto; padding-top: 10px;">
        @csrf
        <button type="submit" class="btn-logout" style="padding: 8px; font-size: 13px; border-radius: 12px;">
            <i class="bi bi-box-arrow-right"></i> Salir
        </button>
    </form>
</nav>

<div class="main-wrapper">
    <div class="hero-panel">
        <div class="mb-4">
            <span class="badge rounded-pill bg-white text-info px-4 py-2 shadow-sm fw-bold border">MI FAMILIA</span>
            <h1 class="mt-3 fw-800">Mis Hijos Registrados</h1>
            <p class="text-muted">Monitorea el crecimiento y salud de tus pequeños.</p>
        </div>

        <div class="row text-start">
            @forelse($todosLosNinios as $hijo)
                <div class="col-md-6 mb-4">
                    <div class="child-card">
                        <div class="row">
                            <div class="col-8">
                                <h3 class="fw-800 text-dark mb-1">{{ $hijo['nombre'] }}</h3>
                                <p class="text-muted fw-600 mb-3">
                                    <i class="bi bi-calendar3"></i> {{ $hijo['edad'] }} años • 
                                    @php 
                                        $genero = strtolower($hijo['sexo'] ?? 'no definido');
                                        $icon = ($genero == 'masculino') ? 'bi-gender-male text-primary' : 'bi-gender-female text-danger';
                                    @endphp
                                    <i class="bi {{ $icon }}"></i> {{ ucfirst($genero) }}
                                </p>
                                
                                @php
                                    $colorImc = 'bg-success'; $estado = 'Normal';
                                    if($hijo['imc'] < 18.5) { $colorImc = 'bg-info'; $estado = 'Bajo peso'; }
                                    elseif($hijo['imc'] >= 25 && $hijo['imc'] < 30) { $colorImc = 'bg-warning text-dark'; $estado = 'Sobrepeso'; }
                                    elseif($hijo['imc'] >= 30) { $colorImc = 'bg-danger'; $estado = 'Obesidad'; }
                                @endphp
                                
                                <div class="d-flex align-items-center">
                                    <span class="imc-badge {{ $colorImc }} text-white me-2 shadow-sm">
                                        IMC: {{ number_format((float)$hijo['imc'], 1) }}
                                    </span>
                                    <small class="fw-800 text-muted uppercase">{{ $estado }}</small>
                                </div>
                            </div>
                            
                            <div class="col-4">
                                <div class="info-badge mb-2">
                                    <small class="text-muted d-block fw-bold">Peso</small>
                                    <span class="fw-800 text-dark">{{ $hijo['peso'] }} kg</span>
                                </div>
                                <div class="info-badge">
                                    <small class="text-muted d-block fw-bold">Talla</small>
                                    <span class="fw-800 text-dark">{{ $hijo['estatura'] }} m</span>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('plan.hijo', $hijo['id']) }}" class="btn btn-plan">
                            <i class="bi bi-file-earmark-text-fill me-2"></i> Ver Plan Nutricional
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-4">
                    <h3 class="text-muted fw-600">No hay niños registrados aún</h3>
                    <a href="{{ url('/agregar_hijo') }}" class="btn-plan d-inline-block w-auto px-5">Agregar ahora</a>
                </div>
            @endforelse
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
@endsection