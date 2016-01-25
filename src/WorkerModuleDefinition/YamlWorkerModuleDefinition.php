<?php
/**
 * Yaml.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry-Register
 */

namespace Foundry\Masonry\ModuleRegister\WorkerModuleDefinition;

use Foundry\Masonry\ModuleRegister\WorkerModuleDefinition;
use Symfony\Component\Yaml\Yaml as YamlReader;

/**
 * Class Yaml
 * Takes a Yaml File and returns a Worker Module Definition
 * @package Masonry-Register
 * @see     https://github.com/TheFoundryVisionmongers/Masonry-Register
 */
class YamlWorkerModuleDefinition extends WorkerModuleDefinition
{

    /**
     * Load a module definition
     * @param $file
     * @return static
     */
    public static function load($file)
    {
        if (!file_exists($file)) {
            throw new \InvalidArgumentException("File '$file' does not exist");
        }
        $data = (array)YamlReader::parse(file_get_contents($file));
        try {
            return static::fromArray($data);
        } catch (\Exception $exception) {
            throw new \RuntimeException(
                "Unable to load module from file '$file'" . PHP_EOL . $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }
    }

}
