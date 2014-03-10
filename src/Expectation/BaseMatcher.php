<?php namespace Ciarand\Midterm\Expectation;

use Ciarand\Midterm\BaseComponent;

abstract class BaseMatcher extends BaseComponent implements MatcherInterface
{
    protected $expected;

    public function __construct($expected)
    {
        $this->expected = $expected;
    }
}
