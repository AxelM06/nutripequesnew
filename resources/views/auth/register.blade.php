<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta - Nutripeques</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root{ --primary:#4e54c8; --primary-2:#6b73ff; --bg:#f3f3f8; --card:#ffffff; }
        body{ background: var(--bg); font-family: 'Poppins', sans-serif; margin: 0; }
        .auth-wrap{ min-height: 100vh; display:flex; align-items:center; justify-content:center; padding: 20px; }
        .auth-card{ border-radius:18px; box-shadow: 0 12px 30px rgba(0,0,0,.12); background: var(--card); width:100%; max-width:600px; overflow: hidden; }
        .auth-header{ background: linear-gradient(135deg, var(--primary), var(--primary-2)); color:#fff; padding:20px; font-weight:bold; text-align:center; font-size: 1.25rem; }
        .auth-body{ padding:30px; }
        label { font-weight: 600; margin-bottom: 5px; display: block; color: #444; }
        .form-control{ border-radius:10px; padding:12px; margin-bottom:15px; border:1px solid #ddd; width:100%; }
        .form-control:focus { border-color: var(--primary); box-shadow: none; outline: none; }
        .btn-primary{ background: var(--primary); border:0; border-radius:10px; padding:12px; width: 100%; color:white; font-weight:bold; cursor: pointer; transition: 0.3s; }
        .btn-primary:hover { background: var(--primary-2); }
        a { color: var(--primary); text-decoration: none; font-size: 0.9rem; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="auth-wrap">
    <div class="auth-card">
        <div class="auth-header">Crear Cuenta</div>
        <div class="auth-body">

            @if(session('error'))
                <div style="color:red; margin-bottom:15px; text-align:center; font-weight:600;">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ url('/guardar-usuario') }}">
                @csrf

                <input type="hidden" name="rol" value="user">

                <label>Nombre</label>
                <input type="text" name="name" class="form-control" placeholder="Tu nombre" required>

                <label>Apellido</label>
                <input type="text" name="last_name" class="form-control" placeholder="Tu apellido" required>

                <label>Correo Electrónico</label>
                <input type="email" name="email" class="form-control" placeholder="correo@ejemplo.com" required>

                <label>Contraseña</label>
                <input type="password" name="password" class="form-control" placeholder="Mínimo 6 caracteres" required>

                <button type="submit" class="btn-primary mt-3">
                    Registrarme
                </button>

                <div class="mt-3 text-center">
                    <a href="{{ route('login') }}">¿Ya tienes cuenta? Inicia sesión</a>
                </div>

            </form>
        </div>
    </div>
</div>

</body>
</html>