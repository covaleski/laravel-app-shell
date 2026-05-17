<?php

namespace Tests\Unit\Routing;

use Covaleski\LaravelPwa\Support\Manifest;
use PHPUnit\Framework\TestCase;

class ManifestTest extends TestCase
{
    /**
     * Ensure the options object is able to clone itself.
     */
    public function test_turns_into_json(): void
    {
        $this->assertSame(
            <<<JSON
                {
                    "background_color": "white",
                    "display": "standalone",
                    "icons": [
                        {
                            "purpose": "any",
                            "sizes": "32x32",
                            "src": "\/path\/to\/icon\/a",
                            "type": "image\/png"
                        },
                        {
                            "purpose": "any",
                            "sizes": "64x64",
                            "src": "\/path\/to\/icon\/b",
                            "type": "image\/png"
                        }
                    ],
                    "name": "My Application",
                    "short_name": "My App",
                    "start_url": ".",
                    "theme_color": "red"
                }
                JSON,
            (new Manifest())
                ->name('My Application')
                ->shortName('My App')
                ->icon('/path/to/icon/a', '32x32', 'image/png')
                ->icon('/path/to/icon/b', '64x64', 'image/png')
                ->startUrl('.')
                ->display('standalone')
                ->backgroundColor('white')
                ->themeColor('red')
                ->toJson(JSON_PRETTY_PRINT),
        );
    }
}
