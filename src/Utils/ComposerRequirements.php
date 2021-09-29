<?php

namespace Sfneal\Dependencies\Utils;

use Illuminate\Support\Collection;
use Sfneal\Helpers\Strings\StringHelpers;

class ComposerRequirements
{
    /**
     * @var bool
     */
    private $dev;

    /**
     * ComposerDependencies constructor.
     *
     * @param  bool  $dev
     */
    public function __construct(bool $dev = false)
    {
        $this->dev = $dev;
    }

    /**
     * Retrieve an array of composer package dependencies from the composer.json.
     *
     * @return Collection
     */
    public function get(): Collection
    {
        // If development packages are included, merge require & require-dev
        $dependencies = $this->dev ? array_merge(self::require(), self::requireDev()) : self::require();

        // Retrieve 'require' array from composer.json with only package names (the keys
        // todo: remove keys?
        return collect(array_keys($dependencies))

            // Remove 'php' & php extensions from the packages array
            ->filter(function (string $dep) {
                return $dep != 'php' && ! (new StringHelpers($dep))->inString('ext');
            });
    }

    /**
     * Return the file contents of a composer.json file decoded as json array.
     *
     * @return array
     */
    private static function composerJson(): array
    {
        return json_decode(file_get_contents(config('dependencies.composer_json_path')), true);
    }

    /**
     * Retrieve an array of the composer package dependencies.
     *
     * @return array
     */
    private static function require(): array
    {
        return self::composerJson()['require'];
    }

    /**
     * Retrieve an array of the composer package development dependencies.
     *
     * @return array
     */
    private static function requireDev(): array
    {
        return self::composerJson()['require-dev'];
    }
}
