<?php

namespace Sfneal\Dependencies\Services;

use Sfneal\Dependencies\Utils\DependencySvg;
use Sfneal\Dependencies\Utils\DependencyUrl;

class DependenciesService
{
    /**
     * @var string Name of the sfneal composer dependency
     */
    public $package;

    /**
     * @var string Type of Dependency ('composer' or 'docker')
     */
    public $type;

    /**
     * DependenciesService constructor.
     * @param string $package
     * @param string $type
     */
    public function __construct(string $package, string $type = 'composer')
    {
        $this->package = $package;
        $this->type = $type;
    }

    /**
     * Retrieve a GitHub URL for a dependency.
     *
     * @return DependencyUrl
     */
    public function gitHub(): DependencyUrl
    {
        return new DependencyUrl("github.com/{$this->package}");
    }

    /**
     * Retrieve a Travis CI build status SVG URL for a dependency.
     *
     * @return DependencySvg
     */
    public function travis(): DependencySvg
    {
        return new DependencySvg(
            "travis-ci.com/{$this->package}",
            "travis-ci.com/{$this->package}.svg?branch=master",
            ''
        );
    }

    /**
     * Retrieve the Dependencies latest version.
     *
     * @return DependencySvg
     */
    public function version(): DependencySvg
    {
        return $this->type == 'composer' ? $this->packagist() : $this->docker();
    }

    /**
     * Retrieve date of the last GitHub commit.
     *
     * @return DependencySvg
     */
    public function lastCommit(): DependencySvg
    {
        return new DependencySvg(
            "github.com/{$this->package}",
            "github/last-commit/{$this->package}"
        );
    }

    /**
     * Retrieve a Packagist versions SVG URL for a dependency.
     *
     * @return DependencySvg
     */
    private function packagist(): DependencySvg
    {
        return new DependencySvg(
            "packagist.org/packages/{$this->package}",
            "packagist/v/{$this->package}.svg"
        );
    }

    /**
     * Retrieve the latest Docker image tag for a dependency.
     *
     * @return DependencySvg
     */
    private function docker(): DependencySvg
    {
        return new DependencySvg(
            "hub.docker.com/r/{$this->package}",
            "docker/v/{$this->package}.svg?sort=semver"
        );
    }
}