<?php

namespace Covaleski\LaravelPwa\Support;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;

class Manifest implements Arrayable, Jsonable
{
    /**
     * Initial background color.
     */
    protected string $backgroundColor;

    /**
     * Display mode.
     */
    protected string $display;

    /**
     * Icon image files.
     */
    protected Collection $icons;

    /**
     * Application full name.
     */
    protected string $name;

    /**
     * Application short name.
     */
    protected string $shortName;

    /**
     * URL to open on launch.
     */
    protected string $startUrl;

    /**
     * User interface default color.
     */
    protected string $themeColor;

    /**
     * Set the initial background color.
     *
     * This color appears before the stylesheets have loaded.
     */
    public function backgroundColor(string $background_color): static
    {
        $this->backgroundColor = $background_color;
        return $this;
    }

    /**
     * Set the display mode.
     *
     * Determines how much of the browser UI is shown to the user.
     */
    public function display(string $display): static
    {
        $this->display = $display;
        return $this;
    }

    /**
     * Add an icon image file.
     */
    public function icon(
        string $src,
        string $sizes,
        string $type,
        string $purpose = 'any',
    ): static {
        $this->icons ??= collect();
        $this->icons->push(new Icon($src, $sizes, $type, $purpose));
        return $this;
    }

    /**
     * Set the application full name.
     *
     * It is usually displayed in the following contexts:
     *
     * - In a list of other installed web apps;
     * - As a label for the app's icon;
     * - In the application switcher or task manager.
     */
    public function name(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Set the application short name.
     *
     * May be used in place of the app's full name space-constrained contexts.
     */
    public function shortName(string $short_name): static
    {
        $this->shortName = $short_name;
        return $this;
    }

    /**
     * Set the url to open on launch.
     */
    public function startUrl(string $start_url): static
    {
        $this->startUrl = $start_url;
        return $this;
    }

    /**
     * Set the user interface default color.
     *
     * May be applied to various browser UI elements.
     */
    public function themeColor(string $theme_color): static
    {
        $this->themeColor = $theme_color;
        return $this;
    }


    /**
     * Get the instance as an array.
     *
     * @return array<string, mixed>
     */
    public function toArray()
    {
        return array_filter([
            'background_color' => $this->backgroundColor ?? null,
            'display' => $this->display ?? null,
            'icons' => $this->icons?->toArray(),
            'name' => $this->name ?? null,
            'short_name' => $this->shortName ?? null,
            'start_url' => $this->startUrl ?? null,
            'theme_color' => $this->themeColor ?? null,
        ], fn ($value) => $value !== null);
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }
}
