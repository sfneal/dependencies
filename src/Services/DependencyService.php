<?php

namespace Sfneal\Dependencies\Services;

use Sfneal\Dependencies\Utils\DependencyUrl;
use Sfneal\Dependencies\Utils\GithubUrl;
use Sfneal\Dependencies\Utils\ImgShieldsUrl;
use Sfneal\Dependencies\Utils\Url;

class DependencyService
{
    /**
     * @var string[] Array of supported dependency types
     */
    private const DEPENDENCY_TYPES = [
        'composer',
        'docker',
        'python',
        'node',
    ];

    /**
     * @var string Name of the dependency
     */
    public $package;

    /**
     * @var string Type of Dependency ('composer', 'docker', 'python' or 'node')
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
     * @var array|null Array of global Img Shields params to be passed to SVG requests
     */
    private $imgShieldGlobals;

    /**
     * DependenciesService constructor.
     *
     * @param  string  $package
     * @param  string  $type
     * @param  array|null  $imgShieldGlobals
     */
    public function __construct(string $package, string $type = 'composer', array $imgShieldGlobals = null)
    {
        $this->package = $package;
        $this->setGitHubRepo($package);
        $this->setType($type);
        $this->setProject($package);
        $this->imgShieldGlobals = $imgShieldGlobals;
    }

    /**
     * Retrieve a GitHub URL for a dependency.
     *
     * @return DependencyUrl|GithubUrl
     */
    public function gitHub(): GithubUrl
    {
        return new GithubUrl($this->githubRepo, $this->imgShieldGlobals);
    }

    /**
     * Retrieve a Travis CI build status SVG URL for a dependency.
     *
     * @return DependencyUrl
     */
    public function travis(): DependencyUrl
    {
        return new DependencyUrl(
            Url::from("app.travis-ci.com/{$this->githubRepo}"),
            Url::from("app.travis-ci.com/{$this->githubRepo}.svg")
                ->withParams([
                    'branch' => 'master',
                ]),
        );
    }

    /**
     * Retrieve the Dependencies latest version.
     *
     * @return DependencyUrl
     */
    public function version(): DependencyUrl
    {
        switch ($this->type) {
            // Docker
            case 'docker':
                return $this->docker();

            // Python
            case 'python':
                return $this->pypi();

            // Python
            case 'node':
                return $this->node();

            // PHP
            default:
                return $this->packagist();
        }
    }

    /**
     * Retrieve date of the last GitHub commit.
     *
     * @return DependencyUrl
     */
    public function lastCommit(): DependencyUrl
    {
        return new DependencyUrl(
            Url::from("github.com/{$this->githubRepo}"),
            ImgShieldsUrl::from("github/last-commit/{$this->githubRepo}")
                ->withGlobalParams($this->imgShieldGlobals)
        );
    }

    /**
     * Retrieve number of open issues.
     *
     * @return DependencyUrl
     */
    public function openIssues(): DependencyUrl
    {
        return new DependencyUrl(
            Url::from("github.com/{$this->githubRepo}/issues"),
            ImgShieldsUrl::from("github/issues-raw/{$this->githubRepo}")
                ->withGlobalParams($this->imgShieldGlobals)
        );
    }

    /**
     * Retrieve number of closed issues.
     *
     * @return DependencyUrl
     */
    public function closedIssues(): DependencyUrl
    {
        return new DependencyUrl(
            Url::from("github.com/{$this->githubRepo}/issues")
                ->withParams([
                    'q' => 'is%3Aissue+is%3Aclosed',
                ]),
            ImgShieldsUrl::from("github/issues-closed-raw/{$this->githubRepo}")
                ->withParams([
                    'color' => 'red',
                ])
                ->withGlobalParams($this->imgShieldGlobals),
        );
    }

    /**
     * Retrieve number of open pull requests.
     *
     * @return DependencyUrl
     */
    public function openPullRequests(): DependencyUrl
    {
        return new DependencyUrl(
            Url::from("github.com/{$this->githubRepo}/pulls"),
            ImgShieldsUrl::from("github/issues-pr-raw/{$this->githubRepo}")
                ->withGlobalParams($this->imgShieldGlobals)
        );
    }

    /**
     * Retrieve number of closed pull requests.
     *
     * @return DependencyUrl
     */
    public function closedPullRequests(): DependencyUrl
    {
        return new DependencyUrl(
            Url::from("github.com/{$this->githubRepo}/pulls")
                ->withParams([
                    'q' => 'is%3Aissue+is%3Aclosed',
                ]),
            ImgShieldsUrl::from("github/issues-pr-closed-raw/{$this->githubRepo}")
                ->withParams([
                    'color' => 'red',
                ])
                ->withGlobalParams($this->imgShieldGlobals)
        );
    }

    /**
     * Retrieve a Packagist versions SVG URL for a dependency.
     *
     * @return DependencyUrl
     */
    private function packagist(): DependencyUrl
    {
        return new DependencyUrl(
            Url::from("packagist.org/packages/{$this->package}"),
            ImgShieldsUrl::from("packagist/v/{$this->package}.svg")
                ->withGlobalParams($this->imgShieldGlobals)
        );
    }

    /**
     * Retrieve the latest Docker image tag for a dependency.
     *
     * @return DependencyUrl
     */
    private function docker(): DependencyUrl
    {
        return new DependencyUrl(
            Url::from("hub.docker.com/r/{$this->package}"),
            ImgShieldsUrl::from("docker/v/{$this->package}.svg")
                ->withParams([
                    'sort' => 'semver',
                ])
                ->withGlobalParams($this->imgShieldGlobals)
        );
    }

    /**
     * Retrieve the latest PyPi version a dependency.
     *
     * @return DependencyUrl
     */
    private function pypi(): DependencyUrl
    {
        $project = explode('/', $this->package)[1];

        return new DependencyUrl(
            Url::from("pypi.org/project/{$project}"),
            ImgShieldsUrl::from("pypi/v/{$project}.svg")
                ->withGlobalParams($this->imgShieldGlobals)
        );
    }

    /**
     * Retrieve a Node versions SVG URL for a dependency.
     *
     * @return DependencyUrl
     */
    private function node(): DependencyUrl
    {
        $project = explode('/', $this->package)[1];

        return new DependencyUrl(
            Url::from("npmjs.com/package/{$project}"),
            ImgShieldsUrl::from("npm/v/{$project}.svg")
                ->withGlobalParams($this->imgShieldGlobals)
        );
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
        if ($this->type == 'python' || $this->type == 'node') {
            [$user, $package] = explode('/', $fullPackageName);
            $this->project = $package;
        } else {
            $this->project = $fullPackageName;
        }
    }
}
