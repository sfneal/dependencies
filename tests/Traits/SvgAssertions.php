<?php

namespace Sfneal\Dependencies\Tests\Traits;

use Illuminate\Support\Facades\Http;
use Sfneal\Dependencies\Utils\DependencySvg;
use Sfneal\Dependencies\Utils\DependencyUrl;
use Sfneal\Helpers\Strings\StringHelpers;

trait SvgAssertions
{
    /**
     * @param string $package
     * @param DependencySvg $generator
     */
    public function assertTravisSvg(string $package, DependencySvg $generator)
    {
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
     * @param string $package
     * @param DependencySvg $generator
     */
    public function assertVersionSvg(string $package, DependencySvg $generator)
    {
        $url = $generator->svg();
        $response = Http::get($url);

        $this->assertInstanceOf(DependencyUrl::class, $generator);
        $this->assertInstanceOf(DependencySvg::class, $generator);
        $this->assertStringContainsString($package, $url);
        $this->assertStringContainsString('img.shields.io/', $url);
        $this->assertTrue($response->ok());

        $inString = (new StringHelpers($response->body()));
        $this->assertTrue(
            $inString->inString('<title>packagist: v') || $inString->inString('version')
        );
    }

    /**
     * @param string $package
     * @param DependencySvg $generator
     */
    public function assertLastCommitSvg(string $package, DependencySvg $generator)
    {
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
