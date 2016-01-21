<?php
/**
 * ConfigValuesTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license   MIT
 * @see       https://github.com/TheFoundryVisionmongers/Masonry-Register
 */

namespace Foundry\Masonry\ModuleRegister\Test\PhpUnit\Command\Traits;

use Foundry\Masonry\ModuleRegister\Command\Traits\ConfigValues;

/**
 * Trait ConfigValuesTest
 * @package Masonry-Register
 * @see     https://github.com/TheFoundryVisionmongers/Masonry-Register
 */
trait ConfigValuesTest
{
    /**
     * @return ConfigValues
     */
    abstract protected function getTestSubject();

    /**
     * @test
     * @covers ::getConfigValuesOption
     */
    public function testGetConfigValuesOption()
    {
        $testSubject = $this->getTestSubject();
        $getConfigValuesOption = $this->getObjectMethod($testSubject, 'getConfigValuesOption');
        $this->assertSame(
            'config-values',
            $getConfigValuesOption()
        );
    }
}
