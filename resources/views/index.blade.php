@extends("layouts.master")
@section('title', 'Bienvenido - Nutripeques')

@section("content")

<style>
    :root {
        --purple-gradient: linear-gradient(135deg, #7276d1 0%, #5a5eb1 100%);
        --soft-blue: #eaf4f8;
        --dark-text: #444;
        --text-purple: #7276d1;
    }

    body {
        background: var(--soft-blue);
        font-family: 'Quicksand', sans-serif;
    }

    .welcome-wrapper {
        min-height: 90vh;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .welcome-card {
        background: white;
        padding: 60px 40px;
        border-radius: 40px;
        box-shadow: 0 25px 50px rgba(0,0,0,0.08);
        max-width: 500px;
        width: 100%;
    }

    .logo-title {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .logo-title span:nth-child(1) { color: #ff6b6b; }
    .logo-title span:nth-child(2) { color: #6bcf63; }
    .logo-title span:nth-child(3) { color: #4dabf7; }
    .logo-title span:nth-child(4) { color: #ffd43b; }
    .logo-title span:nth-child(5) { color: #b197fc; }

    .subtitle {
        margin-top: 10px;
        font-weight: 700;
        letter-spacing: 2px;
        color: var(--dark-text);
    }

    .description {
        margin-top: 25px;
        color: #666;
        font-size: 1.1rem;
    }

    /* Botón Principal (Login) */
    .btn-start {
        margin-top: 40px;
        padding: 14px 45px;
        border-radius: 15px;
        border: none;
        font-weight: 700;
        font-size: 1.1rem;
        background: var(--purple-gradient);
        color: white;
        transition: all 0.3s ease;
        text-decoration: none;
        display: block; /* Ocupa el ancho necesario */
        width: 80%;
        margin-left: auto;
        margin-right: auto;
    }

    .btn-start:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(114, 118, 209, 0.4);
        color: white;
    }

    /* Botón Secundario (Registro) */
    .btn-register {
        margin-top: 15px;
        padding: 12px 45px;
        border-radius: 15px;
        border: 2px solid var(--text-purple);
        font-weight: 700;
        font-size: 1rem;
        background: transparent;
        color: var(--text-purple);
        transition: all 0.3s ease;
        text-decoration: none;
        display: block;
        width: 80%;
        margin-left: auto;
        margin-right: auto;
    }

    .btn-register:hover {
        background: rgba(114, 118, 209, 0.05);
        transform: translateY(-2px);
        color: var(--text-purple);
    }
</style>

<div class="container welcome-wrapper">
    <div class="welcome-card">

        <div class="logo-title">
            Nutri
            <span>P</span><span>e</span><span>q</span><span>u</span><span>e</span><span>s</span>
        </div>

        <div class="subtitle">
            BIENVENIDO
        </div>

        <div class="description">
            ¡Empieza a cuidar tu alimentación<br>
            de una manera divertida!
        </div>

        {{-- BOTÓN QUE VA AL LOGIN (COMENZAR) --}}
        <a href="{{ route('login') }}" class="btn-start">
            Iniciar sesión
        </a>

        {{-- NUEVO BOTÓN QUE VA AL REGISTRO --}}
        <a href="{{ route('register') }}" class="btn-register">
            REGISTRARSE
        </a>

    </div>
</div>

@endsection