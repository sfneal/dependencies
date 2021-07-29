<?php

namespace Sfneal\Dependencies\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Sfneal\Caching\Traits\IsCacheable;
use Sfneal\Dependencies\Utils\ComposerDependencies;
use Sfneal\Helpers\Laravel\LaravelHelpers;
use Sfneal\Helpers\Strings\StringHelpers;

class DependenciesRepository
{
    use IsCacheable;

    /**
     * @var array Array of composer or Docker dependencies
     */
    private $dependencies;

    /**
     * @var bool Use composer.json dependencies as source
     */
    private $composerDependencies;

    /**
     * @var bool Include composer dev dependencies
     */
    private $devComposerDependencies;

    /**
     * @var Collection Collection of dependencies retrieved by the `getDependencies()` method
     */
    private $dependenciesCollection;

    /**
     * Retrieve dependencies from the composer.json file & optionally include 'dev' dependencies.
     *
     * @param bool $devComposerDependencies
     * @return $this
     */
    public function fromComposer(bool $devComposerDependencies = false): self
    {
        $this->composerDependencies = true;
        $this->devComposerDependencies = $devComposerDependencies;

        return $this;
    }

    /**
     * Retrieve dependencies from the config file.
     *
     * @return $this
     */
    public function fromConfig(): self
    {
        $this->composerDependencies = false;
        $this->dependencies = config('dependencies.dependencies');

        return $this;
    }

    /**
     * Retrieve dependencies from an array.
     *
     * @param array $dependencies
     * @return $this
     */
    public function fromArray(array $dependencies): self
    {
        $this->composerDependencies = false;
        $this->dependencies = $dependencies;

        return $this;
    }

    /**
     * Retrieve a Collection of Dependencies with GitHub, Packagist version & Travis CI build status URLs.
     *
     * @return Collection
     */
    public function get(): Collection
    {
        return Cache::remember(
            config('dependencies.cache.prefix').$this->cacheKey(),
            config('dependencies.cache.ttl'),
            function () {
                return $this->getDependencies()->map(function (string $type, string $dependency) {
                    return new DependenciesService($dependency, $type);
                });
            }
        );
    }

    /**
     * Retrieve a list of dependencies from the config file or by reading the composer.json 'requires' section.
     *
     * @return Collection
     */
    private function getDependencies(): Collection
    {
        if (is_null($this->dependenciesCollection)) {
            if ($this->composerDependencies) {
                $this->dependenciesCollection = $this->getComposerRequirements();
            }

            else {
                $this->dependenciesCollection = $this->getArrayDependencies() ?? $this->getComposerRequirements();
            }
        }

        return $this->dependenciesCollection;
    }

    /**
     * Retrieve a list of dependencies set in the 'dependencies' config.
     *
     * @return Collection
     */
    private function getArrayDependencies(): Collection
    {
        // Convert array of dependency type keys & array of dependency values
        // to a flat array of dependency keys and type values
        return collect($this->dependencies)
            ->mapWithKeys(function ($packages, $type) {
                return collect($packages)
                    ->mapWithKeys(function (string $package) use ($type) {
                        return [$package => $type];
                    });
            });
    }

    /**
     * Retrieve an array of composer packages that are required by the composer.json.
     *
     * @return Collection
     */
    private function getComposerRequirements(): Collection
    {
        // Retrieve 'require' array from composer.json with only package names (the keys
        // todo: remove keys?
        return collect(array_keys((new ComposerDependencies($this->devComposerDependencies))->get()))

            // Remove 'php' & php extensions from the packages array
            ->filter(function (string $dep) {
                return $dep != 'php' && ! (new StringHelpers($dep))->inString('ext');
            })

            // Map each dependencies to have a 'composer' value
            ->mapWithKeys(function (string $dep) {
                return [$dep => 'composer'];
            });
    }

    /**
     * Retrieve the cache key.
     *
     * @return string
     */
    public function cacheKey(): string
    {
        return LaravelHelpers::serializeHash($this->getDependencies()->toArray());
    }
}
