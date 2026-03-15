@extends('layouts.app')

@section('title', 'Planes Nutricionales - Nutripeques')

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
        --purple-gradient: linear-gradient(135deg, #7276d1 0%, #5a5eb1 100%);
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

    /* --- CONTENIDO --- */
    .main-wrapper {
        margin-left: var(--sidebar-width);
        padding: 40px;
        min-height: 100vh;
    }

    .glass-container { 
        background: rgba(255, 255, 255, 0.7); 
        backdrop-filter: blur(10px); 
        border: 2px solid white; 
        border-radius: 40px; 
        padding: 40px; 
        box-shadow: 0 15px 35px rgba(0,0,0,0.05); 
    }

    /* --- ESTILOS TABLA Y BADGES --- */
    .table { border-collapse: separate; border-spacing: 0 12px; }
    .table tbody tr { 
        background: white; 
        border-radius: 20px; 
        transition: 0.3s ease; 
        box-shadow: 0 5px 15px rgba(0,0,0,0.02); 
    }
    .table tbody tr:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.05); }
    .table tbody td { border: none; padding: 25px 20px; vertical-align: middle; }
    .table tbody tr td:first-child { border-radius: 20px 0 0 20px; }
    .table tbody tr td:last-child { border-radius: 0 20px 20px 0; }

    .badge-imc { 
        padding: 10px 16px; 
        border-radius: 12px; 
        font-weight: 700; 
        font-size: 0.8rem; 
        display: inline-block;
        text-align: center;
        min-width: 110px;
    }
    .bg-bajo { background-color: #e3f2fd; color: #1976d2; }
    .bg-normal { background-color: #e8f5e9; color: #2e7d32; }
    .bg-sobrepeso { background-color: #fff3e0; color: #ef6c00; }
    .bg-especial { background-color: #f3e5f5; color: #7b1fa2; }

    .btn-view {
        background: var(--purple-gradient); 
        color: white; 
        border-radius: 15px;
        padding: 10px 22px; 
        text-decoration: none; 
        font-weight: 700; 
        transition: 0.3s;
        border: none;
        display: inline-block;
        font-size: 0.9rem;
    }

    .btn-view:hover {
        transform: scale(1.05);
        color: white;
        box-shadow: 0 5px 15px rgba(114, 118, 209, 0.4);
    }

    .btn-logout {
        background: #fff0f0; color: #ff5e5e; border: none; padding: 12px;
        border-radius: 15px; width: 100%; font-weight: 700; margin-top: 20px;
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
        <a href="{{ route('admin.register') }}" class="nav-item">
            <i class="bi bi-person-gear"></i> Administradores
        </a>
        <a href="{{ route('ver.servicios') }}" class="nav-item active">
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
    <div class="glass-container">
        <div class="mb-5">
            <h2 class="fw-bold mb-1" style="color: var(--primary-purple);">Guía de Planes Nutricionales</h2>
            <p class="text-muted">Estrategias personalizadas según el IMC y la etapa de desarrollo</p>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr class="text-muted small">
                        <th class="ps-3">ESTADO (IMC)</th>
                        <th>CATEGORÍA DE PLAN</th>
                        <th>ENFOQUE PRINCIPAL</th>
                        <th class="text-center">GESTIÓN</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td><span class="badge-imc bg-bajo">Bajo Peso</span></td>
                        <td><strong class="text-dark">Plan de Recuperación</strong></td>
                        <td class="text-muted small">
                            Incremento calórico saludable, proteínas de alta calidad y densos en nutrientes para fortalecer el crecimiento.
                        </td>
                        <td class="text-center">
                            <a href="{{ url('/plan/bajo-peso') }}" class="btn-view">Detalles</a>
                        </td>
                    </tr>

                    <tr>
                        <td><span class="badge-imc bg-normal">Peso Normal</span></td>
                        <td><strong class="text-dark">Plan de Vitalidad</strong></td>
                        <td class="text-muted small">
                            Dieta balanceada 50/30/20 (HC/G/P) para mantener energía escolar, deportiva y un desarrollo óptimo.
                        </td>
                        <td class="text-center">
                            <a href="{{ url('/plan/normal') }}" class="btn-view">Detalles</a>
                        </td>
                    </tr>

                    <tr>
                        <td><span class="badge-imc bg-sobrepeso">Sobrepeso</span></td>
                        <td><strong class="text-dark">Reeducación</strong></td>
                        <td class="text-muted small">
                            Control de porciones, sustitución de azúcares procesados por fibra y fomento de actividad física diaria.
                        </td>
                        <td class="text-center">
                            <a href="{{ url('/plan/sobrepeso') }}" class="btn-view">Detalles</a>
                        </td>
                    </tr>

                    <tr>
                        <td><span class="badge-imc bg-especial">Desarrollo</span></td>
                        <td><strong class="text-dark">Crecimiento Pro</strong></td>
                        <td class="text-muted small">
                            Refuerzo de Calcio, Hierro y Zinc para la etapa de 12-15 años. Soporte para el "estirón" y cambios metabólicos.
                        </td>
                        <td class="text-center">
                            <a href="{{ url('/plan/desarrollo') }}" class="btn-view">Detalles</a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection