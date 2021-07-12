<?php


namespace Sfneal\Dependencies\Tests\Feature;


use Sfneal\Dependencies\Tests\TestCase;

class ConfigTest extends TestCase
{
    /** @test */
    public function dependencies_config_exists()
    {
        $config = config('dependencies');

        $this->assertNotNull($config);
        $this->assertIsArray($config);
        $this->assertArrayHasKey('dependencies', $config);
    }

    /** @test */
    public function composer_dependencies()
    {
        $this->assertArrayHasKey('composer', config('dependencies.dependencies'));
        $this->assertIsArray(config('dependencies.dependencies.composer'));
    }

    /** @test */
    public function docker_dependencies()
    {
        $this->assertArrayHasKey('docker', config('dependencies.dependencies'));
        $this->assertIsArray(config('dependencies.dependencies.docker'));
    }
}
