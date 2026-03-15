<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mensaje; 

class MensajeController extends Controller
{
    public function index()
    {
        $mensajes = Mensaje::orderBy('created_at', 'desc')->get();
        return view('mensajes.index', compact('mensajes'));
    }

    public function markAsRead($id)
    {
        $mensaje = Mensaje::findOrFail($id);
        
        // Como tu columna es un ENUM, le asignamos un valor 
        // Si 'Leído' no está en tu ENUM de HeidiSQL, usa uno que sí esté (ej: 'baja')
        $mensaje->Prioridad = 'baja'; 
        $mensaje->save();

        return redirect()->back()->with('success', 'Mensaje procesado.');
    }

    public function destroy($id)
    {
        $mensaje = Mensaje::findOrFail($id);
        $mensaje->delete();

        return redirect()->back()->with('success', 'Mensaje eliminado.');
    }
}