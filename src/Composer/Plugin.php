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
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginEvents;
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
class Plugin implements PluginInterface, EventSubscriberInterface
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
    }

    /**
     * Test the plugin by running `composer test`
     * @param Event $event
     */
    public static function test(Event $event)
    {
        $plugin = new static();
        $plugin->activate($event->getComposer(), $event->getIO());
        $plugin->onPostAutoloadDump($event);
    }

    /**
     * Build the register once the autoloader has been dumped
     * @param Event $event
     */
    public function onPostAutoloadDump(Event $event)
    {
        $event->getIO()->write('Masonry Registry build started.');
        $this->buildRegister();
    }

    /**
     * Some kind of poorly documented magic.
     * Ideally we only want to run once the auto loader exists, not before.
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            PluginEvents::COMMAND => [
                ['onPostAutoloadDump' => 0]
            ]
        ];
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
     * @param string|null $fileLocation
     */
    protected function buildRegister($fileLocation = null)
    {
        $vendorDir = $this->composer->getConfig()->get('vendor-dir');
        $modules = [];
        foreach(glob("$vendorDir/*/*/masonry.y*ml") as $masonryConfig) {
            try {
                $modules[] = YamlWorkerModuleDefinition::load($masonryConfig);
                $this->io->write("<info>Added module:</info> $masonryConfig");
            }
            catch(\Exception $e) {
                $this->io->writeError("<error>Invalid module:</error> $masonryConfig");
                $this->io->writeError("== {$e->getMessage()}");
            }
        }
        $register = new ModuleRegister($fileLocation);
        $register->addWorkerModules($modules);
        $register->save();
    }
}
