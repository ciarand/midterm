<?php namespace Ciarand\Midterm;

class Callback extends BaseComponent
{
    protected $callback;

    protected $args = array();

    public function __construct($callback, array $args)
    {
        $this->args = $args;

        if (is_callable($callback)) {
            $this->callback = $callback;
            return;
        }

        throw new InvalidArgumentException("callback was not callable");
    }

    public function __invoke()
    {
        return call_user_func_array($this->callback, $this->args);
    }
}
