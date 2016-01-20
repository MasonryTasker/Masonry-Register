<?php
/**
 * ConfigValues.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license   MIT
 * @see       https://github.com/TheFoundryVisionmongers/Masonry-Register
 */

namespace Foundry\Masonry\ModuleRegister\Command\Traits;

/**
 * Trait ConfigValues
 * ${CARET}
 * @package Masonry-Register
 * @see     https://github.com/TheFoundryVisionmongers/Masonry-Register
 */
trait ConfigValues
{

    /**
     * @var string
     */
    private $configValuesArgument = 'config';

    /**
     * @return string
     */
    protected function getConfigValuesOption()
    {
        return $this->configValuesArgument;
    }
}
