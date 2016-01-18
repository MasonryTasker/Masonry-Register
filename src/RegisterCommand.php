<?php
/**
 * RegisterCommand.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry-Config
 */

namespace Foundry\Masonry\ModuleRegister;

use Foundry\Masonry\Interfaces\WorkerModuleInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class RegisterCommand
 * ${CARET}
 * @package Masonry-Config
 * @see     https://github.com/TheFoundryVisionmongers/Masonry-Config
 */
class RegisterCommand extends Command
{

    const ARGUMENT_MODULE = 'module';

    protected function configure()
    {
        $this
            ->setName('register')
            ->setDescription('Register a module')
            ->addArgument(
                static::ARGUMENT_MODULE,
                InputArgument::REQUIRED,
                'The fully qualified name of the module you are trying to install'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $register = ModuleRegister::load();

        $module = $input->getArgument(static::ARGUMENT_MODULE);
        $register->addWorkerModule(
            new WorkerModuleDefinition($module)
        );
        $register->save();

        $output->writeln("Registered $module");
    }
}
