<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AdmisController extends Controller
{
    private $key = "?key=AIzaSyDp_V5toh_KO4R7SDm4lHNKP4OHYBIrwRI";
    private $baseUrl = "https://firestore.googleapis.com/v1/projects/mi-pagina-ec6da/databases/(default)/documents/";

    // --- PROCESAR LOGIN ---
    public function procesarLogin(Request $request) 
    {
        // 1. Llamada a Firebase
        $response = Http::get($this->baseUrl . "administradores" . $this->key);
        $data = $response->json();

        if (isset($data['documents'])) {
            foreach ($data['documents'] as $doc) {
                $f = $doc['fields'];

                // Extraemos datos de Firebase
                $fbEmail = $f['correo']['stringValue'] ?? '';
                $fbPass  = $f['contraseña']['stringValue'] ?? '';

                // Si son iguales, entra al panel
                if ($request->email == $fbEmail && $request->password == $fbPass) {
                    session([
                        'admin_logged' => true,
                        'admin_email'  => $fbEmail,
                        'admin_nombre' => $f['nombre']['stringValue'] ?? 'Admin'
                    ]);
                    
                    $request->session()->save(); 
                    return redirect()->route('home');
                }
            }
        }

        // Si el correo no existe o el ciclo termina sin éxito
        return redirect()->back()->withErrors(['email' => 'Credenciales incorrectas o usuario no encontrado.']);
    }

    // --- PROCESAR REGISTRO ---
    public function procesarRegistro(Request $request) 
    {
    $email = $request->input('email');
    $password = $request->input('password');

    $url = "https://firestore.googleapis.com/v1/projects/mi-pagina-ec6da/databases/(default)/documents/users?key=AIzaSyDp_V5toh_KO4R7SDm4lHNKP4OHYBIrwRI";

    $response = Http::get($url)->json();

    if (!isset($response['documents'])) {
        return redirect()->back()->with('error', 'No hay usuarios registrados');
    }

    foreach ($response['documents'] as $doc) {
        $fields = $doc['fields'];

        if (
            isset($fields['email']['stringValue']) &&
            $fields['email']['stringValue'] === $email &&
            password_verify($password, $fields['password']['stringValue'])
        ) {

            session([
                'usuario' => $fields['name']['stringValue'],
                'rol' => $fields['rol']['stringValue']
            ]);

            if (session('rol') == 'admin') {
                return redirect('/home');
            } else {
                return redirect('/panel-usuario');
            }
        }
    }

    return redirect()->back()->with('error', 'Credenciales incorrectas');
}

    // --- CERRAR SESIÓN ---
    public function logout(Request $request) 
    {
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->to('http://localhost:81/dev/public/login');
    }
}