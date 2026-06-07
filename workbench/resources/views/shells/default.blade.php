<div class="shell" @shell>
    <header class="shell__header">
        <h1 class="shell__heading">{{ config('app.name') }}</h1>
        <ul class="shell__nav">
            <li class="shell__nav-item">
                <a class="shell__nav-link" href="/">Home</a>
            </li>
            <li class="shell__nav-item">
                <a class="shell__nav-link" href="/about">About</a>
            </li>
            <li class="shell__nav-item">
                <a class="shell__nav-link" href="/signin">Sign In</a>
            </li>
            <li class="shell__nav-item">
                <a class="shell__nav-link" href="/signup">Sign Up</a>
            </li>
        </ul>
    </header>
    <main class="shell__page" @page>
        {!! $page !!}
    </main>
    <footer class="shell__footer">
        <div>
            This is the <strong>default</strong> shell from {{ date('H:i:s') }}.
        </div>
    </footer>
</div>
