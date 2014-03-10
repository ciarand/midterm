<?php namespace Ciarand\Midterm\Result;

use SplStack;
use Ciarand\Midterm\Reporter\ReporterInterface;
use Ciarand\Midterm\EventEmitter;
use Ciarand\Midterm\Suite;

class TestResult extends EventEmitter
{
    /**
     * @var SplQueue
     */
    protected $suiteStack;

    /**
     * @var array
     */
    protected $specs = array();

    /**
     * @var array
     */
    protected $suites = array();

    /**
     * Initializes the object
     *
     * @param array<Suites>
     */
    public function __construct(array $suites)
    {
        $this->suiteStack = new SplStack;

        $this->suites = $suites;
    }

    /**
     * Emits the "test_begin" event
     */
    public function beginTest()
    {
        foreach ($this->suites as $suite) {
            foreach ($suite->specs as $spec) {
                $this->specs[] = $spec;
            }
        }

        $this->emit("test_begin");
    }

    /**
     * Emits the "test_end" event
     */
    public function endTest()
    {
        $this->emit("test_end");
    }

    /**
     * @param SpecResult $result
     */
    public function broadcastUpdate(SpecResult $result)
    {
        $events = $result->didFail()
            ? array('update', 'spec_fail')
            : array('update', 'spec_pass');

        foreach ($events as $event) {
            $this->emit($event, array($result));
        }
    }

    /**
     * Sets the current suite being tested
     */
    public function setCurrentSuite(Suite $suite)
    {
        $this->suiteStack->push($suite);

        $suite->on("update", array($this, "broadcastUpdate"));
        $suite->on("begin", array($this, "onSuiteBegin"));
        $suite->on("end", array($this, "onSuiteEnd"));
    }

    /**
     * Removes a Suite from the stack and propagates the event up
     */
    public function onSuiteEnd()
    {
        $this->suiteStack->pop();

        $this->emit("suite_end");
    }

    /**
     * Propagates the event up
     */
    public function onSuiteBegin()
    {
        $this->emit("suite_begin");
    }

    public function countSpecs()
    {
        return count($this->specs);
    }

    public function getCurrentSuite()
    {
        return $this->suiteStack->current();
    }
}
