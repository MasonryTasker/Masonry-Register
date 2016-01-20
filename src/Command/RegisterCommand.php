<?php
/**
 * RegisterCommand.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license   MIT
 * @see       https://github.com/TheFoundryVisionmongers/Masonry-Register
 */

namespace Foundry\Masonry\ModuleRegister\Command;

use Foundry\Masonry\ModuleRegister\ModuleRegister;
use Foundry\Masonry\ModuleRegister\WorkerModuleDefinition;
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

    use Traits\ConfigValues;
    use Traits\ModuleName;
    use Traits\RegisterFile;

    protected function configure()
    {
        $this
            ->setName('register')
            ->setDescription('Register a module')
            ->addArgument(
                $this->getModuleArgument(),
                InputArgument::REQUIRED,
                'The fully qualified name of the module you are trying to install'
            )
            ->addOption(
                $this->getRegisterFileOption(),
                $this->getRegisterFileOption()[0],
                InputArgument::OPTIONAL,
                'Where the register file should be kept',
                $this->getRegisterFileDefault()
            )
            ->addOption(
                $this->getConfigValuesOption(),
                $this->getConfigValuesOption()[0],
                InputArgument::OPTIONAL,
                'Any values that must be filled in for a particular module to function'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $module       = $input->getArgument($this->getModuleArgument());
        $registerFile = $input->getOption($this->getRegisterFileOption());
        $config       = explode(',',$input->getOption($this->getConfigValuesOption()));

        $register = ModuleRegister::load($registerFile);
        $register->addWorkerModule(
            new WorkerModuleDefinition($module, $config)
        );
        $register->save();

        $output->writeln("Registered $module");
    }
}
