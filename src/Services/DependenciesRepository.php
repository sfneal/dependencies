<?php

namespace Sfneal\Dependencies\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Sfneal\Caching\Traits\IsCacheable;
use Sfneal\Dependencies\Utils\ComposerDependencies;
use Sfneal\Helpers\Laravel\LaravelHelpers;

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
     * @var array|null Array of global Img Shields params to be passed to SVG requests
     */
    private $imgShieldGlopalParams;

    /**
     * DependenciesRepository constructor.
     *
     * @param array|null $imgShieldGlobalParams
     */
    public function __construct(array $imgShieldGlobalParams = null)
    {
        $this->imgShieldGlopalParams = $imgShieldGlobalParams;
    }

    /**
     * Retrieve dependencies from the composer.json file & optionally include 'dev' dependencies.
     *
     * @param  bool  $devComposerDependencies
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
     * @param  array  $dependencies
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
            $this->cacheKey(),
            config('dependencies.cache.ttl'),
            function () {
                $array = [];

                foreach ($this->getDependencies()->toArray() as $type => $dependencies) {
                    foreach ($dependencies as $dependency) {
                        $array[] = new DependencyService($dependency, $type, $this->imgShieldGlopalParams);
                    }
                }

                return collect($array);
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
            } else {
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
        return collect($this->dependencies);
    }

    /**
     * Retrieve an array of composer packages that are required by the composer.json.
     *
     * @return Collection
     */
    private function getComposerRequirements(): Collection
    {
        return collect([
            'composer' => (new ComposerDependencies($this->devComposerDependencies))->get()->toArray(),
        ]);
    }

    /**
     * Retrieve the cache key.
     *
     * @return string
     */
    public function cacheKey(): string
    {
        return config('dependencies.cache.prefix').':'.LaravelHelpers::serializeHash($this->getDependencies()->toArray());
    }
}
