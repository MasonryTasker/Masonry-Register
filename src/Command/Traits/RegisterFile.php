<?php
/**
 * RegisterFile.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license   MIT
 * @see       https://github.com/TheFoundryVisionmongers/Masonry-Register
 */

namespace Foundry\Masonry\ModuleRegister\Command\Traits;

/**
 * Trait RegisterFile
 * ${CARET}
 * @package Masonry-Register
 * @see     https://github.com/TheFoundryVisionmongers/Masonry-Register
 */
trait RegisterFile
{

    /**
     * @var string
     */
    private $registerFileArgument = 'register-file';

    /**
     * @return string
     */
    protected function getRegisterFileOption()
    {
        return $this->registerFileArgument;
    }

    /**
     * @return string
     */
    protected function getRegisterFileDefault()
    {
        return realpath(__DIR__.'/../../../register'). '/register.yaml';
    }
}
