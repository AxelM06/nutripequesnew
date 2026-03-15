@extends('layouts.app')

@section('title', 'Enviar Mensaje - Nutripeques')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700;800&display=swap');

    :root {
        --primary-purple: #7276d1;
        --soft-purple-bg: #f0f2ff;
        --bg-main: #f4f9f9;
        --card-bg: #ffffff;
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
        width: 280px; height: 100vh; position: fixed;
        left: 0; top: 0; background: var(--card-bg);
        padding: 30px 15px 15px 15px;
        box-shadow: 10px 0 40px rgba(0,0,0,0.03);
        z-index: 1000; display: flex; flex-direction: column;
    }

    .logo-container {
        text-align: center; 
        margin-bottom: 25px; 
        border-bottom: 1px solid #f0f0f0; 
        padding-bottom: 15px;
    }

    .nav-item {
        display: flex; align-items: center;
        padding: 12px 15px; margin-bottom: 5px;
        color: #636e72; text-decoration: none;
        border-radius: 20px; transition: 0.3s; font-weight: 600;
    }

    .nav-item:hover, .nav-item.active {
        background: var(--soft-purple-bg);
        color: var(--primary-purple);
    }

    .nav-item i { margin-right: 12px; font-size: 1.2rem; }

    /* --- ÁREA CENTRAL --- */
    .main-wrapper {
        margin-left: 280px; 
        padding: 40px; 
        min-height: 100vh;
        display: flex; 
        align-items: center; 
        justify-content: center;
        position: relative;
    }

    .message-card {
        background: white; 
        border-radius: 40px;
        padding: 45px; 
        border: 8px solid #f0f2ff;
        box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        width: 100%; 
        max-width: 600px;
        position: relative;
    }

    /* Perfil superior derecho */
    .top-user-nav {
        position: absolute; top: 20px; right: 40px;
        display: flex; align-items: center; gap: 10px;
        background: rgba(255,255,255,0.8); padding: 8px 20px;
        border-radius: 30px; text-decoration: none; color: #444;
        transition: 0.3s; z-index: 10;
    }

    .btn-logout {
        background: #fff0f0; color: #ff5e5e; border: none; padding: 10px;
        border-radius: 12px; width: 100%; font-weight: 700; font-size: 13px; margin-top: auto;
    }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<nav class="sidebar">
    <div class="logo-container">
        <div style="display: inline-flex; align-items: baseline; gap: 4px;">
            <span style="font-weight: 800; font-size: 18px; color: #333;">Nutri</span>
            <div class="logo-peques" style="font-size: 16px; font-weight: 800; display: flex; gap: 1px;">
                <span style="color: #ff786e;">P</span><span style="color: #aec982;">e</span>
                <span style="color: #ffadd1;">q</span><span style="color: #f4be5d;">u</span>
                <span style="color: #b3caff;">e</span><span style="color: #ff786e;">s</span>
            </div>
        </div>
    </div>

    <div class="nav-menu" style="flex-grow: 1;">
        <a href="{{ url('perfil_nutri') }}" class="nav-item">
            <i class="bi bi-person-circle"></i> <span>Mi Perfil</span>
        </a>
        <a href="{{ url('panel-nutriologo') }}" class="nav-item">
            <i class="bi bi-grid-1x2-fill"></i> <span>Panel Control</span>
        </a>
        <a href="{{ route('nutri.pacientes') }}" class="nav-item">
            <i class="bi bi-people-fill"></i> <span>Pacientes</span>
        </a>
        <a href="{{ route('nutri.mensajes') }}" class="nav-item active">
            <i class="bi bi-chat-dots-fill"></i> <span>Mensajería</span>
        </a>
    </div>

    <form action="{{ route('logout') }}" method="POST" style="margin-top: auto;">
        @csrf
        <button type="submit" class="btn-logout">
            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
        </button>
    </form>
</nav>

<div class="main-wrapper">
    

    <div class="message-card">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ url('panel-nutriologo') }}" class="btn btn-light rounded-circle me-3">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h2 class="fw-800 mb-0" style="color: #333;">Enviar Mensaje</h2>
        </div>
        
        <div class="mb-4">
            <span class="badge rounded-pill px-3 py-2 mb-2" style="background: var(--soft-purple-bg); color: var(--primary-purple); font-weight: 700;">NOTIFICACIÓN</span>
            <p class="text-muted fw-600">Envía retroalimentación personalizada a los padres de familia.</p>
        </div>

        <form>
            <div class="mb-4">
                <label class="fw-bold mb-2 text-dark">Para: Padre de familia / Niño</label>
                <textarea class="form-control border-0 bg-light p-3" rows="6" placeholder="Escribe aquí las observaciones del seguimiento..." style="border-radius: 20px; resize: none;"></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100 rounded-pill p-3 fw-bold shadow-sm" style="background: var(--primary-purple); border:none;">
                <i class="bi bi-send-fill me-2"></i> Enviar Notificación
            </button>
        </form>
    </div>
</div>
@endsection