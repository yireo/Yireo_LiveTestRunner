<?php declare(strict_types=1);

namespace Yireo\LiveTestRunner\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RunLiveTests extends Command
{
    protected function configure()
    {
        $this->setName('yireo_livetest:run')
            ->setDescription('Run live tests via PHPUnit')
            ->addArgument('folder', InputArgument::REQUIRED, 'Folder name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $folder = trim((string)$input->getArgument('folder'));
        if (!is_dir($folder)) {
            $output->writeln('Not a valid folder: ' . $folder);
            return Command::FAILURE;
        }

        $arguments = ['phpunit', '--colors', $folder];

        if (class_exists(\PHPUnit\TextUI\Application::class)) {
            return (new \PHPUnit\TextUI\Application())->run($arguments);
        }

        if (class_exists(\PHPUnit\TextUI\Command::class)) {
            return (int)(new \PHPUnit\TextUI\Command())->run($arguments, false);
        }

        $output->writeln('<error>No supported PHPUnit runner found</error>');
        return Command::FAILURE;
    }
}
