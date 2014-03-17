<?php namespace Ciarand\Midterm\Expectation;

/**
* @SuppressWarnings(PHPMD.ShortMethodNames)
*/
class AmorphousExpectation extends AbstractExpectation
{
    public function to()
    {
        return new BehaviorExpectation($this->actual);
    }

    public function when()
    {
        return new PendingExpectation($this->actual);
    }

    public function asA()
    {
        return new TypeExpectation($this->actual);
    }

    public function toBe()
    {
        return new IdentityExpectation($this->actual);
    }

    public function whenRun()
    {
        return new CallbackExpectation($this->actual);
    }

    public function toHave()
    {
        return new AttributeExpectation($this->actual);
    }

    public function __call($name, $args)
    {
        // PHP normally wouldn't let you use "as" as a method name
        if ($name === "as") {
            return call_user_func_array(array($this, "asA"), $args);
        }

        return parent::__call();
    }
}
