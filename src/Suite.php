<?php namespace Ciarand\Midterm;

use Countable;
use Ciarand\Midterm\Result\SpecResult;

class Suite extends EventEmitter implements Countable
{
    /**
     * @var string
     */
    public $title;

    /**
     * @var array<Spec>
     */
    public $specs = array();

    /**
     * @var SuiteHelper
     */
    public $helper;

    /**
     * Creates a new Suite with the provided title
     *
     * @param string $title
     */
    public function __construct($title)
    {
        $this->title = $title;

        $this->helper = new SuiteHelper;
    }

    /**
     * @param Spec $spec
     */
    public function addSpecRunner(SpecRunner $runner)
    {
        $this->specs[] = $runner;
    }

    /**
     * Runs the suite
     */
    public function run()
    {
        $this->emit("begin");

        foreach ($this->specs as $spec) {
            $spec->on("update", array($this, "onSpecUpdate"));

            $spec->run($this->helper);
        }

        $this->emit("end");
    }

    public function count()
    {
        return count($this->specs);
    }

    public function onSpecUpdate(SpecResult $result)
    {
        $this->emit("update", array($result));
    }
}
