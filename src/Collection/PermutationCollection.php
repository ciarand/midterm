<?php namespace Ciarand\Midterm\Collection;

use Ciarand\Midterm\Spec\Permutation;

class PermutationCollection extends AbstractCollection
{
    public function filter($value)
    {
        return $value instanceof Permutation;
    }
}
