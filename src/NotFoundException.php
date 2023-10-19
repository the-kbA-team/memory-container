<?php

namespace kbATeam\MemoryContainer;

use Psr\Container\NotFoundExceptionInterface;

/**
 * Class kbATeam\MemoryContainer\NotFoundException
 *
 * No entry was found in the container.
 *
 * @package kbATeam\MemoryContainer
 * @author  Gregor J.
 * @license MIT
 */
class NotFoundException extends ContainerException implements NotFoundExceptionInterface
{
}
