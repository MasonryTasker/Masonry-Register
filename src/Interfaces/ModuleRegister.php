<?php
/**
 * ModuleRegister.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license   MIT
 * @see       https://github.com/TheFoundryVisionmongers/Masonry-Config
 */

namespace Foundry\Masonry\ModuleRegister\Interfaces;

use Foundry\Masonry\Interfaces\WorkerModuleInterface;

/**
 * Interface ModuleRegister
 * ${CARET}
 * @package Masonry-Config
 * @see     https://github.com/TheFoundryVisionmongers/Masonry-Config
 */
interface ModuleRegister
{
    /**
     * @return WorkerModuleDefinition[]
     */
    public function getWorkerModuleDefinitions();

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
     * @param string $filename Which file to load from
     * @throws \Exception If the file can not be loaded.
     * @return $this
     */
    public static function load($filename = null);


}
