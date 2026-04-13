<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Restricts access to admin and editor users (panel staff).
 */
final class PanelMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user === null || ($user->role !== UserRole::Admin && $user->role !== UserRole::Editor)) {
            abort(403, 'Acceso no autorizado.');
        }

        return $next($request);
    }
}
