<?php

namespace Tests\kbATeam\MemoryContainer;

use kbATeam\MemoryContainer\Container;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

/**
 * Class Tests\kbATeam\MemoryContainer\ContainerTest
 *
 * Test the container class.
 *
 * @package Tests\kbATeam\MemoryContainer
 * @author  Gregor J.
 * @license MIT
 */
class ContainerTest extends TestCase
{
    /**
     * Test for PSR-11 container interface.
     */
    public function testInheritance()
    {
        $container = new Container();
        static::assertInstanceOf(ContainerInterface::class, $container);
    }

    /**
     * Test a trivial set, has and get.
     */
    public function testSimpleAddHasGet()
    {
        $container = new Container();
        $container->set('wP7rpYZg', new \stdClass());
        static::assertTrue($container->has('wP7rpYZg'));
        $result = $container->get('wP7rpYZg');
        static::assertInstanceOf(\stdClass::class, $result);
    }

    /**
     * Test retrieving a non-existent entry.
     */
    public function testNotFoundException()
    {
        $container = new Container();
        $this->expectException(\kbATeam\MemoryContainer\NotFoundException::class);
        $this->expectExceptionMessage('tuToievS not found');
        $container->get('tuToievS');
    }

    /**
     * Data provider for invalid IDs.
     * @return array
     */
    public static function invalidIds()
    {
        return [
            [''],
            ["\t"],
            [' '],
            [187],
            [56.2],
            [null],
            [true],
            [false],
            [new \stdClass()]
        ];
    }

    /**
     * Test invalid IDs on the has method.
     * @param mixed $id The invalid ID.
     * @dataProvider invalidIds
     */
    public function testInvalidIdsOnHas($id)
    {
        $container = new Container();
        $this->expectException(\InvalidArgumentException::class);
        $container->has($id);
    }

    /**
     * Test invalid IDs on the get method.
     * @param mixed $id The invalid ID.
     * @dataProvider invalidIds
     */
    public function testInvalidIdsOnGet($id)
    {
        $container = new Container();
        $this->expectException(\InvalidArgumentException::class);
        $container->get($id);
    }

    /**
     * Test invalid IDs on the set method.
     * @param mixed $id The invalid ID.
     * @dataProvider invalidIds
     */
    public function testInvalidIdsOnSet($id)
    {
        $container = new Container();
        $this->expectException(\InvalidArgumentException::class);
        $container->set($id, null);
    }

    /**
     * Test if two variables contain the same object.
     */
    public function testSingleton()
    {
        $container1 = Container::singleton();
        $container2 = Container::singleton();
        static::assertSame($container1, $container2);
    }
}
