<?php

namespace Sfneal\Dependencies\Utils\Traits;

trait StaticConstructor
{
    /**
     * Static URL constructor.
     *
     * @param string $uri
     * @return self
     */
    public static function from(string $uri): self
    {
        return new self($uri);
    }
}
