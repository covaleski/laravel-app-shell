<div class="shell d-flex flex-column align-items-stretch" @pwaShell()>
    <main class="d-flex flex-column flex-fill overflow-auto" @pwaPage()>
        {!! $page !!}
    </main>
    <aside class="d-flex flex-grow-0 flex-shrink-0 bg-dark">
        <nav class="nav nav-pills nav-fill d-flex gap-2 flex-fill p-1">
            @foreach ($menus as $menu)
                <a {{ attributes([
                    'class' => [
                        'nav-link',
                        'link-light',
                        'active' => $menu->active,
                    ],
                    'href' => $menu->url,
                    'title' => $menu->label,
                    'data-bs-toggle' => 'tooltip',
                    'data-bs-placement' => 'top',
                    'data-bs-trigger' => 'hover',
                    'aria-label' => $menu->label,
                    'aria-current' => $menu->active ? 'page' : null,
                    'hx-on:click' => 'htmx.setCurrent(this, "active", "page")',
                ]) }}>
                    <i class="bi bi-{{ $menu->icon }} fs-4"></i>
                </a>
            @endforeach
        </ul>
    </aside>
</div>
