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
use org\bovigo\vfs\vfsStream;

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

    /**
     * @test
     * @covers ::save
     * @uses \Foundry\Masonry\ModuleRegister\ModuleRegister::toArray
     */
    public function testSave()
    {
        $registerFile = 'register.yaml';
        $vfs = vfsStream::setup('root');

        $register = new ModuleRegister($vfs->url() . '/' . $registerFile);

        $this->assertFalse(
            $vfs->hasChild($registerFile)
        );

        $register->save();

        $this->assertTrue(
            $vfs->hasChild($registerFile)
        );
    }

    /**
     * @test
     * @covers ::load
     * @uses \Foundry\Masonry\ModuleRegister\ModuleRegister::fromArray
     */
    public function testLoadFileExists()
    {
        $registerFile = 'register.yaml';
        $vfs = vfsStream::setup('root', null, [
            $registerFile => ''
        ]);

        $this->assertTrue(
            $vfs->hasChild($registerFile)
        );

        $register = ModuleRegister::load($vfs->url() . '/' . $registerFile);

        $this->assertSame(
            $vfs->url() . '/' . $registerFile,
            $this->getObjectAttribute($register, 'fileLocation')
        );

        $this->assertEmpty(
            $this->getObjectAttribute($register, 'workerModules')
        );
    }

    /**
     * @test
     * @covers ::load
     * @uses \Foundry\Masonry\ModuleRegister\ModuleRegister::fromArray
     */
    public function testLoadFileNotExists()
    {
        $registerFile = 'register.yaml';
        $vfs = vfsStream::setup('root');

        $this->assertFalse(
            $vfs->hasChild($registerFile)
        );

        $register = ModuleRegister::load($vfs->url() . '/' . $registerFile);

        $this->assertTrue(
            $vfs->hasChild($registerFile)
        );

        $this->assertSame(
            $vfs->url() . '/' . $registerFile,
            $this->getObjectAttribute($register, 'fileLocation')
        );

        $this->assertEmpty(
            $this->getObjectAttribute($register, 'workerModules')
        );
    }

    /**
     * @test
     * @covers ::toArray
     */
    public function testToArray()
    {
        $module1 = $this->getMockForAbstractClass(WorkerModuleDefinitionInterface::class);
        $module2 = $this->getMockForAbstractClass(WorkerModuleDefinitionInterface::class);

        $module1
            ->expects($this->exactly(3))
            ->method('getName')
            ->with()
            ->will($this->returnValue('Module1'));
        $module1
            ->expects($this->once())
            ->method('getWorkers')
            ->with()
            ->will($this->returnValue([]));
        $module1
            ->expects($this->once())
            ->method('getDescriptions')
            ->with()
            ->will($this->returnValue([]));
        $module1
            ->expects($this->once())
            ->method('getExtra')
            ->with()
            ->will($this->returnValue([]));

        $module2
            ->expects($this->exactly(3))
            ->method('getName')
            ->with()
            ->will($this->returnValue('Module2'));
        $module2
            ->expects($this->once())
            ->method('getWorkers')
            ->with()
            ->will($this->returnValue([
                'Worker1',
                'Worker2',
            ]));
        $module2
            ->expects($this->once())
            ->method('getDescriptions')
            ->with()
            ->will($this->returnValue([
                'Description1',
                'Description2',
            ]));
        $module2
            ->expects($this->once())
            ->method('getExtra')
            ->with()
            ->will($this->returnValue([
                'something' => 'extra',
            ]));


        $register = new ModuleRegister();

        $register->addWorkerModules([
            $module1,
            $module2,
        ]);

        $expected = [
            'workerModules' => [
                'Module1' => [
                    'name' => 'Module1',
                    'workers' => [],
                    'descriptions' => [],
                    'extra' => [],
                ],
                'Module2' => [
                    'name' => 'Module2',
                    'workers' => [
                        'Worker1',
                        'Worker2',
                    ],
                    'descriptions' => [
                        'Description1',
                        'Description2',
                    ],
                    'extra' => [
                        'something' => 'extra'
                    ],
                ],
            ],
        ];

        $toArray = $this->getObjectMethod($register, 'toArray');
        $this->assertSame(
            $expected,
            $toArray()
        );
    }
}
