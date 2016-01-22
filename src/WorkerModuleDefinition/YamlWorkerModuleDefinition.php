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

    protected static $moduleKeys = [
        'workers',
        'descriptions',
        'config',
    ];

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
        $data = static::flattenKeys($data);

        $missingKeys = static::getMissingKeys($data);
        if($missingKeys) {
            throw new \RuntimeException("Invalid module definition $file, missing keys: ". implode(',', $missingKeys));
        }

        return new static($data['workers'], $data['description'], $data['config']);
    }

    /**
     * Gets a list of any missing keys
     * @param array $moduleDefinition
     * @return array Any missing keys
     */
    protected static function getMissingKeys(array $moduleDefinition)
    {
        $missing = [];
        foreach(static::$moduleKeys as $key) {
            if(!array_key_exists($key, $moduleDefinition)) {
                $missing[] = $key;
            }
        }
        return $missing;
    }

    /**
     * @param array $array
     * @return array
     */
    protected static function flattenKeys(array $array)
    {
        $newArray = [];
        foreach ($array as $key => $value) {
            $newArray[strtolower($key)] = $value;
        }
        return $newArray;
    }

}
