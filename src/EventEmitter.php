<?php namespace Ciarand\Midterm;

use Ciarand\Midterm\Exception\CallbackNotCallableException;

/**
 * Inspired by NodeJS and, more specifically, Igor Wiedler's
 * evenement (https://github.com/igorw/evenement) implementation. The only
 * advantage this offers is that it's implemented as a class, not a trait,
 * which retains PHP 5.3 compatibility
 */
class EventEmitter extends BaseComponent
{
    /**
     * @var array
     */
    protected $listeners;

    /**
     * Add a listener to the specified event
     *
     * @SuppressWarnings(PHPMD.ShortMethodNames)
     *
     * @param string $event
     * @param callable $callable
     */
    public function on($event, $callable)
    {
        if (!is_callable($callable)) {
            throw new CallbackNotCallableException();
        }

        if (!isset($this->listeners[$event])) {
            $this->listeners[$event] = array();
        }

        $this->listeners[$event][] = $callable;
    }

    /**
     * Emit the specified event, alerting all subscribers to that event and
     * passing in the data
     *
     * @param string $event
     * @param array $data
     */
    protected function emit($event, array $data = array())
    {
        if (!isset($this->listeners[$event])) {
            return;
        }

        foreach ($this->listeners[$event] as $listener) {
            call_user_func_array($listener, $data);
        }
    }
}
