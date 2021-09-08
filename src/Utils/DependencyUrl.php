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
     * @param  string  $uri
     */
    public function __construct(string $uri)
    {
        $this->uri = $uri;
    }

    /**
     * Retrieve the Dependency URL.
     *
     * @return string
     */
    public function url(): string
    {
        return self::generateUrl($this->uri);
    }

    /**
     * Generate a URL.
     *
     * @param  string  $uri
     * @return string
     */
    protected static function generateUrl(string $uri): string
    {
        return 'https://'.$uri;
    }
}
