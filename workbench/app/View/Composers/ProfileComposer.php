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
        // Create menu objects.
        $menus = collect([
            $this->menu('pwa.posts', 'Home', 'house'),
            $this->menu('pwa.bookmarks', 'Saved', 'bookmarks'),
            $this->menu('pwa.alerts', 'Alerts', 'bell'),
            $this->menu('pwa.account', 'Account', 'person-gear'),
        ]);
        // Set the active menu.
        $active = null;
        $route = str($this->request->route()->getName());
        foreach ($menus as $i => $menu) {
            // Doesn't match that request route
            if (!$route->startsWith($menu->route)) {
                continue;
            }
            // First to match the request route
            if (!$active) {
                $menu->active = true;
                $active = $menu;
                continue;
            }
            // Matches the request route better
            if (strlen($menu->route) > strlen($active->route)) {
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
    protected function menu(string $route, string $label, string $icon): stdClass
    {
        return literal(
            active: false,
            home: false,
            icon: $icon,
            label: $label,
            route: $route,
            url: route($route),
        );
    }
}
