<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Memeriksa hak akses pengguna berdasarkan role.
     */
    public function handle(
        Request $request,
        Closure $next,
        string ...$roles
    ): Response {

        // Memastikan pengguna sudah login
        if (!$request->user()) {
            return redirect('/login');
        }

        // Memeriksa apakah role pengguna diizinkan
        if (!in_array($request->user()->role, $roles, true)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
