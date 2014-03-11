<?php namespace Ciarand\Midterm;

class SpecRunner extends EventEmitter
{
    protected $data = array();

    protected $spec;

    public function __construct(Spec $spec)
    {
        $this->spec = $spec;
    }

    public function run(SuiteHelper $helper)
    {
        $this->emit("begin");

        if (count($this->data) > 0) {
            foreach ($this->data as $data) {
                $this->runSpecWith($data, $helper);
            }
        } else {
            $this->runSpecWith(array(), $helper);
        }

        $this->emit("end");
    }

    public function with()
    {
        $this->data = func_get_args();
    }

    protected function runSpecWith(array $data, SuiteHelper $helper)
    {
        $result = $this->spec->runWithData($data, $helper);

        $this->emit("update", array($result));
    }
}
