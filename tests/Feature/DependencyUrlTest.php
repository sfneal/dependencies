<?php

namespace Sfneal\Dependencies\Tests\Feature;

use Sfneal\Dependencies\Services\DependencyService;
use Sfneal\Dependencies\Tests\TestCase;

class DependencyUrlTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider packageProvider
     *
     * @param  string  $package
     * @param  string  $type
     */
    public function github(string $package, string $type)
    {
        $service = new DependencyService($package, $type);
        $this->assertGithub($service->githubRepo, $service->gitHub());
    }

    /**
     * @test
     *
     * @dataProvider packageProvider
     *
     * @param  string  $package
     * @param  string  $type
     */
    public function travis(string $package, string $type)
    {
        $service = new DependencyService($package, $type);
        $this->assertTravisUrl($service->githubRepo, $service->travis());
        $this->assertTravisSvg($service->githubRepo, $service->travis());
    }

    /**
     * @test
     *
     * @dataProvider packageProvider
     *
     * @param  string  $package
     * @param  string  $type
     */
    public function version(string $package, string $type)
    {
        $service = new DependencyService($package, $type);
        $this->assertVersionUrl($service->project, $service->version());
        $this->assertVersionSvg($service->project, $service->version());
    }

    /**
     * @test
     *
     * @dataProvider packageProvider
     *
     * @param  string  $package
     * @param  string  $type
     */
    public function last_commit(string $package, string $type)
    {
        $service = new DependencyService($package, $type);
        $this->assertLastCommitSvg($service->githubRepo, $service->lastCommit());
    }

    /**
     * @test
     *
     * @dataProvider packageProvider
     *
     * @param  string  $package
     * @param  string  $type
     */
    public function open_issues(string $package, string $type)
    {
        $service = new DependencyService($package, $type);
        $this->assertOpenIssuesUrl($service->githubRepo, $service->openIssues());
        $this->assertOpenIssuesSvg($service->githubRepo, $service->openIssues());
    }

    /**
     * @test
     *
     * @dataProvider packageProvider
     *
     * @param  string  $package
     * @param  string  $type
     */
    public function closed_issues(string $package, string $type)
    {
        $service = new DependencyService($package, $type);
        $this->assertClosedIssuesUrl($service->githubRepo, $service->closedIssues());
        $this->assertClosedIssuesSvg($service->githubRepo, $service->closedIssues());
    }

    /**
     * @test
     *
     * @dataProvider packageProvider
     *
     * @param  string  $package
     * @param  string  $type
     */
    public function open_pull_requests(string $package, string $type)
    {
        $service = new DependencyService($package, $type);
        $this->assertOpenPullRequestsUrl($service->githubRepo, $service->openPullRequests());
        $this->assertOpenPullRequestsSvg($service->githubRepo, $service->openPullRequests());
    }

    /**
     * @test
     *
     * @dataProvider packageProvider
     *
     * @param  string  $package
     * @param  string  $type
     */
    public function closed_pull_requests(string $package, string $type)
    {
        $service = new DependencyService($package, $type);
        $this->assertClosedPullRequestsUrl($service->githubRepo, $service->closedPullRequests());
        $this->assertClosedPullRequestsSvg($service->githubRepo, $service->closedPullRequests());
    }
}
