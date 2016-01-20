<?php
/**
 * ModuleNameTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license   MIT
 * @see       https://github.com/TheFoundryVisionmongers/Masonry-Register
 */

namespace Foundry\Masonry\ModuleRegister\Test\PhpUnit\Command\Traits;

use Foundry\Masonry\ModuleRegister\Command\Traits\ModuleName;

/**
 * Trait ModuleNameTest
 * @package Masonry-Register
 * @see     https://github.com/TheFoundryVisionmongers/Masonry-Register
 */
trait ModuleNameTest
{
    /**
     * @return ModuleName
     */
    abstract protected function getTestSubject();

    /**
     * @test
     * @covers ::getModuleNameArgument
     */
    public function testGetModuleNameArgument()
    {
        $testSubject = $this->getTestSubject();
        $getModuleNameOption = $this->getObjectMethod($testSubject, 'getModuleNameArgument');
        $this->assertSame(
            'module',
            $getModuleNameOption()
        );
    }
}
