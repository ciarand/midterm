<?php namespace Ciarand\Midterm;

/**
 * BaseComponent contains some core functionality that should be present in all
 * classes, regardless of their intent.
 */
abstract class BaseComponent
{
    /**
     * Returns the fully qualified class name. Useful for older version of PHP
     *
     * @return string
     */
    public static function className()
    {
        return get_called_class();
    }
}
