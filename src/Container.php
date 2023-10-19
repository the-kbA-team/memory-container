<?php

declare(strict_types=1);

namespace kbATeam\MemoryContainer;

use InvalidArgumentException;
use Psr\Container\ContainerInterface;

/**
 * Class kbATeam\MemoryContainer\Container
 *
 * PSR-11 container storing its values in memory and offering a singleton access.
 *
 * @package kbATeam\MemoryContainer
 * @author  Gregor J.
 * @license MIT
 */
class Container implements ContainerInterface
{
    /**
     * @var array in-memory storage
     */
    private array $storage = [];

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     * @return mixed Entry.
     * @throws ContainerException Error while retrieving the entry.
     * @throws InvalidArgumentException The ID was no string or an empty string.
     * @throws NotFoundException No entry was found for **this** identifier.
     */
    public function get(string $id)
    {
        $stringId = $this->validateId($id);
        if ($this->has($stringId)) {
            return $this->storage[$stringId];
        }
        throw new NotFoundException(sprintf('%s not found', $stringId));
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * `has($id)` returning true does not mean that `get($id)` will not throw an
     * exception. It does however mean that `get($id)` will not throw a
     * `NotFoundExceptionInterface`.
     *
     * @param string $id Identifier of the entry to look for.
     * @return bool
     * @throws InvalidArgumentException The ID was no string or an empty string.
     */
    public function has(string $id): bool
    {
        return array_key_exists($this->validateId($id), $this->storage);
    }

    /**
     * Set an entry in the container.
     *
     * An existing entry will be overwritten without notice.
     *
     * @param string $id Identifier of the entry to add.
     * @param mixed $value Content of the entry to add.
     * @throws InvalidArgumentException The ID was no string or an empty string.
     */
    public function set(string $id, $value)
    {
        $stringId = $this->validateId($id);
        $this->storage[$stringId] = $value;
    }

    /**
     * Validate an ID for the other methods.
     * @param string $id The ID to validate.
     * @return string
     * @throws InvalidArgumentException The ID was no string or an empty string.
     */
    protected function validateId(string $id): string
    {
        $resultId = trim($id);
        if ($resultId === '') {
            throw new InvalidArgumentException('Expected ID to have at least one character.');
        }
        return $resultId;
    }

    /**
     * Always returns the same container instance.
     *
     * Singleton pattern taken from Stackoverflow ;-)
     * https://stackoverflow.com/questions/203336/creating-the-singleton-design-pattern-in-php5
     *
     * @return Container
     */
    public static function singleton(): Container
    {
        static $instance = null;
        if ($instance === null) {
            $instance = new static();
        }
        return $instance;
    }
}
