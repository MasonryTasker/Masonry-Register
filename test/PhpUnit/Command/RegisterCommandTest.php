<?php
/**
 * RegisterCommandTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry-Register
 */

namespace Foundry\Masonry\ModuleRegister\Test\PhpUnit\Command;

use Foundry\Masonry\ModuleRegister\Command\RegisterCommand;
use Foundry\Masonry\ModuleRegister\Test\PhpUnit\TestCase;

/**
 * Class RegisterCommandTest
 * @package Masonry-Register
 * @see     https://github.com/TheFoundryVisionmongers/Masonry-Register
 * @coversDefaultClass \Foundry\Masonry\ModuleRegister\Command\RegisterCommand
 */
class RegisterCommandTest extends TestCase
{
    use Traits\ConfigValuesTest;
    use Traits\ModuleNameTest;
    use Traits\RegisterFileTest;

    /**
     * @return RegisterCommand
     */
    protected function getTestSubject()
    {
        return new RegisterCommand();
    }

    /**
     * @test
     * @covers ::configure
     */
    public function testConfigure()
    {
        $testSubject = $this->getTestSubject();

        $this->assertSame(
            'register',
            $testSubject->getName()
        );

        $this->assertSame(
            'Register a module',
            $testSubject->getDescription()
        );

        $arguments = $testSubject->getNativeDefinition()->getArguments();
        $this->assertCount(
            1,
            $arguments
        );

        $this->assertSame(
            'module',
            $arguments[0]->getName()
        );

        $this->assertTrue(
            $arguments[0]->isRequired()
        );

        $options = $testSubject->getNativeDefinition()->getOptions();
        $this->assertCount(
            2,
            $options
        );

        $this->assertSame(
            'register-file',
            $options[0]->getName()
        );

        $this->assertSame(
            'r',
            $options[0]->getShortcut()
        );

        $this->assertTrue(
            $options[0]->isValueOptional()
        );

        $this->assertSame(
            'config-values',
            $options[1]->getName()
        );

        $this->assertSame(
            'c',
            $options[1]->getShortcut()
        );

        $this->assertTrue(
            $options[1]->isValueOptional()
        );
    }
}
