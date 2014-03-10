<?php namespace Ciarand\Midterm;

/**
 * GlobalState is a static class that implements the Singleton pattern for a
 * Midterm object. This is useful for helper functions like describe, it, etc.
 *
 * For more information, see src/helpers.php
 */
class GlobalState extends BaseComponent
{
    /**
     * The single instance of Midterm
     *
     * @var Midterm
     */
    protected static $instance;

    /**
     * Gets the Midterm object, creating it if it doesn't already exist
     *
     * @return Midterm
     */
    public static function getMidterm()
    {
        if (!static::$instance instanceof Midterm) {
            static::$instance = new Midterm;
        }

        return static::$instance;
    }

    /**
     * Resets the Singleton object, which allows for isolation between test
     * runs in a long running script
     */
    public static function resetMidterm()
    {
        unset($this->instance);
    }
}
