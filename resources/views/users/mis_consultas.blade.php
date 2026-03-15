@extends('layouts.app')

@section('title', 'Mis Consultas - Nutripeques')

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
        --logo-red: #ff786e;
        --logo-green: #aec982;
        --logo-pink: #ffadd1;
        --logo-yellow: #f4be5d;
        --logo-blue: #b3caff;
    }

    body { background-color: var(--bg-main); font-family: 'Quicksand', sans-serif; margin: 0; }

    /* --- SIDEBAR MAESTRO COMPACTO --- */
    .sidebar {
        width: 280px; height: 100vh; position: fixed;
        left: 0; top: 0; background: var(--card-bg);
        padding: 15px 15px; box-shadow: 10px 0 40px rgba(0,0,0,0.03);
        z-index: 1000; display: flex; flex-direction: column;
    }

    .logo-container { text-align: center; margin-bottom: 10px; border-bottom: 1px solid #f0f0f0; padding-bottom: 10px; }
    
    .nav-menu { flex-grow: 1; display: flex; flex-direction: column; gap: 2px; }

    .nav-item {
        display: flex; align-items: center; padding: 10px 15px;
        margin-bottom: 2px; color: #636e72; text-decoration: none;
        border-radius: 15px; transition: 0.3s; font-weight: 600; font-size: 0.95rem;
    }
    .nav-item:hover, .nav-item.active { background: var(--soft-cyan-bg); color: var(--secondary-blue); }
    .nav-item i { margin-right: 10px; font-size: 1.1rem; }

    /* --- CONTENIDO --- */
    .main-wrapper {
        margin-left: 280px; padding: 40px; min-height: 100vh;
    }

    .glass-box {
        background: white; border-radius: 35px; padding: 40px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.05); border: 8px solid white;
    }

    .btn-logout {
        background: #fff0f0; color: #ff5e5e; border: none; padding: 10px;
        border-radius: 12px; width: 100%; font-weight: 700; font-size: 13px;
    }
</style>

<nav class="sidebar"> 
    <div class="logo-container">
        <div style="display: inline-flex; align-items: baseline; gap: 4px;">
            <span style="font-weight: 800; font-size: 18px; color: #333;">Nutri</span>
            <div style="font-size: 16px; font-weight: 800; display: flex; gap: 1px;">
                <span style="color: var(--logo-red);">P</span><span style="color: var(--logo-green);">e</span>
                <span style="color: var(--logo-pink);">q</span><span style="color: var(--logo-yellow);">u</span>
                <span style="color: var(--logo-blue);">e</span><span style="color: var(--logo-red);">s</span>
            </div>
        </div>
    </div>

    <div class="nav-menu"> 
        <a href="{{ route('perfil') }}" class="nav-item"><i class="bi bi-person-circle"></i> <span>Mi Perfil</span></a>
        <a href="{{ route('panel.usuario') }}" class="nav-item"><i class="bi bi-grid-1x2-fill"></i> <span>Inicio</span></a>
        <a href="{{ url('/plan/15-18') }}" class="nav-item"><i class="bi bi-egg-fried"></i> <span>Planes</span></a>
        <a href="{{ route('hijos.registrados') }}" class="nav-item"><i class="bi bi-people-fill"></i> <span>Mis Hijos</span></a>
        <a href="{{ url('/agregar_hijo') }}" class="nav-item"><i class="bi bi-person-plus-fill"></i> <span>Agregar Hijo</span></a>
        <a href="{{ url('/actividades') }}" class="nav-item"><i class="bi bi-bicycle"></i> <span>Actividades</span></a>
        <a href="{{ url('/crear_contacto') }}" class="nav-item"><i class="bi bi-envelope-paper-heart-fill"></i> <span>Consulta</span></a>
        <a href="{{ route('mis_consultas') }}" class="nav-item active"><i class="bi bi-chat-left-text-fill"></i> <span>Respuestas</span></a>
        <a href="{{ url('/inicio') }}" class="nav-item"><i class="bi bi-house-heart-fill"></i> <span>Resumen Diario</span></a>
    </div>

    <form action="{{ route('logout') }}" method="POST" style="margin-top: auto;">
        @csrf
        <button type="submit" class="btn-logout"><i class="bi bi-box-arrow-right"></i> Salir</button>
    </form>
</nav>

<div class="main-wrapper">
    <div class="glass-box">
        <div class="mb-4">
            <h2 class="fw-800" style="color: #333;"><i class="bi bi-chat-left-dots me-2" style="color: var(--secondary-blue);"></i>Mis Consultas</h2>
            <p class="text-muted fw-600">Revisa el estado de tus dudas y las respuestas del especialista.</p>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr style="color: var(--secondary-blue);">
                        <th class="ps-3 border-0">Asunto</th>
                        <th class="text-center border-0">Estado</th>
                        <th class="text-center border-0">Respuesta</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($misConsultas as $c)
                    <tr>
                        <td class="ps-3">
                            <span class="fw-bold" style="color: #333;">{{ $c['asunto'] }}</span>
                            <br><small class="text-muted">{{ $c['fecha'] }}</small>
                        </td>
                        <td class="text-center">
                            @if($c['estado'] == 'Finalizado')
                                <span class="badge rounded-pill px-4 py-2" style="background-color: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9;">
                                    <i class="bi bi-check-circle-fill me-1"></i> Finalizada
                                </span>
                            @else
                                <span class="badge rounded-pill px-4 py-2" style="background-color: #fff3e0; color: #ef6c00; border: 1px solid #ffe0b2;">
                                    <i class="bi bi-clock-history me-1"></i> En Proceso
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($c['estado'] == 'Finalizado' && isset($c['respuesta']))
                                <button class="btn btn-link btn-sm text-decoration-none fw-bold" 
                                        style="color: var(--secondary-blue);"
                                        data-bs-toggle="collapse" 
                                        data-bs-target="#resp{{ $loop->index }}">
                                    Ver Respuesta <i class="bi bi-chevron-down"></i>
                                </button>
                            @else
                                <span class="text-muted small">Esperando respuesta...</span>
                            @endif
                        </td>
                    </tr>
                    
                    @if(isset($c['respuesta']))
                    <tr class="collapse" id="resp{{ $loop->index }}">
                        <td colspan="3" class="p-4" style="background-color: #f8f9ff; border-radius: 15px;">
                            <div class="d-flex">
                                <i class="bi bi-reply-all-fill me-3 fs-4" style="color: var(--secondary-blue);"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">Respuesta del Especialista:</h6>
                                    <p class="mb-0 text-dark">{{ $c['respuesta'] }}</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endif
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-5 text-muted">
                            <i class="bi bi-chat-square-dots display-4 d-block mb-3 opacity-25"></i>
                            No tienes consultas registradas actualmente.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection