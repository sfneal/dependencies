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
     * @param string $type
     */
    public function travis_svg(string $package, string $type)
    {
        $this->assertTravisSvg($package, (new DependenciesService($package, $type))->travis());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     * @param string $type
     */
    public function version_svg(string $package, string $type)
    {
        $this->assertVersionSvg($package, (new DependenciesService($package, $type))->version());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     * @param string $type
     */
    public function last_commit_svg(string $package, string $type)
    {
        $this->assertLastCommitSvg($package, (new DependenciesService($package, $type))->lastCommit());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     * @param string $type
     */
    public function github_url(string $package, string $type)
    {
        $this->assertGithubUrl($package, (new DependenciesService($package, $type))->gitHub());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     * @param string $type
     */
    public function travis_url(string $package, string $type)
    {
        $this->assertTravisUrl($package, (new DependenciesService($package, $type))->travis());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     * @param string $type
     */
    public function version_url(string $package, string $type)
    {
        $this->assertVersionUrl($package, (new DependenciesService($package, $type))->version());
    }
}
