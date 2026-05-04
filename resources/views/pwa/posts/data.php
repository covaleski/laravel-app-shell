<?php

use App\Models\Post;

return [
    'posts' => Post::all(['title', 'slug', 'excerpt', 'created_at']),
];
