<?php namespace Ciarand\Midterm\Expectation;

class InstanceOfMatcher extends BaseMatcher
{
    public function test($actual)
    {
        $this->actual = $actual;

        return $this->actual instanceof $this->expected;
    }

    public function getMessage()
    {
        return sprintf(
            "Expected %s, found %s",
            $this->expected,
            get_class($this->actual)
        );
    }
}
