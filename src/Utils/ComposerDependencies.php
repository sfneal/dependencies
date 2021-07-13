<?php

namespace Sfneal\Dependencies\Utils;

class ComposerDependencies
{
    /**
     * @var bool
     */
    private $dev;

    /**
     * ComposerDependencies constructor.
     *
     * @param bool $dev
     */
    public function __construct(bool $dev = false)
    {
        $this->dev = $dev;
    }

    /**
     * Retrieve an array of composer package dependencies from the composer.json.
     *
     * @return array
     */
    public function get(): array
    {
        // If development packages are included, merge require & require-dev
        return $this->dev ? array_merge(self::require(), self::requireDev()) : self::require();
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
