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
     * @param  Url  $url
     * @param  Url  $api
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
    public function description(): ?string
    {
        $response = Http::withHeaders([
            'Authorization' => 'token '.config('dependencies.github_pat'),
        ])
        ->get($this->api->get());

        print_r($response->json());

        if ($response->clientError() && str_contains($response->json('message'), 'API rate limit exceeded')) {
            return null;
        }

        return $response->json('description');
    }
}
