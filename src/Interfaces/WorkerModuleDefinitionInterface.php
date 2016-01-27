<?php
/**
 * WorkerModuleDefinition.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license   MIT
 * @see       https://github.com/TheFoundryVisionmongers/Masonry-Register
 */

namespace Foundry\Masonry\ModuleRegister\Interfaces;

use Foundry\Masonry\Interfaces\WorkerModuleInterface;

/**
 * Interface WorkerModuleDefinition
 *
 * @package Masonry-Register
 * @see     https://github.com/TheFoundryVisionmongers/Masonry-Register
 */
interface WorkerModuleDefinitionInterface
{
    const KEY_NAME = 'name';
    const KEY_WORKERS = 'workers';
    const KEY_DESCRIPTIONS = 'descriptions';
    const KEY_EXTRA = 'extra';

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string[]
     */
    public function getWorkers();

    /**
     * @return string[]
     */
    public function getDescriptions();

    /**
     * Get the name of a description class based on a name or alias
     * @param $nameOrAlias
     * @return string
     */
    public function lookupDescription($nameOrAlias);

    /**
     * @return string[]
     */
    public function getExtra();
}
