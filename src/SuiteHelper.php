<?php namespace Ciarand\Midterm;

use Exception;
use ArrayAccess;
use Countable;

class SuiteHelper extends EventEmitter implements
    ArrayAccess,
    Countable
{
    /**
     * A variable array to share vars between specs
     *
     * @var array<mixed>
     */
    public $vars = array();

    /**
     * Checks whether the given offset exists in the array
     *
     * @param mixed $offset
     */
    public function offsetExists($offset)
    {
        return isset($this->vars[$offset]);
    }

    /**
     * Returns the value for the given offset
     *
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->vars[$offset];
    }

    /**
     * Sets the value for the given offset
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->vars[$offset] = $value;
    }

    /**
     * Unsets the value for the given offset
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->vars[$offset]);
    }

    public function fail($message = "")
    {
        $this->emit("fail", (array) $message);
    }

    public function skip($message = "")
    {
        $this->emit("skip", (array) $message);
    }

    public function count()
    {
        return count($this->vars);
    }

    public function export()
    {
        return $this->vars;
    }

    public function inject(array $array)
    {
        $this->vars = $array + $this->vars;
    }
}
