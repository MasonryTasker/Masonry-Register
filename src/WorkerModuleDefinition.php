<?php
/**
 * WorkerModuleDefinition.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license   MIT
 * @see       https://github.com/TheFoundryVisionmongers/Masonry-Register
 */

namespace Foundry\Masonry\ModuleRegister;

use Foundry\Masonry\ModuleRegister\Interfaces\WorkerModuleDefinition as WorkerModuleDefinitionInterface;
use Foundry\Masonry\Interfaces\WorkerModuleInterface;

/**
 * Class WorkerModuleDefinition
 *
 * @package Masonry-Register
 * @see     https://github.com/TheFoundryVisionmongers/Masonry-Register
 */
class WorkerModuleDefinition implements WorkerModuleDefinitionInterface
{

    /**
     * @var WorkerModuleInterface
     */
    protected $module;

    /**
     * @var array
     */
    protected $config;

    /**
     * WorkerModuleDefinition constructor.
     * @param string $moduleName
     * @param array $config
     */
    public function __construct($moduleName, array $config = [])
    {
        if (!class_exists($moduleName)) {
            throw new \InvalidArgumentException("Worker module '$moduleName' does not exist");
        }
        $module = new $moduleName();
        if(!$module instanceof WorkerModuleInterface) {
            $className = WorkerModuleInterface::class;
            throw new \InvalidArgumentException("Class '$moduleName' does not implement '$className'");
        }

        $this->module = $module;
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function getModuleName()
    {
        return get_class($this->module);
    }

    /**
     * @return WorkerModuleInterface
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @return array
     */
    public function getConfiguration()
    {
        return $this->config;
    }

}
