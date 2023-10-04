<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Periksa peran pengguna saat ini
        if ($request->user() && $request->user()->role === $role) {
            return $next($request);
        }

        // Jika pengguna tidak memiliki peran yang sesuai, kembalikan respon larangan (403)
        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
