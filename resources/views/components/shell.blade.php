<div {{ $attributes->merge([
    'id' => 'shell',
    'hx-history-elt' => 'hx-history-elt',
    'hx-headers' => json_encode([
        'HX-Current-Shell' => $shell,
    ]),
]) }}>
    {{ $slot }}
</div>
