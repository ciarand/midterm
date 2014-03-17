<?php namespace Ciarand\Midterm\Expectation;

class TypeExpectation extends AbstractExpectation
{
    public function string()
    {
        return new StringExpectation($this->actual);
    }
}
