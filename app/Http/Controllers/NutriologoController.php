<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NutriologoController extends Controller
{
    private $key = "AIzaSyDp_V5toh_KO4R7SDm4lHNKP4OHYBIrwRI";
    private $baseUrl = "https://firestore.googleapis.com/v1/projects/mi-pagina-ec6da/databases/(default)/documents/Ninios";


// 1. Directorio General: Donde aparecen todos para "Elegir"
    public function verPacientes() {  // <--- ¡AQUÍ ESTÁ EL CAMBIO!
        $response = Http::get($this->baseUrl . "?key=" . $this->key)->json();
        $ninos = $this->formatearDatosNinos($response);
        return view('nutri.pacientes', compact('ninos'));
    }

    // 2. Mis Pacientes: Solo los vinculados al ID del nutriólogo en sesión
    public function misPacientes() {
        $nutriId = session('user_id');
        $response = Http::get($this->baseUrl . "?key=" . $this->key)->json();
        
        $todos = $this->formatearDatosNinos($response);
        
        // Filtramos la lista
        $misPacientes = array_filter($todos, function($nino) use ($nutriId) {
            return isset($nino['id_nutriologo']) && $nino['id_nutriologo'] == $nutriId;
        });

        return view('nutri.mis_pacientes', compact('misPacientes'));
    }

    // 3. Lógica para "Elegir": Guarda el ID del nutriólogo en el niño
    public function elegirPaciente($id) {
        $nutriId = session('user_id');
        $urlPatch = $this->baseUrl . "/" . $id . "?key=" . $this->key . "&updateMask.fieldPaths=id_nutriologo";

        Http::patch($urlPatch, [
            'fields' => [
                'id_nutriologo' => ['stringValue' => (string)$nutriId]
            ]
        ]);

        return redirect()->route('nutri.mis_pacientes')->with('status', '¡Paciente añadido con éxito!');
    }

    // --- FUNCIÓN AUXILIAR DE LIMPIEZA Y CÁLCULOS (CLAVE PARA EVITAR ERRORES) ---
    private function formatearDatosNinos($response) {
        $items = [];
        if (isset($response['documents'])) {
            foreach ($response['documents'] as $doc) {
                $f = $doc['fields'];
                $path = explode('/', $doc['name']);

                // Limpieza de números (peso y talla)
                $pesoRaw = $f['peso']['stringValue'] ?? ($f['peso']['integerValue'] ?? 0);
                $tallaRaw = $f['estatura']['stringValue'] ?? ($f['estatura']['integerValue'] ?? 0);
                
                $peso = floatval(preg_replace('/[^0-9.]/', '', $pesoRaw));
                $tallaNum = floatval(preg_replace('/[^0-9.]/', '', $tallaRaw));

                // Normalizar Talla (si es > 3 asumimos cm y pasamos a metros)
                $talla = ($tallaNum > 3) ? ($tallaNum / 100) : $tallaNum;

                // Cálculo de IMC
                $imc = ($talla > 0) ? round($peso / ($talla * $talla), 1) : 0;

                $items[] = [
                    'id' => end($path),
                    'nombre' => trim(($f['nombre']['stringValue'] ?? 'Sin nombre') . ' ' . ($f['apellido']['stringValue'] ?? '')),
                    'edad' => $f['edad']['integerValue'] ?? ($f['edad']['stringValue'] ?? 0),
                    'peso' => $peso,
                    'talla' => $talla,
                    'imc' => $imc, 
                    'id_nutriologo' => $f['id_nutriologo']['stringValue'] ?? null,
                    'genero' => ($f['sexo']['stringValue'] ?? '') == "masculino"
                ];
            }
        }
        return $items;
    }

    public function perfil() { return view('nutri.perfil_nutri'); }

    public function index() { return view('nutri.panel_nutriologo'); }
}