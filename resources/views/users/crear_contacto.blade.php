@extends('layouts.app')

@section('title', 'Contacto - Nutripeques')

@section('content')
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

    /* --- SIDEBAR AJUSTADO --- */
    .sidebar {
        width: 280px; height: 100vh; position: fixed;
        left: 0; top: 0; background: var(--card-bg);
        padding: 15px 15px; box-shadow: 10px 0 40px rgba(0,0,0,0.03);
        z-index: 1000; display: flex; flex-direction: column;
    }

    .logo-container {
        text-align: center; 
        margin-bottom: 15px; 
        border-bottom: 1px solid #f0f0f0; 
        padding-bottom: 10px;
    }

    .nav-item {
        display: flex; align-items: center; padding: 10px 15px;
        margin-bottom: 4px; color: #636e72; text-decoration: none;
        border-radius: 20px; transition: 0.3s; font-weight: 600;
    }
    .nav-item:hover, .nav-item.active { background: var(--soft-cyan-bg); color: var(--secondary-blue); }
    .nav-item i { margin-right: 12px; font-size: 1.1rem; }

    /* --- ÁREA CENTRAL --- */
    .main-wrapper {
        margin-left: 280px; padding: 50px; min-height: 100vh;
        display: flex; align-items: center; justify-content: center;
    }

    .hero-panel {
        background: var(--soft-cyan-bg); border-radius: 60px;
        padding: 60px; border: 12px solid white;
        box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        width: 100%; max-width: 900px; margin: 0 auto;
    }

    /* FORMULARIO STYLE ORIGINAL */
    .form-label { color: var(--secondary-blue); font-weight: 700; margin-left: 10px; margin-bottom: 8px; }

    .form-control, .form-select {
        border-radius: 20px; padding: 14px 20px; border: 2px solid white;
        background: rgba(255, 255, 255, 0.8); font-weight: 600; transition: 0.3s;
    }

    .form-control:focus, .form-select:focus {
        background: white; border-color: var(--primary-cyan);
        box-shadow: 0 10px 20px rgba(67, 206, 162, 0.05); outline: none;
    }

    .btn-enviar {
        background: linear-gradient(135deg, var(--primary-cyan), var(--secondary-blue));
        color: white; border: none; border-radius: 25px;
        padding: 18px; font-weight: 800; font-size: 1.1rem;
        transition: 0.4s; box-shadow: 0 10px 25px rgba(67, 206, 162, 0.2);
    }

    .btn-enviar:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(67, 206, 162, 0.3); color: white; }

    .btn-logout {
        background: #fff0f0; color: #ff5e5e; border: none; padding: 8px;
        border-radius: 12px; width: 100%; font-weight: 700; font-size: 13px; margin-top: auto;
    }
</style>

@php
    $urlRegreso = route('perfil'); 
@endphp
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
        <a href="{{ route('panel.usuario') }}" class="nav-item"><i class="bi bi-grid-1x2-fill"></i> <span>Inicio</span></a>
        <a href="{{ url('/plan/15-18') }}" class="nav-item"><i class="bi bi-egg-fried"></i> <span>Planes</span></a>
        <a href="{{ route('hijos.registrados') }}" class="nav-item"><i class="bi bi-people-fill"></i> <span>Mis Hijos</span></a>
        <a href="{{ url('/agregar_hijo') }}" class="nav-item"><i class="bi bi-person-plus-fill"></i> <span>Agregar Hijo</span></a>
        <a href="{{ url('/actividades') }}" class="nav-item"><i class="bi bi-bicycle"></i> <span>Actividades</span></a>
        <a href="{{ url('/crear_contacto') }}" class="nav-item active"><i class="bi bi-envelope-paper-heart-fill"></i> <span>Consulta</span></a>
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
    <div class="hero-panel">
        
        <div class="mb-5">
            <span class="badge rounded-pill bg-white text-info px-4 py-2 shadow-sm fw-bold border mb-2">CANAL DIRECTO</span>
            <h1 class="fw-800 mb-0">Envía tu Consulta</h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 fw-600">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('guardar.contacto') }}">
            @csrf
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label">Nombre del Tutor</label>
                    <input type="text" name="nombre" class="form-control" placeholder="Ej. Juan Pérez" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Correo Electrónico</label>
                    <input type="email" name="correo" class="form-control" placeholder="correo@ejemplo.com" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Prioridad</label>
                    <select name="prioridad" class="form-select" required>
                        <option value="" disabled selected>Nivel de urgencia...</option>
                        <option value="alta">Alta</option>
                        <option value="media">Media</option>
                        <option value="baja">Baja</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Asunto</label>
                    <input type="text" name="asunto" class="form-control" placeholder="Tema de la consulta" required>
                </div>

                <div class="col-12">
                    <label class="form-label">Tu Mensaje</label>
                    <textarea name="mensaje" rows="4" class="form-control" placeholder="Describe tu duda detalladamente..." required></textarea>
                </div>

                <div class="col-12 mt-5 text-center">
                    <button type="submit" class="btn btn-enviar w-100 shadow">
                        <i class="bi bi-send-check-fill me-2"></i> Enviar consulta
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
@endsection