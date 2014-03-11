<?php namespace Ciarand\Midterm;

use Ciarand\Midterm\Reporter\ReporterInterface;
use Ciarand\Midterm\Result\TestResult;

/**
 * The Midterm class is the driver for the tests. It holds the list of
 * reporters and test suites and is responsible for beginning the test run (via
 * `go()`)
 */
class Midterm extends BaseComponent
{
    /**
     * A collection of reporters
     *
     * @var array<ReporterInterface>
     */
    protected $reporters = array();

    /**
     * A collection of Suites to run
     *
     * @var array<Suite>
     */
    protected $suites = array();

    protected $exitCode = 0;

    /**
     * Runs each of the specs
     *
     * @SuppressWarnings(PHPMD.ShortMethodNames)
     */
    public function go()
    {
        $result = new TestResult($this->suites);
        $result->on("spec_fail", array($this, "onSpecFail"));

        foreach ($this->reporters as $reporter) {
            $reporter->subscribe($result);
        }

        $result->beginTest();

        foreach ($this->suites as $suite) {
            $result->setCurrentSuite($suite);
            $suite->run();
        }

        $result->endTest();

        return $this->exitCode;
    }

    /**
     * Takes a file glob and runs all files that match the glob
     *
     * @param string $glob
     */
    public function addGlob($glob)
    {
        …($glob);
    }

    /**
     * Adds a suite to the list of suites to run
     *
     * @param Suite $suite
     */
    public function addSuite(Suite $suite)
    {
        $this->suites[] = $suite;
    }

    /**
     * Adds a reporter
     *
     * @param ReporterInterface $reporter
     */
    public function addReporter(ReporterInterface $reporter)
    {
        $this->reporters[] = $reporter;
    }

    /**
     * Gets the current active Suite object
     *
     * @return Suite
     */
    public function getCurrentSuite()
    {
        return end($this->suites);
    }

    public function onSpecFail()
    {
        $this->exitCode = 1;
    }
}
