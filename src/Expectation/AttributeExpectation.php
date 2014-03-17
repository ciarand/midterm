<?php namespace Ciarand\Midterm\Expectation;

class AttributeExpectation extends AbstractExpectation
{
    public function key($key)
    {
        $this->message = "Key {$key} was not in provided array";

        //TODO throw a smarter exception if $actual is not an array
        $this->check(array_key_exists($key, $this->actual));
    }

    public function property($prop)
    {
        $this->message = "Object does not have property {$prop}";

        $this->check(property_exists($this->actual, $prop));
    }

    public function count($count)
    {
        $actual = count($this->actual);

        $this->message = "Count ($count) did not match actual count ($actual)";

        $this->check($count === $actual);
    }

    public function length($count)
    {
        return $this->count($count);
    }

    public function element($elem)
    {
        $this->message = "Element was not found in array";

        $this->check(in_array($elem, $this->actual, true));
    }
}
