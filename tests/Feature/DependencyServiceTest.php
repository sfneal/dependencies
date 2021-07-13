<?php

namespace Sfneal\Dependencies\Tests\Feature;

use Sfneal\Dependencies\Services\DependenciesService;
use Sfneal\Dependencies\Tests\TestCase;

class DependencyServiceTest extends TestCase
{
    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     */
    public function travis_svg(string $package)
    {
        $this->assertTravisSvg($package, (new DependenciesService($package))->travis());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     */
    public function version_svg(string $package)
    {
        $this->assertVersionSvg($package, (new DependenciesService($package))->version());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     */
    public function last_commit_svg(string $package)
    {
        $this->assertLastCommitSvg($package, (new DependenciesService($package))->lastCommit());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     */
    public function github_url(string $package)
    {
        $this->assertGithubUrl($package, (new DependenciesService($package))->gitHub());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     */
    public function travis_url(string $package)
    {
        $this->assertTravisUrl($package, (new DependenciesService($package))->travis());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     */
    public function version_url(string $package)
    {
        $this->assertVersionUrl($package, (new DependenciesService($package))->version());
    }
}
