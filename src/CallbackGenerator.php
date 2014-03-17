<?php namespace Ciarand\Midterm;

class CallbackGenerator extends BaseComponent
{
    public function generate($callback, array $args = array())
    {
        return new Callback($callback, $args);
    }
}
