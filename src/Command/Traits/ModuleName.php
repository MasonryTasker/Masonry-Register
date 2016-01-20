<?php
/**
 * ModuleName.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license   MIT
 * @see       https://github.com/TheFoundryVisionmongers/Masonry-Register
 */

namespace Foundry\Masonry\ModuleRegister\Command\Traits;

/**
 * Trait ModuleName
 *
 * @package Masonry-Register
 * @see     https://github.com/TheFoundryVisionmongers/Masonry-Register
 */
trait ModuleName
{

    /**
     * @var string
     */
    private $moduleArgument = 'module';

    /**
     * @return string
     */
    protected function getModuleNameArgument()
    {
        return $this->moduleArgument;
    }
}
