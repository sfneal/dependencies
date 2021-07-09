<?php


namespace Sfneal\Dependencies\Utils;


class DependencySvg extends DependencyUrl
{
    /**
     * @var string
     */
    private $svg;

    /**
     * DependencySvg constructor.
     * @param string $uri
     * @param string $svg
     */
    public function __construct(string $uri, string $svg)
    {
        parent::__construct($uri);
        $this->svg = $svg;
    }

    /**
     * Retrieve a dependency SVG image.
     *
     * @return string
     */
    public function svg(): string
    {
        return $this->url('img.shields.io'.$this->svg);
    }
}
