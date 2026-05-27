<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DownForMaintnanceMW
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->isAllowedDuringMaintenance($request)) {
            return $next($request);
        }

        return redirect()->route('maintenance');
    }

    private function isAllowedDuringMaintenance(Request $request): bool
    {
        return $request->routeIs(
            'maintenance',
            'login',
            'authenticate',
            'logout',
            'password.change',
            'password.update',
            'home',
            'admin.*',
            'teacher.*',
            'student.*',
            'students.*',
            'degrees.*',
            'logs'
        );
    }
}
