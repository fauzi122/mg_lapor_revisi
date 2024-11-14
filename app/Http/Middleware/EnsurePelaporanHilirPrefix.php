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
        if (env('APP_ENV') === 'local' && !str_starts_with($request->getPathInfo(), '/pelaporan-hilir')) {
            // Tambahkan prefix hanya jika belum ada
            return redirect('/pelaporan-hilir' . $request->getPathInfo());
        }
    
        return $next($request);
    }
}
