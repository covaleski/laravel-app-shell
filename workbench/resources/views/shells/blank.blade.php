<x-pwa::shell class="shell d-flex flex-column align-items-stretch">
    <x-pwa::page class="d-flex flex-column justify-content-center align-items-center flex-fill overflow-auto">
        {!! $page !!}
    </x-pwa::page>
    <footer>
        <div>
            This is the <strong>blank</strong> shell from {{ date('H:i:s') }}.
        </div>
    </footer>
</x-pwa::shell>
