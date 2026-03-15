<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdmin
{
public function handle($request, Closure $next)
{
    if (session('rol') != 'admin') {
        return redirect('/login');
    }

    return $next($request);
}
}