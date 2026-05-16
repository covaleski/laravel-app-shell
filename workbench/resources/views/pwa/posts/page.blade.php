<header class="py-5">
    <h1 class="text-center">
        {{ config('app.name') }}
    </h1>
    <h2 class="h4 text-center text-body-secondary fst-italic">
        {{ date('l, d M Y') }}
    </h2>
    <div class="text-center">Welcome back!</div>
</header>
<main class="container">
    @foreach ($posts as $post)
        <article
            class="card clickable mb-2"
            hx-get="{{ route('pwa.posts.[post]', ['post' => $post->slug]) }}"
            hx-push-url="true"
        >
            <div class="card-body">
                <header class="mb-2">
                    <h3 class="card-title h5">
                        {{ $post->title }}
                    </h3>
                    <div class="card-subtitle h6 text-body-secondary">
                        {{ $post->created_at }}
                    </div>
                </header>
                <main>
                    <p class="card-text">
                        {{ $post->excerpt }}
                    </p>
                </main>
            </div>
        </article>
    @endforeach
</main>
