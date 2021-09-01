<?php

namespace Sfneal\Dependencies\Tests\Feature;

use Sfneal\Dependencies\Services\DependenciesService;
use Sfneal\Dependencies\Tests\TestCase;
use Sfneal\Dependencies\Utils\DependencyUrl;

class DependencyUrlTest extends TestCase
{
    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     * @param string $type
     */
    public function github_url(string $package, string $type)
    {
        $repo = (new DependenciesService($package, $type))->githubRepo;
        $this->assertGithubUrl($repo, new DependencyUrl("github.com/{$repo}"));
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     * @param string $type
     */
    public function travis_url(string $package, string $type)
    {
        $repo = (new DependenciesService($package, $type))->githubRepo;
        $this->assertTravisUrl($repo, new DependencyUrl("app.travis-ci.com/{$repo}"));
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     * @param string $type
     */
    public function version_url(string $package, string $type)
    {
        $this->assertVersionUrl($package, new DependencyUrl("packagist.org/packages/{$package}"));
    }
}
