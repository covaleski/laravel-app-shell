<?php

namespace App\View\Composers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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
        $view->with('menus', collect([
            $this->menu('pwa.posts', 'Posts', 'newspaper'),
            $this->menu('pwa.posts.new', 'New Post', 'plus-circle'),
            $this->menu('pwa.about', 'About', 'info-circle'),
            $this->menu('pwa.account', 'Account', 'person-gear'),
        ])->tap($this->activate(...)));
    }

    /**
     * Update the `active` field of menu objects in the specified collection.
     */
    protected function activate(Collection $menus): void
    {
        $active = null;
        $route = str($this->request->route()->getName());
        foreach ($menus as $menu) {
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
    }

    /**
     * Create a menu object.
     */
    protected function menu(string $route, string $label, string $icon): stdClass
    {
        return literal(
            active: false,
            icon: $icon,
            label: $label,
            route: $route,
            url: route($route),
        );
    }
}
