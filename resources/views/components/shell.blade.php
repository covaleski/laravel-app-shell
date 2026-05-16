<div {{ $attributes->merge([
    'id' => 'shell',
    'hx-history-elt' => 'hx-history-elt',
]) }}>
    {{ $slot }}
</div>
