<?php

namespace kbATeam\MemoryContainer;

use Psr\Container\ContainerExceptionInterface;
use RuntimeException;

/**
 * Class kbATeam\MemoryContainer\ContainerException
 *
 * Generic memory container exception.
 *
 * @package kbATeam\MemoryContainer
 * @author  Gregor J.
 * @license MIT
 */
class ContainerException extends RuntimeException implements ContainerExceptionInterface
{
}
