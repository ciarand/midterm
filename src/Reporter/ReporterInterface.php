<?php namespace Ciarand\Midterm\Reporter;

use Ciarand\Midterm\Result\TestResult;

interface ReporterInterface
{
    public function __construct($output);

    public function subscribe(TestResult $result);
}
