<?php namespace Ciarand\Midterm\Spec;

use Ciarand\Midterm\BaseComponent;

class Permutation extends BaseComponent
{
    protected $title;

    protected $args;

    public function __construct($args)
    {
        $this->args = $args;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getArgs()
    {
        return $this->args;
    }

    public function title($title)
    {
        $this->title = $title;

        return $this;
    }
}
