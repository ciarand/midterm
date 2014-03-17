<?php namespace Ciarand\Midterm\Expectation;

use Ciarand\Midterm\BaseComponent;
use Ciarand\Midterm\Exception\SpecFailedException;
use Ciarand\Midterm\Presenter\PresenterFactory;

abstract class AbstractExpectation extends BaseComponent implements
    ExpectationInterface
{
    protected $negated = false;

    protected $actual;

    protected $message;

    protected $presenter;

    public function __construct($actual)
    {
        $this->actual = $actual;
    }

    public function check($boolean)
    {
        if ($this->negated) {
            $boolean = !$boolean;
            $this->message = "NEGATED: " . $this->message;
        }

        if ($boolean) {
            return;
        }

        throw new SpecFailedException($this->message);
    }

    public function not()
    {
        $this->negated = !(bool) $this->negated;

        return $this;
    }

    public function isNegated()
    {
        return (bool) $this->negated;
    }

    public function present($var)
    {
        if (!$this->presenter) {
            $this->presenter = new Presenterfactory;
        }

        return $this->presenter->present($var);
    }
}
