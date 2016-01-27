<?php
/**
 * ModuleRegister.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license   MIT
 * @see       https://github.com/TheFoundryVisionmongers/Masonry-Register
 */

namespace Foundry\Masonry\ModuleRegister\Interfaces;

/**
 * Interface ModuleRegister
 *
 * @package Masonry-Register
 * @see     https://github.com/TheFoundryVisionmongers/Masonry-Register
 */
interface ModuleRegister
{
    /**
     * @return WorkerModuleDefinition[]
     */
    public function getWorkerModules();

    /**
     * Get a named module
     * @param $name
     * @return WorkerModuleDefinition
     */
    public function getWorkerModule($name);

    /**
     * @param WorkerModuleDefinition $module The definition of the module to be added
     * @throws \Exception If a problem occurs.
     * @return $this
     */
    public function addWorkerModule(WorkerModuleDefinition $module);

    /**
     * This will always save to the file from which is was loaded
     * @throws \Exception If the file can not be saved.
     * @return $this
     */
    public function save();

    /**
     * @param string $fileLocation Which file to load from
     * @throws \Exception If the file can not be loaded.
     * @return $this
     */
    public static function load($fileLocation = null);
}
