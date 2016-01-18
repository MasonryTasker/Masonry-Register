<?php
/**
 * ListCommand.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license   MIT
 * @see       https://github.com/TheFoundryVisionmongers/Masonry-Register
 */

namespace Foundry\Masonry\ModuleRegister;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ListCommand
 * List currently registered modules
 * @example bin/masonry-register list
 * @package Masonry-Register
 * @see     https://github.com/TheFoundryVisionmongers/Masonry-Register
 */
class ListCommand extends Command
{

    const ARGUMENT_MODULE = 'module';

    protected function configure()
    {
        $this
            ->setName('list')
            ->setDescription('Lists currently registered modules')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $list = ModuleRegister::load();

        $output->writeln('Modules Listed:');

        foreach($list->getWorkerModuleDefinitions() as $definition) {
            $output->writeln($definition->getModuleName());
        }

    }
}
