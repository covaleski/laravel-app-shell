<div @pwaShell() style="width: 100vw; height: 100vh;">
    <main @pwaPage()
          style="display: flex;
                 flex-direction: column;
                 align-items: center;
                 width: 100%;
                 height: 100%;
                 overflow: auto"
    >
        {!! $page !!}
    </main>
</div>
