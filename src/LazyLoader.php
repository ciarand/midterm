<?php namespace Ciarand\Midterm;

class LazyLoader extends BaseComponent
{
    protected $callable;

    public function __construct($value)
    {
        //TODO refactor

        if (is_object($value) && !is_callable($value)) {
            $this->callable = $this->createParameterReturner($value);

            return;
        }

        if (is_callable($value)) {
            $this->callable = $value;

            return;
        }

        if (is_string($value) && class_exists($value)) {
            $this->callable = $this->createClassConstructor($value);

            return;
        }

        if (is_array($value) && is_callable(array_slice($value, 0, 2))) {
            $callable = array_slice($value, 0, 2);
            $arguments = array_slice($value, 2);
            $this->callable = $this->createCallable($callable, $arguments);

            return;
        }

        $this->callable = $this->createParameterReturner($value);
    }

    public function run($args = null)
    {
        return call_user_func_array($this->callable, $args);
    }

    public function __invoke($args = null)
    {
        return $this->run($args);
    }

    protected function createClassConstructor($value)
    {
        return function () use ($value) {
            return new $value;
        };
    }

    protected function createCallable(&$callable, &$args)
    {
        return function () use (&$callable, &$args) {
            return call_user_func_array($callable, $args);
        };
    }

    protected function createParameterReturner(&$value)
    {
        return function () use (&$value) {
            return $value;
        };
    }
}
