<?php


namespace Sfneal\Dependencies\Utils;


class DependencySvg extends DependencyUrl
{
    /**
     * @var string
     */
    private $svg;

    /**
     * @var string
     */
    private $baseUrl;

    /**
     * DependencySvg constructor.
     * @param string $uri
     * @param string $svg
     * @param string $baseUrl
     */
    public function __construct(string $uri, string $svg, string $baseUrl = 'img.shields.io/')
    {
        parent::__construct($uri);
        $this->svg = $svg;
        $this->baseUrl = $baseUrl;
    }

    /**
     * Retrieve a dependency SVG image.
     *
     * @return string
     */
    public function svg(): string
    {
        return self::generateUrl($this->baseUrl.$this->svg);
    }
}
