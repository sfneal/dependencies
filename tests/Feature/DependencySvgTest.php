<?php

namespace Sfneal\Dependencies\Tests\Feature;

use Sfneal\Dependencies\Services\DependencyService;
use Sfneal\Dependencies\Tests\TestCase;

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
        $service = new DependencyService($package, $type);
        $this->assertTravisSvg($service->githubRepo, $service->travis());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param  string  $package
     * @param  string  $type
     */
    public function version_svg(string $package, string $type)
    {
        $service = new DependencyService($package, $type);
        $this->assertVersionSvg($service->project, $service->version());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param  string  $package
     * @param  string  $type
     */
    public function last_commit_svg(string $package, string $type)
    {
        $service = new DependencyService($package, $type);
        $this->assertLastCommitSvg($service->githubRepo, $service->lastCommit());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param  string  $package
     * @param  string  $type
     */
    public function open_issues_svg(string $package, string $type)
    {
        $service = new DependencyService($package, $type);
        $this->assertOpenIssuesSvg($service->githubRepo, $service->openIssues());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param  string  $package
     * @param  string  $type
     */
    public function closed_issues_svg(string $package, string $type)
    {
        $service = new DependencyService($package, $type);
        $this->assertClosedIssuesSvg($service->githubRepo, $service->closedIssues());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param  string  $package
     * @param  string  $type
     */
    public function open_pull_requests_svg(string $package, string $type)
    {
        $service = new DependencyService($package, $type);
        $this->assertOpenPullRequestsSvg($service->githubRepo, $service->openPullRequests());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param  string  $package
     * @param  string  $type
     */
    public function closed_pull_requests_svg(string $package, string $type)
    {
        $service = new DependencyService($package, $type);
        $this->assertClosedPullRequestsSvg($service->githubRepo, $service->closedPullRequests());
    }
}
