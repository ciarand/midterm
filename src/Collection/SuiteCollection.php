<?php namespace Ciarand\Midterm\Collection;

use Ciarand\Midterm\Suite;

class SuiteCollection extends AbstractCollection
{
    protected function filter($value)
    {
        return $value instanceof Suite;
    }
}
