<?php declare(strict_types=1);

namespace Yireo\LiveTestRunner\Test\Integration\Command;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\State as AppState;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Yireo\LiveTestRunner\Command\RunLiveTests;

class RunLiveTestsTest extends TestCase
{
    public function testRefusesToRunInProductionMode(): void
    {
        $commandTester = $this->getCommandTester(AppState::MODE_PRODUCTION);
        $result = $commandTester->execute(['folder' => $this->getRoot()]);

        $this->assertSame(Command::FAILURE, $result);
        $this->assertStringContainsString('Refusing to run', $commandTester->getDisplay());
    }

    public function testForceAllowsProductionMode(): void
    {
        $commandTester = $this->getCommandTester(AppState::MODE_PRODUCTION);
        $result = $commandTester->execute(['folder' => '/nonexisting-folder', '--force' => true]);

        $this->assertSame(Command::FAILURE, $result);
        $this->assertStringNotContainsString('Refusing to run', $commandTester->getDisplay());
        $this->assertStringContainsString('Not a valid folder: /nonexisting-folder', $commandTester->getDisplay());
    }

    public function testRejectsFolderOutsideMagentoRoot(): void
    {
        $commandTester = $this->getCommandTester(AppState::MODE_DEVELOPER);
        $folder = dirname((string)realpath($this->getRoot()));
        $result = $commandTester->execute(['folder' => $folder]);

        $this->assertSame(Command::FAILURE, $result);
        $this->assertStringContainsString('Not a valid folder: ' . $folder, $commandTester->getDisplay());
    }

    public function testEscapesFolderInOutput(): void
    {
        $commandTester = $this->getCommandTester(AppState::MODE_DEVELOPER);
        $result = $commandTester->execute(['folder' => '<error>foo</error>']);

        $this->assertSame(Command::FAILURE, $result);
        $this->assertStringContainsString('Not a valid folder: <error>foo</error>', $commandTester->getDisplay());
    }

    private function getRoot(): string
    {
        return Bootstrap::getObjectManager()->get(DirectoryList::class)->getRoot();
    }

    private function getCommandTester(string $mode): CommandTester
    {
        $appState = $this->createMock(AppState::class);
        $appState->method('getMode')->willReturn($mode);

        $command = Bootstrap::getObjectManager()->create(RunLiveTests::class, ['appState' => $appState]);

        return new CommandTester($command);
    }
}
