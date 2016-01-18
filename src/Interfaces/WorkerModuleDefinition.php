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

    public function __construct($moduleName);

    /**
     * @return string
     */
    public function getModuleName();

    /**
     * @return WorkerModuleInterface
     */
    public function getModule();

    /**
     * @return array
     */
    public function getConfiguration();

}
