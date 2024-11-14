<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePelaporanHilirPrefix
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
{
    // Hanya aktif jika APP_ENV adalah production
    if (env('APP_ENV') === 'production') {
        $path = $request->getPathInfo();

        // Daftar route yang dikecualikan
        $excludedPaths = [
            '/',                 // Dashboard route
            '/login',            // Login route
            '/evaluator/login',  // Evaluator login route
        ];

        // Tambahkan prefix jika path tidak ada dalam daftar pengecualian
        if (!in_array($path, $excludedPaths)) {
            return redirect('/pelaporan-hilir' . $path);
        }
    }

    return $next($request);
}

    
}
