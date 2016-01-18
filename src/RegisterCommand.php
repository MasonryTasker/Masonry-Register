<?php
/**
 * RegisterCommand.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry-Config
 */

namespace Foundry\Masonry\ModuleRegister;

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
    protected function configure()
    {
        $this
            ->setName('register')
            ->setDescription('Register a module')
            ->addArgument(
                'module',
                InputArgument::REQUIRED,
                'The fully qualified name of the module you are trying to install'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $register = ModuleRegister::load();
        $output->writeln("register");
    }
}
