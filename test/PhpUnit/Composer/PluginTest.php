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
use Composer\Config;
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
            $this->getObjectAttribute($plugin, 'inputOutput')
        );
    }

    /**
     * @test
     * @covers ::getSubscribedEvents
     */
    public function testGetSubscribedEvents()
    {
        $events = Plugin::getSubscribedEvents();

        $this->assertArrayHasKey(
            'post-autoload-dump',
            $events
        );
    }

//    /**
//     * @test
//     * @covers ::requireAutoload
//     */
//    public function testRequireAutoload()
//    {
//        $testValue = 'test/value';
//        $expected = 'test/value/autoload.php';
//
//        $config = $this->getMock(Config::class);
//        $config
//            ->expects($this->once())
//            ->method('get')
//            ->with('vendor-dir')
//            ->will($this->returnValue($testValue));
//
//        $composer = $this->getMock(Composer::class);
//        $composer
//            ->expects($this->once())
//            ->method('getConfig')
//            ->with()
//            ->will($this->returnValue($config));
//
//        $plugin = new Plugin();
//        $requireAutoload = $this->getObjectMethod($plugin, 'requireAutoload');
//
//        $this->assertSame(
//            $expected,
//            $requireAutoload($composer)
//        );
//    }
}
