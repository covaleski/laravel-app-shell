<div class="shell" @pwaShell()>
    <main @pwaPage()>
        @include($page)
    </main>
    <footer>
        <div>
            This is the <strong>blank</strong> shell from {{ date('H:i:s') }}.
        </div>
    </footer>
</div>
