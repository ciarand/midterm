<?php namespace Ciarand\Midterm\Expectation;

use Ciarand\Midterm\Exception\SpecFailedException;
use Ciarand\Midterm\BaseComponent;

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
        $comparator = new StrictEqualityMatcher($this->actual);

        $this->checkWith($comparator, $expected);
    }

    public function output()
    {
        ob_start();

        $this->callback($this->actual);

        $this->actual = ob_get_clean();

        return $this;
    }

    public function toMatch($pattern)
    {
        $comparator = new StringPatternMatcher($pattern);

        $this->checkWith($comparator);
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

    protected function checkWith(MatcherInterface $comparator)
    {
        if ($comparator->test($this->actual)) {
            return $this;
        }

        throw new SpecFailedException($comparator->getMessage());
    }
}
