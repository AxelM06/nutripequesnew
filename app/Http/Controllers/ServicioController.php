<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ViewController extends Controller
{
    // Configuración de conexión a Firebase Firestore
    private $key = "?key=AIzaSyDp_V5toh_KO4R7SDm4lHNKP4OHYBIrwRI";
    private $baseUrl = "https://firestore.googleapis.com/v1/projects/mi-pagina-ec6da/databases/(default)/documents/";

    /**
     * VISTA: Listado de Clientes (Padres)
     */
    public function verUsuarios()
    {
        $response = Http::get($this->baseUrl . "users" . $this->key)->json();
        $usuarios = $this->limpiarDatos($response, 'users');
        return view('ver_usuarios', compact('usuarios'));
    }

    /**
     * VISTA: Listado de Servicios
     */
    public function verServicios()
    {
        $response = Http::get($this->baseUrl . "servicios" . $this->key)->json();
        $servicios = $this->limpiarDatos($response, 'servicios');
        return view('ver_servicios', compact('servicios'));
    }

    /**
     * VISTA: Listado de Mensajes de Contacto
     */
    public function verContactos()
    {
        $response = Http::get($this->baseUrl . "contacts" . $this->key)->json();
        $contactos = $this->limpiarDatos($response, 'contacts');
        return view('ver_contactos', compact('contactos'));
    }

    /**
     * ACCIÓN: Eliminar cualquier documento por Colección e ID
     */
    public function eliminarDoc($coleccion, $id)
    {
        $url = $this->baseUrl . $coleccion . "/" . $id . $this->key;
        Http::delete($url);
        
        return redirect()->back()->with('status', 'Registro eliminado correctamente.');
    }

    /**
     * ACCIÓN: Actualizar campos de un documento (Edición)
     */
    public function actualizarDoc(Request $request, $coleccion, $id)
    {
        $fields = [];
        // Recorremos los inputs del formulario exceptuando tokens de seguridad
        foreach ($request->except(['_token', '_method']) as $key => $value) {
            // Lógica para detectar tipos de datos en Firestore
            if ($key == 'precio' || is_numeric($value) && $key != 'telefono') {
                $fields[$key] = ['integerValue' => (int)$value];
            } else {
                $fields[$key] = ['stringValue' => (string)$value];
            }
        }

        $datos = ['fields' => $fields];
        
        // Creamos la máscara de actualización para que Google sepa qué campos tocar
        $mask = "";
        foreach (array_keys($fields) as $field) {
            $mask .= "&updateMask.fieldPaths=" . $field;
        }

        $url = $this->baseUrl . $coleccion . "/" . $id . $this->key . $mask;
        Http::patch($url, $datos);

        return redirect()->back()->with('status', 'Datos actualizados con éxito.');
    }

    /**
     * ACCIÓN: Cambiar estado de contacto (Pendiente/Finalizado)
     */
    public function estadoContacto($id, $estado)
    {
        $datos = [
            'fields' => [
                'estado' => ['stringValue' => $estado]
            ]
        ];

        $url = $this->baseUrl . "contacts/" . $id . $this->key . "&updateMask.fieldPaths=estado";
        Http::patch($url, $datos);

        return redirect()->back()->with('status', 'El mensaje ha sido marcado como ' . $estado);
    }

    /**
     * FUNCIÓN INTERNA: Formatea el JSON complejo de Firebase a Array simple
     */
    private function limpiarDatos($response, $tipo)
    {
        $items = [];
        if (isset($response['documents'])) {
            foreach ($response['documents'] as $doc) {
                $f = $doc['fields'];
                
                // Extraer el ID del documento desde el nombre completo del path
                $path = explode('/', $doc['name']);
                $id = end($path);
                
                // Formatear fecha de creación interna de Google
                $fecha = isset($doc['createTime']) 
                         ? date('d/m/Y H:i', strtotime($doc['createTime'])) 
                         : 'N/A';

                if ($tipo == 'users') {
                    $items[] = [
                        'id'     => $id,
                        'nombre' => $f['name']['stringValue'] ?? ($f['nombre']['stringValue'] ?? 'N/A'),
                        'email'  => $f['email']['stringValue'] ?? 'N/A',
                        'fecha'  => $fecha
                    ];
                } elseif ($tipo == 'servicios') {
                    $items[] = [
                        'id'     => $id,
                        'nombre' => $f['nombre']['stringValue'] ?? 'N/A',
                        'desc'   => $f['descripcion']['stringValue'] ?? 'N/A',
                        'precio' => $f['precio']['integerValue'] ?? ($f['precio']['stringValue'] ?? '0'),
                        'fecha'  => $fecha
                    ];
                } elseif ($tipo == 'contacts') {
                    $items[] = [
                        'id'      => $id,
                        'nombre'  => $f['Nombre']['stringValue'] ?? 'N/A',
                        'asunto'  => $f['asunto']['stringValue'] ?? 'N/A',
                        'mensaje' => $f['Mensaje']['stringValue'] ?? 'N/A',
                        'estado'  => $f['estado']['stringValue'] ?? 'Pendiente',
                        'fecha'   => $fecha
                    ];
                }
            }
        }
        return $items;
    }
}