<?php namespace Ciarand\Midterm\Expectation;

class PendingExpectation extends AbstractExpectation
{
    public function run()
    {
        return new CallbackExpectation($this->actual);
    }
}
