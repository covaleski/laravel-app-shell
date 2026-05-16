@use(Symfony\Component\HttpKernel\Exception\HttpExceptionInterface)

<x-pwa::page style="display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                    width: 100%;
                    height: 100%;
                    overflow: hidden;"
>
    <dl>
        @if($error instanceof HttpExceptionInterface)
            <dt>Status:</dt>
            <dd>{{ $error->getStatusCode() }}</dd>
            <dt>Message:</dt>
            <dd>{{ $error->getMessage() ?: '-' }}</dd>
        @else
            <dt>Status:<dt>
            <dd>500</dd>
            <dt>Message:</dt>
            <dd>Internal Server Error</dd>
        @endif
        @if(app()->hasDebugModeEnabled())
            <hr/>
            <dt>Class:</dt>
            <dd>{{ class_basename($error::class) }}</dd>
            <dt>Code:</dt>
            <dd>{{ $error->getCode() }}</dd>
            <dt>Message:</dt>
            <dd>{{ $error->getMessage() ?: '-' }}</dd>
        @endif
    </dl>
    <button type="button" aria-label="Back" hx-on:click="history.back()">
        Back
    </button>
</div>
