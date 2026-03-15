<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FirebaseController extends Controller
{
    private $key = "?key=AIzaSyDp_V5toh_KO4R7SDm4lHNKP4OHYBIrwRI";
    private $projectUrl = "https://firestore.googleapis.com/v1/projects/mi-pagina-ec6da/databases/(default)/documents/";

    public function store(Request $request)
    {
        $url = $this->projectUrl . "users" . $this->key;
        $datos = [
            'fields' => [
                'name'       => ['stringValue' => (string)$request->input('name')],
                'last_name'  => ['stringValue' => (string)$request->input('last_name')],
                'email'      => ['stringValue' => (string)$request->input('email')],
                'password'   => ['stringValue' => (string)$request->input('password')],
                'created_at' => ['stringValue' => date('Y-m-d H:i:s')],
                'updated_at' => ['stringValue' => date('Y-m-d H:i:s')],
            ]
        ];
        $response = Http::post($url, $datos);
        return $response->successful() ? redirect('/login')->with('status', 'Usuario registrado') : redirect()->back();
    }

    public function storeServicio(Request $request)
    {
        $url = $this->projectUrl . "servicios" . $this->key;
        $datos = [
            'fields' => [
                'nombre'      => ['stringValue' => (string)$request->input('nombre')],
                'descripcion' => ['stringValue' => (string)$request->input('descripcion')],
                'precio'      => ['integerValue' => (int)$request->input('precio')],
            ]
        ];
        $response = Http::post($url, $datos);
        return $response->successful() ? redirect('/ver-servicios')->with('status', 'Servicio creado') : redirect()->back();
    }

public function storeContacto(Request $request)
{
    $url = $this->projectUrl . "contacts" . $this->key;
    
    $datos = [
        'fields' => [
            'Nombre'     => ['stringValue' => (string)$request->input('nombre')],
            'Correo'     => ['stringValue' => (string)$request->input('correo')],
            'Mensaje'    => ['stringValue' => (string)$request->input('mensaje')],
            'asunto'     => ['stringValue' => (string)$request->input('asunto')],
            'Prioridad'  => ['stringValue' => (string)$request->input('prioridad')],
            'Estado'     => ['stringValue' => 'Pendiente'],
            // Asegúrate de que auth()->id() o session('user_id') tengan valor
            'user_id'    => ['stringValue' => (string)(auth()->id() ?? session('user_id'))], 
            'created_at' => ['stringValue' => date('Y-m-d H:i:s')],
        ]
    ];

    $response = Http::post($url, $datos);

    if ($response->successful()) {
        return redirect()->route('crear_contacto')->with('success', 'Tu consulta ha sido enviada y está en revisión.');
    }
    return redirect()->back()->with('error', 'Error al enviar');
}
public function historial_Contacto()
{
    $url = $this->projectUrl . "contacts" . $this->key;
    $response = Http::get($url);
    $documentos = $response->json()['documents'] ?? [];
    
    $misConsultas = [];
    
    // Obtenemos el ID del usuario desde la sesión o el sistema de auth
    $miId = (string)(session('user_id') ?? auth()->id());

    foreach ($documentos as $doc) {
        $fields = $doc['fields'] ?? [];
        
        // Extraemos el user_id de Firebase
        $userIdFB = $fields['user_id']['stringValue'] ?? null;

        // FILTRO POR ID: Solo entra si el ID coincide exactamente
        if ($userIdFB && $userIdFB === $miId) {
            $parts = explode('/', $doc['name']);
            $misConsultas[] = [
                'id'      => end($parts),
                'fecha'   => $fields['created_at']['stringValue'] ?? 'N/A',
                'asunto'  => $fields['asunto']['stringValue'] ?? 'Sin Asunto',
                'mensaje' => $fields['Mensaje']['stringValue'] ?? '',
                'estado'  => $fields['Estado']['stringValue'] ?? 'Pendiente',
            ];
        }
    }

    return view('historial_contacto', compact('misConsultas'));
}

    public function crearServicio() { return view('crear_servicio'); }

    // Esta función carga la vista que tú tienes
    public function crearContacto() { return view('crear_contacto'); }
}