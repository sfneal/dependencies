<?php

namespace Sfneal\Dependencies\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Sfneal\Dependencies\Providers\DependenciesServiceProvider;
use Sfneal\Dependencies\Services\DependencyService;
use Sfneal\Dependencies\Utils\DependencySvg;
use Sfneal\Dependencies\Utils\DependencyUrl;
use Sfneal\Helpers\Strings\StringHelpers;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * @var int Number of packages to be return from the packageProvider
     */
    protected $numberOfPackages = 3;

    /**
     * Register package service providers.
     *
     * @param  Application  $app
     * @return array|string
     */
    protected function getPackageProviders($app)
    {
        return [
            DependenciesServiceProvider::class,
        ];
    }

    /**
     * Retrieve an array of packages.
     *
     * @return array
     */
    public function packageProvider(): array
    {
        $packages = [
            ['sfneal/actions', 'composer'],
            ['sfneal/controllers', 'composer'],
            ['sfneal/laravel-helpers', 'composer'],
            ['sfneal/queueables', 'composer'],
            ['sfneal/redis-helpers', 'composer'],
            ['sfneal/scopes', 'composer'],
            ['sfneal/string-helpers', 'composer'],
            ['sfneal/time-helpers', 'composer'],
            ['sfneal/tracking', 'composer'],
            ['symfony/console', 'composer'],
            ['spatie/laravel-view-models', 'composer'],
            ['webmozart/assert', 'composer'],
            ['spatie/laravel-settings', 'composer'],
            ['illuminate/database', 'composer'],
            ['laravel/framework', 'composer'],
            ['stephenneal/php-composer', 'docker'],
            ['stephenneal/php-laravel', 'docker'],
            ['stephenneal/nginx-laravel', 'docker'],
            ['stephenneal/nginx-proxy', 'docker'],
            ['stephenneal/node-yarn', 'docker'],
            ['stephenneal/python-flask', 'docker'],
            ['sfneal/pdfconduit', 'python'],
        ];
        shuffle($packages);

        return $packages;
    }

    /**
     * Retrieve the number of packages to expect.
     *
     * @return int
     */
    public function expectedPackagesCount(): int
    {
        return count($this->packageProvider());
    }

    /**
     * Define environment setup.
     *
     * @param  Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('dependencies.github_alias', ['stephenneal' => 'sfneal']);
    }

    /**
     * Execute `DependencyService` assertions.
     *
     * @param  Collection  $collection
     * @param  int  $expected
     */
    public function assertDependencyServiceCollection(Collection $collection, int $expected): void
    {
        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertSame($expected, $collection->count());

        $collection->each(function (DependencyService $service) {
            $this->assertTravisSvg($service->githubRepo, $service->travis(), false);
            $this->assertVersionSvg($service->project, $service->version(), false);
            $this->assertLastCommitSvg($service->githubRepo, $service->lastCommit(), false);
            $this->assertOpenIssuesSvg($service->githubRepo, $service->openIssues(), false);
            $this->assertClosedIssuesSvg($service->githubRepo, $service->closedIssues(), false);

            $this->assertGithubUrl($service->githubRepo, $service->gitHub(), false);
            $this->assertTravisUrl($service->githubRepo, $service->travis(), false);
            $this->assertVersionUrl($service->project, $service->version(), false);
            $this->assertOpenIssuesUrl($service->githubRepo, $service->openIssues(), false);
            $this->assertClosedIssuesUrl($service->githubRepo, $service->closedIssues(), false);
        });
    }

    /**
     * @param  string  $package
     * @param  DependencySvg  $generator
     * @param  bool  $sendRequest
     */
    public function assertTravisSvg(string $package, DependencySvg $generator, bool $sendRequest = true)
    {
        $url = $generator->svg();

        $this->assertInstanceOf(DependencyUrl::class, $generator);
        $this->assertInstanceOf(DependencySvg::class, $generator);
        $this->assertStringContainsString($package, $url);
        $this->assertStringContainsString('app.travis-ci.com', $url);
        $this->assertStringContainsString('.svg?branch=master', $url);

        if ($sendRequest) {
            $response = $this->sendRequest($url);

            $this->assertStringContainsString('build', $response->body());
        }
    }

    /**
     * @param  string  $package
     * @param  DependencySvg  $generator
     * @param  bool  $sendRequest
     */
    public function assertVersionSvg(string $package, DependencySvg $generator, bool $sendRequest = true)
    {
        $url = $generator->svg();

        $this->assertInstanceOf(DependencyUrl::class, $generator);
        $this->assertInstanceOf(DependencySvg::class, $generator);
        $this->assertStringContainsString($package, $url);
        $this->assertStringContainsString('img.shields.io/', $url);

        if ($sendRequest) {
            $response = $this->sendRequest($url);

            $inString = (new StringHelpers($response->body()));
            $this->assertTrue(
                $inString->inString('<title>packagist: v')
                || $inString->inString('version')
                || $inString->inString('<title>pypi'),
                "The response body provided by {$url} doesn't contain 'packagist' or 'version'"
            );
        }
    }

    /**
     * @param  string  $package
     * @param  DependencySvg  $generator
     * @param  bool  $sendRequest
     */
    public function assertLastCommitSvg(string $package, DependencySvg $generator, bool $sendRequest = true)
    {
        $url = $generator->svg();

        $this->assertInstanceOf(DependencyUrl::class, $generator);
        $this->assertInstanceOf(DependencySvg::class, $generator);
        $this->assertStringContainsString($package, $url);
        $this->assertStringContainsString('img.shields.io/github/last-commit', $url);

        if ($sendRequest) {
            $response = $this->sendRequest($url);

            $this->assertStringContainsString('last commit', $response->body());
        }
    }

    /**
     * @param  string  $package
     * @param  DependencyUrl  $generator
     * @param  bool  $sendRequest
     */
    public function assertGithubUrl(string $package, DependencyUrl $generator, bool $sendRequest = true)
    {
        $url = $generator->url();

        $this->assertInstanceOf(DependencyUrl::class, $generator);
        $this->assertStringContainsString($package, $url);
        $this->assertStringContainsString('github.com', $url);

        if ($sendRequest) {
            $response = $this->sendRequest($url);
        }
    }

    /**
     * @param  string  $package
     * @param  DependencyUrl  $generator
     * @param  bool  $sendRequest
     */
    public function assertTravisUrl(string $package, DependencyUrl $generator, bool $sendRequest = true)
    {
        $url = $generator->url();

        $this->assertInstanceOf(DependencyUrl::class, $generator);
        $this->assertStringContainsString($package, $url);
        $this->assertStringContainsString('app.travis-ci.com', $url);

        if ($sendRequest) {
            $response = $this->sendRequest($url);
        }
    }

    /**
     * @param  string  $package
     * @param  DependencyUrl  $generator
     * @param  bool  $sendRequest
     */
    public function assertVersionUrl(string $package, DependencyUrl $generator, bool $sendRequest = true)
    {
        $url = $generator->url();
        $inString = new StringHelpers($url);

        $this->assertInstanceOf(DependencyUrl::class, $generator);
        $this->assertStringContainsString($package, $url);
        $this->assertTrue(
            $inString->inString('packagist.org/packages')
            || $inString->inString('hub.docker.com/r/')
            || $inString->inString('pypi.org/project/'),
            "The response body provided by {$url} doesn't contain 'packagist.org' or 'hub.docker.com'"
        );

        if ($sendRequest) {
            $response = $this->sendRequest($url);
        }
    }

    /**
     * @param  string  $package
     * @param  DependencySvg  $generator
     * @param  bool  $sendRequest
     */
    public function assertOpenIssuesSvg(string $package, DependencySvg $generator, bool $sendRequest = true)
    {
        $url = $generator->svg();

        $this->assertInstanceOf(DependencyUrl::class, $generator);
        $this->assertInstanceOf(DependencySvg::class, $generator);
        $this->assertStringContainsString($package, $url);
        $this->assertStringContainsString('github/issues-raw', $url);

        if ($sendRequest) {
            $response = $this->sendRequest($url);

            $this->assertStringContainsString('open issues', $response->body());
        }
    }

    /**
     * @param  string  $package
     * @param  DependencySvg  $generator
     * @param  bool  $sendRequest
     */
    public function assertClosedIssuesSvg(string $package, DependencySvg $generator, bool $sendRequest = true)
    {
        $url = $generator->svg();

        $this->assertInstanceOf(DependencyUrl::class, $generator);
        $this->assertInstanceOf(DependencySvg::class, $generator);
        $this->assertStringContainsString($package, $url);
        $this->assertStringContainsString('github/issues-closed-raw', $url);
        $this->assertStringContainsString('color=red', $url);

        if ($sendRequest) {
            $response = $this->sendRequest($url);

            $this->assertStringContainsString('closed issues', $response->body());
        }
    }

    /**
     * @param  string  $package
     * @param  DependencySvg  $generator
     * @param  bool  $sendRequest
     */
    public function assertOpenIssuesUrl(string $package, DependencyUrl $generator, bool $sendRequest = true)
    {
        $url = $generator->url();

        $this->assertInstanceOf(DependencyUrl::class, $generator);
        $this->assertStringContainsString($package, $url);
        $this->assertStringContainsString('github.com', $url);
        $this->assertStringContainsString('/issues', $url);

        if ($sendRequest) {
            $response = $this->sendRequest($url);
        }
    }

    /**
     * @param  string  $package
     * @param  DependencySvg  $generator
     * @param  bool  $sendRequest
     */
    public function assertClosedIssuesUrl(string $package, DependencyUrl $generator, bool $sendRequest = true)
    {
        $url = $generator->url();

        $this->assertInstanceOf(DependencyUrl::class, $generator);
        $this->assertStringContainsString($package, $url);
        $this->assertStringContainsString('github.com', $url);
        $this->assertStringContainsString('/issues', $url);
        $this->assertStringContainsString('q=is%3Aissue+is%3Aclosed', $url);

        if ($sendRequest) {
            $response = $this->sendRequest($url);
        }
    }

    /**
     * Send an HTTP request, validate its response is "Ok" & return the response.
     *
     * @param  string  $url
     * @return Response
     */
    private function sendRequest(string $url): Response
    {
        $response = Http::retry(3, 500)->get($url);

        $this->assertTrue($response->ok(), "Error: code {$response->status()} from {$url}");

        return $response;
    }
}
