@extends('layouts.app')

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

    /* --- CONTENIDO PRINCIPAL --- */
    .main-wrapper {
        margin-left: var(--sidebar-width);
        padding: 40px;
        min-height: 100vh;
        position: relative;
    }

    .top-bar {
        background: var(--primary-purple);
        border-radius: 20px;
        padding: 15px 30px;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        box-shadow: 0 10px 20px rgba(123, 127, 212, 0.2);
    }

    .hero-card {
        background: var(--card-bg);
        border-radius: 35px;
        padding: 50px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.03);
        text-align: center;
    }

    .fact-card-box {
        background: #eef2f7;
        border-radius: 25px;
        padding: 30px;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        border: 2px solid white;
    }

    .info-pill {
        background: var(--accent-blue);
        color: var(--primary-purple);
        padding: 6px 18px;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 700;
        display: inline-block;
        margin-bottom: 20px;
        text-transform: uppercase;
    }

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

    .fade-text { transition: opacity 0.5s ease; }

    @media (max-width: 992px) {
        .sidebar { transform: translateX(-100%); }
        .main-wrapper { margin-left: 0; }
    }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<nav class="sidebar">
    <div class="logo-container">
        <div class="logo-nutri">Nutri</div>
        <div class="logo-peques">
            <span>P</span><span>e</span><span>q</span><span>u</span><span>e</span><span>s</span>
        </div>
    </div>

    <div class="nav-menu">
        <a href="{{ url('/home') }}" class="nav-item {{ Request::is('home') ? 'active' : '' }}">
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
    <div class="top-bar">
        <h4 class="mb-0 fw-bold">Panel de Gestión para Administradores</h4>
        <div class="d-flex align-items-center">
            <span class="me-3 opacity-75">Bienvenido, <b>{{ Auth::user()->name ?? 'Administrador' }}</b></span>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="hero-card">
                <div class="mb-4">
                    <div class="logo-nutri" style="font-size: 60px;">Nutri</div>
                    <div class="logo-peques" style="font-size: 50px;">
                        <span>P</span><span>e</span><span>q</span><span>u</span><span>e</span><span>s</span>
                    </div>
                </div>
                
                <h2 class="fw-bold mb-3">La mejor página para mejorar la salud de tus pequeños</h2>
                <p class="text-muted fs-5">Gestiona el futuro saludable de los niños desde una plataforma intuitiva y profesional.</p>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="fact-card-box">
                <span class="info-pill">Recuerda que...</span>
                <h4 id="nutri-fact" class="fade-text fw-bold">Cargando consejos saludables...</h4>  
            </div>
        </div>
    </div>
</div>

<script>
    const facts = [
        "Nuestra prioridad es la integridad y seguridad de la información de cada paciente.",
        "Comprometidos con la excelencia en el servicio nutricional para las nuevas generaciones.",
        "La eficiencia operativa es la base para un seguimiento pediátrico de calidad.",
        "Trabajamos con ética y profesionalismo para transformar la salud infantil.",
        "Cada dato gestionado es un paso hacia un futuro más saludable para los pequeños.",
        "Innovamos constantemente para ofrecer las mejores herramientas a nuestros especialistas."
    ];

    let factIndex = 0;
    const factElement = document.getElementById('nutri-fact');

    function rotateFact() {
        if(!factElement) return;
        factElement.style.opacity = 0;
        setTimeout(() => {
            factElement.innerText = facts[factIndex];
            factElement.style.opacity = 1;
            factIndex = (factIndex + 1) % facts.length;
        }, 500);
    }

    setInterval(rotateFact, 5000);
    rotateFact();
</script>
@endsection