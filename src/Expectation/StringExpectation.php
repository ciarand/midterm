<?php namespace Ciarand\Midterm\Expectation;

class StringExpectation extends AbstractExpectation
{
    /**
     * @SuppressWarnings(PHPMD.ShortMethodNames)
     */
    public function to()
    {
        return $this;
    }

    public function contain($needle)
    {
        $this->message = sprintf(
            "%s was not found in %s",
            $needle,
            $this->actual
        );

        $this->check(strpos($this->actual, $needle) !== false);
    }

    public function beginWith($needle)
    {
        $this->message = sprintf(
            "%s does not begin with %s",
            $this->actual,
            $needle
        );

        $this->check(substr($this->actual, 0, strlen($needle)) === $needle);
    }

    public function endWith($needle)
    {
        $this->message = sprintf(
            "%s does not end with %s",
            $this->actual,
            $needle
        );

        $this->check(substr($this->actual, -strlen($needle)) === $needle);
    }

    public function match($pattern)
    {
        $this->message = sprintf(
            "Pattern %s does not match subject %s",
            $pattern,
            $this->actual
        );

        $this->check(preg_match($pattern, $this->actual) === 1);
    }
}
