<?php
/**
 * PluginTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry-Register
 */

namespace Foundry\Masonry\ModuleRegister\Test\PhpUnit\Composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Foundry\Masonry\ModuleRegister\Composer\Plugin;
use Foundry\Masonry\ModuleRegister\Test\PhpUnit\TestCase;

/**
 * Class PluginTest
 * ${CARET}
 * @package Masonry-Register
 * @see     https://github.com/TheFoundryVisionmongers/Masonry-Register
 * @coversDefaultClass Foundry\Masonry\ModuleRegister\Composer\Plugin
 */
class PluginTest extends TestCase
{

    /**
     * @test
     * @covers ::activate
     */
    public function testActivate()
    {
        /** @var Composer|\PHPUnit_Framework_MockObject_MockObject $composer */
        $composer = $this->getMock(Composer::class);
        /** @var IOInterface|\PHPUnit_Framework_MockObject_MockObject $ioInterface */
        $ioInterface = $this->getMockForAbstractClass(IOInterface::class);

        $plugin = new Plugin();
        $plugin->activate($composer, $ioInterface);

        $this->assertSame(
            $composer,
            $this->getObjectAttribute($plugin, 'composer')
        );
        $this->assertSame(
            $ioInterface,
            $this->getObjectAttribute($plugin, 'io')
        );
    }

    public function testGetSubscribedEvents()
    {
        $events = Plugin::getSubscribedEvents();

        $this->assertArrayHasKey(
            'post-autoload-dump',
            $events
        );
    }

}
