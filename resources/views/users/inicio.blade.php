@extends("layouts.master")
@section('title', 'Resumen Diario - Nutripeques')

@section("content") 
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

    body { background-color: var(--bg-main); font-family: 'Quicksand', sans-serif; color: #4a4a4a; margin: 0; }

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
    .logo-peques span:nth-child(5) { color: var(--logo-blue); }
    .logo-peques span:nth-child(6) { color: var(--logo-red); }

    .nav-item {
        display: flex; align-items: center; padding: 14px 18px;
        margin-bottom: 8px; color: #636e72; text-decoration: none;
        border-radius: 20px; transition: 0.3s; font-weight: 600;
    }
    .nav-item:hover, .nav-item.active { background: var(--soft-cyan-bg); color: var(--secondary-blue); }
    .nav-item i { margin-right: 12px; font-size: 1.2rem; }

    /* --- ÁREA CENTRAL --- */
    .main-wrapper { margin-left: 280px; padding: 40px; min-height: 100vh; }

    /* PANEL DE CALORÍAS */
    .hero-kcal-panel {
        background: var(--soft-cyan-bg); border-radius: 60px;
        padding: 50px; border: 12px solid white;
        box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        text-align: center; position: relative;
    }

    .kcal-number { font-size: 8rem; font-weight: 800; color: #2d3436; line-height: 0.9; margin: 15px 0; }
    
    /* DÍAS DE LA SEMANA */
    .day-pill {
        background: white; border-radius: 22px; padding: 12px; width: 75px;
        text-align: center; font-weight: 700; border: 2px solid transparent;
        transition: 0.3s; cursor: pointer; color: #b2bec3;
    }
    .day-pill.active {
        background: white; border-color: var(--logo-pink);
        color: var(--logo-pink); transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(255, 173, 209, 0.2);
    }

    /* WIDGETS DERECHOS */
    .widget-card {
        background: white; border-radius: 40px; padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02); margin-bottom: 25px;
        border: 2px solid transparent; transition: 0.3s;
    }
    .widget-card:hover { border-color: var(--soft-cyan-bg); transform: scale(1.02); }

    /* VASOS DE AGUA */
    .water-container { display: flex; justify-content: center; gap: 8px; margin: 20px 0; }
    .glass {
        width: 30px; height: 45px; border: 3px solid #e0e0e0;
        border-radius: 0 0 10px 10px; position: relative; transition: 0.3s;
    }
    .glass.filled { background: #81d4fa; border-color: #81d4fa; box-shadow: 0 5px 10px rgba(129, 212, 250, 0.3); }

    .btn-action {
        background: var(--soft-cyan-bg); color: var(--secondary-blue);
        border-radius: 20px; padding: 12px; font-weight: 700;
        text-decoration: none; display: block; text-align: center; transition: 0.3s;
    }
    .btn-action:hover { background: var(--secondary-blue); color: white; }

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
        <a href="{{ url('/inicio') }}" class="nav-item active" style="padding: 10px 15px; margin-bottom: 4px;"><i class="bi bi-house-heart-fill"></i> <span>Resumen Diario</span></a>
    </div>

    <form action="{{ route('logout') }}" method="POST" style="margin-top: auto; padding-top: 10px;">
        @csrf
        <button type="submit" class="btn-logout" style="padding: 8px; font-size: 13px; border-radius: 12px;">
            <i class="bi bi-box-arrow-right"></i> Salir
        </button>
    </form>
</nav>
<div class="main-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-800 mb-0">¡Hola de nuevo, {{ session('usuario') }}! 👋</h2>
            <p class="text-muted fw-600">Revisa el progreso de hoy</p>
        </div>
        <div class="d-flex gap-2">
            <div class="day-pill">J 13</div>
            <div class="day-pill active">V 14</div>
            <div class="day-pill">S 15</div>
            <div class="day-pill">D 16</div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="hero-kcal-panel">
                <span class="badge rounded-pill bg-white text-info px-4 py-2 shadow-sm fw-800 border mb-4">META NUTRICIONAL</span>
                <h1 class="kcal-number">1,035</h1>
                <p class="text-muted fw-800 text-uppercase" style="letter-spacing: 3px; font-size: 0.9rem;">Kilocalorías Consumidas</p>

                <div class="mt-5 mb-4">
                    <div class="d-flex justify-content-between mb-2 px-5">
                        <span class="fw-800 text-muted small">0 kcal</span>
                        <span class="fw-800 text-dark">Meta: 1,050 kcal</span>
                    </div>
                    <div class="progress mx-5" style="height: 15px; border-radius: 30px; background: white;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" 
                             role="progressbar" style="width: 92%; background: linear-gradient(90deg, var(--primary-cyan), var(--secondary-blue));"></div>
                    </div>
                </div>

                <div class="row mt-5 g-3 px-4">
                    <div class="col-6">
                        <div class="bg-white p-4 rounded-5 shadow-sm text-start border">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-800 text-muted small">PROTEÍNAS</span>
                                <span class="fw-800 text-success small">45%</span>
                            </div>
                            <div class="progress" style="height: 8px; border-radius: 10px;">
                                <div class="progress-bar" style="width: 45%; background: var(--logo-green);"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-white p-4 rounded-5 shadow-sm text-start border">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-800 text-muted small">CARBOS</span>
                                <span class="fw-800 text-warning small">30%</span>
                            </div>
                            <div class="progress" style="height: 8px; border-radius: 10px;">
                                <div class="progress-bar" style="width: 30%; background: var(--logo-yellow);"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="widget-card text-center">
                <h6 class="fw-800 mb-3 text-uppercase small text-muted">Hidratación Diaria</h6>
                <div class="water-container">
                    <div class="glass filled"></div>
                    <div class="glass filled"></div>
                    <div class="glass filled"></div>
                    <div class="glass"></div>
                    <div class="glass"></div>
                    <div class="glass"></div>
                </div>
                <p class="fw-800 mb-0">3 de 6 vasos</p>
                <small class="text-muted fw-600">¡Sigue así, casi llegas a la meta!</small>
            </div>

            <div class="widget-card">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="icon-circle bg-light text-warning" style="width: 50px; height: 50px; border-radius: 18px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; background: #fff9e6 !important;">
                        <i class="bi bi-egg-fried"></i>
                    </div>
                    <div>
                        <h5 class="fw-800 mb-0">Cena de Hoy</h5>
                        <p class="text-muted small mb-0 fw-600">Sugerencia saludable</p>
                    </div>
                </div>
                <div class="bg-light p-3 rounded-4 mb-3 border-start border-4 border-warning">
                    <p class="mb-0 fw-700 small">Tortilla de vegetales con una porción pequeña de aguacate.</p>
                </div>
                <a href="#" class="btn-action">Ver Receta Completa</a>
            </div>

            <div class="widget-card text-center" style="background: linear-gradient(135deg, var(--logo-blue), #81d4fa); color: white;">
                <i class="bi bi-trophy-fill mb-2 d-block" style="font-size: 2rem;"></i>
                <h5 class="fw-800">Racha Semanal</h5>
                <p class="small mb-0 opacity-75">¡Has cumplido tus metas 4 días seguidos!</p>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
@endsection