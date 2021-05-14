<?php declare(strict_types=1);

namespace Yireo\LiveTestRunner\TestCase;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\State as AppState;
use PHPUnit\Framework\TestCase;

class GenericTestCase extends TestCase
{

    /**
     * @return AppState
     */
    protected function getAppState(): AppState
    {
        return $this->get(AppState::class);
    }

    /**
     * @return ObjectManager
     */
    protected function getObjectManager(): ObjectManager
    {
        return ObjectManager::getInstance();
    }

    /**
     * @param string $className
     * @return mixed
     */
    protected function get(string $className)
    {
        return $this->getObjectManager()->get($className);
    }

    protected function assertIsDeveloperMode()
    {
        $this->assertSame($this->getAppState()->getMode(), AppState::MODE_DEVELOPER);
    }
}
