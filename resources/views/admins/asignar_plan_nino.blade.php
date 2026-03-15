@extends('layouts.app')

@section('title', 'Asignar Plan Nutricional')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

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
        --accent-green: #10b981;
    }

    body {
        background-color: var(--bg-main);
        font-family: 'Quicksand', sans-serif;
        color: var(--text-dark);
        margin: 0;
        overflow-x: hidden;
    }

    /* --- SIDEBAR --- */
    .sidebar {
        width: var(--sidebar-width);
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        background: var(--card-bg);
        padding: 30px 20px;
        box-shadow: 10px 0 30px rgba(0,0,0,0.02);
        z-index: 1100;
        display: flex;
        flex-direction: column;
    }

    .nav-menu {
        margin-top: 40px;
        flex-grow: 1;
    }

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

    .nav-item i {
        margin-right: 12px;
        font-size: 1.2rem;
    }

    /* --- LOGO --- */
    .logo-container { text-align: center; user-select: none; }
    .logo-nutri { font-weight: 800; font-size: 28px; color: #000; display: block; line-height: 1; }
    .logo-peques { font-size: 24px; font-weight: 800; display: flex; justify-content: center; gap: 2px; }
    .logo-peques span:nth-child(1) { color: var(--logo-red); }
    .logo-peques span:nth-child(2) { color: var(--logo-green); }
    .logo-peques span:nth-child(3) { color: var(--logo-pink); }
    .logo-peques span:nth-child(4) { color: var(--logo-yellow); }
    .logo-peques span:nth-child(5) { color: var(--logo-blue); }
    .logo-peques span:nth-child(6) { color: var(--logo-red); }

    .btn-logout {
        background: #fff0f0;
        color: #ff5e5e;
        border: none;
        padding: 12px;
        border-radius: 15px;
        width: 100%;
        font-weight: 700;
        transition: 0.3s;
        margin-top: 20px;
    }

    .btn-logout:hover { background: #ff5e5e; color: white; }

    /* --- CONTENIDO PRINCIPAL --- */
    .main-wrapper {
        margin-left: var(--sidebar-width);
        padding: 40px;
        min-height: 100vh;
        position: relative;
    }
    
    .profile-card {
        background: var(--card-bg);
        border-radius: 30px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .imc-display {
        background: linear-gradient(135deg, var(--primary-purple) 0%, #5a5eb1 100%);
        color: white;
        border-radius: 20px;
        padding: 20px;
        text-align: center;
    }

    .form-section {
        background: var(--card-bg);
        border-radius: 30px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .form-control {
        border-radius: 15px;
        border: 2px solid #edf2f7;
        padding: 12px;
    }

    .btn-assign {
        background: var(--accent-green);
        color: white;
        border-radius: 18px;
        padding: 16px;
        font-weight: 700;
        border: none;
        width: 100%;
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
            <i class="bi bi-house-door"></i> Inicio
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
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="profile-card text-center">
                <div class="avatar-large mb-3 mx-auto" style="width: 80px; height: 80px; background: #eef2ff; border-radius: 20px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-person-fill text-primary fs-1"></i>
                </div>
                <h3 class="fw-bold mb-1 text-dark">{{ $nino['nombre'] ?? 'Sin nombre' }}</h3>
                <span class="badge bg-light text-primary rounded-pill px-3 py-2 mb-3">Expediente Médico</span>

                <div class="imc-display my-4">
                    <small class="d-block opacity-75 text-uppercase fw-bold">IMC Calculado</small>
                    <h2 class="fw-bold mb-0" style="font-size: 2.5rem;">{{ $nino['imc_calculado'] ?? '0' }}</h2>
                </div>

                <div class="row text-start g-3">
                    <div class="col-6 border-end">
                        <small class="text-muted d-block text-uppercase">Peso</small>
                        <strong class="fs-5">{{ $nino['peso'] ?? '0' }} kg</strong>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block text-uppercase">Estatura</small>
                        <strong class="fs-5">{{ $nino['estatura'] ?? '0' }} m</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="form-section">
                <div class="d-flex align-items-center mb-4">
                    <div class="p-3 rounded-4 me-3" style="background: var(--primary-purple); color: white;">
                        <i class="bi bi-journal-check fs-3"></i>
                    </div>
                    <div>
                        <h2 class="fw-bold mb-0">Prescribir Plan Nutricional</h2>
                        <p class="text-muted mb-0">Diseña la dieta y recomendaciones personalizadas.</p>
                    </div>
                </div>
                
                <form action="{{ route('nino.guardar_plan', $nino['id']) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label">Título del Plan</label>
                        <input type="text" name="titulo_plan" class="form-control" placeholder="Ej: Control de peso" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Detalle del Menú</label>
                        <textarea name="detalle_plan" class="form-control" rows="6" required>{{ $sugerencia ?? '' }}</textarea>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Calorías (Kcal)</label>
                            <input type="number" name="calorias" class="form-control" placeholder="1200">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Próxima Cita</label>
                            <input type="date" name="proxima_cita" class="form-control">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Archivo de Apoyo (PDF/TXT)</label>
                        <input type="file" name="archivo_adjunto" class="form-control" accept=".pdf,.txt">
                    </div>

                    <button type="submit" class="btn btn-assign">
                        <i class="bi bi-send-fill me-2"></i> Guardar y Notificar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection