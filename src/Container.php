<?php namespace Ciarand\Midterm;

use Ciarand\Midterm\Result\TestResult;
use ReflectionClass;

class Container extends BaseComponent
{
    protected $bindings = array();

    public function bind($key, $value)
    {
        $this->bindings[$key] = new LazyLoader($value);
    }

    public function make($key)
    {
        $args = array_slice(func_get_args(), 1);

        if (isset($this->bindings[$key])) {
            return $this->bindings[$key]->run($args);
        }

        if (class_exists($key)) {
            $class = new ReflectionClass($key);

            return $class->newInstanceArgs($args);
        }

        throw new Exception("Could not create {$key}");
    }

    public function share($key, $instance)
    {
        $this->bindings[$key] = new LazyLoader($instance);
    }
}
