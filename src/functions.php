<?php

use Illuminate\Support\Arr;
use Illuminate\View\ComponentAttributeBag;

if (!function_exists('attributes')) {
    /**
     * Turn the specified array into HTML attributes.
     */
    function attributes(array ...$attributes): ComponentAttributeBag
    {
        return (new ComponentAttributeBag())->merge(Arr::map(
            array_merge_recursive(...$attributes),
            fn ($value, $key) => match ($key) {
                'class' => Arr::toCssClasses($value),
                'style' => Arr::toCssStyles($value),
                default => $value,
            },
        ));
    }
}
