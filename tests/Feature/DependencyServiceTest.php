<?php

namespace Sfneal\Dependencies\Tests\Feature;

use Illuminate\Support\Facades\Http;
use Sfneal\Dependencies\Services\DependenciesService;
use Sfneal\Dependencies\Tests\TestCase;
use Sfneal\Dependencies\Utils\DependencySvg;
use Sfneal\Dependencies\Utils\DependencyUrl;

class DependencyServiceTest extends TestCase
{
    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     */
    public function github_url(string $package)
    {
        $generator = (new DependenciesService($package))->gitHub();
        $url = $generator->url();
        $response = Http::get($url);

        $this->assertInstanceOf(DependencyUrl::class, $generator);
        $this->assertStringContainsString($package, $url);
        $this->assertStringContainsString('github.com', $url);
        $this->assertTrue($response->ok());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     */
    public function travis_url(string $package)
    {
        $generator = (new DependenciesService($package))->travis();
        $url = $generator->url();
        $response = Http::get($url);

        $this->assertInstanceOf(DependencyUrl::class, $generator);
        $this->assertStringContainsString($package, $url);
        $this->assertStringContainsString('travis-ci.com', $url);
        $this->assertTrue($response->ok());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     */
    public function version_url(string $package)
    {
        $generator = (new DependenciesService($package))->version();
        $url = $generator->url();
        $response = Http::get($url);

        $this->assertInstanceOf(DependencyUrl::class, $generator);
        $this->assertStringContainsString($package, $url);
        $this->assertStringContainsString('packagist.org/packages', $url);
        $this->assertTrue($response->ok());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     */
    public function travis_svg(string $package)
    {
        $generator = (new DependenciesService($package))->travis();
        $url = $generator->svg();
        $response = Http::get($url);

        $this->assertInstanceOf(DependencyUrl::class, $generator);
        $this->assertInstanceOf(DependencySvg::class, $generator);
        $this->assertStringContainsString($package, $url);
        $this->assertStringContainsString('travis-ci.com', $url);
        $this->assertStringContainsString('.svg?branch=master', $url);
        $this->assertTrue($response->ok());
        $this->assertStringContainsString('build', $response->body());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     */
    public function version_svg(string $package)
    {
        $generator = (new DependenciesService($package))->version();
        $url = $generator->svg();
        $response = Http::get($url);

        $this->assertInstanceOf(DependencyUrl::class, $generator);
        $this->assertInstanceOf(DependencySvg::class, $generator);
        $this->assertStringContainsString($package, $url);
        $this->assertStringContainsString('img.shields.io/packagist/v', $url);
        $this->assertTrue($response->ok());
        $this->assertStringContainsString('<title>packagist: v', $response->body());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     */
    public function last_commit_svg(string $package)
    {
        $generator = (new DependenciesService($package))->lastCommit();
        $url = $generator->svg();
        $response = Http::get($url);

        $this->assertInstanceOf(DependencyUrl::class, $generator);
        $this->assertInstanceOf(DependencySvg::class, $generator);
        $this->assertStringContainsString($package, $url);
        $this->assertStringContainsString('img.shields.io/github/last-commit', $url);
        $this->assertTrue($response->ok());
        $this->assertStringContainsString('last commit', $response->body());
    }
}
