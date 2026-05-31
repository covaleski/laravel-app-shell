<?php

namespace Covaleski\LaravelAppShell\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;

class EnforceHtmx
{
    /**
     * Handle an incoming request.
     *
     * Validates requests and serves the entrypoint view when needed.
     *
     * @param Closure(Request $request): Response $next
     */
    public function handle(Request $request, Closure $next, string $entrypoint_view): Response
    {
        if (!$request->acceptsHtml()) {
            throw new NotAcceptableHttpException();
        }
        if (!$request->header('HX-Request')) {
            return response()->view($entrypoint_view);
        }
        return $next($request);
    }
}
