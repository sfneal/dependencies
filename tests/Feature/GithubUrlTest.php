<?php

namespace Sfneal\Dependencies\Tests\Feature;

use Sfneal\Dependencies\Tests\TestCase;
use Sfneal\Dependencies\Utils\DependencyUrl;
use Sfneal\Dependencies\Utils\GithubUrl;
use Sfneal\Helpers\Strings\StringHelpers;

class GithubUrlTest extends TestCase
{
    /**
     * Retrieve an array of packages.
     *
     * @return array
     */
    public static function packageProviderWithWorkflows(): array
    {
        return collect([
            ['sfneal/dependencies', 'composer'],
            ['sfneal/socials', 'composer'],
            ['sfneal/users', 'composer'],
            ['sfneal/models', 'composer'],
            ['sfneal/laravel-helpers', 'composer'],
            ['sfneal/datum', 'composer'],
            ['sfneal/tracking', 'composer'],
        ])
        ->map(function (array $dependency) {
            $dependency[] = ['docker.yml', 'tests.yml'];

            return $dependency;
        })
        ->shuffle()
        ->take(2)
        ->toArray();
    }

    /**
     * @test
     *
     * @dataProvider packageProviderWithWorkflows
     *
     * @param  string  $package
     * @param  string  $type
     */
    public function github_url_public_methods(string $package, string $type)
    {
        $github = new GithubUrl($package);

        $this->assertGithub($package, $github, true);
    }

    /**
     * @test
     *
     * @dataProvider packageProviderWithWorkflows
     *
     * @param  string  $package
     * @param  string  $type
     * @param  array  $workflows
     */
    public function github_url_workflow_badges(string $package, string $type, array $workflows)
    {
        $github = new GithubUrl($package);

        foreach ($workflows as $workflow) {
            $generator = $github->workflow($workflow);
            $svg = $generator->svg();

            $this->assertInstanceOf(DependencyUrl::class, $generator);
            $this->assertStringContainsString($package, $svg);
            $this->assertStringContainsString("github.com/{$package}/actions", $generator->url());
            $this->assertStringContainsString('img.shields.io/github/actions/workflow/status', $svg);

            $response = $this->sendRequest($svg);

            $this->assertStringContainsString($workflow, $response->body());

            $stringHelper = new StringHelpers($response->body());

            $this->assertTrue(
                $stringHelper->inString('passing')
                || $stringHelper->inString('failing')
                || $stringHelper->inString('no status'),
                '"passing", "failing" or "no status" were not found in the badge (url: '.$svg.')'
            );
        }
    }

    /**
     * @test
     *
     * @dataProvider packageProviderWithWorkflows
     */
    public function github_release(string $package, string $type)
    {
        $github = new GithubUrl($package);
        $svg = $github->release()->svg();

        $this->assertInstanceOf(DependencyUrl::class, $github);
        $this->assertStringContainsString($package, $svg);
        $this->assertStringContainsString("github.com/{$package}/releases", $github->release()->url());
        $this->assertStringContainsString('img.shields.io/github/v/release', $svg);

        $response = $this->sendRequest($svg);

        $this->assertStringContainsString('release', $response->body());
    }
}
