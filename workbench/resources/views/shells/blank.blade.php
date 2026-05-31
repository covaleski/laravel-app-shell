<x-app-shell::shell class="shell d-flex flex-column align-items-stretch">
    <x-app-shell::page class="d-flex flex-column justify-content-center align-items-center flex-fill overflow-auto">
        {!! $page !!}
    </x-app-shell::page>
    <footer>
        <div>
            This is the <strong>blank</strong> shell from {{ date('H:i:s') }}.
        </div>
    </footer>
</x-app-shell::shell>
