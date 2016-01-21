<?php
/**
 * TestCase.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry-Register
 */

namespace Foundry\Masonry\ModuleRegister\Test\PhpUnit;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class TestCase
 * An extension of PHPUnits test case
 * @package Masonry-Register
 * @see     https://github.com/TheFoundryVisionmongers/Masonry-Register
 */
class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Gets returns a proxy for any method of an object, regardless of scope
     * @param object $object Any object
     * @param string $methodName The name of the method you want to proxy
     * @return \Closure
     */
    protected function getObjectMethod($object, $methodName)
    {
        if (!is_object($object)) {
            throw new \InvalidArgumentException('Can not get method of non object');
        }
        $reflectionMethod = new \ReflectionMethod($object, $methodName);
        $reflectionMethod->setAccessible(true);
        return function () use ($object, $reflectionMethod) {
            return $reflectionMethod->invokeArgs($object, func_get_args());
        };
    }

    /**
     * @return InputInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    public function getMockInput()
    {
        return $this->getMockForAbstractClass(InputInterface::class);
    }

    /**
     * @return OutputInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    public function getMockOutput()
    {
        return $this->getMockForAbstractClass(OutputInterface::class);
    }
}
