<?php


namespace Sfneal\Dependencies\Tests\Feature;


use Sfneal\Dependencies\Tests\TestCase;
use Sfneal\Dependencies\Tests\Traits\UrlAssertions;
use Sfneal\Dependencies\Utils\DependencyUrl;

class DependencyUrlTest extends TestCase
{
    use UrlAssertions;

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     */
    public function github_url(string $package)
    {
        $this->assertGithubUrl($package, new DependencyUrl("github.com/{$package}"));
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     */
    public function travis_url(string $package)
    {
        $this->assertTravisUrl($package, new DependencyUrl("travis-ci.com/{$package}"));
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     */
    public function version_url(string $package)
    {
        $this->assertVersionUrl($package, new DependencyUrl("packagist.org/packages/{$package}"));
    }
}
