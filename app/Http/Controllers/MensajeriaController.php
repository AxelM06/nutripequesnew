<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MensajeriaController extends Controller
{
    private $key = "AIzaSyDp_V5toh_KO4R7SDm4lHNKP4OHYBIrwRI";
    private $baseUrl = "https://firestore.googleapis.com/v1/projects/mi-pagina-ec6da/databases/(default)/documents/";

    // ESTE ES EL MÉTODO QUE BUSCA LA RUTA
    public function mostrarFormularioRespuesta($id) {

        $url = $this->baseUrl . "contacts/" . $id . "?key=" . $this->key;
        $response = Http::get($url)->json();

        if (isset($response['error'])) {
            return redirect()->back()->with('error', 'La consulta no existe en Firebase.');
        }

        $consulta = [];

        if (isset($response['fields'])) {

            $f = $response['fields'];

            $consulta['nombre']  = $f['nombre']['stringValue']  ?? ($f['Nombre']['stringValue'] ?? 'Anónimo');
            $consulta['asunto']  = $f['asunto']['stringValue']  ?? 'Sin asunto';
            $consulta['mensaje'] = $f['mensaje']['stringValue'] ?? ($f['Mensaje']['stringValue'] ?? 'Sin mensaje');
            $consulta['estado']  = $f['Estado']['stringValue']  ?? 'Pendiente';
            $consulta['respuesta'] = $f['respuesta']['stringValue'] ?? '';

        }

        $consulta['id'] = $id;

        return view('admins.responder_consulta', compact('consulta'));
    }

    public function procesarRespuesta(Request $request, $id) {

        $url = $this->baseUrl . "respuestas?key=" . $this->key;

        $datos = [
            'fields' => [
                'contacto_id' => ['stringValue' => $id],
                'respuesta'   => ['stringValue' => (string)$request->respuesta],
                'fecha'       => ['stringValue' => date('Y-m-d')]
            ]
        ];

        Http::post($url, $datos);

        // Opcional: marcar consulta como finalizada
        $urlEstado = $this->baseUrl . "contacts/" . $id . "?key=" . $this->key .
                     "&updateMask.fieldPaths=Estado";

        Http::patch($urlEstado, [
            'fields' => [
                'Estado' => ['stringValue' => 'Finalizado']
            ]
        ]);

        return redirect()->route('ver.contactos')
            ->with('status', '¡Respuesta enviada con éxito!');
    }
}