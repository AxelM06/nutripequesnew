@extends('layouts.app')

@section('title', 'Gestión de Clientes - Nutripeques')

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
        left: 0;
        top: 0;
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

    /* Puedes borrar la clase .btn-new-user de tu CSS si quieres, pero si la dejas no afecta nada */
    .btn-new-user {
        background: var(--purple-gradient);
        color: white;
        border-radius: 30px;
        padding: 12px 25px;
        font-weight: 600;
        border: none;
        transition: 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-new-user:hover {
        transform: scale(1.05);
        color: white;
        box-shadow: 0 8px 20px rgba(114, 118, 209, 0.3);
    }

    .table { border-collapse: separate; border-spacing: 0 10px; }
    .table tbody tr { 
        background: white; 
        border-radius: 15px; 
        transition: 0.2s; 
        box-shadow: 0 5px 10px rgba(0,0,0,0.02); 
    }
    .table tbody td { border: none; padding: 20px; vertical-align: middle; }
    .table tbody tr td:first-child { border-radius: 15px 0 0 15px; }
    .table tbody tr td:last-child { border-radius: 0 15px 15px 0; }

    .btn-action { 
        width: 40px; height: 40px; 
        display: inline-flex; 
        align-items: center; 
        justify-content: center; 
        border-radius: 12px; 
        transition: 0.3s; 
        text-decoration: none; 
    }
    .btn-edit { background-color: #fff3e0; color: #ff9800; }
    .btn-delete { background-color: #ffebee; color: #f44336; border: none; }

    .user-avatar { 
        width: 45px; height: 45px; 
        background: #eee; 
        border-radius: 12px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-weight: bold; 
        color: var(--primary-purple); 
        margin-right: 15px; 
    }

    .btn-logout {
        background: #fff0f0;
        color: #ff5e5e;
        border: none;
        padding: 12px;
        border-radius: 15px;
        width: 100%;
        font-weight: 700;
        margin-top: 20px;
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
        <a href="{{ route('ver.usuarios') }}" class="nav-item active">
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
    @if(session('status'))
        <div class="alert alert-success rounded-pill border-0 shadow-sm text-center mb-4">
            {{ session('status') }}
        </div>
    @endif

    <div class="glass-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0">Usuarios Registrados</h2>
                <p class="text-muted mb-0">Gestión de usuarios en Firebase</p>
            </div>
            </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr class="text-muted small">
                        <th>FECHA REGISTRO</th>
                        <th>USUARIO</th>
                        <th>CORREO ELECTRÓNICO</th>
                        <th class="text-center">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $u)
                    <tr>
                        <td>{{ $u['fecha'] }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar">
                                    {{ substr($u['nombre'], 0, 1) }}
                                </div>
                                <strong class="text-dark">{{ $u['nombre'] }}</strong>
                            </div>
                        </td>
                        <td class="text-muted">{{ $u['email'] }}</td>
                        <td class="text-center">
                            <a href="{{ url('/editar-firebase/users/'.$u['id']) }}" 
                               class="btn-action btn-edit me-1" 
                               title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <form action="{{ url('/eliminar-firebase/users/'.$u['id']) }}" 
                                  method="POST" 
                                  class="d-inline" 
                                  onsubmit="return confirm('¿Eliminar cliente?')">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection