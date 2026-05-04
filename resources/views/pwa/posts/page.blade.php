<x-header title="Posts">
    <x-slot:dropdown>
        <li><a class="dropdown-item" href="#">Action</a></li>
        <li><a class="dropdown-item" href="#">Another action</a></li>
    </x-slot:dropdown>
</x-header>
<main class="container d-flex gap-2 flex-column flex-fill overflow-auto py-2">
    @foreach ($posts as $post)
        <article class="card clickable"
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
