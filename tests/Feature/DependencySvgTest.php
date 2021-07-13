<?php

namespace Sfneal\Dependencies\Tests\Feature;

use Sfneal\Dependencies\Tests\TestCase;
use Sfneal\Dependencies\Utils\DependencySvg;

class DependencySvgTest extends TestCase
{
    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     */
    public function travis_svg(string $package)
    {
        $this->assertTravisSvg($package, new DependencySvg(
            "travis-ci.com/{$package}",
            "travis-ci.com/{$package}.svg?branch=master",
            ''
        ));
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     */
    public function version_svg(string $package)
    {
        $this->assertVersionSvg($package, new DependencySvg(
            "packagist.org/packages/{$package}",
            "packagist/v/{$package}.svg",
        ));
    }

    /**
     * @test
     * @dataProvider packageProvider
     * @param string $package
     */
    public function last_commit_svg(string $package)
    {
        $this->assertLastCommitSvg($package, new DependencySvg(
            "github.com/{$package}",
            "github/last-commit/{$package}"
        ));
    }
}
