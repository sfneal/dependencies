<?php

namespace Sfneal\Dependencies\Tests\Feature;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Sfneal\Dependencies\DependenciesService;
use Sfneal\Dependencies\Tests\TestCase;

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

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     * @throws GuzzleException
     */
    public function travis_url_svg(string $package)
    {
        $url = (new DependenciesService($package))->travis(true);
        $response = (new Client())->request('get', $url);
        $contents = $response->getBody()->getContents();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('build', $contents);
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     * @throws GuzzleException
     */
    public function version_url_svg(string $package)
    {
        $url = (new DependenciesService($package))->version(true);
        $response = (new Client())->request('get', $url);
        $contents = $response->getBody()->getContents();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('<title>packagist: v', $contents);
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     * @throws GuzzleException
     */
    public function last_commit_url(string $package)
    {
        $url = (new DependenciesService($package))->lastCommit();
        $response = (new Client())->request('get', $url);
        $contents = $response->getBody()->getContents();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('last commit', $contents);
    }
}
