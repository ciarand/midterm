<?php namespace Ciarand\Midterm\Expectation;

use Ciarand\Midterm\Exception\SpecFailedException;
use Ciarand\Midterm\BaseComponent;
use Exception;

class Expectation extends BaseComponent
{
    /**
     * @var mixed
     */
    protected $actual;

    /**
     * Create a new Expectation based on the provided thing
     *
     * @param mixed $thing
     */
    public function __construct($actual)
    {
        $this->actual = $actual;
    }

    public function toBe($expected)
    {
        $matcher = new StrictEqualityMatcher($expected);

        $this->checkWith($matcher);
    }

    public function toBeAnInstanceOf($expected)
    {
        $matcher = new InstanceOfMatcher($expected);

        $this->checkWith($matcher);
    }

    public function output()
    {
        ob_start();

        $this->callback($this->actual);

        $this->actual = ob_get_clean();

        return $this;
    }

    public function toReturn($expected)
    {
        $this->actual = $this->callback($this->actual);

        return $this->toBe($expected);
    }

    public function toMatch($pattern)
    {
        $matcher = new StringPatternMatcher($pattern);

        $this->checkWith($matcher);
    }

    public function toThrow(Exception $exception)
    {
        $expectation = new ExceptionExpectation($this->actual);

        return $expectation->toThrow($exception);
    }

    protected function callback($thing)
    {
        if (is_callable($thing)) {
            return call_user_func($thing);
        }

        if (count($thing) > 2) {
            list($callback[0], $callback[1]) = array_slice($thing, 0, 2);
            return call_user_func_array($callback, array_slice($thing, 2));
        }

        throw new CallbackNotCallableException();
    }

    protected function checkWith(MatcherInterface $matcher)
    {
        if ($matcher->test($this->actual)) {
            return $this;
        }

        throw new SpecFailedException($matcher->getMessage());
    }

    protected function whenRun()
    {
        $this->callback($this->actual);
    }
}
