<?php

namespace Sfneal\Dependencies\Tests\Feature;

use Sfneal\Dependencies\Services\DependenciesService;
use Sfneal\Dependencies\Tests\TestCase;

class DependenciesServiceTest extends TestCase
{
    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     * @param string $type
     */
    public function travis_svg(string $package, string $type)
    {
        $service = (new DependenciesService($package, $type));
        $this->assertTravisSvg($service->githubRepo, $service->travis());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     * @param string $type
     */
    public function version_svg(string $package, string $type)
    {
        $service = (new DependenciesService($package, $type));
        $this->assertVersionSvg($service->package, $service->version());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     * @param string $type
     */
    public function last_commit_svg(string $package, string $type)
    {
        $service = (new DependenciesService($package, $type));
        $this->assertLastCommitSvg($service->githubRepo, $service->lastCommit());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     * @param string $type
     */
    public function github_url(string $package, string $type)
    {
        $service = (new DependenciesService($package, $type));
        $this->assertGithubUrl($service->githubRepo, $service->gitHub());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     * @param string $type
     */
    public function travis_url(string $package, string $type)
    {
        $service = (new DependenciesService($package, $type));
        $this->assertTravisUrl($service->githubRepo, $service->travis());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     * @param string $type
     */
    public function version_url(string $package, string $type)
    {
        $service = (new DependenciesService($package, $type));
        $this->assertVersionUrl($service->package, $service->version());
    }
}
