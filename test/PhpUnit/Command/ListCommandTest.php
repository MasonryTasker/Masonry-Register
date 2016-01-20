<?php
/**
 * ListCommandTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry-Register
 */

namespace Foundry\Masonry\ModuleRegister\Test\PhpUnit\Command;

use Foundry\Masonry\ModuleRegister\Command\ListCommand;
use Foundry\Masonry\ModuleRegister\Test\PhpUnit\TestCase;

/**
 * Class ListCommandTest
 * @package Masonry-Register
 * @see     https://github.com/TheFoundryVisionmongers/Masonry-Register
 * @coversDefaultClass \Foundry\Masonry\ModuleRegister\Command\ListCommand
 */
class ListCommandTest extends TestCase
{
    use Traits\RegisterFileTest;

    /**
     * @return ListCommand
     */
    protected function getTestSubject()
    {
        return new ListCommand();
    }

    /**
     * @test
     * @covers ::configure
     */
    public function testConfigure()
    {
        $testSubject = $this->getTestSubject();

        $this->assertSame(
            'list',
            $testSubject->getName()
        );

        $this->assertSame(
            'Lists currently registered modules',
            $testSubject->getDescription()
        );

        $options = $testSubject->getNativeDefinition()->getOptions();
        $this->assertCount(
            1,
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
    }
}
