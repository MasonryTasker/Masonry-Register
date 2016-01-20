<?php
/**
 * ListCommand.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license   MIT
 * @see       https://github.com/TheFoundryVisionmongers/Masonry-Register
 */

namespace Foundry\Masonry\ModuleRegister\Command;

use Foundry\Masonry\ModuleRegister\ModuleRegister;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
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
    use Traits\RegisterFile;

    protected function configure()
    {
        $this
            ->setName('list')
            ->setDescription('Lists currently registered modules')
            ->addOption(
                $this->getRegisterFileOption(),
                $this->getRegisterFileOption()[0],
                InputArgument::OPTIONAL,
                'Where the register file should be kept',
                $this->getRegisterFileDefault()
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $registerFile = $input->getOption($this->getRegisterFileOption());

        $list = ModuleRegister::load($registerFile);

        $output->writeln('Modules Listed:');

        foreach($list->getWorkerModuleDefinitions() as $definition) {
            $output->writeln($definition->getModuleName());
            foreach($definition->getConfiguration() as $configValue) {
                $output->writeln("  $configValue");
            }
        }
    }
}
