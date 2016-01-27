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

    public function getName();

    public function getWorkers();

    public function getDescriptions();

    public function getExtra();
}
