<?php
/**
 * RegisterCommand.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license   MIT
 * @see       https://github.com/TheFoundryVisionmongers/Masonry-Register
 */

namespace Foundry\Masonry\ModuleRegister;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class RegisterCommand
 * The command to register a Module
 * @example bin/masonry-register register \\Example\\Module
 * @package Masonry-Register
 * @see     https://github.com/TheFoundryVisionmongers/Masonry-Register
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
