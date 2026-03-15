<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Nutripeques')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
      :root {
        --purple-gradient: linear-gradient(135deg, #7276d1 0%, #5a5eb1 100%);
        --accent: #f5c542;
      }
      body {
        font-family: 'Quicksand', sans-serif;
        background-color: #f3f3f8;
      }
      .navbar { 
        background: var(--purple-gradient) !important; 
        border-bottom: 2px solid rgba(255,255,255,0.1);
      }
      .navbar .nav-link { color: rgba(255,255,255,0.9) !important; font-weight:600; }
      .navbar .nav-link:hover { color: var(--accent) !important; }
      .navbar-brand { color:#fff !important; font-size: 1.4rem; }
      .navbar-brand img { height:35px; border-radius:8px; }
      .dropdown-menu {
        border-radius: 15px;
        border: none;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
      }
    </style>

    @stack('styles')
</head>
<body>
<div id="app">
<nav class="navbar navbar-expand-md navbar-dark shadow-sm">
<div class="container">

<a class="navbar-brand d-flex align-items-center fw-bold" href="{{ url('/') }}">
    <img src="{{ asset('imagenes/hala.png') }}" alt="hala" class="me-2">
    <span>Nutripeques</span>
</a>

<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
    <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarSupportedContent">

@if(session()->has('usuario'))

    <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle me-2"></i> 
                {{ session('usuario') }}
                
                @if(session('rol') == 'admin')
                    <span class="badge bg-warning text-dark ms-2">Admin</span>
                @endif
            </a>

            <div class="dropdown-menu dropdown-menu-end p-2">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item rounded-3">
                        <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
                    </button>
                </form>
            </div>
        </li>
    </ul>

@else

    <ul class="navbar-nav ms-auto align-items-md-center">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">Regístrate</a>
        </li>
    </ul>

@endif

</div>
</div>
</nav>

<main class="py-4">
@yield('content')
</main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>