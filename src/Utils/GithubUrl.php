<?php

namespace Sfneal\Dependencies\Utils;

use Illuminate\Support\Facades\Http;

class GithubUrl extends DependencyUrl
{
    /**
     * @var Url
     */
    private $api;

    /**
     * GithubUrl Constructor.
     *
     * @param Url $url
     * @param Url $api
     */
    public function __construct(Url $url, Url $api)
    {
        parent::__construct($url, null);
        $this->api = $api;
    }

    /**
     * Retrieve the GitHub repo's description.
     *
     * @return string
     */
    public function description(): string
    {
        return Http::get($this->api->get())->json('description');
    }
}
