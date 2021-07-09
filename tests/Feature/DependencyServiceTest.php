<?php

namespace Sfneal\Dependencies\Tests\Feature;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Sfneal\Dependencies\Tests\TestCase;
use Sfneal\Dependencies\Utils\DependenciesService;

class DependencyServiceTest extends TestCase
{
    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     * @throws GuzzleException
     */
    public function github_url(string $package)
    {
        $url = (new DependenciesService($package))->gitHub();
        $response = (new Client())->request('get', $url);

        $this->assertStringContainsString($package, $url);
        $this->assertStringContainsString('github.com', $url);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     * @throws GuzzleException
     */
    public function travis_url(string $package)
    {
        $url = (new DependenciesService($package))->travis();
        $response = (new Client())->request('get', $url);

        $this->assertStringContainsString($package, $url);
        $this->assertStringContainsString('travis-ci.com', $url);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     * @throws GuzzleException
     */
    public function version_url(string $package)
    {
        $url = (new DependenciesService($package))->version();
        $response = (new Client())->request('get', $url);

        $this->assertStringContainsString($package, $url);
        $this->assertStringContainsString('packagist.org/packages', $url);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     * @throws GuzzleException
     */
    public function travis_svg(string $package)
    {
        $url = (new DependenciesService($package))->travis(true);
        $response = (new Client())->request('get', $url);
        $contents = $response->getBody()->getContents();

        $this->assertStringContainsString($package, $url);
        $this->assertStringContainsString('travis-ci.com', $url);
        $this->assertStringContainsString('.svg?branch=master', $url);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('build', $contents);
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     * @throws GuzzleException
     */
    public function version_svg(string $package)
    {
        $url = (new DependenciesService($package))->version(true);
        $response = (new Client())->request('get', $url);
        $contents = $response->getBody()->getContents();

        $this->assertStringContainsString($package, $url);
        $this->assertStringContainsString('img.shields.io/packagist/v', $url);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('<title>packagist: v', $contents);
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     * @throws GuzzleException
     */
    public function last_commit_svg(string $package)
    {
        $url = (new DependenciesService($package))->lastCommit();
        $response = (new Client())->request('get', $url);
        $contents = $response->getBody()->getContents();

        $this->assertStringContainsString($package, $url);
        $this->assertStringContainsString('img.shields.io/github/last-commit', $url);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('last commit', $contents);
    }
}
