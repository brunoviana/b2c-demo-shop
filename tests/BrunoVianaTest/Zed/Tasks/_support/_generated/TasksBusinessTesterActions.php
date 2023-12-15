<?php  //[STAMP] bb56d72a8a9574408af09e18032343bc
// phpcs:ignoreFile
namespace BrunoVianaTest\Zed\Tasks\_generated;

// This class was automatically generated by build task
// You should not change it manually as it will be overwritten on next build

trait TasksBusinessTesterActions
{
    /**
     * @return \Codeception\Scenario
     */
    abstract protected function getScenario();

    
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $key
     * @param array|string|float|int|bool $value
     *
     * @return void
     * @see \SprykerTest\Shared\Testify\Helper\LocatorHelper::setConfig()
     */
    public function setConfig(string $key, $value): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('setConfig', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $key
     * @param array|string|float|int|bool $value
     *
     * @return void
     * @see \SprykerTest\Shared\Testify\Helper\ConfigHelper::mockEnvironmentConfig()
     */
    public function mockEnvironmentConfig(string $key, $value): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('mockEnvironmentConfig', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $methodName
     * @param mixed $return
     * @param string|null $moduleName
     * @param string|null $applicationName
     *
     * @throws \Exception
     *
     * @return \Spryker\Shared\Kernel\AbstractBundleConfig|null
     * @see \SprykerTest\Shared\Testify\Helper\ConfigHelper::mockConfigMethod()
     */
    public function mockConfigMethod(string $methodName, $return, ?string $moduleName = NULL, ?string $applicationName = NULL): ?\Spryker\Shared\Kernel\AbstractBundleConfig {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('mockConfigMethod', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $methodName
     * @param mixed $return
     * @param string|null $moduleName
     *
     * @throws \Exception
     *
     * @return \Spryker\Shared\Kernel\AbstractSharedConfig|null
     * @see \SprykerTest\Shared\Testify\Helper\ConfigHelper::mockSharedConfigMethod()
     */
    public function mockSharedConfigMethod(string $methodName, $return, ?string $moduleName = NULL): ?\Spryker\Shared\Kernel\AbstractSharedConfig {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('mockSharedConfigMethod', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string|null $moduleName
     *
     * @return \Spryker\Shared\Kernel\AbstractBundleConfig
     * @see \SprykerTest\Shared\Testify\Helper\ConfigHelper::getModuleConfig()
     */
    public function getModuleConfig(?string $moduleName = NULL): \Spryker\Shared\Kernel\AbstractBundleConfig {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('getModuleConfig', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string|null $moduleName
     *
     * @return \Spryker\Shared\Kernel\AbstractSharedConfig|null
     * @see \SprykerTest\Shared\Testify\Helper\ConfigHelper::getSharedModuleConfig()
     */
    public function getSharedModuleConfig(?string $moduleName = NULL): ?\Spryker\Shared\Kernel\AbstractSharedConfig {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('getSharedModuleConfig', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $moduleName
     *
     * @return bool
     * @see \SprykerTest\Shared\Testify\Helper\ConfigHelper::configExists()
     */
    public function configExists(string $moduleName): bool {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('configExists', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $key
     *
     * @return void
     * @see \SprykerTest\Shared\Testify\Helper\ConfigHelper::removeConfig()
     */
    public function removeConfig(string $key): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('removeConfig', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Sets a class instance into the Locator cache to ensure the mocked instance is returned when
     * `$locator->moduleName()->type()` is used.
     *
     * !!! When this method is used the locator will not re-initialize classes with `new` but will return
     * always the already resolved instances. This can have but should not have side-effects.
     *
     * @param string $cacheKey
     * @param mixed $classInstance
     *
     * @return void
     * @see \SprykerTest\Shared\Testify\Helper\LocatorHelper::addToLocatorCache()
     */
    public function addToLocatorCache(string $cacheKey, $classInstance): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('addToLocatorCache', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @return \Spryker\Shared\Kernel\LocatorLocatorInterface&\Generated\Zed\Ide\AutoCompletion&\Generated\Service\Ide\AutoCompletion&\Generated\Glue\Ide\AutoCompletion
     * @see \SprykerTest\Shared\Testify\Helper\LocatorHelper::getLocator()
     */
    public function getLocator() {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('getLocator', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string|null $moduleName
     *
     * @return \Spryker\Zed\Kernel\Business\AbstractFacade
     * @see \SprykerTest\Zed\Testify\Helper\Business\BusinessHelper::getFacade()
     */
    public function getFacade(?string $moduleName = NULL): \Spryker\Zed\Kernel\Business\AbstractFacade {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('getFacade', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @return void
     * @see \SprykerTest\Shared\Testify\Helper\DependencyHelper::clearFactoryContainerCache()
     */
    public function clearFactoryContainerCache(): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('clearFactoryContainerCache', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $key
     * @param mixed $value
     * @param string|null $onlyFor
     *
     * @return void
     * @see \SprykerTest\Shared\Testify\Helper\DependencyHelper::setDependency()
     */
    public function setDependency(string $key, $value, ?string $onlyFor = NULL): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('setDependency', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param \Closure $closure
     *
     * @return void
     * @see \SprykerTest\Shared\Testify\Helper\DataCleanupHelper::addCleanup()
     */
    public function addCleanup(\Closure $closure): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('addCleanup', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $methodName
     * @param mixed $return
     * @param string|null $moduleName
     *
     * @throws \Exception
     *
     * @return \Spryker\Zed\Kernel\Business\AbstractFacade
     * @see \SprykerTest\Zed\Testify\Helper\Business\BusinessHelper::mockFacadeMethod()
     */
    public function mockFacadeMethod(string $methodName, $return, ?string $moduleName = NULL) {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('mockFacadeMethod', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $methodName
     * @param mixed $return
     * @param string|null $moduleName
     *
     * @throws \Exception
     *
     * @return \Spryker\Zed\Kernel\Business\AbstractBusinessFactory|object
     * @see \SprykerTest\Zed\Testify\Helper\Business\BusinessHelper::mockFactoryMethod()
     */
    public function mockFactoryMethod(string $methodName, $return, ?string $moduleName = NULL) {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('mockFactoryMethod', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $methodName
     * @param mixed $return
     * @param string|null $moduleName
     *
     * @throws \Exception
     *
     * @return \Spryker\Zed\Kernel\Business\AbstractBusinessFactory|object
     * @see \SprykerTest\Zed\Testify\Helper\Business\BusinessHelper::mockSharedFactoryMethod()
     */
    public function mockSharedFactoryMethod(string $methodName, $return, ?string $moduleName = NULL) {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('mockSharedFactoryMethod', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string|null $moduleName
     *
     * @return \Spryker\Zed\Kernel\Business\AbstractBusinessFactory
     * @see \SprykerTest\Zed\Testify\Helper\Business\BusinessHelper::getFactory()
     */
    public function getFactory(?string $moduleName = NULL): \Spryker\Zed\Kernel\Business\AbstractBusinessFactory {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('getFactory', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \BrunoVianaTest\Zed\Tasks\Helper\TasksBusinessAssertionHelper::assertCreateTaskCreatedTaskSuccessfully()
     */
    public function assertCreateTaskCreatedTaskSuccessfully(\Generated\Shared\Transfer\TaskResponseTransfer $taskResponseTransfer): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('assertCreateTaskCreatedTaskSuccessfully', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \BrunoVianaTest\Zed\Tasks\Helper\TasksBusinessAssertionHelper::assertTaskResponseReturnedError()
     */
    public function assertTaskResponseReturnedError(\Generated\Shared\Transfer\TaskResponseTransfer $taskResponseTransfer, string $expectedErrorMessage): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('assertTaskResponseReturnedError', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \BrunoVianaTest\Zed\Tasks\Helper\TasksBusinessAssertionHelper::assertUpdateTaskChangeTaskAttributesSuccessfully()
     */
    public function assertUpdateTaskChangeTaskAttributesSuccessfully(\Generated\Shared\Transfer\TaskResponseTransfer $taskResponseTransfer, \Generated\Shared\Transfer\TaskTransfer $originalTaskTransfer): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('assertUpdateTaskChangeTaskAttributesSuccessfully', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string[] $override
     * @return TaskTransfer
     * @see \BrunoVianaTest\Zed\Tasks\Helper\TaskDataHelper::haveTask()
     */
    public function haveTask(array $override = []): \Generated\Shared\Transfer\TaskTransfer {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('haveTask', func_get_args()));
    }
}
