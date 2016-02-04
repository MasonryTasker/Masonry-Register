<?php
/**
 * WorkerModuleDefinitionTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry-Register
 */

namespace Foundry\Masonry\ModuleRegister\Test\PhpUnit;

use Foundry\Masonry\ModuleRegister\WorkerModuleDefinition;

/**
 * Class WorkerModuleDefinitionTest
 * ${CARET}
 * @package Masonry-Register
 * @see     https://github.com/TheFoundryVisionmongers/Masonry-Register
 * @coversDefaultClass \Foundry\Masonry\ModuleRegister\WorkerModuleDefinition
 */
class WorkerModuleDefinitionTest extends TestCase
{

    /**
     * @test
     * @covers ::__construct
     */
    public function testConstruct()
    {
        $name = 'name';
        $workers = [
            'Worker1' => [],
            'Worker2' => [],
        ];
        $descriptions = [
            'Description1' => [],
            'Description2' => [],
        ];
        $extra = [
            'something' => 'extra'
        ];

        $module = new WorkerModuleDefinition($name, $workers, $descriptions, $extra);

        $this->assertSame(
            $name,
            $this->getObjectAttribute($module, 'name')
        );
        $this->assertSame(
            $workers,
            $this->getObjectAttribute($module, 'workers')
        );
        $this->assertSame(
            $descriptions,
            $this->getObjectAttribute($module, 'descriptions')
        );
        $this->assertSame(
            $extra,
            $this->getObjectAttribute($module, 'extra')
        );
    }

    /**
     * @test
     * @covers ::getName
     */
    public function testGetName()
    {
        $name = 'name';
        $module = new WorkerModuleDefinition($name, [], []);

        $this->assertSame(
            $name,
            $module->getName()
        );
    }

    /**
     * @test
     * @covers ::getName
     * @expectedException \LogicException
     * @expectedExceptionMessage Module was never named
     */
    public function testGetNameException()
    {
        $module = new WorkerModuleDefinition(null, [], []);
        $module->getName();
    }

    /**
     * @test
     * @covers ::getWorkers
     */
    public function testGetWorkers()
    {
        $workers = [
            'Worker1' => [],
            'Worker2' => [],
        ];

        $module = new WorkerModuleDefinition(null, $workers, []);

        $this->assertSame(
            $workers,
            $module->getWorkers()
        );
    }

    /**
     * @test
     * @covers ::getDescriptions
     */
    public function testGetDescriptions()
    {
        $descriptions = [
            'Description1' => [],
            'Description2' => [],
        ];

        $module = new WorkerModuleDefinition(null, [], $descriptions);

        $this->assertSame(
            $descriptions,
            $module->getDescriptions()
        );
    }

    /**
     * @test
     * @covers ::getExtra
     */
    public function testGetExtra()
    {
        $extra = [
            'something' => 'extra'
        ];

        $module = new WorkerModuleDefinition(null, [], [], $extra);

        $this->assertSame(
            $extra,
            $module->getExtra()
        );
    }

    /**
     * @test
     * @covers ::getNameErrors
     */
    public function testGetNameErrors()
    {
        $module = new WorkerModuleDefinition(null, [], []);
        $getNameErrors = $this->getObjectMethod($module, 'getNameErrors');

        $testArray = [];
        $this->assertSame(
            'name key is missing',
            $getNameErrors($testArray)
        );

        $testArray = [
            'name' => []
        ];
        $this->assertSame(
            'name must be a string',
            $getNameErrors($testArray)
        );

        $testArray = [
            'name' => 'name'
        ];
        $this->assertFalse(
            $getNameErrors($testArray)
        );
    }

    /**
     * @test
     * @covers ::lookupDescription
     */
    public function testLookupDescriptionExact()
    {
        $description = 'Description1';
        $descriptions = [
            $description => []
        ];

        $module = new WorkerModuleDefinition(null, [], $descriptions);

        $this->assertSame(
            $description,
            $module->lookupDescription($description)
        );
    }

    /**
     * @test
     * @covers ::lookupDescription
     */
    public function testLookupDescriptionAlias()
    {
        $description = 'Description1';
        $alias1 = 'alias1';
        $alias2 = 'alias2';
        $descriptions = [
            $description => [$alias1, $alias2],
        ];

        $module = new WorkerModuleDefinition(null, [], $descriptions);

        $this->assertSame(
            $description,
            $module->lookupDescription($alias1)
        );
        $this->assertSame(
            $description,
            $module->lookupDescription($alias2)
        );
    }

    /**
     * @test
     * @covers ::lookupDescription
     * @expectedException \RuntimeException
     * @expectedExceptionMessage No description could be found matching name/anything
     */
    public function testLookupDescriptionException()
    {
        $descriptions = [
            'description' => 'no aliases'
        ];

        $module = new WorkerModuleDefinition('name', [], $descriptions);

        $module->lookupDescription('anything');
    }

    /**
     * @test
     * @covers ::flattenKeys
     */
    public function testFlattenKeys()
    {
        $module = new WorkerModuleDefinition(null, [], []);
        $flattenKeys = $this->getObjectMethod($module, 'flattenKeys');

        $test = [];
        $expected = [];

        $this->assertSame(
            $expected,
            $flattenKeys($test)
        );

        $test = [
            'kEy' => 'vAlUe',
            'kEy ' => 'vAlUe 2',
            'keY-2' => 'vAlUe-3',
            'kEy-2' => 'value 4'
        ];
        $expected = [
            'key' => 'vAlUe',
            'key ' => 'vAlUe 2',
            'key-2' => 'value 4'
        ];

        $this->assertSame(
            $expected,
            $flattenKeys($test)
        );
    }
}
