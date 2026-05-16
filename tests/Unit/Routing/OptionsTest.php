<?php

namespace Tests\Unit\View;

use Covaleski\LaravelPwa\Routing\Options;
use PHPUnit\Framework\TestCase;

class OptionsTest extends TestCase
{
    /**
     * Ensure the options object is able to clone itself.
     */
    public function test_clones_options(): void
    {
        $options = new Options();
        $this->assertNotSame($options, $options->clone());
    }

    /**
     * Ensure the options object merges other options objects.
     */
    public function test_merges_options(): void
    {
        $options_a = new Options(['m1', 'm2'], ['p1' => 'v1', 'p2' => 'v2']);
        $options_b = new Options(['m1', 'm3'], ['p1' => 'v3', 'p3' => 'v4']);
        $options_c = $options_a->merge($options_b);
        $this->assertNotSame($options_c, $options_a);
        $this->assertNotSame($options_c, $options_b);
        $this->assertSame(['m1', 'm2', 'm3'], $options_c->middleware);
        $this->assertSame(
            ['p1' => 'v3', 'p2' => 'v2', 'p3' => 'v4'],
            $options_c->where,
        );
    }
}
