<?php

namespace Sfneal\Dependencies\Tests\Feature;

use Sfneal\Dependencies\Services\DependencyService;
use Sfneal\Dependencies\Tests\TestCase;

class DependencyUrlTest extends TestCase
{
    /**
     * @test
     * @dataProvider packageProvider
     * @param  string  $package
     * @param  string  $type
     */
    public function github_url(string $package, string $type)
    {
        $service = new DependencyService($package, $type);
        $this->assertGithubUrl($service->githubRepo, $service->gitHub());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param  string  $package
     * @param  string  $type
     */
    public function travis_url(string $package, string $type)
    {
        $service = new DependencyService($package, $type);
        $this->assertTravisUrl($service->githubRepo, $service->travis());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param  string  $package
     * @param  string  $type
     */
    public function version_url(string $package, string $type)
    {
        $service = new DependencyService($package, $type);
        $this->assertVersionUrl($service->project, $service->version());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param  string  $package
     * @param  string  $type
     */
    public function open_issues_url(string $package, string $type)
    {
        $service = new DependencyService($package, $type);
        $this->assertOpenIssuesUrl($service->githubRepo, $service->openIssues());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param  string  $package
     * @param  string  $type
     */
    public function closed_issues_url(string $package, string $type)
    {
        $service = new DependencyService($package, $type);
        $this->assertClosedIssuesUrl($service->githubRepo, $service->closedIssues());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param  string  $package
     * @param  string  $type
     */
    public function open_pull_requests_url(string $package, string $type)
    {
        $service = new DependencyService($package, $type);
        $this->assertOpenPullRequestsUrl($service->githubRepo, $service->openPullRequests());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param  string  $package
     * @param  string  $type
     */
    public function closed_pull_requests_url(string $package, string $type)
    {
        $service = new DependencyService($package, $type);
        $this->assertClosedPullRequestsUrl($service->githubRepo, $service->closedPullRequests());
    }
}
