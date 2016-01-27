<?php
/**
 * ModuleRegistryTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry-Register
 */

namespace Foundry\Masonry\ModuleRegister\Test\PhpUnit;

use Foundry\Masonry\ModuleRegister\Interfaces\WorkerModuleDefinitionInterface;
use Foundry\Masonry\ModuleRegister\ModuleRegister;

/**
 * Class ModuleRegistryTest
 * @package Masonry-Register
 * @see     https://github.com/TheFoundryVisionmongers/Masonry-Register
 * @coversDefaultClass \Foundry\Masonry\ModuleRegister\ModuleRegister
 */
class ModuleRegistryTest extends TestCase
{

    /**
     * @test
     * @covers ::__construct
     */
    public function testConstruct()
    {
        $register = new ModuleRegister();
        $this->assertStringEndsWith(
            '/../register/register.yaml',
            $this->getObjectAttribute($register, 'fileLocation')
        );

        $testLocation = 'test location';
        $register = new ModuleRegister($testLocation);
        $this->assertSame(
            $testLocation,
            $this->getObjectAttribute($register, 'fileLocation')
        );
    }

    /**
     * @test
     * @covers ::getWorkerModules
     * @covers ::addWorkerModule
     */
    public function testGetWorkerModules()
    {
        $moduleName = 'module';
        /** @var WorkerModuleDefinitionInterface|\PHPUnit_Framework_MockObject_MockObject $module */
        $module = $this->getMockForAbstractClass(WorkerModuleDefinitionInterface::class);
        $module
            ->expects($this->once())
            ->method('getName')
            ->with()
            ->will($this->returnValue($moduleName));

        $register = new ModuleRegister();
        $this->assertEmpty(
            $register->getWorkerModules()
        );

        $this->assertSame(
            $register,
            $register->addWorkerModule($module)
        );

        $this->assertArrayHasKey(
            $moduleName,
            $register->getWorkerModules()
        );

        $this->assertContains(
            $module,
            $register->getWorkerModules()
        );
    }

    /**
     * @test
     * @covers ::getWorkerModule
     * @uses \Foundry\Masonry\ModuleRegister\ModuleRegister::addWorkerModule
     */
    public function testGetWorkerModule()
    {
        $moduleName = 'module';
        /** @var WorkerModuleDefinitionInterface|\PHPUnit_Framework_MockObject_MockObject $module */
        $module = $this->getMockForAbstractClass(WorkerModuleDefinitionInterface::class);
        $module
            ->expects($this->once())
            ->method('getName')
            ->with()
            ->will($this->returnValue($moduleName));

        $register = new ModuleRegister();
        $register->addWorkerModule($module);

        $this->assertSame(
            $module,
            $register->getWorkerModule($moduleName)
        );
    }

    /**
     * @test
     * @covers ::getWorkerModule
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Could not find module named
     */
    public function testGetWorkerModuleException()
    {
        $moduleName = 'module';
        $register = new ModuleRegister();
        $register->getWorkerModule($moduleName);
    }

    /**
     * @test
     * @covers ::addWorkerModules
     * @uses \Foundry\Masonry\ModuleRegister\ModuleRegister::addWorkerModule
     */
    public function testAddWorkerModules()
    {
        $module1Name = 'module1';
        $module2Name = 'module2';
        /** @var WorkerModuleDefinitionInterface|\PHPUnit_Framework_MockObject_MockObject $module1 */
        $module1 = $this->getMockForAbstractClass(WorkerModuleDefinitionInterface::class);
        $module1
            ->expects($this->once())
            ->method('getName')
            ->with()
            ->will($this->returnValue($module1Name));
        /** @var WorkerModuleDefinitionInterface|\PHPUnit_Framework_MockObject_MockObject $module2 */
        $module2 = $this->getMockForAbstractClass(WorkerModuleDefinitionInterface::class);
        $module1
            ->expects($this->once())
            ->method('getName')
            ->with()
            ->will($this->returnValue($module2Name));

        $modules = [
            $module1,
            $module2
        ];

        $register = new ModuleRegister();
        $this->assertEmpty(
            $this->getObjectAttribute($register, 'workerModules')
        );

        $this->assertSame(
            $register,
            $register->addWorkerModules($modules)
        );

        $this->assertContains(
            $module1,
            $this->getObjectAttribute($register, 'workerModules')
        );

        $this->assertContains(
            $module2,
            $this->getObjectAttribute($register, 'workerModules')
        );

        $this->assertContainsOnlyInstancesOf(
            WorkerModuleDefinitionInterface::class,
            $this->getObjectAttribute($register, 'workerModules')
        );
    }
}
