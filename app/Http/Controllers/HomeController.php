<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     * * @return void
     */
    public function __construct()
    { 
        $this->middleware('checkAdmin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admins.home');
    }
    
    public function users()
    {
        $usuarios = User::all();
        // Si tienes una vista específica para esto en admins, usa admins.users o admins.ver_usuarios
        return view('admins.ver_usuarios', compact('usuarios'));
    }
}