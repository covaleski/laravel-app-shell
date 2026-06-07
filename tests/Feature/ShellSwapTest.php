<?php

namespace Tests\Feature;

use Illuminate\Support\Uri;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ShellSwapTest extends TestCase
{
    public function test_rejects_non_html_requests(): void
    {
        $this->getJson('/')->assertNotAcceptable();
    }

    public function test_does_not_swap_the_shell_when_not_needed(): void
    {
        $this->getHtmx('/', 'shells.default')
            ->assertOk()
            ->assertHeaderContains('Content-Type', 'text/html')
            ->assertHeader('HX-Retarget', '#page')
            ->assertHeader('HX-Reswap', 'innerHTML')
            ->assertDontSeeHtml('<!DOCTYPE html>')
            ->assertDontSeeHtml('id="shell"')
            ->assertDontSeeHtml('id="page"');
    }

    public function test_serves_entrypoint_when_not_htmx(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertHeaderContains('Content-Type', 'text/html')
            ->assertHeaderMissing('HX-Retarget')
            ->assertHeaderMissing('HX-Reswap')
            ->assertSeeHtml('<!DOCTYPE html>')
            ->assertSeeHtml('id="shell"')
            ->assertDontSeeHtml('id="page"');
    }

    public function test_swaps_the_shell_when_needed(): void
    {
        $this->getHtmx('/', 'shells.other')
            ->assertOk()
            ->assertHeaderContains('Content-Type', 'text/html')
            ->assertHeader('HX-Retarget', '#shell')
            ->assertHeader('HX-Reswap', 'outerHTML')
            ->assertDontSeeHtml('<!DOCTYPE html>')
            ->assertSeeHtml('id="shell"')
            ->assertSeeHtml('id="page"');
    }

    /**
     * Visit the given URI with a GET request, expecting an HTMX response.
     *
     * @param string|Uri $uri
     * @param null|string $shell
     * @param array $headers
     */
    protected function getHtmx($uri, $shell = null, $headers = []): TestResponse
    {
        $headers['HX-Request'] ??= 'true';
        if ($shell) $headers['HX-Current-Shell'] ??= $shell;
        return $this->get($uri, $headers);
    }
}
