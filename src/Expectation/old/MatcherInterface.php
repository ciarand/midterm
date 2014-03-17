<?php namespace Ciarand\Midterm\Expectation;

interface MatcherInterface
{
    public function test($actual);

    public function getMessage();
}
