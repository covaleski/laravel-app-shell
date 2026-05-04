@props([
    'dropdown' => '',
    'title' => 'Untitled',
])

<header class="d-flex flex-grow-0 flex-shrink-0 bg-dark text-light">
    <nav class="d-flex gap-1 align-items-center flex-fill p-1">
        <button class="btn link-light"
                type="button"
                aria-label="Back"
                hx-on:click="history.back()"
        >
            <i class="bi bi-arrow-left fs-4"></i>
        </button>
        <h2 class="flex-fill m-0">{{ $title }}</h2>
        @if ($dropdown)
            <div class="dropdown">
                <button class="btn link-light"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                >
                    <i class="bi bi-three-dots-vertical fs-4"></i>
                </button>
                <ul class="dropdown-menu">
                    {{ $dropdown }}
                </ul>
            </div>
        @endif
    </nav>
</header>
