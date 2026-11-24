<?php declare(strict_types=1);

namespace Yireo\LiveTestRunner\Command;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\State as AppState;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RunLiveTests extends Command
{
    public function __construct(
        private readonly AppState $appState,
        private readonly DirectoryList $directoryList,
        ?string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('yireo_livetest:run')
            ->setDescription('Run live tests via PHPUnit')
            ->addArgument('folder', InputArgument::REQUIRED, 'Folder name')
            ->addOption('force', null, InputOption::VALUE_NONE, 'Allow running tests in production mode');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($this->appState->getMode() === AppState::MODE_PRODUCTION && !$input->getOption('force')) {
            $output->writeln(
                '<error>Refusing to run live tests in production mode. Use --force to override.</error>'
            );
            return Command::FAILURE;
        }

        $folder = trim((string)$input->getArgument('folder'), " \n\r\t\v\0");
        $realFolder = $this->resolveFolder($folder);
        if ($realFolder === null) {
            $output->writeln('Not a valid folder: ' . OutputFormatter::escape($folder));
            return Command::FAILURE;
        }

        $arguments = ['phpunit', '--colors', $realFolder];

        if (class_exists(\PHPUnit\TextUI\Application::class)) {
            return (new \PHPUnit\TextUI\Application())->run($arguments);
        }

        if (class_exists(\PHPUnit\TextUI\Command::class)) {
            return (int)(new \PHPUnit\TextUI\Command())->run($arguments, false);
        }

        $output->writeln('<error>No supported PHPUnit runner found</error>');
        return Command::FAILURE;
    }

    private function resolveFolder(string $folder): ?string
    {
        if ($folder === '') {
            return null;
        }

        $realFolder = realpath($folder);
        if ($realFolder === false || !is_dir($realFolder)) {
            return null;
        }

        $root = realpath($this->directoryList->getRoot());
        if ($root === false) {
            return null;
        }

        $root = rtrim($root, '/') . '/';
        if (!str_starts_with($realFolder . '/', $root)) {
            return null;
        }

        return $realFolder;
    }
}
