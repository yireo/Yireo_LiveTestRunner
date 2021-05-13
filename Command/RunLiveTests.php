<?php declare(strict_types=1);

namespace Yireo\LiveTestRunner\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use PHPUnit\TextUI\Command as TestCommand;

class RunLiveTests extends Command
{
    protected function configure()
    {
        $this->setName('yireo_livetest:run')
            ->setDescription('Run live tests via PHPUnit')
            ->addArgument('folder', InputArgument::REQUIRED, 'Folder name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $folder = trim((string)$input->getArgument('folder'));
        if (!is_dir($folder)) {
            $output->writeln('Not a valid folder: ' . $folder);
            return;
        }

        $command = new TestCommand();
        $command->run(['phpunit', $folder, '--colors']);
    }
}
