<?php

namespace Sfneal\Dependencies\Utils;

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
     * @var array|null Array of global Img Shields params to be passed to SVG requests
     */
    private $imgShieldGlobals;

    /**
     * GithubUrl Constructor.
     *
     * @param  string  $githubRepo  GitHub repo name
     */
    public function __construct(string $githubRepo, array $imgShieldGlobals = null)
    {
        $this->githubRepo = $githubRepo;
        $this->imgShieldGlobals = $imgShieldGlobals;

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
        return $this->getApiResponse()['description'];
    }

    /**
     * Retrieve the GitHub repo's description.
     *
     * @return string
     */
    public function defaultBranch(): string
    {
        return $this->getApiResponse()['default_branch'] ?? 'master';
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
     * Retrieve a link to the GitHub repo's workflow status page.
     *
     * @return string
     */
    public function actions(): string
    {
        return Url::from("github.com/{$this->githubRepo}/actions")->get();
    }

    /**
     * Display pass/fail status for a GitHub repo's workflow.
     *
     * @param  string  $name
     * @return DependencyUrl
     */
    public function workflow(string $name): DependencyUrl
    {
        return new DependencyUrl(
            Url::from("github.com/{$this->githubRepo}/actions"),
            ImgShieldsUrl::from("github/workflow/status/{$this->githubRepo}/{$name}")
                ->withGlobalParams($this->imgShieldGlobals)
                ->withParams([
                    'logo' => 'github',
                    'label' => $name,
                ])
        );
    }

    /**
     * Display the latest GitHub release (by date) for a GitHub repo.
     *
     * @return DependencyUrl
     */
    public function release(): DependencyUrl
    {
        return new DependencyUrl(
            Url::from("github.com/{$this->githubRepo}/releases"),
            ImgShieldsUrl::from("github/v/release/{$this->githubRepo}")
                ->withGlobalParams($this->imgShieldGlobals)
                ->withParams([
                    'display_name' => 'tag',
                    'sort' => 'semver',
                    'include_prereleases',
                ])
        );
    }

    /**
     * Retrieve a cached HTTP response from the GitHub api.
     *
     * @return ?array
     */
    private function getApiResponse(): ?array
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
            function () use ($response): array {
                return $response->json();
            }
        );
    }
}
