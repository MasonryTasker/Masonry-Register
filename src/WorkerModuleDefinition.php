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
use Foundry\Masonry\ModuleRegister\Interfaces\WorkerModuleDefinitionInterface;

/**
 * Class WorkerModuleDefinition
 *
 * @package Masonry-Register
 * @see     https://github.com/TheFoundryVisionmongers/Masonry-Register
 */
class WorkerModuleDefinition implements WorkerModuleDefinitionInterface
{

    protected static $moduleKeys = [
        self::KEY_WORKERS,
        self::KEY_DESCRIPTIONS,
        self::KEY_EXTRA,
    ];

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string[]
     */
    protected $workers = [];

    /**
     * @var string[]
     */
    protected $descriptions = [];

    /**
     * @var array
     */
    protected $extra = [];

    /**
     * WorkerModuleDefinition constructor.
     * @param string $name
     * @param string[] $workers
     * @param string[] $descriptions
     * @param string[] $extra
     */
    public function __construct($name, array $workers, array $descriptions, array $extra = [])
    {
        $this->name = $name;
        $this->workers = $workers;
        $this->descriptions = $descriptions;
        $this->extra = $extra;
    }

    /**
     * @return string
     */
    public function getName()
    {
        if (!$this->name) {
            throw new \LogicException('Module was never named');
        }
        return $this->name;
    }

    /**
     * Create a new module definition from an array of data
     * @param array $definition
     * @return static
     */
    public static function fromArray(array $definition)
    {
        $flatDefinition = static::flattenKeys($definition);

        if (!static::validateArray($flatDefinition)) {
            throw new \RuntimeException('Unknown error happened while validating module array data');
        }
        $name = $flatDefinition[static::KEY_NAME];
        $workers = (array)$flatDefinition[static::KEY_WORKERS];
        $description = (array)$flatDefinition[static::KEY_DESCRIPTIONS];
        $extra = array_key_exists(static::KEY_EXTRA, $flatDefinition) ? (array)$flatDefinition[static::KEY_EXTRA] : [];

        return new static($name, $workers, $description, $extra);
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
                return $key . ' key is missing';
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
                return $key . ' key is missing';
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
        $getNameErrors = function (array $definition) {
            $key = static::KEY_NAME;

            // Check there are even configs
            if (!array_key_exists($key, $definition)) {
                return $key . ' key is missing';
            }

            if (!is_string($definition[$key])) {
                return $key . ' must be a string';
            }

            return false;
        };

        $errors = [];
        $workerErrors = $getWorkerErrors($definition);
        $descriptionErrors = $getDescriptionErrors($definition);
        $nameErrors = $getNameErrors($definition);
        if ($workerErrors) {
            $errors[] = $workerErrors;
        }
        if ($descriptionErrors) {
            $errors[] = $descriptionErrors;
        }
        if ($nameErrors) {
            $errors[] = $nameErrors;
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
     * Get the name of a description class based on a name or alias
     * @param $nameOrAlias
     * @return string
     */
    public function lookupDescription($nameOrAlias)
    {
        // It might already be the right class
        if (array_key_exists($nameOrAlias, $this->descriptions)) {
            return $nameOrAlias;
        }

        // If it isn't, we should look it up.
        foreach ($this->descriptions as $description => $aliases) {
            if (is_array($aliases)) {
                foreach ($aliases as $alias) {
                    if ($nameOrAlias === $alias) {
                        return $description;
                    }
                }
            }
        }

        // If we haven't found it by now, we're not going to.
        throw new \RuntimeException("No description could be found matching {$this->getName()}/{$nameOrAlias}");
    }

    /**
     * @return string[]
     */
    public function getExtra()
    {
        return $this->extra;
    }

    /**
     * @param array $data
     * @return array
     */
    protected static function flattenKeys(array $data)
    {
        $flatArray = [];
        foreach ($data as $key => $value) {
            $flatArray[strtolower($key)] = $value;
        }
        return $flatArray;
    }
}
