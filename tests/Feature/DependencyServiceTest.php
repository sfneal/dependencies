<?php


namespace Sfneal\Dependencies\Tests\Feature;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Sfneal\Dependencies\DependenciesService;
use Sfneal\Dependencies\Tests\TestCase;

class DependencyServiceTest extends TestCase
{
    /**
     * @param string $url
     * @throws GuzzleException
     */
    public function urlAssertions(string $url)
    {
        $response = (new Client())->request('get', $url);

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     * @throws GuzzleException
     */
    public function github_url(string $package)
    {
        $url = (new DependenciesService($package))->gitHub();

        $this->urlAssertions($url);
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

        $this->urlAssertions($url);
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

        $this->urlAssertions($url);
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

        $this->urlAssertions($url);
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

        $this->urlAssertions($url);
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

        $this->urlAssertions($url);
    }
}
