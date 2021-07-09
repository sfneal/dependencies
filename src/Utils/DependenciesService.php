<?php

namespace Sfneal\Dependencies\Utils;

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
     * @return string
     */
    public function gitHub(): string
    {
        return self::url("github.com/{$this->packageName()}");
    }

    /**
     * Retrieve a Travis CI build status SVG URL for a dependency.
     *
     * @param bool $svg
     * @return string
     */
    public function travis(bool $svg = false): string
    {
        return self::url("travis-ci.com/{$this->packageName()}".($svg ? '.svg?branch=master' : ''));
    }

    /**
     * Retrieve the Dependencies latest version.
     *
     * @param bool $svg
     * @return string
     */
    public function version(bool $svg = false): string
    {
        return $this->type == 'composer' ? $this->packagist($svg) : $this->docker($svg);
    }

    /**
     * Retrieve date of the last GitHub commit.
     *
     * @return string
     */
    public function lastCommit(): string
    {
        return self::imgShieldUrl("/github/last-commit/{$this->packageName()}");
    }

    /**
     * Retrieve a Packagist versions SVG URL for a dependency.
     *
     * @param bool $svg
     * @return string
     */
    private function packagist(bool $svg = false): string
    {
        if ($svg) {
            return self::imgShieldUrl("/packagist/v/{$this->package}.svg");
        } else {
            return self::url("packagist.org/packages/{$this->package}");
        }
    }

    /**
     * Retrieve the latest Docker image tag for a dependency.
     *
     * @param bool $svg
     * @return string
     */
    private function docker(bool $svg = false): string
    {
        if ($svg) {
            return self::imgShieldUrl("/docker/v/{$this->package}.svg?sort=semver");
        } else {
            return self::url("hub.docker.com/r/{$this->package}");
        }
    }

    /**
     * Retrieve the correct name for a package.
     *
     * @return string
     */
    private function packageName(): string
    {
        if ($this->type == 'docker') {
            return str_replace('stephenneal', 'sfneal', $this->package);
        }

        return $this->package;
    }

    /**
     * Retrieve a image shield url.
     *
     * @param string $endpoint
     * @return string
     */
    private static function imgShieldUrl(string $endpoint): string
    {
        return self::url('img.shields.io'.$endpoint);
    }

    /**
     * Retrieve a secure url.
     *
     * @param string $uri
     * @param bool $secure use https
     * @return string
     */
    private static function url(string $uri, bool $secure = true): string
    {
        return 'http'.($secure ? 's' : '')."://{$uri}";
    }
}
