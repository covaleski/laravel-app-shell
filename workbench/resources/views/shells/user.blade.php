<x-pwa::shell class="shell d-flex flex-column align-items-stretch">
    <x-pwa::page class="d-flex flex-column flex-fill overflow-auto">
        {!! $page !!}
    </x-pwa::page>
    <aside class="d-flex flex-grow-0 flex-shrink-0 bg-dark">
        <nav class="nav nav-pills nav-fill d-flex gap-2 flex-fill p-1">
            @foreach ($menus as $menu)
                <a  @if($menu->home)
                    id="home-link"
                    @endif
                    @class(['nav-link', 'link-light', 'active' => $menu->active])
                    href="{{ $menu->url }}"
                    title="{{ $menu->label }}"
                    data-bs-toggle="tooltip"
                    data-bs-placement="top"
                    data-bs-trigger="hover"
                    @if($menu->active)
                    aria-current="page"
                    @endif
                    aria-label="{{ $menu->label }}"
                    hx-on:click="htmx.setCurrent(this, 'active', 'page')"
                    hx-replace-url="true"
                >
                    <i class="bi bi-{{ $menu->icon }} fs-4"></i>
                </a>
            @endforeach
        </ul>
    </aside>
</x-pwa::shell>
