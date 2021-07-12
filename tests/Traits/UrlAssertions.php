<?php


namespace Sfneal\Dependencies\Tests\Traits;


use Illuminate\Support\Facades\Http;
use Sfneal\Dependencies\Utils\DependencyUrl;

trait UrlAssertions
{
    /**
     * @param string $package
     * @param DependencyUrl $generator
     */
    public function assertGithubUrl(string $package, DependencyUrl $generator)
    {
        $url = $generator->url();
        $response = Http::get($url);

        $this->assertInstanceOf(DependencyUrl::class, $generator);
        $this->assertStringContainsString($package, $url);
        $this->assertStringContainsString('github.com', $url);
        $this->assertTrue($response->ok());
    }

    /**
     * @param string $package
     * @param DependencyUrl $generator
     */
    public function assertTravisUrl(string $package, DependencyUrl $generator)
    {
        $url = $generator->url();
        $response = Http::get($url);

        $this->assertInstanceOf(DependencyUrl::class, $generator);
        $this->assertStringContainsString($package, $url);
        $this->assertStringContainsString('travis-ci.com', $url);
        $this->assertTrue($response->ok());
    }

    /**
     * @param string $package
     * @param DependencyUrl $generator
     */
    public function assertVersionUrl(string $package, DependencyUrl $generator)
    {
        $url = $generator->url();
        $response = Http::get($url);

        $this->assertInstanceOf(DependencyUrl::class, $generator);
        $this->assertStringContainsString($package, $url);
        $this->assertStringContainsString('packagist.org/packages', $url);
        $this->assertTrue($response->ok());
    }
}
