<?php

namespace Sfneal\Dependencies\Utils;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GithubUrl extends DependencyUrl
{
    /**
     * @var Url
     */
    private $api;

    /**
     * @var string
     */
    private $githubRepo;

    /**
     * GithubUrl Constructor.
     *
     * @param  string  $githubRepo  GitHub repo name
     */
    public function __construct(string $githubRepo)
    {
        $this->githubRepo = $githubRepo;
        $this->api = Url::from("api.github.com/repos/{$this->githubRepo}");

        parent::__construct(Url::from("github.com/{$this->githubRepo}"), null);
    }

    /**
     * Retrieve the GitHub repo's description.
     *
     * @return string
     */
    public function description(): ?string
    {
        return $this->getApiResponse()->json('description');
    }

    /**
     * Retrieve the GitHub repo's description.
     *
     * @return string
     */
    public function defaultBranch(): string
    {
        return $this->getApiResponse()->json('default_branch') ?? 'master';
    }

    /**
     * Retrieve a link to download the GitHub repo zip.
     *
     * @return string
     */
    public function download(): string
    {
        return Url::from("github.com/{$this->githubRepo}/archive/refs/heads/{$this->defaultBranch()}.zip")->get();
    }

    /**
     * Retrieve a cached HTTP response from the GitHub api.
     *
     * @return ?Response
     */
    private function getApiResponse(): ?Response
    {
        $response = Http::withHeaders([
            'Authorization' => 'token '.config('dependencies.github_pat'),
        ])
            ->get($this->api->get());

        // Client error
        if ($response->clientError() && str_contains($response->json('message'), 'API rate limit exceeded')) {
            return null;
        }

        // Cache response
        return Cache::remember(
            config('dependencies.cache.prefix').':api-responses:'.crc32($this->api->get()),
            config('dependencies.cache.ttl'),
            function () use ($response): Response {
                return $response;
            }
        );
    }
}
