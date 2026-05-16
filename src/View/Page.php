<?php

namespace Covaleski\LaravelPwa\View;

use Closure;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class Page implements Responsable
{
    /**
     * Create the page instance.
     */
    public function __construct(
        /**
         * View name.
         */
        protected string $view,

        /**
         * Shell name.
         */
        protected string $shell,

        /**
         * Additional data.
         */
        protected array $data = [],
    ) {
        //
    }

    /**
     * Get a response for the specified request.
     *
     * @param Request $request
     * @return Response
     */
    public function toResponse($request)
    {
        return $this->shouldSwapShell($request->header('HX-Current-Shell', ''))
            ? $this->toShellSwapResponse($request)
            : $this->toPageSwapResponse($request);
    }

    /**
     * Get data for the page view.
     */
    protected function composePageView(View $view): void
    {
        $data = $this->loadData(dirname($view->getPath()) . "/data.php");
        $view->with($this->data)->with($data);
    }

    /**
     * Get data for the page view.
     */
    protected function composeShellView(View $view): void
    {
        $view->with([
            'shell' => $view->getName(),
            'page' => $this->getPageView()->render(),
        ]);
    }

    /**
     * Get a page view instance.
     */
    protected function getPageView(): View
    {
        return tap(view($this->view), $this->composePageView(...));
    }

    /**
     * Get a shell view instance.
     */
    protected function getShellView(): View
    {
        return tap(view($this->shell), $this->composeShellView(...));
    }

    /**
     * Load data using the specified PHP script.
     */
    protected function loadData(string $filename): array
    {
        if (file_exists($filename)) {
            $data = require $filename;
            if ($data instanceof Closure) {
                $data = app()->call($data);
            }
            if (!is_array($data)) {
                $message = "Failed to get an array from {$filename}";
                throw new RuntimeException($message);
            }
            return $data;
        } else {
            return [];
        }
    }

    /**
     * Get whether the specified shell should be swapped.
     */
    protected function shouldSwapShell(string $shell): bool
    {
        return trim($shell) !== trim($this->shell);
    }

    /**
     * Get a response for the specified request that swaps the shell page.
     */
    protected function toPageSwapResponse(Request $request): Response
    {
        return response($this->getPageView(), 200, [
            'HX-Retarget' => $request->header('HX-Page-Target', '#page'),
            'HX-Reswap' => 'innerHTML',
        ]);
    }

    /**
     * Get a response for the specified request that swaps the app shell.
     */
    protected function toShellSwapResponse(Request $request): Response
    {
        return response($this->getShellView(), 200, [
            'HX-Retarget' => $request->header('HX-Shell-Target', '#shell'),
            'HX-Reswap' => 'outerHTML',
        ]);
    }
}
