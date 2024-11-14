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
        if (env('APP_ENV') === 'production') {
            $path = $request->getPathInfo();
            
            // Tambahkan prefix hanya jika belum ada di awal path
            if (!str_starts_with($path, '/pelaporan-hilir')) {
                return redirect('/pelaporan-hilir' . $path);
            }
        }
    
        return $next($request);
    }
}
