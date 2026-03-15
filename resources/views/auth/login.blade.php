<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - Nutripeques</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root { 
            --primary: #4e54c8; 
            --primary-2: #6b73ff; 
            --accent: #f5c542; 
            --bg: #f3f3f8; 
            --card: #ffffff; 
        }
        
        body { 
            background: var(--bg); 
            font-family: 'Poppins', sans-serif; 
            margin: 0;
        }

        .auth-wrap { 
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            padding: 20px;
        }

        .auth-card { 
            border: 0; 
            border-radius: 18px; 
            box-shadow: 0 12px 30px rgba(0,0,0,.12); 
            background: var(--card); 
            width: 100%; 
            max-width: 450px; 
            overflow: hidden; 
        }

        .auth-header { 
            background: linear-gradient(135deg, var(--primary), var(--primary-2)); 
            color: #fff; 
            padding: 25px; 
            text-align: center; 
            font-weight: bold; 
            font-size: 1.3rem;
        }

        .auth-body { 
            padding: 40px 30px; 
        }

        .form-label {
            font-weight: 600;
            color: #444;
            margin-bottom: 8px;
            display: block;
        }

        .form-control { 
            border-radius: 10px; 
            padding: 12px; 
            margin-bottom: 20px; 
            border: 1px solid #ddd; 
            width: 100%; 
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(78, 84, 200, 0.1);
            outline: none;
        }

        .btn-primary { 
            background: linear-gradient(135deg, var(--primary), var(--primary-2)); 
            border: 0; 
            border-radius: 10px; 
            padding: 14px; 
            width: 100%; 
            color: white; 
            font-weight: bold; 
            cursor: pointer; 
            transition: transform 0.2s, filter 0.2s;
        }

        .btn-primary:hover {
            filter: brightness(1.1);
            transform: translateY(-2px);
        }

        .error-msg {
            background: #fff0f0;
            color: #e74c3c;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            text-align: center;
            border-left: 4px solid #e74c3c;
        }
    </style>
</head>
<body>

<div class="auth-wrap">
    <div class="auth-card">
        <div class="auth-header">
            <i class="bi bi-person-circle me-2"></i> Iniciar Sesión
        </div>
        <div class="auth-body">

            @if(session('error'))
                <div class="error-msg">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ url('/procesar-login') }}">
                @csrf

                <label class="form-label">Correo electrónico</label>
                <input type="email" name="email" class="form-control" placeholder="correo@ejemplo.com" required>

                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>

                <button type="submit" class="btn-primary">Entrar ahora</button>

                <div class="mt-4 text-center">
                    <span class="text-muted small">¿Eres nuevo aquí?</span><br>
                    <a href="{{ url('/register') }}" style="color:var(--primary); text-decoration:none; font-weight:600;">
                        Crear cuenta nueva
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>