<?php

namespace Workbench\App\View\Composers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use stdClass;

class ProfileComposer
{
    /**
     * Currently active menu.
     */
    protected ?stdClass $active = null;

    /**
     * Create a new profile composer.
     */
    public function __construct(
        /**
         * Current request.
         */
        protected Request $request,
    ) {
        //
    }

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        if (!$this->request->route()) {
            return;
        }
        // Create menu objects.
        $menus = collect([
            $this->menu('/posts', 'Home', 'house'),
            $this->menu('/bookmarks', 'Saved', 'bookmarks'),
            $this->menu('/alerts', 'Alerts', 'bell'),
            $this->menu('/account', 'Account', 'person-gear'),
        ]);
        // Set the active menu.
        $active = null;
        $path = str($this->request->path())->start('/')->rtrim('/');
        foreach ($menus as $menu) {
            // Doesn't match that request path
            if (!$path->startsWith($menu->path)) {
                continue;
            }
            // First to match the request path
            if (!$active) {
                $menu->active = true;
                $active = $menu;
                continue;
            }
            // Matches the request path better
            if (strlen($menu->path) > strlen($active->path)) {
                $active->active = false;
                $menu->active = true;
                $active = $menu;
            }
        }
        // Set the home menu.
        $home = $menus->first();
        $home->home = true;
        // Add menus to the view.
        $view->with(['menus' => $menus, 'home' => $home]);
    }

    /**
     * Create a menu object.
     */
    protected function menu(string $path, string $label, string $icon): stdClass
    {
        return literal(
            active: false,
            home: false,
            icon: $icon,
            label: $label,
            path: str($path)->start('/')->rtrim('/')->toString(),
            url: url($path),
        );
    }
}
