<?php

namespace Sfneal\Dependencies\Utils;

class DependencyUrl
{
    /**
     * @var Url
     */
    private $url;

    /**
     * @var Url|null
     */
    private $svg;

    /**
     * DependencySvg constructor.
     * @param Url $url
     * @param Url|null $svg
     */
    public function __construct(Url $url, Url $svg = null)
    {
        $this->url = $url;
        $this->svg = $svg;
    }

    /**
     * Retrieve a dependency SVG image.
     *
     * @return string
     */
    public function svg(): string
    {
        return $this->svg->get();
    }

    /**
     * Retrieve the Dependency URL.
     *
     * @return string
     */
    public function url(): string
    {
        return $this->url->get();
    }
}
