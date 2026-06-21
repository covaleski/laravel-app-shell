<?php

namespace Covaleski\Laravel\Shelter\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\View\Factory;
use Symfony\Component\HttpFoundation\Response;

class EnforceShell
{
    /**
     * Create the middleware instance.
     */
    public function __construct(
        /**
         * View factory.
         */
        protected Factory $viewFactory,
    ) {
        //
    }
    /**
     * Handle an incoming request.
     *
     * Manages shell swaps.
     *
     * @param Closure(Request $request): Response $next
     */
    public function handle(Request $request, Closure $next, string $shell): Response
    {
        if ($request->header('HX-Current-Shell') === $shell) {
            $retarget = $request->header('HX-Page-Target', '#page');
            $reswap = 'innerHTML';
            $wrapper = null;
        } else {
            $retarget = $request->header('HX-Shell-Target', '#shell');
            $reswap = 'outerHTML';
            $wrapper = view($shell);
        }
        $this->viewFactory->share('shell', $shell);
        $response = $next($request);
        if ($wrapper !== null) {
            $wrapper->with('page', $response->getContent());
            $response->setContent($wrapper->render());
        }
        $response->headers->set('HX-Retarget', $retarget);
        $response->headers->set('HX-Reswap', $reswap);
        return $response;
    }
}
