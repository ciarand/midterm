<?php namespace Ciarand\Midterm\Expectation;

use Exception;

class CallbackExpectation extends AbstractExpectation
{
    public function toThrow(Exception $exception = null)
    {
        $exception = $exception ?: new Exception;

        try {
            $this->runCallback();
        } catch (Exception $e) {
            $this->message = sprintf(
                "Exception (%s) was not an instanceof %s",
                get_class($e),
                get_class($exception)
            );

            return $this->check($e instanceof $exception);
        }

        $this->message = "No exception thrown";

        return $this->check(false);
    }

    public function toOutput($expected)
    {
        $this->check($this->getOutput() === $expected);
    }

    protected function runCallback()
    {
        return call_user_func($this->actual);
    }

    public function output()
    {
        return new StringExpectation($this->getOutput());
    }

    protected function getOutput()
    {
        ob_start();
        $this->runCallback();
        return ob_get_clean();
    }
}
