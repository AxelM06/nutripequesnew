<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HijoController extends Controller
{   // calve de la API
    private $key = "?key=AIzaSyDp_V5toh_KO4R7SDm4lHNKP4OHYBIrwRI"; 
    private $projectUrl = "https://firestore.googleapis.com/v1/projects/mi-pagina-ec6da/databases/(default)/documents/";

    public function store(Request $request)
    {
        // URL para la colección
        $url = $this->projectUrl . "Ninios" . $this->key;

        // Datos del niño a agregar
        $datos = [
            'fields' => [
                'nombre'       => ['stringValue' => (string)$request->input('nombre')],
                'apellido'     => ['stringValue' => (string)$request->input('apellido')],
                'edad'         => ['integerValue' => (int)$request->input('edad')],
                'estatura'     => ['stringValue' => (string)$request->input('estatura')],
                'peso'         => ['stringValue' => (string)$request->input('peso')],
                'sexo'         => ['stringValue' => (string)$request->input('sexo')],
                'id_padre'   => ['stringValue' => (string)session('user_id')], // Id del apdre del que agrega el hijo
                'created_at'   => ['stringValue' => date('Y-m-d H:i:s')],
                'updated_at'   => ['stringValue' => date('Y-m-d H:i:s')],
            ]
        ];

        //  se realiza el POST a Firestore
        $response = Http::post($url, $datos);

        // comprobamos si se agrego con exito
        if ($response->successful()) {
            return redirect()->back()->with('status', 'Hijo registrado correctamente');
        } else {
            return redirect()->back()->with('error', 'Error al registrar al hijo');
        }
    }
}