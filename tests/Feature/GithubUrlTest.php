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
    public function packageProviderWithWorkflows(): array
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
            $dependency[] = ['Docker Builds', 'Test Suite'];

            return $dependency;
        })
        ->shuffle()
        ->toArray();
    }

    /**
     * @test
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
            $url = $generator->url();

            $this->assertInstanceOf(DependencyUrl::class, $generator);
            $this->assertStringContainsString($package, $url);
            $this->assertStringContainsString('img.shields.io/github/workflow/status', $url);

            $response = $this->sendRequest($url);

            $this->assertStringContainsString($workflow, $response->body());

            $stringHelper = new StringHelpers($response->body());

            $this->assertTrue(
                $stringHelper->inString('passing')
                || $stringHelper->inString('failing')
                || $stringHelper->inString('not found'),
                '"passing", "failing" or "not found" were not found in the badge (url: '.$url.')'
            );
        }
    }

    /**
     * @test
     * @dataProvider packageProviderWithWorkflows
     */
    public function github_release(string $package, string $type)
    {
        $github = new GithubUrl($package);
        $url = $github->release()->url();

        $this->assertInstanceOf(DependencyUrl::class, $github);
        $this->assertStringContainsString($package, $url);
        $this->assertStringContainsString('img.shields.io/github/v/release', $url);

        $response = $this->sendRequest($url);

        $this->assertStringContainsString('release', $response->body());
    }
}
