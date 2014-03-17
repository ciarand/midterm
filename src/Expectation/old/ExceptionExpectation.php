<?php namespace Ciarand\Midterm\Expectation;

use Ciarand\Midterm\Exception\SpecFailedException;
use Ciarand\Midterm\BaseComponent;
use Exception;

class ExceptionExpectation extends BaseComponent
{
    protected $expectedMessage;
    protected $expectedType;
    protected $exception;

    public function __construct($callback)
    {
        $this->callback = $callback;
    }

    public function whenRun()
    {
        try {
            call_user_func($this->callback);
        } catch (Exception $e) {
            $this->exception = $e;
        }

        $this->checkException();
    }

    public function withMessage($message)
    {
        $this->messageMatcher = new StrictEqualityMatcher($message);

        return $this;
    }

    public function toThrow($type)
    {
        $this->typeMatcher = new InstanceOfMatcher($type);

        return $this;
    }

    public function checkException()
    {
        if ($this->typeMatcher) {
            $this->checkMatcher($this->typeMatcher, $this->exception);
        }

        if ($this->messageMatcher) {
            $this->checkMatcher(
                $this->messageMatcher,
                $this->exception->getMessage()
            );
        }
    }

    protected function checkMatcher(MatcherInterface $matcher, $actual)
    {
        if ($matcher->test($actual)) {
            return $this;
        }

        throw new SpecFailedException($matcher->getMessage());
    }
}
