<?php namespace Ciarand\Midterm\Reporter;

use Ciarand\Midterm\Result\SpecResult;
use Ciarand\Midterm\Result\TestResult;

class DotReporter extends NullReporter
{
    /**
     * @var array<SpecResult>
     */
    protected $results = array();

    /**
     * @var int
     */
    protected $startTime;

    public function onTestBegin()
    {
        $this->startTime = microtime(true);
    }

    public function onSpecFail()
    {
        echo "F";
    }

    public function onSpecPass()
    {
        echo ".";
    }

    public function onUpdate(SpecResult $result)
    {
        $this->results[] = $result;
    }

    public function onTestEnd()
    {
        $this->printResourceStatistics();

        $this->printTestSummary();
    }

    protected function printResourceStatistics()
    {
        $totalTime = $this->startTime - microtime(true);
        $memory = memory_get_peak_usage(true) / 1048576;

        echo PHP_EOL;
        printf(
            "Time: %d seconds, Memory: %4.2fMb" . PHP_EOL,
            $totalTime,
            $memory
        );
        echo PHP_EOL;
    }

    protected function printTestSummary()
    {
        $failures = array_filter($this->results, function ($result) {
            return $result->didFail();
        });

        if (count($failures) === 0) {
            return printf("OK (%d tests)" . PHP_EOL, count($this->results));
        }

        printf("FAILURES!" . PHP_EOL . "Failures: %d", count($failures));

        echo PHP_EOL;

        foreach ($failures as $index => $failure) {
            printf(
                "%d) %s: %s\n",
                $index + 1,
                $failure->title,
                $failure->getMessage()
            );
        }
    }

    protected function getSubscriptions()
    {
        return array(
            "test_begin" => array($this, "onTestBegin"),
            "test_end"   => array($this, "onTestEnd"),
            "update"     => array($this, "onUpdate"),
            "spec_fail"  => array($this, "onSpecFail"),
            "spec_pass"  => array($this, "onSpecPass"),
        );
    }
}
