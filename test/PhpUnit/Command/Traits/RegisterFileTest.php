<?php
/**
 * RegisterFileTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license   MIT
 * @see       https://github.com/TheFoundryVisionmongers/Masonry-Register
 */

namespace Foundry\Masonry\ModuleRegister\Test\PhpUnit\Command\Traits;

use Foundry\Masonry\ModuleRegister\Command\Traits\RegisterFile;

/**
 * Trait RegisterFileTest
 * @package Masonry-Register
 * @see     https://github.com/TheFoundryVisionmongers/Masonry-Register
 */
trait RegisterFileTest
{
    /**
     * @return RegisterFile
     */
    abstract protected function getTestSubject();

    /**
     * @test
     * @covers ::getRegisterFileOption
     */
    public function testGetRegisterFileOption()
    {
        $testSubject = $this->getTestSubject();
        $getRegisterFileOption = $this->getObjectMethod($testSubject, 'getRegisterFileOption');
        $this->assertSame(
            'register-file',
            $getRegisterFileOption()
        );
    }

    /**
     * @test
     * @covers ::getRegisterFileDefault
     */
    public function testGetRegisterFileDefault()
    {
        $testSubject = $this->getTestSubject();
        $getRegisterFileOption = $this->getObjectMethod($testSubject, 'getRegisterFileDefault');
        $this->assertRegExp(
            '|.*/register/register.yaml|',
            $getRegisterFileOption()
        );
    }
}
