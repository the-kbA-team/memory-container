<?php
/**
 * File src/Container.php
 *
 * PSR-11 container class.
 *
 * @package memory-container
 * @author  Gregor J.
 * @license MIT
 */

namespace kbATeam\MemoryContainer;

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
    private $storage = [];

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     * @throws \kbATeam\MemoryContainer\NotFoundException No entry was found for **this** identifier.
     * @throws \kbATeam\MemoryContainer\ContainerException Error while retrieving the entry.
     * @throws \InvalidArgumentException The ID was no string or an empty string.
     * @return mixed Entry.
     */
    public function get($id)
    {
        $stringId = $this->validateId($id);
        if ($this->has($stringId)) {
            return $this->storage[$stringId];
        }
        throw new NotFoundException(sprintf('Requested ID %s not found', $stringId));
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
     * @throws \InvalidArgumentException The ID was no string or an empty string.
     */
    public function has($id)
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
     * @throws \InvalidArgumentException The ID was no string or an empty string.
     */
    public function set($id, $value)
    {
        $stringId = $this->validateId($id);
        $this->storage[$stringId] = $value;
    }

    /**
     * Validate an ID for the other methods.
     * @param mixed $id The ID to validate.
     * @return string
     * @throws \InvalidArgumentException The ID was no string or an empty string.
     */
    protected function validateId($id)
    {
        if (!is_string($id)) {
            throw new \InvalidArgumentException('Expected ID to be a string!');
        }
        $resultId = trim($id);
        if ($resultId === '') {
            throw new \InvalidArgumentException('Expected ID to have at least one character.');
        }
        return $resultId;
    }

    /**
     * Always returns the same container instance.
     *
     * Singleton pattern taken from Stackoverflow ;-)
     * https://stackoverflow.com/questions/203336/creating-the-singleton-design-pattern-in-php5
     *
     * @return \kbATeam\MemoryContainer\Container
     */
    public static function singleton()
    {
        static $instance = null;
        if ($instance === null) {
            $instance = new static();
        }
        return $instance;
    }
}
