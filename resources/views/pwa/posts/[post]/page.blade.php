<x-header title="Post">
    <x-slot:dropdown>
        <li><a class="dropdown-item" href="#">Copy Link</a></li>
        <li><a class="dropdown-item" href="#">Share</a></li>
    </x-slot:dropdown>
</x-header>
<main class="container d-flex gap-2 flex-column flex-fill overflow-auto py-2">
    <article>
        <header class="mb-2">
            <h3>{{ $post->title }}</h3>
            <div class="text-body-secondary">
                {{ $post->created_at }}
            </div>
        </header>
        <main>
            {!! $post->html !!}
        </main>
    </article>
</main>
