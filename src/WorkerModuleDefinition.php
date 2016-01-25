<?php
/**
 * WorkerModuleDefinition.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license   MIT
 * @see       https://github.com/TheFoundryVisionmongers/Masonry-Register
 */

namespace Foundry\Masonry\ModuleRegister;

use Foundry\Masonry\Interfaces\Task\DescriptionInterface;
use Foundry\Masonry\Interfaces\WorkerInterface;
use Foundry\Masonry\ModuleRegister\Interfaces\WorkerModuleDefinition as WorkerModuleDefinitionInterface;


/**
 * Class WorkerModuleDefinition
 *
 * @package Masonry-Register
 * @see     https://github.com/TheFoundryVisionmongers/Masonry-Register
 */
class WorkerModuleDefinition implements WorkerModuleDefinitionInterface
{

    const KEY_WORKERS = 'workers';
    const KEY_DESCRIPTIONS = 'descriptions';
    const KEY_CONFIG = 'config';

    protected static $moduleKeys = [
        self::KEY_WORKERS,
        self::KEY_DESCRIPTIONS,
        self::KEY_CONFIG,
    ];

    /**
     * @var string[]
     */
    protected $workers = [];

    /**
     * @var string[]
     */
    protected $descriptions = [];

    /**
     * @var string[]
     */
    protected $configurationKeys = [];

    /**
     * WorkerModuleDefinition constructor.
     * @param string[] $workers
     * @param string[] $descriptions
     * @param string[] $configurationKeys
     */
    public function __construct(array $workers, array $descriptions, array $configurationKeys = [])
    {
        $this->workers = $workers;
        $this->descriptions = $descriptions;
        $this->configurationKeys = $configurationKeys;
    }

    /**
     * Create a new module definition from an array of data
     * @param array $definition
     * @return static
     */
    public static function fromArray(array $definition)
    {
        if (!static::validateArray($definition)) {
            throw new \RuntimeException('Unknown error happened while validating module array data');
        }
        return new static(
            $definition[static::KEY_WORKERS],
            $definition[static::KEY_DESCRIPTIONS],
            $definition[static::KEY_CONFIG]
        );
    }

    /**
     * Validates the workers
     * @param array $definition
     * @throws \RuntimeException
     * @return true
     */
    public static function validateArray(array $definition)
    {
        /**
         * Get any errors regarding workers from the definition
         * @param array $definition
         * @return bool|string
         */
        $getWorkerErrors = function (array $definition) {
            $workerInterfaceName = WorkerInterface::class;
            $key = static::KEY_WORKERS;

            // Check there are even workers
            if (!array_key_exists($key, $definition)) {
                return $key . ' key does not exist';
            }

            // Check all workers are included
            $incompatibleWorkers = [];
            foreach ($definition[$key] as $potentialWorker => $aliases) {
                $reflectedWorker = new \ReflectionClass($potentialWorker);
                if (!$reflectedWorker->isSubclassOf($workerInterfaceName)) {
                    $incompatibleWorkers[$potentialWorker] = $aliases;
                }
            }
            if ($incompatibleWorkers) {
                return 'Incompatible workers: ' . implode(', ', $incompatibleWorkers);
            }
            return false;
        };
        /**
         * Get any errors regarding descriptions from the definition
         * @param array $definition
         * @return bool|string
         */
        $getDescriptionErrors = function (array $definition) {
            $descriptionInterfaceName = DescriptionInterface::class;
            $key = static::KEY_DESCRIPTIONS;

            // Check there are even descriptions
            if (!array_key_exists($key, $definition)) {
                return $key . ' key does not exist';
            }

            // Check all descriptions are included
            $incompatibleDescriptions = [];
            foreach ($definition[$key] as $potentialDescription => $aliases) {
                $reflectedDescription = new \ReflectionClass($potentialDescription);
                if (!$reflectedDescription->isSubclassOf($descriptionInterfaceName)) {
                    $incompatibleDescriptions[$potentialDescription] = $aliases;
                }
            }
            if ($incompatibleDescriptions) {
                return 'Incompatible descriptions: ' . implode(', ', $incompatibleDescriptions);
            }
            return false;
        };
        /**
         * Get any errors regarding config variables from the definition
         * @param array $definition
         * @return bool|string
         */
        $getConfigErrors = function (array $definition) {
            $key = static::KEY_CONFIG;

            // Check there are even configs
            if (!array_key_exists($key, $definition)) {
                return $key . ' key does not exist';
            }
            return false;
        };

        $errors = [];
        $workerErrors = $getWorkerErrors($definition);
        $descriptionErrors = $getDescriptionErrors($definition);
        $configErrors = $getConfigErrors($definition);
        if ($workerErrors) {
            $errors[] = $workerErrors;
        }
        if ($descriptionErrors) {
            $errors[] = $descriptionErrors;
        }
        if ($configErrors) {
            $errors[] = $configErrors;
        }

        if ($errors) {
            throw new \RuntimeException(
                'Could not validate module, the following errors were found' . PHP_EOL . implode(PHP_EOL, $errors)
            );
        }

        return true;
    }

    /**
     * @return string[]
     */
    public function getWorkers()
    {
        return $this->workers;
    }

    /**
     * @return string[]
     */
    public function getDescriptions()
    {
        return $this->descriptions;
    }

    /**
     * @return string[]
     */
    public function getConfigurationKeys()
    {
        return $this->configurationKeys;
    }
}
