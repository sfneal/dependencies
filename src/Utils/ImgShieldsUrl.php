<?php

namespace Sfneal\Dependencies\Utils;

class ImgShieldsUrl extends Url
{
    /**
     * Url constructor.
     *
     * @param string $uri
     * @param array|null $params
     */
    public function __construct(string $uri, array $params = null)
    {
        parent::__construct('img.shields.io/'.$uri, $params);
    }
}
