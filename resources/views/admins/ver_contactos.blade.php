@extends('layouts.app')

@section('title', 'Bandeja de Entrada - Nutripeques')

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

    /* --- TABLA DE MENSAJES --- */
    .custom-table { border-collapse: separate; border-spacing: 0 12px; width: 100%; }
    .custom-table tbody tr { 
        background: white; 
        border-radius: 20px; 
        transition: 0.3s; 
        box-shadow: 0 5px 15px rgba(0,0,0,0.02); 
    }
    .custom-table tbody tr.done { opacity: 0.7; filter: grayscale(0.2); }
    .custom-table tbody td { border: none; padding: 20px; vertical-align: middle; }
    .custom-table tbody tr td:first-child { border-radius: 20px 0 0 20px; }
    .custom-table tbody tr td:last-child { border-radius: 0 20px 20px 0; }

    .msg-preview { max-width: 350px; }
    .msg-text { font-size: 0.88rem; color: #6c757d; line-height: 1.4; }

    .response-box {
        background-color: #f0fdf4; 
        border: 1px solid #bbf7d0; 
        padding: 10px;
        border-radius: 12px;
        margin-top: 10px;
        font-size: 0.82rem;
    }

    .btn-action { 
        width: 38px; height: 38px; 
        display: inline-flex; 
        align-items: center; 
        justify-content: center; 
        border-radius: 12px; 
        transition: 0.3s; 
        text-decoration: none;
        border: none;
    }
    .btn-finish { background-color: #e8f5e9; color: #4caf50; }
    .btn-reply { background-color: #e0e7ff; color: #4338ca; }
    .btn-delete { background-color: #ffebee; color: #f44336; }

    .btn-action:hover { transform: translateY(-3px); box-shadow: 0 5px 10px rgba(0,0,0,0.1); }

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
    <div class="glass-container">
        <div class="mb-4">
            <h2 class="fw-bold mb-1" style="color: var(--primary-purple);">Bandeja de Entrada</h2>
            <p class="text-muted mb-0">Gestión de dudas y consultas de padres de familia</p>
        </div>

        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr class="text-muted small" style="font-weight: 700;">
                        <th class="ps-4">FECHA</th>
                        <th>REMITENTE</th>
                        <th>MENSAJE / ASUNTO</th>
                        <th>ESTADO</th>
                        <th class="text-end pe-4">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contactos as $c)
                    <tr class="{{ $c['estado'] == 'Finalizado' ? 'done' : '' }}">
                        <td class="ps-4">
                            <span class="badge bg-light text-dark fw-600 rounded-3">{{ $c['fecha'] }}</span>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $c['nombre'] }}</div>
                        </td>
                        <td class="msg-preview">
                            <div class="text-primary fw-600 mb-1">{{ $c['asunto'] }}</div>
                            <p class="msg-text mb-0">{{ $c['mensaje'] }}</p>
                            
                            @if(isset($c['respuesta']))
                                <div class="response-box">
                                    <strong class="text-success small d-block mb-1">RESPUESTA ENVIADA:</strong>
                                    {{ $c['respuesta'] }}
                                </div>
                            @endif
                        </td>
                        <td>
                            @if($c['estado'] == 'Finalizado')
                                <span class="badge bg-success rounded-pill px-3">Finalizado</span>
                            @else
                                <span class="badge bg-warning text-dark rounded-pill px-3">Pendiente</span>
                            @endif
                        </td>
                        <td class="pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                {{-- 1. FINALIZAR --}}
                                @if($c['estado'] != 'Finalizado')
                                <a href="{{ url('/estado-contacto/'.$c['id'].'/Finalizado') }}" 
                                   class="btn-action btn-finish" 
                                   title="Marcar como finalizado">
                                    <i class="bi bi-check-lg"></i>
                                </a>
                                @endif

                                {{-- 2. RESPONDER --}}
                                <a href="{{ route('mensaje.responder', $c['id']) }}" 
                                   class="btn-action btn-reply" 
                                   title="Responder Mensaje">
                                    <i class="bi bi-chat-left-text-fill"></i>
                                </a>

                                {{-- 3. ELIMINAR --}}
                                <form action="{{ url('/eliminar-firebase/contacts/'.$c['id']) }}" method="POST" onsubmit="return confirm('¿Borrar definitivamente?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" title="Eliminar">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection