<?php

use App\Models\Post;
use Illuminate\Http\Request;

return function (Request $request) {
    return [
        'post' => Post::query()
            ->where('slug', '=', $request->route('post'))
            ->sole(),
    ];
};
