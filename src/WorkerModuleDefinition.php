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
     * @var WorkerInterface[]
     */
    protected $workers = [];

    /**
     * @var DescriptionInterface[]
     */
    protected $descriptions = [];

    /**
     * @var string[]
     */
    protected $configurationKeys = [];

    /**
     * WorkerModuleDefinition constructor.
     * @param \Foundry\Masonry\Interfaces\WorkerInterface[] $workers
     * @param \Foundry\Masonry\Interfaces\Task\DescriptionInterface[] $descriptions
     * @param string[] $configurationKeys
     */
    public function __construct(array $workers, array $descriptions, array $configurationKeys = [])
    {
        $this->workers = $workers;
        $this->descriptions = $descriptions;
        $this->configurationKeys = $configurationKeys;
    }

    /**
     * @return \Foundry\Masonry\Interfaces\WorkerInterface[]
     */
    public function getWorkers()
    {
        return $this->workers;
    }

    /**
     * @return \Foundry\Masonry\Interfaces\Task\DescriptionInterface[]
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
