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
interface WorkerModuleDefinition
{

    public function getName();

    public function getWorkers();

    public function getDescriptions();

    public function getExtra();

}
