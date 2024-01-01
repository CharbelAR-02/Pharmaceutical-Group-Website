<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class ProtectRoutes
{
    /**
     * Handle an incoming request.
     * @param  string[] ...$roles
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (Auth::check() && in_array(Auth::user()->role, $roles)) {
            $userId = Auth::user()->id;
            $urlUserId = $request->route('id'); // Assuming the URL parameter name is 'id'

            if ($userId == $urlUserId) {
                return $next($request);
            }
        }
        return redirect('/unauthorized');
    }
}
