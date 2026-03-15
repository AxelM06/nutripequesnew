@extends('layouts.app')

@section('title', 'Actividades Saludables - Nutripeques')

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

    body { background-color: var(--bg-main); font-family: 'Quicksand', sans-serif; margin: 0; overflow-x: hidden; }

    /* --- SIDEBAR --- */
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
    .logo-peques span:nth-child(5) { color: var(--logo-blue); }
    .logo-peques span:nth-child(6) { color: var(--logo-red); }

    .nav-item {
        display: flex; align-items: center; padding: 14px 18px;
        margin-bottom: 8px; color: #636e72; text-decoration: none;
        border-radius: 20px; transition: 0.3s; font-weight: 600;
    }
    .nav-item:hover, .nav-item.active { background: var(--soft-cyan-bg); color: var(--secondary-blue); }

    /* --- ÁREA CENTRAL --- */
    .main-wrapper {
        margin-left: 280px; padding: 40px; min-height: 100vh;
        display: flex; align-items: center; justify-content: center;
    }

    .hero-panel {
        background: var(--soft-cyan-bg); border-radius: 60px;
        padding: 60px; border: 12px solid white;
        box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        width: 100%; max-width: 1150px; 
        min-height: 650px; position: relative;
        overflow: hidden; /* Importante para que las tarjetas no se salgan del borde al animar */
    }

    /* CONTENEDOR DE TARJETAS */
    #activities-container {
        display: flex; gap: 30px; justify-content: center;
        transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .activity-card {
        background: white; border-radius: 45px; padding: 45px 30px;
        width: 320px; border: none; text-align: center;
        box-shadow: 0 15px 35px rgba(0,0,0,0.03);
        display: flex; flex-direction: column; align-items: center;
        /* Animación interna */
        transition: transform 0.4s ease;
    }

    .activity-card:hover { transform: translateY(-10px); }

    .icon-box {
        width: 90px; height: 90px; border-radius: 30px;
        display: flex; align-items: center; justify-content: center;
        font-size: 3rem; margin-bottom: 25px; color: white;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    /* Clases de Animación JS */
    .exit-left {
        transform: translateX(-100px);
        opacity: 0;
    }

    .enter-right {
        transform: translateX(100px);
        opacity: 0;
    }

    .normal-state {
        transform: translateX(0);
        opacity: 1;
    }

    /* Colores */
    .c-red { background: var(--logo-red); }
    .c-green { background: var(--logo-green); }
    .c-pink { background: var(--logo-pink); }
    .c-yellow { background: var(--logo-yellow); }
    .c-blue { background: var(--logo-blue); }
    .c-cyan { background: var(--primary-cyan); }

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
        <a href="{{ url('/inicio') }}" class="nav-item" style="padding: 10px 15px; margin-bottom: 4px;"><i class="bi bi-house-heart-fill"></i> <span>Resumen Diario</span></a>
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
        <div class="d-flex align-items-center justify-content-between mb-5">
            <div>
                <span class="badge rounded-pill bg-white text-info px-4 py-2 shadow-sm fw-bold border mb-2">VIDA ACTIVA</span>
                <h1 class="fw-800 mb-0">Recomendaciones del día</h1>
            </div>
            <div class="text-end">
                <div class="spinner-grow text-info spinner-grow-sm" role="status"></div>
                <span class="text-muted small fw-600 ms-2">Actualizando...</span>
            </div>
        </div>

        <div id="activities-container" class="normal-state">
            </div>

        <div class="mt-5 text-center">
            <div class="p-3 bg-white d-inline-block rounded-pill shadow-sm border px-4">
                <p class="mb-0 text-muted fw-600">
                    <i class="bi bi-stars text-warning me-2"></i>
                    Las actividades cambian automáticamente cada 7 segundos.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    const actividades = [
        {tit: 'Caminar', desc: '30 min al aire libre mejora el corazón.', ico: 'bi-tree-fill', clr: 'c-green'},
        {tit: 'Yoga Kids', desc: 'Mejora flexibilidad y concentración.', ico: 'bi-flower1', clr: 'c-pink'},
        {tit: 'Saltar Cuerda', desc: 'Excelente ejercicio de coordinación.', ico: 'bi-lightning-fill', clr: 'c-red'},
        {tit: 'Bailar', desc: 'Libera endorfinas y quema energía.', ico: 'bi-music-note-beamed', clr: 'c-yellow'},
        {tit: 'Bicicleta', desc: 'Fortalece piernas y equilibrio.', ico: 'bi-bicycle', clr: 'c-blue'},
        {tit: 'Estiramientos', desc: 'Evita lesiones y relaja el cuerpo.', ico: 'bi-person-arms-up', clr: 'c-cyan'},
        {tit: 'Carreras', desc: 'Competencias cortas para velocidad.', ico: 'bi-flag-fill', clr: 'c-red'},
        {tit: 'Balón', desc: 'Fomenta el trabajo en equipo.', ico: 'bi-dribbble', clr: 'c-green'},
        {tit: 'Natación', desc: 'El deporte más completo para crecer.', ico: 'bi-water', clr: 'c-blue'},
        {tit: 'Limpieza', desc: 'Ayudar en casa también es moverse.', ico: 'bi-house-heart', clr: 'c-yellow'}
    ];

    let currentIdx = 0;

    function updateCards() {
        const container = document.getElementById('activities-container');
        
        // Fase 1: Salida (Slide Left + Fade Out)
        container.classList.remove('normal-state', 'enter-right');
        container.classList.add('exit-left');

        setTimeout(() => {
            // Fase 2: Cambio de contenido (mientras está invisible)
            container.innerHTML = '';
            for (let i = 0; i < 3; i++) {
                const act = actividades[(currentIdx + i) % actividades.length];
                container.innerHTML += `
                    <div class="activity-card shadow-sm">
                        <div class="icon-box ${act.clr}">
                            <i class="bi ${act.ico}"></i>
                        </div>
                        <h3 class="fw-800 mb-3">${act.tit}</h3>
                        <p class="text-muted fw-600 mb-0">${act.desc}</p>
                    </div>
                `;
            }
            
            // Colocamos el contenedor a la derecha (invisible aún)
            container.classList.remove('exit-left');
            container.classList.add('enter-right');

            // Pequeño delay para que el navegador procese el cambio de posición
            setTimeout(() => {
                // Fase 3: Entrada (Slide Center + Fade In)
                container.classList.remove('enter-right');
                container.classList.add('normal-state');
                currentIdx = (currentIdx + 3) % actividades.length;
            }, 50);

        }, 600); // Duración de la animación de salida
    }

    // Inicio
    updateCards();
    setInterval(updateCards, 7000);
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
@endsection