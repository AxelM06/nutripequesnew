@extends('layouts.app')

@section('title', 'Agregar Hijo - Nutripeques')

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
        --logo-blue: #b3caff;
    }

    body {
        background-color: var(--bg-main);
        font-family: 'Quicksand', sans-serif;
        margin: 0;
    }

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

    /* --- ÁREA CENTRAL --- */
    .main-wrapper {
        margin-left: 280px;
        padding: 50px;
        min-height: 100vh;
        display: flex;
        align-items: center;
    }

    .hero-panel {
        background: var(--soft-cyan-bg);
        border-radius: 60px;
        padding: 60px;
        border: 12px solid white;
        box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        width: 100%;
        max-width: 1100px;
        margin: 0 auto;
    }

    /* ESTILOS DE FORMULARIO */
    .form-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .form-label {
        color: var(--secondary-blue);
        font-weight: 700;
        margin-bottom: 8px;
        margin-left: 5px;
    }

    .form-control, .form-select {
        border-radius: 20px;
        padding: 14px 20px;
        border: 2px solid white;
        background: rgba(255,255,255,0.8);
        font-weight: 600;
        transition: 0.3s;
    }

    .form-control:focus, .form-select:focus {
        background: white;
        border-color: var(--primary-cyan);
        box-shadow: 0 0 0 0.25rem rgba(67, 206, 162, 0.1);
        outline: none;
    }

    .btn-register {
        background: linear-gradient(135deg, var(--primary-cyan), #38b68f);
        color: white;
        border: none;
        border-radius: 25px;
        padding: 16px;
        font-weight: 800;
        font-size: 1.1rem;
        transition: 0.4s;
        box-shadow: 0 10px 20px rgba(67, 206, 162, 0.2);
    }

    .btn-register:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(67, 206, 162, 0.3);
        color: white;
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
        <a href="{{ route('panel.usuario') }}" class="nav-item"><i class="bi bi-grid-1x2-fill"></i> <span>Inicio</span></a>
        <a href="{{ url('/plan/15-18') }}" class="nav-item"><i class="bi bi-egg-fried"></i> <span>Planes</span></a>
        <a href="{{ route('hijos.registrados') }}" class="nav-item"><i class="bi bi-people-fill"></i> <span>Mis Hijos</span></a>
        <a href="{{ url('/agregar_hijo') }}" class="nav-item active"><i class="bi bi-person-plus-fill"></i> <span>Agregar Hijo</span></a>
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
    <div class="hero-panel">
        <div class="form-container">
            
            <div class="mb-5 text-center">
                <span class="badge rounded-pill bg-white text-info px-4 py-2 shadow-sm fw-bold border mb-2">NUEVO MIEMBRO</span>
                <h1 class="fw-800 mb-0">Registro de Hijo</h1>
            </div>

            @if (session('status'))
                <div class="alert alert-success border-0 shadow-sm mb-4 rounded-4 fw-600">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('agregar_hijo') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label">Nombre del Niño</label>
                        <input type="text" name="nombre" class="form-control shadow-sm" placeholder="Ej. Juan" required>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label">Apellido</label>
                        <input type="text" name="apellido" class="form-control shadow-sm" placeholder="Ej. Pérez" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Edad</label>
                        <input type="number" name="edad" class="form-control shadow-sm" placeholder="0" required>
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Estatura (mts)</label>
                        <input type="text" name="estatura" class="form-control shadow-sm" placeholder="1.20" required>
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Peso (kg)</label>
                        <input type="text" name="peso" class="form-control shadow-sm" placeholder="25" required>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="form-label">Sexo</label>
                    <select name="sexo" class="form-select shadow-sm" required>
                        <option value="" selected disabled>Seleccione una opción</option>
                        <option value="masculino">Masculino</option>
                        <option value="femenino">Femenino</option>
                    </select>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-register shadow">
                        <i class="bi bi-heart-fill me-2"></i> REGISTRAR PEQUEÑO
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
@endsection