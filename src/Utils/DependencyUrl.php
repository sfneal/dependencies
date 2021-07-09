<?php


namespace Sfneal\Dependencies\Utils;


class DependencyUrl
{
    /**
     * @var string
     */
    private $uri;

    /**
     * DependencyUrl constructor.
     *
     * @param string $uri
     */
    public function __construct(string $uri)
    {
        $this->uri = $uri;
    }

    /**
     * Retrieve the Dependency URL.
     *
     * @param string|null $uri
     * @return string
     */
    public function url(string $uri = null): string
    {
        return 'https://'.$uri ?? $this->uri;
    }
}
