<?php
/**
 * File src/NotFoundException.php
 *
 * No entry found exception.
 *
 * @package memory-container
 * @author  Gregor J.
 * @license MIT
 */

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
