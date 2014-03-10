<?php namespace Ciarand\Midterm\Expectation;

class StringPatternMatcher extends BaseMatcher
{
    protected $pattern;

    protected $actual;

    public function __construct($pattern)
    {
        $this->pattern = $pattern;
    }

    public function test($actual)
    {
        $this->actual = $actual;

        return preg_match($this->pattern, $actual) === 1;
    }

    public function getMessage()
    {
        return sprintf(
            'Provided pattern ("%s") did not match output ("%s")',
            $this->pattern,
            $this->actual
        );
    }
}
