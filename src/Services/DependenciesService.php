<?php

namespace Sfneal\Dependencies\Services;

use Sfneal\Dependencies\Utils\DependencySvg;
use Sfneal\Dependencies\Utils\DependencyUrl;

class DependenciesService
{
    /**
     * @var string[] Array of supported dependency types
     */
    private const DEPENDENCY_TYPES = [
        'composer',
        'docker',
        'python',
    ];

    /**
     * @var string Name of the dependency
     */
    public $package;

    /**
     * @var string Type of Dependency ('composer' or 'docker')
     */
    public $type;

    /**
     * @var string Name of the GitHub package.
     */
    public $githubRepo;

    /**
     * @var string Name of the project without the GitHub user prefix (used for Python projects).
     */
    public $project;

    /**
     * DependenciesService constructor.
     * @param  string  $package
     * @param  string  $type
     */
    public function __construct(string $package, string $type = 'composer')
    {
        $this->package = $package;
        $this->setGitHubRepo($package);
        $this->setType($type);
        $this->setProject($package);
    }

    /**
     * Retrieve the GitHub package name with alias replacement.
     *
     * @param  string  $fullPackageName
     * @return void
     */
    private function setGitHubRepo(string $fullPackageName): void
    {
        [$user, $package] = explode('/', $fullPackageName);

        // Replace GitHub username with alias if one is provided
        if (array_key_exists($user, config('dependencies.github_alias'))) {
            $this->githubRepo = config('dependencies.github_alias')[$user]."/{$package}";
        }

        // Use default package name
        else {
            $this->githubRepo = $fullPackageName;
        }
    }

    /**
     * Set the dependencies type.
     *
     * @param  string  $type
     */
    private function setType(string $type): void
    {
        assert(
            in_array($type, self::DEPENDENCY_TYPES),
            "'{$type} is not a supported dependency type (supported: ".join(', ', self::DEPENDENCY_TYPES)
        );
        $this->type = $type;
    }

    /**
     * Set the dependency project name.
     *
     * @param  string  $fullPackageName
     */
    private function setProject(string $fullPackageName): void
    {
        if ($this->type == 'python') {
            [$user, $package] = explode('/', $fullPackageName);
            $this->project = $package;
        } else {
            $this->project = $fullPackageName;
        }
    }

    /**
     * Retrieve a GitHub URL for a dependency.
     *
     * @return DependencyUrl
     */
    public function gitHub(): DependencyUrl
    {
        return new DependencyUrl("github.com/{$this->githubRepo}");
    }

    /**
     * Retrieve a Travis CI build status SVG URL for a dependency.
     *
     * @return DependencySvg
     */
    public function travis(): DependencySvg
    {
        return new DependencySvg(
            "app.travis-ci.com/{$this->githubRepo}",
            "app.travis-ci.com/{$this->githubRepo}.svg?branch=master",
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
        switch ($this->type) {
            // Docker
            case 'docker':
                return $this->docker();

            // Python
            case 'python':
                return $this->pypi();

            // PHP
            default:
                return $this->packagist();
        }
    }

    /**
     * Retrieve date of the last GitHub commit.
     *
     * @return DependencySvg
     */
    public function lastCommit(): DependencySvg
    {
        return new DependencySvg(
            "github.com/{$this->githubRepo}",
            "github/last-commit/{$this->githubRepo}"
        );
    }

    /**
     * Retrieve number of open issues.
     *
     * @return DependencySvg
     */
    public function openIssues(): DependencySvg
    {
        return new DependencySvg(
            "github.com/{$this->githubRepo}/issues",
            "github/issues-raw/{$this->githubRepo}"
        );
    }

    /**
     * Retrieve number of closed issues.
     *
     * @return DependencySvg
     */
    public function closedIssues(): DependencySvg
    {
        return new DependencySvg(
            "github.com/{$this->githubRepo}/issues?q=is%3Aissue+is%3Aclosed",
            "github/issues-closed-raw/{$this->githubRepo}"
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

    /**
     * Retrieve the latest PyPi version a dependency.
     *
     * @return DependencySvg
     */
    private function pypi(): DependencySvg
    {
        $project = explode('/', $this->package)[1];

        return new DependencySvg(
            "pypi.org/project/{$project}",
            "pypi/v/{$project}.svg"
        );
    }
}
