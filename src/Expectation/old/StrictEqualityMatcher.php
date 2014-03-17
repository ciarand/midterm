<?php namespace Ciarand\Midterm\Expectation;

use Ciarand\Midterm\BaseComponent;

class StrictEqualityMatcher extends BaseMatcher
{
    public function test($actual)
    {
        return ($this->actual = $actual) === $this->expected;
    }

    public function getMessage()
    {
        //TODO need to abstract printing values out to another class
        return sprintf(
            "Expected %s to be %s",
            rtrim(print_r($this->actual, true)),
            rtrim(print_r($this->expected, true))
        );
    }
}
