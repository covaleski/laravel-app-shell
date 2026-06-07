<div class="shell" @shell>
    <header class="shell__header">
        <h1 class="shell__heading">{{ config('app.name') }}</h1>
        <ul class="shell__nav">
            <li class="shell__nav-item">
                <a class="shell__nav-link" href="/">Home</a>
            </li>
        </ul>
    </header>
    <main class="shell__page shell__page--tiny" @page>
        {!! $page !!}
    </main>
    <footer class="shell__footer">
        <div>
            This is the <strong>blank</strong> shell from {{ date('H:i:s') }}.
        </div>
    </footer>
</div>
