<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    // Configuración de Firebase
    private $key = "?key=AIzaSyDp_V5toh_KO4R7SDm4lHNKP4OHYBIrwRI";
    private $projectUrl = "https://firestore.googleapis.com/v1/projects/mi-pagina-ec6da/databases/(default)/documents/";

    public function login() { return view('auth.login'); }

    /*
    |--------------------------------------------------------------------------
    | LOGIN MULTI-ROL (Capturando user_id para edición)
    |--------------------------------------------------------------------------
    */
    public function procesarLogin(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        // 1. INTENTAR LOGIN COMO ADMIN
        $adminRes = Http::get($this->projectUrl . "administradores" . $this->key)->json();
        if (isset($adminRes['documents'])) {
            foreach ($adminRes['documents'] as $doc) {
                $f = $doc['fields'];
                if (($f['correo']['stringValue'] ?? '') == $email && ($f['contraseña']['stringValue'] ?? '') == $password) {
                    
                    $docId = basename($doc['name']); // Captura el ID real de Firebase

                    session([
                        'user_id' => $docId,
                        'admin_logged' => true, 
                        'usuario' => $f['nombre']['stringValue'], 
                        'apellido' => $f['apellido']['stringValue'] ?? '', 
                        'email_login' => $f['correo']['stringValue'], 
                        'rol' => 'admin'
                    ]);
                    return redirect('/home');
                }
            }
        }

        // 2. INTENTAR LOGIN COMO NUTRIÓLOGO
        $nutriRes = Http::get($this->projectUrl . "nutriologo" . $this->key)->json();
        if (isset($nutriRes['documents'])) {
            foreach ($nutriRes['documents'] as $doc) {
                $f = $doc['fields'];
                if (($f['correo']['stringValue'] ?? '') == $email && ($f['contraseña']['stringValue'] ?? '') == $password) {
                    
                    $docId = basename($doc['name']);

                    session([
                        'user_id' => $docId,
                        'usuario' => $f['nombre']['stringValue'], 
                        'apellido' => $f['apellido']['stringValue'] ?? '', 
                        'email_login' => $f['correo']['stringValue'], 
                        'rol' => 'nutriologo'
                    ]);
                    return redirect('/panel-nutriologo');
                }
            }
        }

        // 3. INTENTAR LOGIN COMO USUARIO (Colección 'users')
        $userRes = Http::get($this->projectUrl . "users" . $this->key)->json();
        if (isset($userRes['documents'])) {
            foreach ($userRes['documents'] as $doc) {
                $f = $doc['fields'];
                if (($f['email']['stringValue'] ?? '') == $email && ($f['password']['stringValue'] ?? '') == $password) {
                    
                    $docId = basename($doc['name']);

                    session([
                        'user_id' => $docId,
                        'usuario' => $f['name']['stringValue'], 
                        'apellido' => $f['last_name']['stringValue'] ?? '', 
                        'email_login' => $f['email']['stringValue'], 
                        'rol' => 'user'
                    ]);
                    return redirect('/panel-usuario');
                }
            }
        }

        return redirect()->back()->with('error', 'Credenciales incorrectas');
    }

    /*
    |--------------------------------------------------------------------------
    | REGISTRO INTELIGENTE
    |--------------------------------------------------------------------------
    */
    public function procesarRegistro(Request $request)
    {
        $rol = $request->input('rol', 'user'); 

        if ($rol === 'user') {
            $coleccion = "users";
            $fields = [
                'name'      => ['stringValue' => (string)$request->name],
                'last_name' => ['stringValue' => (string)$request->last_name],
                'email'     => ['stringValue' => (string)$request->email],
                'password'  => ['stringValue' => (string)$request->password],
                'rol'       => ['stringValue' => 'user'],
            ];
        } else {
            $coleccion = "administradores";
            $fields = [
                'nombre'     => ['stringValue' => (string)$request->name],
                'apellido'   => ['stringValue' => (string)$request->last_name],
                'correo'     => ['stringValue' => (string)$request->email],
                'contraseña' => ['stringValue' => (string)$request->password],
                'rol'        => ['stringValue' => 'admin'],
            ];
        }

        $response = Http::post($this->projectUrl . $coleccion . $this->key, [
            'fields' => $fields
        ]);

        if ($response->successful()) {
            if ($rol === 'user') {
                return redirect()->route('login')->with('success', '¡Cuenta creada! Inicia sesión.');
            }
            return redirect()->route('home')->with('success', 'Administrador registrado.');
        }

        return redirect()->back()->with('error', 'Error al conectar con la base de datos.');
    }

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR PERFIL
    |--------------------------------------------------------------------------
    */
    public function actualizarPerfil(Request $request)
    {
        $rol = session('rol');
        $emailActual = session('email_login');
        $adminLogged = session('admin_logged');
        $userIdActual = session('user_id');

        $coleccion = ($rol == 'admin') ? 'administradores' : (($rol == 'nutriologo') ? 'nutriologo' : 'users');
        $campoNombre = ($rol == 'user') ? 'name' : 'nombre';
        $campoApellido = ($rol == 'user') ? 'last_name' : 'apellido';

        $urlPatch = $this->projectUrl . $coleccion . "/" . $userIdActual . "?updateMask.fieldPaths=".$campoNombre."&updateMask.fieldPaths=".$campoApellido."&key=AIzaSyDp_V5toh_KO4R7SDm4lHNKP4OHYBIrwRI";
        
        Http::patch($urlPatch, [
            'fields' => [
                $campoNombre => ['stringValue' => $request->nombre],
                $campoApellido => ['stringValue' => $request->apellido]
            ]
        ]);

        session([
            'user_id'      => $userIdActual,
            'usuario'      => $request->nombre,
            'apellido'     => $request->apellido,
            'email_login'  => $emailActual,
            'rol'          => $rol,
            'admin_logged' => $adminLogged
        ]);

        return redirect()->route('perfil')->with('success', 'Datos actualizados.');
    }

    /*
    |--------------------------------------------------------------------------
    | GUARDAR NUTRIÓLOGO
    |--------------------------------------------------------------------------
    */
    public function guardarNutriologo(Request $request)
    {
        $fields = [
            'nombre'     => ['stringValue' => (string)$request->nombre],
            'apellido'   => ['stringValue' => (string)$request->apellido],
            'correo'     => ['stringValue' => (string)$request->correo],
            'contraseña' => ['stringValue' => (string)$request->contraseña],
            'campo'      => ['stringValue' => (string)$request->campo], 
        ];

        $response = Http::post($this->projectUrl . "nutriologo" . $this->key, ['fields' => $fields]);

        if ($response->successful()) {
            return redirect()->route('home')->with('success', 'Nutriólogo registrado.');
        }
        return redirect()->back()->with('error', 'Error al guardar.');
    }

    public function logout() { session()->flush(); return redirect('/login'); }
}