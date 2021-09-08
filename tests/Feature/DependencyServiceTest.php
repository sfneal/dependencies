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
    public function package_property_is_correct(string $package, string $type)
    {
        $service = new DependencyService($package, $type);

        $this->assertNotNull($service->package);
        $this->assertIsString($service->package);
        $this->assertEquals($package, $service->package);
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param  string  $package
     * @param  string  $type
     */
    public function type_property_is_correct(string $package, string $type)
    {
        $service = new DependencyService($package, $type);

        $this->assertNotNull($service->type);
        $this->assertIsString($service->type);
        $this->assertEquals($type, $service->type);
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param  string  $package
     * @param  string  $type
     */
    public function githubRepo_property_is_correct(string $package, string $type)
    {
        $service = new DependencyService($package, $type);

        $this->assertNotNull($service->githubRepo);
        $this->assertIsString($service->githubRepo);

        if ($service->type == 'docker') {
            $this->assertStringContainsString(config('dependencies.github_alias')['stephenneal'], $service->githubRepo);
            $this->assertEquals(
                str_replace('stephenneal', config('dependencies.github_alias')['stephenneal'], $service->package),
                $service->githubRepo
            );
        }
        else {
            $this->assertStringNotContainsString('stephenneal', $service->githubRepo);

            $this->assertEquals($package, $service->githubRepo);
        }
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param  string  $package
     * @param  string  $type
     */
    public function project_property_is_correct(string $package, string $type)
    {
        $service = new DependencyService($package, $type);

        $this->assertNotNull($service->project);
        $this->assertIsString($service->project);

        if ($service->type == 'python') {
            $this->assertEquals(
                explode('/', $service->package)[1],
                $service->project
            );
        }

        else {
            $this->assertEquals($package, $service->project);
            $this->assertEquals($service->package, $service->project);
        }
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param  string  $package
     * @param  string  $type
     */
    public function travis_svg(string $package, string $type)
    {
        $service = new DependencyService($package, $type);
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
        $service = new DependencyService($package, $type);
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
        $service = new DependencyService($package, $type);
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
        $service = new DependencyService($package, $type);
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
        $service = new DependencyService($package, $type);
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
        $service = new DependencyService($package, $type);
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
        $service = new DependencyService($package, $type);
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
        $service = new DependencyService($package, $type);
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
        $service = new DependencyService($package, $type);
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
        $service = new DependencyService($package, $type);
        $this->assertClosedIssuesUrl($service->githubRepo, $service->closedIssues(), false);
    }
}
