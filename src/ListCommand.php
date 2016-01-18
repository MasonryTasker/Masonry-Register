<?php
/**
 * ListCommand.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry-Config
 */

namespace Foundry\Masonry\ModuleRegister;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ListCommand
 * ${CARET}
 * @package Masonry-Config
 * @see     https://github.com/TheFoundryVisionmongers/Masonry-Config
 */
class ListCommand extends Command
{

    const ARGUMENT_MODULE = 'module';

    protected function configure()
    {
        $this
            ->setName('list')
            ->setDescription('Lists all Listed modules')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $List = ModuleRegister::load();

        $output->writeln('Modules Listed:');

        foreach($List->getWorkerModuleDefinitions() as $definition) {
            $output->writeln($definition->getModuleName());
        }

    }
}
