<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ViewController extends Controller
{
    // Configuración de Firebase Firestore
    private $key = "AIzaSyDp_V5toh_KO4R7SDm4lHNKP4OHYBIrwRI";
    private $baseUrl = "https://firestore.googleapis.com/v1/projects/mi-pagina-ec6da/databases/(default)/documents/";

    /* ============================================================
       1. VISTAS DE ADMINISTRADOR (TABLAS PRINCIPALES)
       ============================================================ */

    // Ver Clientes/Usuarios Registrados
    public function verUsuarios() {
        $response = Http::get($this->baseUrl . "users?key=" . $this->key)->json();
        $usuarios = $this->limpiarDatos($response, 'users');
        return view('admins.ver_usuarios', compact('usuarios'));
    }

    // Ver Catálogo de Servicios
    public function verServicios() {
        $response = Http::get($this->baseUrl . "servicios?key=" . $this->key)->json();
        $servicios = $this->limpiarDatos($response, 'servicios');
        return view('admins.ver_servicios', compact('servicios'));
    }

    // Ver Bandeja de Mensajes de Contacto
    public function verContactos() {
        $response = Http::get($this->baseUrl . "contacts?key=" . $this->key)->json();
        $contactos = $this->limpiarDatos($response, 'contacts');
        return view('admins.ver_contactos', compact('contactos'));
    }

    // Ver Expedientes de todos los Niños (Admin / Nutriólogo)
    public function verTodosLosNinos() {
        $url = $this->baseUrl . "Ninios?key=" . $this->key;
        $response = Http::get($url)->json();
        
        $ninos = [];
        if (isset($response['documents'])) {
            foreach ($response['documents'] as $doc) {
                $f = $doc['fields'];
                
                // Extraemos los valores crudos de Firebase
                $pesoRaw = $f['peso']['stringValue'] ?? ($f['peso']['integerValue'] ?? 0);
                $tallaRaw = $f['estatura']['stringValue'] ?? ($f['estatura']['integerValue'] ?? 0);
                
                // LIMPIEZA
                $peso = $this->limpiarNumero($pesoRaw);
                $tallaNum = $this->limpiarNumero($tallaRaw);
                
                // NORMALIZACIÓN DE TALLA (cm a m si es necesario)
                $talla = ($tallaNum > 3) ? ($tallaNum / 100) : $tallaNum;
                
                // CÁLCULO FINAL DE IMC
                $imc = ($talla > 0) ? round($peso / ($talla * $talla), 1) : 0;

                $path = explode('/', $doc['name']);
                $ninos[] = [
                    'id'     => end($path),
                    'nombre' => trim(($f['nombre']['stringValue'] ?? '') . ' ' . ($f['apellido']['stringValue'] ?? '')),
                    'correo' => $f['id_padre']['stringValue'] ?? 'N/A',
                    'edad'   => $f['edad']['integerValue'] ?? ($f['edad']['stringValue'] ?? 0),
                    'peso'   => $peso,
                    'talla'  => $talla,
                    'imc'    => $imc,
                    'genero' => ($f['sexo']['stringValue'] ?? '') == 'masculino'
                ];
            }
        }

        // --- LÓGICA DE SEPARACIÓN POR ROL ---
        $rol = session('rol');

        if ($rol == 'admin') {
            // Vista completa de Administrador
            return view('admins.ver_ninos', compact('ninos'));
        } else {
            // Vista simplificada de Nutriólogo
            return view('nutri.pacientes', compact('ninos'));
        }
    }

    /**
     * Método de apoyo para limpiar strings y convertirlos en números usables
     */
    private function limpiarNumero($valor) {
        // Elimina cualquier carácter que no sea número o punto decimal
        $limpio = preg_replace('/[^0-9.]/', '', $valor);
        return $limpio === '' ? 0 : (float)$limpio;
    }

    /* ============================================================
       2. ASIGNACIÓN DE PLANES NUTRICIONALES
       ============================================================ */

    // Cargar pantalla de prescripción con datos del niño
    public function pantallaAsignarPlan($id) {
        $url = $this->baseUrl . "Ninios/" . $id . "?key=" . $this->key;
        $response = Http::get($url)->json();

        if (isset($response['error'])) return redirect()->back()->with('error', 'Expediente no encontrado.');

        $f = $response['fields'];
        $nino = [];
        foreach ($f as $campo => $valor) { $nino[$campo] = reset($valor); }
        $nino['id'] = $id;

        // Cálculos para la tarjeta lateral de la vista
        $peso = (float)($f['peso']['stringValue'] ?? ($f['peso']['integerValue'] ?? 0));
        $tallaRaw = (float)($f['estatura']['stringValue'] ?? ($f['estatura']['integerValue'] ?? 0));
        
        $talla = ($tallaRaw > 3) ? ($tallaRaw / 100) : $tallaRaw;
        $imc = ($talla > 0) ? round($peso / ($talla * $talla), 1) : 0;

        // Inyectamos los valores calculados al array $nino para que el Blade los vea
        $nino['peso'] = $peso;
        $nino['estatura'] = $tallaRaw; 
        $nino['imc_calculado'] = $imc; // Este es el que usa tu Blade: {{ $nino['imc_calculado'] }}

        $edad = (int)($nino['edad'] ?? 0);
        $sugerencia = "PLAN SUGERIDO PARA PACIENTE DE " . $edad . " AÑOS:\n- Desayuno: Avena con fruta.\n- Almuerzo: Proteína magra y vegetales.\n- Cena: Ligera.";

        return view('admins.asignar_plan_nino', compact('nino', 'sugerencia'));
    }

    // Guardar el plan y subir archivo PDF/TXT
    public function guardarPlanNino(Request $request, $id) {
        $urlArchivo = "sin_archivo";
        
        // 1. Gestión del archivo adjunto (si existe)
        if ($request->hasFile('archivo_adjunto')) {
            $archivo = $request->file('archivo_adjunto');
            $nombre = $id . '_' . time() . '.' . $archivo->getClientOriginalExtension();
            
            // Asegurar que la carpeta de destino exista en el servidor
            if (!file_exists(public_path('uploads/planes'))) {
                mkdir(public_path('uploads/planes'), 0777, true);
            }
            
            $archivo->move(public_path('uploads/planes'), $nombre);
            $urlArchivo = '/uploads/planes/' . $nombre;
        }

        // 2. Preparación de los campos para Firebase Firestore
        $fields = [
            'nino_id'      => ['stringValue' => (string)$id],
            'titulo'       => ['stringValue' => (string)$request->titulo_plan],
            'detalle'      => ['stringValue' => (string)$request->detalle_plan],
            'calorias'     => ['integerValue' => (int)$request->calorias],
            'proxima_cita' => ['stringValue' => (string)($request->proxima_cita ?? 'Pendiente')],
            'url_archivo'  => ['stringValue' => $urlArchivo],
            'fecha_creado' => ['stringValue' => date('Y-m-d')]
        ];

        // 3. Petición POST a la API de Firebase
        Http::post($this->baseUrl . "planes?key=" . $this->key, [
            'fields' => $fields
        ]);

        // 4. LÓGICA DE REDIRECCIÓN DINÁMICA
        // Obtenemos el rol desde la sesión para saber a dónde regresar
        $rol = session('rol');

        if ($rol == 'admin') {
            // Redirige a la vista de "Expedientes de todos los Niños" para el Administrador
            return redirect()->route('ver.ninos')
                             ->with('success', '¡Plan nutricional guardado correctamente como Administrador!');
        } else {
            // Redirige a la vista de "Directorio/Pacientes" para el Nutriólogo
            return redirect()->route('nutri.pacientes')
                             ->with('success', '¡El plan nutricional ha sido enviado correctamente a los padres!');
        }
    }

    /* ============================================================
       3. GESTIÓN DE HIJOS (VISTA PADRE)
       ============================================================ */

    public function verHijosRegistrados() {
        $padreId = session('user_id');
        // Consultamos la colección Ninios
        $response = Http::get($this->baseUrl . "Ninios?key=" . $this->key)->json();
        
        $todosLosNinios = [];
        if (isset($response['documents'])) {
            foreach ($response['documents'] as $doc) {
                $f = $doc['fields'];

                // Filtramos por el ID del padre en sesión
                if (isset($f['id_padre']['stringValue']) && $f['id_padre']['stringValue'] == $padreId) {
                    
                    // --- CÁLCULOS DE PESO Y TALLA ---
                    $peso = (float)($f['peso']['stringValue'] ?? ($f['peso']['integerValue'] ?? 0));
                    $tallaRaw = (float)($f['estatura']['stringValue'] ?? ($f['estatura']['integerValue'] ?? 0));
                    
                    // Normalización de Estatura (si puso 160cm en lugar de 1.60m)
                    $tallaM = ($tallaRaw > 3) ? ($tallaRaw / 100) : $tallaRaw;
                    
                    // Cálculo de IMC
                    $imc = ($tallaM > 0) ? ($peso / ($tallaM * $tallaM)) : 0;

                    $path = explode('/', $doc['name']);
                    
                    // --- ESTRUCTURA DEL ARRAY PARA LA VISTA ---
                    $todosLosNinios[] = [
                        'id'       => end($path),
                        'nombre'   => $f['nombre']['stringValue'] ?? 'Sin nombre',
                        'apellido' => $f['apellido']['stringValue'] ?? '',
                        'edad'     => $f['edad']['integerValue'] ?? ($f['edad']['stringValue'] ?? '0'),
                        'sexo'     => $f['sexo']['stringValue'] ?? 'No definido', 
                        'peso'     => $peso,
                        'estatura' => $tallaRaw,
                        'imc'      => number_format($imc, 1), 
                    ];
                }
            }
        }

        // Retornamos la vista con los datos ya filtrados
        return view('users.hijos_registrados', compact('todosLosNinios'));
    }

    /* ============================================================
       4. UTILIDADES (PATCH, DELETE, LIMPIEZA)
       ============================================================ */

    public function estadoContacto($id, $estado) {
        $url = $this->baseUrl . "contacts/" . $id . "?key=" . $this->key . "&updateMask.fieldPaths=Estado";
        
        $response = Http::patch($url, [
            'fields' => [
                'Estado' => ['stringValue' => $estado]
            ]
        ]);

        if ($response->successful()) {
            return redirect()->back()->with('status', 'Estatus de la consulta actualizado correctamente.');
        }
        
        return redirect()->back()->with('error', 'No se pudo actualizar el estatus.');
    }

    /* ============================
       ====== EDICIÓN DE PERFIL =====
       ============================ */

    public function editarDocPerfil($id) {
        $rol = session('rol');

        $coleccion = ($rol == 'admin') 
            ? 'administradores' 
            : (($rol == 'nutriologo') ? 'nutriologo' : 'users');

        return $this->editarDoc($coleccion, $id);
    }

    public function editarDoc($coleccion, $id) {
        $url = $this->baseUrl . $coleccion . "/" . $id . "?key=" . $this->key;
        $response = Http::get($url)->json();

        if (isset($response['error'])) {
            return redirect()->back()->with('error', 'No se encontró el registro en la colección: ' . $coleccion);
        }

        $documento = [];
        if (isset($response['fields'])) {
            foreach ($response['fields'] as $campo => $valor) {
                $documento[$campo] = reset($valor);
            }
        }

        $documento['id'] = $id;
        $documento['coleccion'] = $coleccion;

        // Según la imagen, editar_perfil está fuera de las carpetas
        return view('editar_perfil', compact('documento'));
    }

    public function eliminarDoc($coleccion, $id) {
        Http::delete($this->baseUrl . $coleccion . "/" . $id . "?key=" . $this->key);
        return redirect()->back()->with('status', 'Registro eliminado correctamente.');
    }

    public function descargarPlanHijo($id_nino) {
        $url = $this->baseUrl . "planes?key=" . $this->key;
        $response = Http::get($url)->json();

        $miPlan = null;

        if (isset($response['documents'])) {
            foreach ($response['documents'] as $doc) {
                $f = $doc['fields'];
                
                if (isset($f['nino_id']['stringValue']) && $f['nino_id']['stringValue'] == $id_nino) {
                    $miPlan = [
                        'titulo'  => $f['titulo']['stringValue'] ?? 'Plan Nutricional',
                        'archivo' => $f['url_archivo']['stringValue'] ?? 'sin_archivo',
                        'detalle' => $f['detalle']['stringValue'] ?? ''
                    ];
                }
            }
        }

        return view('users.ver_plan_detalle', compact('miPlan'));
    }

    public function misConsultas() {
        $miIdSesion = (string)session('user_id');
        
        $response = Http::get($this->baseUrl . "contacts?key=" . $this->key)->json();
        $respuestas = Http::get($this->baseUrl . "respuestas?key=" . $this->key)->json();

        $misConsultas = [];

        if (isset($response['documents'])) {
            foreach ($response['documents'] as $doc) {
                $f = $doc['fields'];
                $idEnFirebase = $f['user_id']['stringValue'] ?? ($f['id_padre']['stringValue'] ?? '');

                if (!empty($miIdSesion) && $idEnFirebase == $miIdSesion) {
                    $path = explode('/', $doc['name']);
                    $idConsulta = end($path);
                    $respuestaTexto = null;
                    
                    if(isset($respuestas['documents'])){
                        foreach($respuestas['documents'] as $r){
                            $rf = $r['fields'];
                            if(($rf['contacto_id']['stringValue'] ?? '') == $idConsulta){
                                $respuestaTexto = $rf['respuesta']['stringValue'] ?? '';
                            }
                        }
                    }

                    $misConsultas[] = [
                        'id'        => $idConsulta,
                        'asunto'    => $f['asunto']['stringValue'] ?? 'Sin Asunto',
                        'mensaje'   => $f['mensaje']['stringValue'] ?? '',
                        'estado'    => $f['Estado']['stringValue'] ?? 'Pendiente',
                        'respuesta' => $respuestaTexto,
                        'fecha'     => date('d/m/Y', strtotime($doc['createTime']))
                    ];
                }
            }
        }

        return view('users.mis_consultas', compact('misConsultas'));
    }

    public function mostrarPerfilSegunRol() {
        $rol = session('rol');
        
        if ($rol == 'admin') {
            return view('admins.perfil_admin');
        } elseif ($rol == 'nutriologo') {
            return view('nutri.perfil_nutri');
        } else {
            return view('users.perfil');
        }
    }

    public function buscarAlimento(Request $request) {
        $nombreAlimento = $request->input('alimento');
        
        $response = Http::get("https://world.openfoodfacts.org/cgi/search.pl", [
            'search_terms' => $nombreAlimento,
            'search_simple' => 1,
            'action' => 'process',
            'json' => 1,
            'page_size' => 1 
        ])->json();

        if (isset($response['products']) && count($response['products']) > 0) {
            $producto = $response['products'][0];
            $grado = strtoupper($producto['nutrition_grades'] ?? 'unknown'); // A, B, C, D, E
            $nombreReal = $producto['product_name'] ?? $nombreAlimento;
            
            switch ($grado) {
                case 'A':
                case 'B':
                    $resultado = " **$nombreReal** es altamente recomendado (Calificación $grado).";
                    $color = "alert-success";
                    break;
                case 'C':
                    $resultado = " **$nombreReal** es aceptable (Calificación $grado). Consumo moderado.";
                    $color = "alert-info";
                    break;
                case 'D':
                case 'E':
                    $resultado = " **$nombreReal** NO es recomendado para niños (Calificación $grado).";
                    $color = "alert-danger";
                    break;
                default:
                    $resultado = " No tenemos datos nutricionales suficientes para '$nombreReal'.";
                    $color = "alert-secondary";
            }
        } else {
            $resultado = " No se encontró el alimento '$nombreAlimento' en la base de datos.";
            $color = "alert-warning";
        }

        return back()->with(['resultado_busqueda' => $resultado, 'color_alerta' => $color]);
    }
    
    public function actualizarDoc(Request $request, $coleccion, $id)
    {
        $fields = [];

        foreach ($request->except(['_token', '_method']) as $campo => $valor) {
            if ($valor === null) continue;
            $fields[$campo] = [
                'stringValue' => (string)$valor
            ];
        }

        $url = $this->baseUrl . $coleccion . "/" . $id . "?key=" . $this->key;
        
        $response = Http::patch($url, [
            'fields' => $fields
        ]);

        if ($response->successful()) {
            if ($id == session('user_id')) {
                if ($request->has('nombre')) session(['usuario' => $request->nombre]);
                if ($request->has('name')) session(['usuario' => $request->name]);
                if ($request->has('apellido')) session(['apellido' => $request->apellido]);
                if ($request->has('email')) session(['email_login' => $request->email]);
                if ($request->has('especialidad')) session(['especialidad' => $request->especialidad]);
            }

            return redirect()->back()->with('status', '¡Perfil actualizado y sesión refrescada con éxito!');
        }

        return redirect()->back()->with('error', 'No se pudo actualizar la información en Firebase.');
    }

    private function limpiarDatos($response, $tipo) {
        $items = [];
        if (isset($response['documents'])) {
            foreach ($response['documents'] as $doc) {
                $f = $doc['fields'];
                $path = explode('/', $doc['name']);
                $id = end($path);
                $fecha = isset($doc['createTime']) ? date('d/m/Y', strtotime($doc['createTime'])) : 'N/A';

                if ($tipo == 'users') {
                    $items[] = [
                        'id'     => $id,
                        'nombre' => $f['name']['stringValue'] ?? ($f['nombre']['stringValue'] ?? 'Sin nombre'),
                        'email'  => $f['email']['stringValue'] ?? ($f['correo']['stringValue'] ?? 'N/A'),
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
                        'nombre'  => $f['nombre']['stringValue'] ?? ($f['Nombre']['stringValue'] ?? 'Anónimo'),
                        'asunto'  => $f['asunto']['stringValue'] ?? 'Sin asunto',
                        'mensaje' => $f['mensaje']['stringValue'] ?? ($f['Mensaje']['stringValue'] ?? 'Sin mensaje'),
                        'estado'  => $f['Estado']['stringValue'] ?? 'Pendiente',
                        'fecha'   => $fecha
                    ];
                }
            }
        }
        return $items;
    }
}