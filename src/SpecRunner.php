<?php namespace Ciarand\Midterm;

use Ciarand\Midterm\Spec\Permutation;
use Ciarand\Midterm\Collection\PermutationCollection;
use Exception;

class SpecRunner extends EventEmitter
{
    protected $data;

    protected $spec;

    public function __construct(Spec $spec)
    {
        $this->spec = $spec;

        $this->data = new PermutationCollection;
    }

    public function run(SuiteHelper $helper)
    {
        $this->emit("begin");

        if (count($this->data) > 0) {
            foreach ($this->data as $data) {
                $this->runSpecWith($helper, $data);
            }
        } else {
            $this->runSpecWith($helper);
        }

        $this->emit("end");
    }

    public function with()
    {
        $this->data = new PermutationCollection(func_get_args());
    }

    protected function runSpecWith(SuiteHelper $helper, Permutation $data = null)
    {
        if ($data === null) {
            $data = with(new Permutation(array()))->title($this->spec->title);
        }

        $result = $this->spec->runWithData($data, $helper);

        $this->emit("update", array($result));
    }
}
