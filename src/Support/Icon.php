<?php

namespace Covaleski\LaravelPwa\Support;

use Illuminate\Contracts\Support\Arrayable;

class Icon implements Arrayable
{
    /**
     * Create the icon instance.
     */
    public function __construct(
        /**
         * Path to the icon image file.
         */
        protected string $src,

        /**
         * Sizes at which the icon file can be used.
         */
        protected string $sizes,

        /**
         * MIME type of the icon.
         */
        protected string $type,

        /**
         * Contexts in which the icon can be used.
         */
        protected string $purpose,
    ) {
        //
    }

    /**
     * Get the instance as an array.
     *
     * @return array<string, string>
     */
    public function toArray()
    {
        return [
            'purpose' => $this->purpose,
            'sizes' => $this->sizes,
            'src' => $this->src,
            'type' => $this->type,
        ];
    }
}
