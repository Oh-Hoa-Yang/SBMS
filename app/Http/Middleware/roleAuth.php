<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class roleAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
      if (! $request->user()->hasRole($role)) {
        return $next($request);
      }
      else {
        abort(401);
      }
    }

    protected $routeMiddleware = [
      'roleAuth' => \App\Http\Middleware\roleAuth::class,
    ];
}
