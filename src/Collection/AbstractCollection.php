<?php namespace Ciarand\Midterm\Collection;

use Iterator;
use ArrayAccess;
use Countable;
use ArrayIterator;
use Exception;

use Ciarand\Midterm\BaseComponent;

/**
 * An AbstractCollection is an abstract implementation of an array-like 
 * collection that only takes elements of a certain class. This helps to fight 
 * the stupidity that is unclear typehinting and loosely typed arrays.
 */
abstract class AbstractCollection extends BaseComponent implements
    Iterator,
    ArrayAccess,
    Countable
{
    protected $data = array();

    public function __construct(array $array = array())
    {
        $this->guard($array);

        $this->data = $array;
    }

    public function current()
    {
        return current($this->data);
    }

    public function end()
    {
        return end($this->data);
    }

    public function key()
    {
        return key($this->data);
    }

    public function next()
    {
        return next($this->data);
    }

    public function rewind()
    {
        return reset($this->data);
    }

    public function valid()
    {
        return key($this->data) !== null;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->guard($value);

        is_null($offset)
            ? $this->data[] = $value
            : $this->data[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    public function count()
    {
        return count($this->data);
    }

    protected function guard($data)
    {
        $invalid = is_array($data)
            ? $this->filterArray($data)
            : ($this->filter($data) ? array() : array($data));

        if (count($invalid) === 0) {
            return;
        }

        $message = sprintf(
            "%s is an invalid data type for %s",
            get_class(reset($invalid)),
            get_class($this)
        );

        throw new Exception($message);
    }

    protected function filterArray($data)
    {
        if (count($data) === 0) {
            return array();
        }

        $self = $this;

        return array_filter($data, function ($elem) use ($self) {
            return !$self->filter($elem);
        });
    }

    abstract public function filter($value);
}
