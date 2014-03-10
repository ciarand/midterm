<?php namespace Ciarand\Midterm;

use Countable;

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
    public function addSpec(Spec $spec)
    {
        $this->specs[] = $spec;
    }

    /**
     * An alias for addSpec
     *
     * @param Spec $spec
     */
    public function test(Spec $spec)
    {
        $this->addSpec($spec);
    }

    /**
     * Runs the suite
     */
    public function run()
    {
        $this->emit("begin");

        foreach ($this->specs as $spec) {
            $this->emit("update", array($spec->run($this->helper)));
        }

        $this->emit("end");
    }

    public function count()
    {
        return count($this->specs);
    }
}
