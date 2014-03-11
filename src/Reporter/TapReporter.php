<?php namespace Ciarand\Midterm\Reporter;

use Ciarand\Midterm\Result\SpecResult;
use Ciarand\Midterm\Suite;

class TapReporter extends NullReporter
{
    protected $count = 0;

    public function onTestBegin()
    {
        $this->write("TAP version 13\n");

        $this->write("1..%d\n", $this->result->countSpecs());
    }

    public function onSpecFail(SpecResult $result)
    {
        $this->write(
            "not ok %d - %s: %s",
            ++$this->count,
            $result->title,
            $result->getMessage()
        );

        $this->write("\n");
    }

    public function onSpecPass(SpecResult $result)
    {
        $this->write(
            "ok %d - %s",
            ++$this->count,
            $result->title
        );

        $this->write("\n");
    }

    public function onSuiteBegin()
    {
        $suite = $this->result->getCurrentSuite();

        //return $this->write("# %s\n", $suite->title);
        return $this->write("# New suite\n");
    }

    protected function getSubscriptions()
    {
        return array(
            "spec_fail"  => array($this, "onSpecFail"),
            "spec_pass"  => array($this, "onSpecPass"),
            //"test_begin" => array($this, "onTestBegin"),
            //"test_end"   => array($this, "onTestEnd"),
            "suite_begin" => array($this, "onSuiteBegin"),
            //"suite_end"   => array($this, "onSuiteEnd"),
        );
    }
}
