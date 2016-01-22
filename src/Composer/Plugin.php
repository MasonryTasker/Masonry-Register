<?php
/**
 * Plugin.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry-Register
 */

namespace Foundry\Masonry\ModuleRegister\Composer;

use Composer\Composer;
use Composer\Config;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event;

/**
 * Class Plugin
 * ${CARET}
 * @package Masonry-Register
 * @see     https://github.com/TheFoundryVisionmongers/Masonry-Register
 */
class Plugin implements PluginInterface
{
    /**
     * @var Composer
     */
    protected $composer;

    /**
     * @var IOInterface
     */
    protected $io;

    /**
     * @param Composer $composer
     * @param IOInterface $io
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;

        $this->buildRegister($composer);
    }

    /**
     * Test the plugin by running `composer run-script test`
     * @param Event $event
     */
    public static function test(Event $event)
    {
        $plugin = new static();
        $plugin->activate($event->getComposer(), $event->getIO());
    }

    /**
     * @param Composer $composer
     */
    protected function buildRegister(Composer $composer)
    {
        $vendorDir = $composer->getConfig()->get('vendor-dir');
        foreach(glob("$vendorDir/*/*/masonry.y*ml") as $masonryConfig) {
            
        }
    }

    protected function getDirectories(\DirectoryIterator $vendorDirectory)
    {
        foreach($vendorDirectory as $vendor) {
            echo $vendor->current().PHP_EOL;
        }
    }
}
