<?php

/**
 * Part of the Fusion.Collection package.
 *
 * @license MIT
 */

declare(strict_types=1);

namespace Fusion\Collection\Contracts;

use Fusion\Collection\Exceptions\CollectionException;
use ArrayAccess;
use Iterator;

/**
 * Implements core functionality for collections.
 *
 * @since 1.0.0
 */
abstract class AbstractCollection implements CollectionCoreInterface, ArrayAccess, Iterator
{
    /**
     * The internal collection container.
     *
     * @var array
     */
    protected $collection = [];

    /** {@inheritdoc} */
    public function clear(): void
    {
        $this->collection = [];
    }

    /** {@inheritdoc} */
    public function remove($item): void
    {
        foreach ($this->collection as $key => $value)
        {
            if ($item === $value)
            {
                $this->removeAt($key);
            }
        }
    }

    /** {@inheritdoc} */
    public function removeAt($key): void
    {
        if ($this->offsetExists($key))
        {
            if (is_int($key))
            {
                array_splice($this->collection, $key, 1);
            }
            else if (is_string($key))
            {
                unset($this->collection[$key]);
            }
        }
    }

    /**
     * Checks if an offset exists in the collection.
     *
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->collection);
    }

    /**
     * Retrieves a value at the given offset.
     *
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->collection[$offset];
    }

    /**
     * Sets a value at the given offset.
     *
     * This method will throw a `CollectionException` if the offset does not exist.
     *
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset
     * @param mixed $value
     *
     * @return void
     *
     * @throws \Fusion\Collection\Exceptions\CollectionException
     */
    public function offsetSet($offset, $value): void
    {
        $this->throwExceptionIfValueIsNull($value);
        $this->collection[$offset] = $value;
    }

    /**
     * Removes a value at the given offset.
     *
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset
     *
     * @return void
     */
    public function offsetUnset($offset): void
    {
        if ($this->offsetExists($offset))
        {
            $this->removeAt($offset);
        }
    }

    /**
     * Checks if a given value is `null` and throws an exception if so.
     *
     * @param mixed $value
     *
     * @throws \Fusion\Collection\Exceptions\CollectionException
     *
     * @return void
     */
    protected function throwExceptionIfValueIsNull($value): void
    {
        if ($value === null)
        {
            throw new CollectionException('Collection operations will not accept null values.');
        }
    }

    /**
     * Checks if a given offset exists in the collection and throws and exception if it does not.
     *
     * @see \Fusion\Collection\Contracts\AbstractCollection::offsetExists()
     *
     * @param mixed $offset
     *
     * @throws \Fusion\Collection\Exceptions\CollectionException
     *
     * @return void
     */
    protected function throwExceptionIfOffsetDoesNotExist($offset): void
    {
        if ($this->offsetExists($offset) === false)
        {
            throw new CollectionException("The key '$offset' does not exist in the collection.");
        }
    }

    /**
     * Returns the current element in the collection.
     *
     * @link http://php.net/manual/en/iterator.current.php
     *
     * @return mixed
     */
    public function current()
    {
        return current($this->collection);
    }

    /**
     * Move forward to the next element in the collection.
     *
     * @link http://php.net/manual/en/iterator.next.php
     *
     * @return void
     */
    public function next(): void
    {
        next($this->collection);
    }

    /**
     * Return the key of the current element in the collection.
     *
     * @link http://php.net/manual/en/iterator.key.php
     *
     * @return mixed
     */
    public function key()
    {
        return key($this->collection);
    }

    /**
     * Checks if the current element position is valid.
     *
     * @link http://php.net/manual/en/iterator.valid.php
     *
     * @return bool
     */
    public function valid(): bool
    {
        return key($this->collection) !== null;
    }

    /**
     * Rewind the collection's position to the first index.
     *
     * @link http://php.net/manual/en/iterator.rewind.php
     *
     * @return void
     */
    public function rewind(): void
    {
        reset($this->collection);
    }

    /**
     * Returns of count of the elements in a collection.
     *
     * @link http://php.net/manual/en/countable.count.php
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->collection);
    }
}