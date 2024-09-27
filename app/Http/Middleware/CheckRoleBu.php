<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleBu
{
   // app/Http/Middleware/CheckRoleBu.php

   public function handle($request, Closure $next, $role = 'BU')
   {
       // Mendapatkan peran pengguna saat ini
       $userRole = $request->user() ? $request->user()->role : null;
   
       // Mengecek apakah peran pengguna adalah "BU"
       if ($userRole !== $role) {
           return back(); // Mengarahkan pengguna kembali ke halaman sebelumnya
       }
   
       return $next($request);
   }

}
