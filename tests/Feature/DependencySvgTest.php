<?php

namespace Sfneal\Dependencies\Tests\Feature;

use Sfneal\Dependencies\Services\DependenciesService;
use Sfneal\Dependencies\Tests\TestCase;
use Sfneal\Dependencies\Utils\DependencySvg;

class DependencySvgTest extends TestCase
{
    /**
     * @test
     * @dataProvider packageProvider
     * @param  string  $package
     * @param  string  $type
     */
    public function travis_svg(string $package, string $type)
    {
        $repo = (new DependenciesService($package, $type))->githubRepo;
        $this->assertTravisSvg($repo, new DependencySvg(
            "app.travis-ci.com/{$repo}",
            "app.travis-ci.com/{$repo}.svg?branch=master",
            ''
        ));
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param  string  $package
     * @param  string  $type
     */
    public function version_svg(string $package, string $type)
    {
        $service = (new DependenciesService($package, $type));
        $repo = $service->githubRepo;
        $project = $service->project;

        if ($type == 'composer') {
            $svg = new DependencySvg(
                "packagist.org/packages/{$repo}",
                "packagist/v/{$repo}.svg",
            );

            $this->assertVersionSvg($repo, $svg);
        } elseif ($type == 'docker') {
            $svg = new DependencySvg(
                "hub.docker.com/r/{$repo}",
                "docker/v/{$repo}.svg?sort=semver"
            );

            $this->assertVersionSvg($repo, $svg);
        } elseif ($type == 'python') {
            $svg = new DependencySvg(
                "pypi.org/project/{$project}",
                "pypi/v/{$project}.svg"
            );
            $this->assertVersionSvg($project, $svg);
        }
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param  string  $package
     * @param  string  $type
     */
    public function last_commit_svg(string $package, string $type)
    {
        $repo = (new DependenciesService($package, $type))->githubRepo;
        $this->assertLastCommitSvg($repo, new DependencySvg(
            "github.com/{$repo}",
            "github/last-commit/{$repo}"
        ));
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param  string  $package
     * @param  string  $type
     */
    public function open_issues_svg(string $package, string $type)
    {
        $repo = (new DependenciesService($package, $type))->githubRepo;
        $this->assertOpenIssuesSvg($repo, new DependencySvg(
            "github.com/{$repo}/issues",
            "github/issues-raw/{$repo}"
        ));
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param  string  $package
     * @param  string  $type
     */
    public function closed_issues_svg(string $package, string $type)
    {
        $repo = (new DependenciesService($package, $type))->githubRepo;
        $this->assertClosedIssuesSvg($repo, new DependencySvg(
            "github.com/{$repo}/issues",
            "github/issues-closed-raw/{$repo}?color=red"
        ));
    }
}
