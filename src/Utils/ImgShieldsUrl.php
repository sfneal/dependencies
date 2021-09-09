<?php

namespace Sfneal\Dependencies\Utils;

class ImgShieldsUrl extends Url
{
    /**
     * Url constructor.
     *
     * @param  string  $uri
     * @param  array|null  $params
     */
    public function __construct(string $uri, array $params = null)
    {
        parent::__construct('img.shields.io/'.$uri, $params);
    }

    /**
     * Merge global Img Shields params with the original params.
     *
     * @param array|null $globalParams
     * @return $this
     */
    public function withGlobalParams(array $globalParams = null): self
    {
        if (! is_null($globalParams)) {
            $this->params = array_merge($this->params, $globalParams);
        }

        return $this;
    }
}
