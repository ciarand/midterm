<?php namespace Ciarand\Midterm\Expectation;

class BehaviorExpectation extends AbstractExpectation
{
    /**
     * @SuppressWarnings(PHPMD.ShortMethodNames)
     */
    public function be()
    {
        return new IdentityExpectation($this->actual);
    }
}
