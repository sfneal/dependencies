<?php

namespace Sfneal\Dependencies\Tests\Feature;

use Sfneal\Dependencies\Services\DependencyService;
use Sfneal\Dependencies\Tests\TestCase;

class DependencyServiceTest extends TestCase
{
    /**
     * @test
     * @dataProvider packageProvider
     * @param  string  $package
     * @param  string  $type
     */
    public function travis_svg(string $package, string $type)
    {
        $service = (new DependencyService($package, $type));
        $this->assertTravisSvg($service->githubRepo, $service->travis(), false);
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param  string  $package
     * @param  string  $type
     */
    public function version_svg(string $package, string $type)
    {
        $service = (new DependencyService($package, $type));
        $this->assertVersionSvg($service->project, $service->version(), false);
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param  string  $package
     * @param  string  $type
     */
    public function last_commit_svg(string $package, string $type)
    {
        $service = (new DependencyService($package, $type));
        $this->assertLastCommitSvg($service->githubRepo, $service->lastCommit(), false);
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param  string  $package
     * @param  string  $type
     */
    public function open_issues_svg(string $package, string $type)
    {
        $service = (new DependencyService($package, $type));
        $this->assertOpenIssuesSvg($service->githubRepo, $service->openIssues(), false);
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param  string  $package
     * @param  string  $type
     */
    public function closed_issues_svg(string $package, string $type)
    {
        $service = (new DependencyService($package, $type));
        $this->assertClosedIssuesSvg($service->githubRepo, $service->closedIssues(), false);
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param  string  $package
     * @param  string  $type
     */
    public function github_url(string $package, string $type)
    {
        $service = (new DependencyService($package, $type));
        $this->assertGithubUrl($service->githubRepo, $service->gitHub(), false);
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param  string  $package
     * @param  string  $type
     */
    public function travis_url(string $package, string $type)
    {
        $service = (new DependencyService($package, $type));
        $this->assertTravisUrl($service->githubRepo, $service->travis(), false);
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param  string  $package
     * @param  string  $type
     */
    public function version_url(string $package, string $type)
    {
        $service = (new DependencyService($package, $type));
        $this->assertVersionUrl($service->project, $service->version(), false);
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param  string  $package
     * @param  string  $type
     */
    public function open_issues_url(string $package, string $type)
    {
        $service = (new DependencyService($package, $type));
        $this->assertOpenIssuesUrl($service->githubRepo, $service->openIssues(), false);
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param  string  $package
     * @param  string  $type
     */
    public function closed_issues_url(string $package, string $type)
    {
        $service = (new DependencyService($package, $type));
        $this->assertClosedIssuesUrl($service->githubRepo, $service->closedIssues(), false);
    }
}
