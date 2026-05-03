<div class="shell shell--blank" @pwaShell()>
    <main class="page page--centered" @pwaPage()>
        @include($page)
    </main>
    <footer class="footer">
        <div class="debugbar">
            This is the <strong>blank</strong> shell from {{ date('H:i:s') }}.
        </div>
    </footer>
</div>
