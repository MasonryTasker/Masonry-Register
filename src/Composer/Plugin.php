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
use Foundry\Masonry\ModuleRegister\ModuleRegister;
use Foundry\Masonry\ModuleRegister\WorkerModuleDefinition\YamlWorkerModuleDefinition;

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
     * Test the plugin by running `composer test`
     * @param Event $event
     */
    public static function test(Event $event)
    {
        $plugin = new static();
        $plugin->activate($event->getComposer(), $event->getIO());
    }

    /**
     * Run with composer validate-masonry
     * @param Event $event
     */
    public static function validate(Event $event)
    {
        $configFile = '';
        $localYaml = getcwd().'/masonry.yaml';
        if(is_file($localYaml)) {
            $configFile = $localYaml;
        }
        if(array_key_exists(0, $event->getArguments())) {
            $configFile = $event->getArguments()[0];
            if(!is_file($configFile)) {
                throw new \InvalidArgumentException("'$configFile' is not a Module configuration file");
            }
        }

        // Validate
        YamlWorkerModuleDefinition::load($configFile);

        $event->getIO()->write("Module file '$configFile' is valid");
    }

    /**
     * @param Composer $composer
     * @param string|null $fileLocation
     */
    protected function buildRegister(Composer $composer, $fileLocation = null)
    {
        $vendorDir = $composer->getConfig()->get('vendor-dir');
        $modules = [];
        foreach(glob("$vendorDir/*/*/masonry.y*ml") as $masonryConfig) {
            $modules[] = YamlWorkerModuleDefinition::load($masonryConfig);
        }
        $register = new ModuleRegister($fileLocation);
        $register->addWorkerModules($modules);
        $register->save();
    }
}
